<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use App\Models\LpSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LpSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $landingPageId)
    {
        $landingPage = LandingPage::with(['sections' => function ($query) {
            $query->orderBy('order');
        }])->findOrFail($landingPageId);

        return view('admin.landing-pages.sections.index', compact('landingPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $landingPageId)
    {
        $landingPage = LandingPage::findOrFail($landingPageId);
        $sectionTypes = [
            'header' => 'ヘッダー',
            'text' => 'テキスト',
            'image' => '画像',
            'cards' => 'カード',
        ];

        return view('admin.landing-pages.sections.create', compact('landingPage', 'sectionTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $landingPageId)
    {
        // リクエスト全体をログに出力
        \Log::info('セクション作成リクエスト', [
            'all' => $request->all(),
            'files' => $request->allFiles(),
            'has_bg_image' => $request->hasFile('bg_image'),
        ]);

        $landingPage = LandingPage::findOrFail($landingPageId);

        $rules = [
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:50',
        ];

        // タイプに応じたバリデーションを追加
        if ($request->type === 'image') {
            $rules['image'] = 'required|image';
        } elseif ($request->type === 'text') {
            $rules['content'] = 'nullable|string';
            $rules['bg_image'] = 'nullable|image';
        } elseif ($request->type === 'cta') {
            $rules['microcopy'] = 'required|string|max:255';
            $rules['cta_type'] = 'required|in:modal,link';
            $rules['button_text'] = 'required|string|max:255';

            if ($request->cta_type === 'modal') {
                // 既存のCTAセクションがない場合は必須
                $rules['qr_image'] = 'required|image';
            } elseif ($request->cta_type === 'link') {
                $rules['link_url'] = 'required|url';
            }
        }

        $validated = $request->validate($rules);

        // 最大の順序を取得
        $maxOrder = $landingPage->sections()->max('order') ?? 0;

        // 新しいセクションを作成
        $section = new LpSection([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'order' => $maxOrder + 1,
        ]);

        // 画像タイプの場合の画像アップロード処理
        if ($request->type === 'image' && $request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('section-images', 'public');
            $section->image_path = $imagePath;
        }

        // テキストタイプの場合の背景画像アップロード処理
        if ($request->type === 'text' && $request->hasFile('bg_image')) {
            // デバッグ情報をログに出力
            \Log::info('bg_imageがアップロードされました', [
                'is_valid' => $request->file('bg_image')->isValid(),
                'original_name' => $request->file('bg_image')->getClientOriginalName(),
                'mime_type' => $request->file('bg_image')->getMimeType(),
                'size' => $request->file('bg_image')->getSize(),
            ]);

            if ($request->file('bg_image')->isValid()) {
                $imagePath = $request->file('bg_image')->store('section-images', 'public');
                $section->image_path = $imagePath;
                \Log::info('画像が保存されました', ['path' => $imagePath]);
            } else {
                \Log::error('bg_imageが無効です');
            }
        } else if ($request->type === 'text') {
            \Log::info('テキストタイプですが、bg_imageがアップロードされていません', [
                'has_file' => $request->hasFile('bg_image'),
                'all_files' => $request->allFiles(),
            ]);
        }

        // セクションを保存
        $landingPage->sections()->save($section);

        // テキストタイプの場合、関連するカードを作成してテキスト内容を保存
        if ($request->type === 'text' && isset($validated['content'])) {
            $section->cards()->create([
                'title' => $section->title,
                'content' => $validated['content'],
                'order' => 1,
            ]);
        }

        // CTAタイプの場合、関連するカードを作成してCTA情報を保存
        if ($request->type === 'cta') {
            // マイクロコピーとボタンテキストを一緒にcontentに保存
            // JSON形式で保存して後で分割できるようにする
            $contentData = [
                'microcopy' => $request->microcopy,
                'button_text' => $request->button_text
            ];

            $cardData = [
                'title' => $request->cta_type, // modalまたはlinkを保存
                'content' => json_encode($contentData, JSON_UNESCAPED_UNICODE),
                'order' => 1, // 整数値を設定
            ];

            // タイプに応じて画像またはURLを保存
            if ($request->cta_type === 'modal' && $request->hasFile('qr_image') && $request->file('qr_image')->isValid()) {
                $imagePath = $request->file('qr_image')->store('section-images', 'public');
                $cardData['image_path'] = $imagePath;
            } elseif ($request->cta_type === 'link') {
                $cardData['image_path'] = $request->link_url; // URLをimage_pathに保存
            }

            $section->cards()->create($cardData);
        }

        // カードタイプの場合、セクション作成後にカード管理画面にリダイレクト
        if ($request->type === 'cards') {
            return redirect()
                ->route('admin.sections.cards.index', $section)
                ->with('success', 'カードセクションが作成されました。カードを追加してください。');
        }

        return redirect()
            ->route('admin.landing-pages.sections.index', $landingPage)
            ->with('success', 'セクションが作成されました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $section = LpSection::with(['landingPage', 'cards' => function ($query) {
            $query->orderBy('order');
        }])->findOrFail($id);

        return view('admin.sections.show', compact('section'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $section = LpSection::with(['landingPage', 'cards' => function ($query) {
            $query->orderBy('order');
        }])->findOrFail($id);

        $sectionTypes = [
            'header' => 'ヘッダー',
            'text' => 'テキスト',
            'image' => '画像',
            'cards' => 'カード',
            'footer' => 'フッター',
        ];

        return view('admin.sections.edit', compact('section', 'sectionTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $section = LpSection::with('cards')->findOrFail($id);

        $rules = [
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:50',
        ];

        // タイプに応じたバリデーションを追加
        if ($request->type === 'image') {
            // 既に画像がある場合は必須ではない
            $rules['image'] = $section->image_path ? 'nullable|image' : 'required|image';
        } elseif ($request->type === 'text') {
            $rules['content'] = 'nullable|string';
            $rules['bg_image'] = 'nullable|image';
        } elseif ($request->type === 'cta') {
            $rules['microcopy'] = 'required|string|max:255';
            $rules['cta_type'] = 'required|in:modal,link';
            $rules['button_text'] = 'required|string|max:255';

            // セクションに関連するカードがあるか確認
            $hasCard = $section->cards->isNotEmpty();
            $card = $hasCard ? $section->cards->first() : null;

            if ($request->cta_type === 'modal') {
                // モーダルタイプで、既存のカードがないか、タイプが変更された場合は必須
                if (!$hasCard || ($hasCard && $card->title !== 'modal')) {
                    $rules['qr_image'] = 'required|image';
                } else {
                    $rules['qr_image'] = 'nullable|image';
                }
            } elseif ($request->cta_type === 'link') {
                $rules['link_url'] = 'required|url';
            }
        }

        $validated = $request->validate($rules);

        // 画像タイプの場合の画像アップロード処理
        if ($request->type === 'image' && $request->hasFile('image') && $request->file('image')->isValid()) {
            // 古い画像を削除
            if ($section->image_path && \Storage::disk('public')->exists($section->image_path)) {
                \Storage::disk('public')->delete($section->image_path);
            }

            $imagePath = $request->file('image')->store('section-images', 'public');
            $validated['image_path'] = $imagePath;
        }

        // テキストタイプの場合の背景画像アップロード処理
        if ($request->type === 'text' && $request->hasFile('bg_image')) {
            // デバッグ情報をログに出力
            \Log::info('update: bg_imageがアップロードされました', [
                'is_valid' => $request->file('bg_image')->isValid(),
                'original_name' => $request->file('bg_image')->getClientOriginalName(),
                'mime_type' => $request->file('bg_image')->getMimeType(),
                'size' => $request->file('bg_image')->getSize(),
            ]);

            if ($request->file('bg_image')->isValid()) {
                // 古い画像を削除
                if ($section->image_path && \Storage::disk('public')->exists($section->image_path)) {
                    \Storage::disk('public')->delete($section->image_path);
                }

                $imagePath = $request->file('bg_image')->store('section-images', 'public');
                $validated['image_path'] = $imagePath;
                \Log::info('update: 画像が保存されました', ['path' => $imagePath]);
            } else {
                \Log::error('update: bg_imageが無効です');
            }
        } else if ($request->type === 'text') {
            \Log::info('update: テキストタイプですが、bg_imageがアップロードされていません', [
                'has_file' => $request->hasFile('bg_image'),
                'all_files' => $request->allFiles(),
            ]);
        }

        // セクションを更新
        $section->update($validated);

        // テキストタイプの場合、関連するカードを更新または作成してテキスト内容を保存
        if ($request->type === 'text' && isset($validated['content'])) {
            if ($section->cards->isNotEmpty()) {
                // 既存のカードを更新
                $section->cards->first()->update([
                    'title' => $section->title,
                    'content' => $validated['content'],
                ]);
            } else {
                // 新しいカードを作成
                $section->cards()->create([
                    'title' => $section->title,
                    'content' => $validated['content'],
                    'order' => 1,
                ]);
            }
        }

        // CTAタイプの場合、関連するカードを更新または作成してCTA情報を保存
        if ($request->type === 'cta') {
            // マイクロコピーとボタンテキストを一緒にcontentに保存
            // JSON形式で保存して後で分割できるようにする
            $contentData = [
                'microcopy' => $request->microcopy,
                'button_text' => $request->button_text
            ];

            $cardData = [
                'title' => $request->cta_type, // modalまたはlinkを保存
                'content' => json_encode($contentData, JSON_UNESCAPED_UNICODE),
                'order' => 1, // 整数値を設定
            ];

            // タイプに応じて画像またはURLを保存
            if ($request->cta_type === 'modal' && $request->hasFile('qr_image') && $request->file('qr_image')->isValid()) {
                // 古い画像を削除（モーダルタイプの場合のみ）
                if ($section->cards->isNotEmpty() && $section->cards->first()->title === 'modal' && $section->cards->first()->image_path) {
                    \Storage::disk('public')->delete($section->cards->first()->image_path);
                }

                $imagePath = $request->file('qr_image')->store('section-images', 'public');
                $cardData['image_path'] = $imagePath;
            } elseif ($request->cta_type === 'link') {
                $cardData['image_path'] = $request->link_url; // URLをimage_pathに保存
            }

            if ($section->cards->isNotEmpty()) {
                // 既存のカードを更新
                $section->cards->first()->update($cardData);
            } else {
                // 新しいカードを作成
                $section->cards()->create($cardData);
            }
        }

        // タイプが変更された場合の処理
        if ($section->type !== $request->type) {
            // カードタイプに変更された場合、カード管理画面にリダイレクト
            if ($request->type === 'cards') {
                return redirect()
                    ->route('admin.sections.cards.index', $section)
                    ->with('success', 'セクションがカードタイプに変更されました。カードを追加してください。');
            }
        }

        return redirect()
            ->route('admin.sections.edit', $section)
            ->with('success', 'セクションが更新されました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $section = LpSection::with('landingPage')->findOrFail($id);
        $landingPageId = $section->landingPage->id;

        DB::transaction(function () use ($section) {
            // 削除するセクションの順序を取得
            $deletedOrder = $section->order;

            // セクションを削除
            $section->delete();

            // 削除したセクションより大きい順序を持つセクションの順序を更新
            LpSection::where('landing_page_id', $section->landing_page_id)
                ->where('order', '>', $deletedOrder)
                ->decrement('order');
        });

        return redirect()
            ->route('admin.landing-pages.sections.index', $landingPageId)
            ->with('success', 'セクションが削除されました。');
    }

    /**
     * Reorder sections.
     */
    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'sections' => 'required|array',
            'sections.*' => 'required|integer|exists:lp_sections,id',
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['sections'] as $order => $sectionId) {
                LpSection::where('id', $sectionId)->update(['order' => $order + 1]);
            }
        });

        return response()->json(['success' => true]);
    }
}
