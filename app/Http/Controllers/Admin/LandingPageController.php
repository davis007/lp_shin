<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $landingPages = LandingPage::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.landing-pages.index', compact('landingPages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.landing-pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meta_description' => 'nullable|string|max:255',
            'cta_microcopy' => 'nullable|string',
            'cta_button_text' => 'nullable|string',
            'cta_type' => 'nullable|string|in:modal,link',
            'cta_link_url' => 'nullable|url',
            'cta_qr_image' => 'nullable|image',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        // スラッグが既に存在する場合は、ユニークになるように数字を追加
        $count = 1;
        $originalSlug = $validated['slug'];
        while (LandingPage::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count++;
        }

        // QRコード画像のアップロード処理
        if ($request->hasFile('cta_qr_image') && $request->file('cta_qr_image')->isValid()) {
            $imagePath = $request->file('cta_qr_image')->store('cta-images', 'public');
            $validated['cta_qr_image'] = $imagePath;
        }

        $landingPage = LandingPage::create($validated);

        return redirect()
            ->route('admin.landing-pages.edit', $landingPage)
            ->with('success', 'ランディングページが作成されました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $landingPage = LandingPage::with('sections.cards')->findOrFail($id);
        return view('admin.landing-pages.show', compact('landingPage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $landingPage = LandingPage::findOrFail($id);
        return view('admin.landing-pages.edit', compact('landingPage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $landingPage = LandingPage::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meta_description' => 'nullable|string|max:255',
            'cta_microcopy' => 'nullable|string',
            'cta_button_text' => 'nullable|string',
            'cta_type' => 'nullable|string|in:modal,link',
            'cta_link_url' => 'nullable|url',
            'cta_qr_image' => 'nullable|image',
        ]);

        // スラッグを更新する場合
        if ($landingPage->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);

            // スラッグが既に存在する場合は、ユニークになるように数字を追加
            $count = 1;
            $originalSlug = $validated['slug'];
            while (LandingPage::where('slug', $validated['slug'])->where('id', '!=', $id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count++;
            }
        }

        // QRコード画像のアップロード処理
        if ($request->hasFile('cta_qr_image') && $request->file('cta_qr_image')->isValid()) {
            // 古い画像を削除
            if ($landingPage->cta_qr_image && \Storage::disk('public')->exists($landingPage->cta_qr_image)) {
                \Storage::disk('public')->delete($landingPage->cta_qr_image);
            }

            $imagePath = $request->file('cta_qr_image')->store('cta-images', 'public');
            $validated['cta_qr_image'] = $imagePath;
        }

        $landingPage->update($validated);

        return redirect()
            ->route('admin.landing-pages.edit', $landingPage)
            ->with('success', 'ランディングページが更新されました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $landingPage = LandingPage::findOrFail($id);
        $landingPage->delete();

        return redirect()
            ->route('admin.landing-pages.index')
            ->with('success', 'ランディングページが削除されました。');
    }

    /**
     * Preview the landing page.
     */
    public function preview(string $id)
    {
        $landingPage = LandingPage::with(['sections' => function ($query) {
            $query->orderBy('order');
        }, 'sections.cards' => function ($query) {
            $query->orderBy('order');
        }])->findOrFail($id);

        return view('admin.landing-pages.preview', compact('landingPage'));
    }

    /**
     * Toggle the publish status of the landing page.
     */
    public function togglePublish(string $id)
    {
        $landingPage = LandingPage::findOrFail($id);

        DB::transaction(function () use ($landingPage) {
            $landingPage->is_published = !$landingPage->is_published;

            if ($landingPage->is_published && !$landingPage->published_at) {
                $landingPage->published_at = now();
            }

            $landingPage->save();
        });

        $status = $landingPage->is_published ? '公開' : '非公開';

        return redirect()
            ->back()
            ->with('success', "ランディングページが{$status}になりました。");
    }
}
