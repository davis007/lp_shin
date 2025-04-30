@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>ランディングページ詳細</h1>
        </div>
        <div class="col-md-6 text-right">
            <div class="btn-group" role="group">
                <a href="{{ route('admin.landing-pages.edit', $landingPage) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> 編集
                </a>
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

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">基本情報</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 200px;">ID</th>
                    <td>{{ $landingPage->id }}</td>
                </tr>
                <tr>
                    <th>タイトル</th>
                    <td>{{ $landingPage->title }}</td>
                </tr>
                <tr>
                    <th>スラッグ</th>
                    <td>{{ $landingPage->slug }}</td>
                </tr>
                <tr>
                    <th>公開URL</th>
                    <td>
                        @if($landingPage->is_published)
                            <a href="{{ $landingPage->getPublicUrl() }}" target="_blank">
                                {{ $landingPage->getPublicUrl() }}
                                <i class="fas fa-external-link-alt ml-1"></i>
                            </a>
                        @else
                            <span class="text-muted">公開後に表示されます</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>説明</th>
                    <td>{!! nl2br(e($landingPage->description)) !!}</td>
                </tr>
                <tr>
                    <th>メタ説明</th>
                    <td>{{ $landingPage->meta_description }}</td>
                </tr>
                <tr>
                    <th>公開状態</th>
                    <td>
                        @if($landingPage->is_published)
                            <span class="badge badge-success">公開中</span>
                        @else
                            <span class="badge badge-secondary">非公開</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>公開日時</th>
                    <td>{{ $landingPage->published_at ? $landingPage->published_at->format('Y-m-d H:i') : '未公開' }}</td>
                </tr>
                <tr>
                    <th>作成日時</th>
                    <td>{{ $landingPage->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                <tr>
                    <th>更新日時</th>
                    <td>{{ $landingPage->updated_at->format('Y-m-d H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">セクション一覧</h5>
            <a href="{{ route('admin.landing-pages.sections.index', $landingPage) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-th-large"></i> セクション管理へ
            </a>
        </div>
        <div class="card-body">
            @if($landingPage->sections->isEmpty())
                <div class="alert alert-info">
                    セクションがまだ作成されていません。
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>タイトル</th>
                                <th>タイプ</th>
                                <th>順序</th>
                                <th>カード数</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($landingPage->sections->sortBy('order') as $section)
                                <tr>
                                    <td>{{ $section->id }}</td>
                                    <td>{{ $section->title }}</td>
                                    <td>{{ $section->type }}</td>
                                    <td>{{ $section->order }}</td>
                                    <td>{{ $section->cards->count() }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.sections.show', $section) }}" class="btn btn-sm btn-info" title="詳細">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.sections.edit', $section) }}" class="btn btn-sm btn-primary" title="編集">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.sections.cards.index', $section) }}" class="btn btn-sm btn-warning" title="カード管理">
                                                <i class="fas fa-th"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="form-group">
        <a href="{{ route('admin.landing-pages.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> 一覧に戻る
        </a>
    </div>
</div>
@endsection
