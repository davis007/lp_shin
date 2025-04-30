@csrf

<div class="form-group">
    <label for="title">タイトル <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $section->title ?? '') }}" required>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="type">タイプ <span class="text-danger">*</span></label>
    <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
        <option value="">選択してください</option>
        @foreach($sectionTypes as $value => $label)
            <option value="{{ $value }}" {{ (old('type', $section->type ?? '') == $value) ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('type')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <small class="form-text text-muted">
        <ul>
            <li><strong>テキスト</strong>: 段落テキストを表示するセクション</li>
            <li><strong>画像</strong>: 1つの大きな画像を表示するセクション</li>
            <li><strong>カード</strong>: 複数のカードを表示するセクション（特徴、サービス、チームメンバーなど）。カードは横スライドで表示され、スワイプまたは矢印で横にスクロールして閲覧できます。</li>
            <li><strong>フッターボタン</strong>: アクションを促すセクション（お問い合わせボタンなど）</li>
        </ul>
    </small>
</div>

<div class="form-group image-upload-field" id="imageUploadField" style="{{ (old('type', $section->type ?? '') == 'image') ? '' : 'display: none;' }}">
    <label for="image">画像 <span class="text-danger">*</span></label>
    <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image" {{ (old('type', $section->type ?? '') == 'image') ? 'required' : '' }}>
    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    @if(isset($section) && $section->image_path)
        <div class="mt-2">
            <p>現在の画像:</p>
            <img src="{{ asset('storage/' . $section->image_path) }}" alt="{{ $section->title }}" class="img-thumbnail" style="max-height: 200px;">
        </div>
    @endif
    <small class="form-text text-muted">推奨サイズ: 1200 x 600 ピクセル (16:9)</small>
</div>

<!-- テキストセクション用のフィールド -->
<div class="form-group text-content-field" id="textContentField" style="{{ (old('type', $section->type ?? '') == 'text') ? '' : 'display: none;' }}">
    <label for="content">テキスト内容</label>
    <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="5">{{ old('content', isset($section) && $section->cards->isNotEmpty() ? $section->cards->first()->content : '') }}</textarea>
    @error('content')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- カードセクション用のフィールド -->
<div class="form-group card-section-field" id="cardSectionField" style="{{ (old('type', $section->type ?? '') == 'cards') ? '' : 'display: none;' }}">
    <div class="alert alert-info">
        <h5><i class="fas fa-info-circle"></i> カードセクションについて</h5>
        <p>カードセクションでは、複数のカードを登録できます。各カードは正方形の画像とテキストで構成されます。</p>
        <p>セクションを保存した後、カード管理画面からカードを追加・編集・削除できます。</p>
        <p>表示時には、カードが横スライドで表示され、スワイプまたは矢印ボタンで横にスクロールして閲覧できます。</p>
    </div>

    @if(isset($section) && $section->type == 'cards')
        <div class="card mb-3">
            <div class="card-header bg-light">
                <h5 class="mb-0">登録済みカード ({{ $section->cards->count() }}件)</h5>
            </div>
            <div class="card-body">
                @if($section->cards->isEmpty())
                    <p class="text-muted">カードがまだ登録されていません。セクションを保存した後、カード管理からカードを追加してください。</p>
                @else
                    <div class="card-preview-container" style="position: relative; padding: 0 20px;">
                        <div class="card-preview-slider" style="display: flex; overflow-x: auto; padding: 10px 0; scroll-snap-type: x mandatory; scroll-behavior: smooth; scrollbar-width: none; -ms-overflow-style: none;">
                        <style>
                            .card-preview-slider::-webkit-scrollbar {
                                display: none;
                                width: 0;
                                height: 0;
                            }
                        </style>
                            @foreach($section->cards->sortBy('order') as $card)
                                <div class="card" style="flex: 0 0 auto; width: 200px; margin-right: 15px; scroll-snap-align: start;">
                                    @if($card->image_path)
                                        <div style="height: 0; padding-bottom: 100%; position: relative; overflow: hidden;">
                                            <img src="{{ asset('storage/' . $card->image_path) }}" alt="{{ $card->title }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title" style="font-size: 0.9rem;">{{ $card->title }}</h5>
                                        <p class="card-text small">{{ Str::limit($card->content, 50) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.sections.cards.index', $section) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-th"></i> カード管理へ
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>

<!-- テキストセクション用の背景画像アップロードフィールド -->
<div class="form-group text-bg-image-field" id="textBgImageField" style="{{ (old('type', $section->type ?? '') == 'text') ? '' : 'display: none;' }}">
    <label for="bg_image">背景画像</label>
    <input type="file" class="form-control-file @error('bg_image') is-invalid @enderror" id="bg_image" name="bg_image">
    @error('bg_image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    @if(isset($section) && $section->type == 'text' && $section->image_path)
        <div class="mt-2">
            <p>現在の背景画像:</p>
            <img src="{{ asset('storage/' . $section->image_path) }}" alt="背景画像" class="img-thumbnail" style="max-height: 200px;">
        </div>
    @endif
    <small class="form-text text-muted">推奨サイズ: 1920 x 1080 ピクセル</small>
</div>

<!-- CTAセクション用のフィールド -->
<div class="form-group cta-section-field" id="ctaSectionField" style="{{ (old('type', $section->type ?? '') == 'cta') ? '' : 'display: none;' }}">
    <div class="form-group">
        <label for="microcopy">マイクロコピー <span class="text-danger">*</span>
			<small>クリックを促す簡単なコメント 例:3分で登録 1分で申し込み など</small>
		</label>
        <input type="text" class="form-control @error('microcopy') is-invalid @enderror" id="microcopy" name="microcopy" value="{{ old('microcopy', isset($section) && $section->cards->isNotEmpty() ? (is_string($section->cards->first()->content) && json_decode($section->cards->first()->content) ? json_decode($section->cards->first()->content, true)['microcopy'] ?? '' : $section->cards->first()->content) : '') }}">
        @error('microcopy')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="cta_type">タイプ <span class="text-danger">*</span></label>
        <select class="form-control @error('cta_type') is-invalid @enderror" id="cta_type" name="cta_type">
            <option value="">選択してください</option>
            <option value="modal" {{ (old('cta_type', isset($section) && $section->cards->isNotEmpty() && $section->cards->first()->title == 'modal' ? 'modal' : '') == 'modal') ? 'selected' : '' }}>モーダル</option>
            <option value="link" {{ (old('cta_type', isset($section) && $section->cards->isNotEmpty() && $section->cards->first()->title == 'link' ? 'link' : '') == 'link') ? 'selected' : '' }}>リンク</option>
        </select>
        @error('cta_type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group cta-modal-field" id="ctaModalField" style="display: none;">
        <label for="qr_image">QRコード画像 <span class="text-danger">*</span></label>
        <input type="file" class="form-control-file @error('qr_image') is-invalid @enderror" id="qr_image" name="qr_image">
        @error('qr_image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        @if(isset($section) && $section->type == 'cta' && $section->cards->isNotEmpty() && $section->cards->first()->title == 'modal' && $section->cards->first()->image_path)
            <div class="mt-2">
                <p>現在のQRコード画像:</p>
                <img src="{{ asset('storage/' . $section->cards->first()->image_path) }}" alt="QRコード" class="img-thumbnail" style="max-height: 200px;">
            </div>
        @endif
        <small class="form-text text-muted">QRコードをアップロードして下さい</small>
    </div>

    <div class="form-group cta-link-field" id="ctaLinkField" style="display: none;">
        <label for="link_url">リンク先URL <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('link_url') is-invalid @enderror" id="link_url" name="link_url" value="{{ old('link_url', isset($section) && $section->cards->isNotEmpty() && $section->cards->first()->title == 'link' ? $section->cards->first()->image_path : '') }}">
        @error('link_url')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="form-text text-muted">リンクは新しいタブで開きます (_blank)</small>
    </div>

    <div class="form-group">
        <label for="button_text">ボタンに表示する文字列 <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('button_text') is-invalid @enderror" id="button_text" name="button_text" value="{{ old('button_text', isset($section) && $section->cards->isNotEmpty() ? (is_string($section->cards->first()->content) && json_decode($section->cards->first()->content) ? json_decode($section->cards->first()->content, true)['button_text'] ?? '' : '') : '') }}">
        @error('button_text')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const imageUploadField = document.getElementById('imageUploadField');
    const imageInput = document.getElementById('image');
    const textContentField = document.getElementById('textContentField');
    const textBgImageField = document.getElementById('textBgImageField');
    const cardSectionField = document.getElementById('cardSectionField');
    const ctaSectionField = document.getElementById('ctaSectionField');
    const ctaTypeSelect = document.getElementById('cta_type');
    const ctaModalField = document.getElementById('ctaModalField');
    const ctaLinkField = document.getElementById('ctaLinkField');

    // CTA タイプの変更イベントリスナー
    ctaTypeSelect.addEventListener('change', function() {
        // すべてのCTAフィールドを非表示にする
        ctaModalField.style.display = 'none';
        ctaLinkField.style.display = 'none';

        // 選択されたCTAタイプに応じて表示するフィールドを切り替える
        if (this.value === 'modal') {
            ctaModalField.style.display = 'block';
        } else if (this.value === 'link') {
            ctaLinkField.style.display = 'block';
        }
    });

    // 初期表示時にCTAタイプに応じたフィールドを表示
    if (ctaTypeSelect.value === 'modal') {
        ctaModalField.style.display = 'block';
    } else if (ctaTypeSelect.value === 'link') {
        ctaLinkField.style.display = 'block';
    }

    typeSelect.addEventListener('change', function() {
        // すべてのフィールドを非表示にする
        imageUploadField.style.display = 'none';
        textContentField.style.display = 'none';
        textBgImageField.style.display = 'none';
        cardSectionField.style.display = 'none';
        ctaSectionField.style.display = 'none';
        imageInput.required = false;

        // 選択されたタイプに応じて表示するフィールドを切り替える
        if (this.value === 'image') {
            imageUploadField.style.display = 'block';
            imageInput.required = true;
        } else if (this.value === 'text') {
            textContentField.style.display = 'block';
            textBgImageField.style.display = 'block';
        } else if (this.value === 'cards') {
            cardSectionField.style.display = 'block';
        } else if (this.value === 'cta') {
            ctaSectionField.style.display = 'block';
        }
    });
});
</script>

<div class="form-group">
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> 保存
    </button>
    <a href="{{ isset($landingPage) ? route('admin.landing-pages.sections.index', $landingPage) : route('admin.landing-pages.show', $section->landingPage) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> 戻る
    </a>
</div>
