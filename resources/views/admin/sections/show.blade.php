@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>セクション詳細</h1>
            <p class="text-muted">ランディングページ: {{ $section->landingPage->title }}</p>
        </div>
        <div class="col-md-6 text-right">
            <div class="btn-group" role="group">
                <a href="{{ route('admin.sections.edit', $section) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> 編集
                </a>
                <a href="{{ route('admin.sections.cards.index', $section) }}" class="btn btn-warning">
                    <i class="fas fa-th"></i> カード管理
                </a>
                <a href="{{ route('admin.landing-pages.preview', $section->landingPage) }}" class="btn btn-secondary" target="_blank">
                    <i class="fas fa-desktop"></i> プレビュー
                </a>
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
                    <td>{{ $section->id }}</td>
                </tr>
                <tr>
                    <th>タイトル</th>
                    <td>{{ $section->title }}</td>
                </tr>
                <tr>
                    <th>タイプ</th>
                    <td>{{ $section->type }}</td>
                </tr>
                @if($section->type === 'image' && $section->image_path)
                <tr>
                    <th>画像</th>
                    <td>
                        <img src="{{ asset('storage/' . $section->image_path) }}" alt="{{ $section->title }}" class="img-fluid" style="max-height: 300px;">
                    </td>
                </tr>
                @endif
                <tr>
                    <th>順序</th>
                    <td>{{ $section->order }}</td>
                </tr>
                <tr>
                    <th>作成日時</th>
                    <td>{{ $section->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                <tr>
                    <th>更新日時</th>
                    <td>{{ $section->updated_at->format('Y-m-d H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">カード一覧</h5>
            <a href="{{ route('admin.sections.cards.index', $section) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-th"></i> カード管理へ
            </a>
        </div>
        <div class="card-body">
            @if($section->cards->isEmpty())
                <div class="alert alert-info">
                    カードがまだ作成されていません。
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>タイトル</th>
                                <th>画像</th>
                                <th>順序</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($section->cards->sortBy('order') as $card)
                                <tr>
                                    <td>{{ $card->id }}</td>
                                    <td>{{ $card->title }}</td>
                                    <td>
                                        @if($card->image_path)
                                            <img src="{{ asset('storage/' . $card->image_path) }}" alt="{{ $card->title }}" style="max-width: 100px; max-height: 60px;">
                                        @else
                                            <span class="text-muted">なし</span>
                                        @endif
                                    </td>
                                    <td>{{ $card->order }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.cards.edit', $card) }}" class="btn btn-sm btn-primary" title="編集">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.cards.destroy', $card) }}" method="POST" class="d-inline delete-form">
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
            @endif
        </div>
    </div>

    <div class="form-group">
        <a href="{{ route('admin.landing-pages.sections.index', $section->landingPage) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> セクション一覧に戻る
        </a>
    </div>
</div>
@endsection
