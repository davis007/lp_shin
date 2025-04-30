@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>セクション編集</h1>
            <p class="text-muted">ランディングページ: {{ $section->landingPage->title }}</p>
        </div>
        <div class="col-md-6 text-right">
            <div class="btn-group" role="group">
                <a href="{{ route('admin.sections.cards.index', $section) }}" class="btn btn-warning">
                    <i class="fas fa-th"></i> カード管理
                </a>
                <a href="{{ route('admin.landing-pages.preview', $section->landingPage) }}" class="btn btn-secondary" target="_blank">
                    <i class="fas fa-desktop"></i> プレビュー
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.sections.update', $section) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @include('admin.landing-pages.sections._form')
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0">危険ゾーン</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.sections.destroy', $section) }}" method="POST" class="delete-form">
                @csrf
                @method('DELETE')
                <p>このセクションを削除すると、関連するすべてのカードも削除されます。この操作は元に戻せません。</p>
                <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか？この操作は元に戻せません。')">
                    <i class="fas fa-trash"></i> セクションを削除
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
