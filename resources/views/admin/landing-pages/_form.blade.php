@csrf

<div class="form-group">
    <label for="title">タイトル <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $landingPage->title ?? '') }}" required>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="description">説明</label>
    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description', $landingPage->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="meta_description">メタ説明（SEO用）</label>
    <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $landingPage->meta_description ?? '') }}</textarea>
    <small class="form-text text-muted">検索エンジンの結果に表示される説明文です。160文字以内が推奨されます。</small>
    @error('meta_description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<h4 class="mt-4 mb-3">フッターCTAボタン設定</h4>
<div class="card mb-4">
    <div class="card-body">
        <div class="form-group">
            <label for="cta_microcopy">マイクロコピー</label>
            <input type="text" class="form-control @error('cta_microcopy') is-invalid @enderror" id="cta_microcopy" name="cta_microcopy" value="{{ old('cta_microcopy', $landingPage->cta_microcopy ?? '') }}">
            <small class="form-text text-muted">クリックを促す簡単なコメント 例:3分で登録 1分で申し込み など</small>
            @error('cta_microcopy')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="cta_button_text">ボタンに表示する文字列</label>
            <input type="text" class="form-control @error('cta_button_text') is-invalid @enderror" id="cta_button_text" name="cta_button_text" value="{{ old('cta_button_text', $landingPage->cta_button_text ?? '') }}">
            @error('cta_button_text')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="cta_type">タイプ</label>
            <select class="form-control @error('cta_type') is-invalid @enderror" id="cta_type" name="cta_type">
                <option value="">--選択してください--</option>
                <option value="modal" {{ (old('cta_type', $landingPage->cta_type ?? '') == 'modal') ? 'selected' : '' }}>モーダル</option>
                <option value="link" {{ (old('cta_type', $landingPage->cta_type ?? '') == 'link') ? 'selected' : '' }}>リンク</option>
            </select>
			<small class="form-text text-muted">モーダル: LINEなどのQRコードをアップロードして連絡を受けるスタイル。<br> リンク: 申し込みフォームを別ページで用意し、そこで申し込みさせるスタイル。</small>
            @error('cta_type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group cta-modal-field" id="ctaModalField" style="display: none;">
            <label for="cta_qr_image">QRコード画像</label>
            <input type="file" class="form-control-file @error('cta_qr_image') is-invalid @enderror" id="cta_qr_image" name="cta_qr_image">
            @error('cta_qr_image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @if(isset($landingPage) && $landingPage->cta_qr_image)
                <div class="mt-2">
                    <p>現在のQRコード画像:</p>
                    <img src="{{ asset('storage/' . $landingPage->cta_qr_image) }}" alt="QRコード" class="img-thumbnail" style="max-height: 200px;">
                </div>
            @endif
            <small class="form-text text-muted">QRコードをアップロードして下さい</small>
        </div>

        <div class="form-group cta-link-field" id="ctaLinkField" style="display: none;">
            <label for="cta_link_url">リンク先URL</label>
            <input type="text" class="form-control @error('cta_link_url') is-invalid @enderror" id="cta_link_url" name="cta_link_url" value="{{ old('cta_link_url', $landingPage->cta_link_url ?? '') }}">
            @error('cta_link_url')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">リンクは新しいタブで開きます (_blank)</small>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
});
</script>

<div class="form-group">
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> 保存
    </button>
    <a href="{{ route('admin.landing-pages.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> 戻る
    </a>
</div>
