@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>カード編集</h1>
            <p class="text-muted">
                セクション: {{ $card->section->title }} ({{ $card->section->type }}) |
                ランディングページ: {{ $card->section->landingPage->title }}
            </p>
        </div>
        <div class="col-md-6 text-right">
            <div class="btn-group" role="group">
                <a href="{{ route('admin.landing-pages.preview', $card->section->landingPage) }}" class="btn btn-secondary" target="_blank">
                    <i class="fas fa-desktop"></i> プレビュー
                </a>
                <a href="{{ route('admin.sections.cards.index', $card->section) }}" class="btn btn-info">
                    <i class="fas fa-th"></i> カード一覧
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.cards.update', $card) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @include('admin.sections.cards._form')
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0">危険ゾーン</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.cards.destroy', $card) }}" method="POST" class="delete-form">
                @csrf
                @method('DELETE')
                <p>このカードを削除します。この操作は元に戻せません。</p>
                <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか？この操作は元に戻せません。')">
                    <i class="fas fa-trash"></i> カードを削除
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // ファイル選択時にラベルにファイル名を表示
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            var label = e.target.nextElementSibling;
            label.innerHTML = fileName;
        });
    });
</script>
@endsection
