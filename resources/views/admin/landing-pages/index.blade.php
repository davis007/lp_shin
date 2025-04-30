@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>ランディングページ一覧</h1>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('admin.landing-pages.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> 新規作成
            </a>
        </div>
    </div>

    @if($landingPages->isEmpty())
        <div class="alert alert-info">
            ランディングページがまだ作成されていません。
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>タイトル</th>
                                <th>スラッグ</th>
                                <th>公開状態</th>
                                <th>作成日</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($landingPages as $landingPage)
                                <tr>
                                    <td>{{ $landingPage->id }}</td>
                                    <td>{{ $landingPage->title }}</td>
                                    <td>{{ $landingPage->slug }}</td>
                                    <td>
                                        @if($landingPage->is_published)
                                            <span class="badge badge-success">公開中</span>
                                        @else
                                            <span class="badge badge-secondary">非公開</span>
                                        @endif
                                    </td>
                                    <td>{{ $landingPage->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.landing-pages.show', $landingPage) }}" class="btn btn-sm btn-info" title="詳細">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.landing-pages.edit', $landingPage) }}" class="btn btn-sm btn-primary" title="編集">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.landing-pages.preview', $landingPage) }}" class="btn btn-sm btn-secondary" title="プレビュー" target="_blank">
                                                <i class="fas fa-desktop"></i>
                                            </a>
                                            <a href="{{ route('admin.landing-pages.sections.index', $landingPage) }}" class="btn btn-sm btn-warning" title="セクション管理">
                                                <i class="fas fa-th-large"></i>
                                            </a>
                                            <form action="{{ route('admin.landing-pages.toggle-publish', $landingPage) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm {{ $landingPage->is_published ? 'btn-dark' : 'btn-success' }}" title="{{ $landingPage->is_published ? '非公開にする' : '公開する' }}">
                                                    <i class="fas {{ $landingPage->is_published ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.landing-pages.destroy', $landingPage) }}" method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="削除" onclick="return confirm('本当に削除しますか？')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $landingPages->links() }}
        </div>
    @endif
</div>
@endsection
