@csrf

<div class="form-group">
    <label for="title">タイトル <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $card->title ?? '') }}" required>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="content">内容</label>
    <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="5">{{ old('content', $card->content ?? '') }}</textarea>
    @error('content')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="image">画像 <span class="text-danger">*</span></label>
    <div class="alert alert-info mb-2">
        <i class="fas fa-info-circle"></i> カード画像は正方形（1:1の比率）で表示されます。正方形の画像をアップロードするか、長方形の画像の場合は中央部分が表示されます。
    </div>
    <div class="custom-file">
        <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image">
        <label class="custom-file-label" for="image">ファイルを選択...</label>
        @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <small class="form-text text-muted">推奨サイズ: 500x500px（正方形）、ファイルサイズ制限なし</small>

    @if(isset($card) && $card->image_path)
        <div class="mt-2">
            <p>現在の画像:</p>
            <div style="width: 200px; height: 200px; overflow: hidden; position: relative;">
                <img src="{{ asset('storage/' . $card->image_path) }}" alt="{{ $card->title }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>
    @endif
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> 保存
    </button>
    <a href="{{ isset($section) ? route('admin.sections.cards.index', $section) : route('admin.sections.cards.index', $card->section) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> 戻る
    </a>
</div>
