@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>ランディングページ編集</h1>
        </div>
        <div class="col-md-6 text-right">
            <div class="btn-group" role="group">
                <a href="{{ route('admin.landing-pages.preview', $landingPage) }}" class="btn btn-secondary" target="_blank">
                    <i class="fas fa-desktop"></i> プレビュー
                </a>
                <a href="{{ route('admin.landing-pages.sections.index', $landingPage) }}" class="btn btn-warning">
                    <i class="fas fa-th-large"></i> セクション管理
                </a>
                <form action="{{ route('admin.landing-pages.toggle-publish', $landingPage) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn {{ $landingPage->is_published ? 'btn-dark' : 'btn-success' }}">
                        <i class="fas {{ $landingPage->is_published ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                        {{ $landingPage->is_published ? '非公開にする' : '公開する' }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.landing-pages.update', $landingPage) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @include('admin.landing-pages._form')
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0">危険ゾーン</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.landing-pages.destroy', $landingPage) }}" method="POST" class="delete-form">
                @csrf
                @method('DELETE')
                <p>このランディングページを削除すると、関連するすべてのセクションとカードも削除されます。この操作は元に戻せません。</p>
                <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか？この操作は元に戻せません。')">
                    <i class="fas fa-trash"></i> ランディングページを削除
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
