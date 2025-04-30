<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LpCard;
use App\Models\LpSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LpCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $sectionId)
    {
        $section = LpSection::with(['landingPage', 'cards' => function ($query) {
            $query->orderBy('order');
        }])->findOrFail($sectionId);

        return view('admin.sections.cards.index', compact('section'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $sectionId)
    {
        $section = LpSection::with('landingPage')->findOrFail($sectionId);
        return view('admin.sections.cards.create', compact('section'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $sectionId)
    {
        $section = LpSection::findOrFail($sectionId);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image',
        ]);

        // 最大の順序を取得
        $maxOrder = $section->cards()->max('order') ?? 0;

        // 画像のアップロード処理
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cards', 'public');
        }

        // 新しいカードを作成
        $card = new LpCard([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'image_path' => $imagePath,
            'order' => $maxOrder + 1,
        ]);

        $section->cards()->save($card);

        return redirect()
            ->route('admin.sections.cards.index', $section)
            ->with('success', 'カードが作成されました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $card = LpCard::with(['section.landingPage'])->findOrFail($id);
        return view('admin.cards.show', compact('card'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $card = LpCard::with(['section.landingPage'])->findOrFail($id);
        return view('admin.cards.edit', compact('card'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $card = LpCard::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image',
        ]);

        // 画像のアップロード処理
        if ($request->hasFile('image')) {
            // 古い画像を削除
            if ($card->image_path) {
                Storage::disk('public')->delete($card->image_path);
            }

            $validated['image_path'] = $request->file('image')->store('cards', 'public');
        }

        $card->update($validated);

        return redirect()
            ->route('admin.cards.edit', $card)
            ->with('success', 'カードが更新されました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $card = LpCard::with('section')->findOrFail($id);
        $sectionId = $card->section->id;

        DB::transaction(function () use ($card) {
            // 削除するカードの順序を取得
            $deletedOrder = $card->order;

            // 画像を削除
            if ($card->image_path) {
                Storage::disk('public')->delete($card->image_path);
            }

            // カードを削除
            $card->delete();

            // 削除したカードより大きい順序を持つカードの順序を更新
            LpCard::where('section_id', $card->section_id)
                ->where('order', '>', $deletedOrder)
                ->decrement('order');
        });

        return redirect()
            ->route('admin.sections.cards.index', $sectionId)
            ->with('success', 'カードが削除されました。');
    }
}
