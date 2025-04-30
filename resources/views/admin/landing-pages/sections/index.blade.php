@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.css">
<style>
    .section-item {
        cursor: move;
        transition: background-color 0.3s;
    }
    .section-item:hover {
        background-color: #f8f9fa;
    }
    .section-item.sortable-ghost {
        opacity: 0.5;
        background-color: #e9ecef;
    }
    .section-handle {
        cursor: move;
        color: #adb5bd;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>セクション管理</h1>
            <p class="text-muted">ランディングページ: {{ $landingPage->title }}</p>
        </div>
        <div class="col-md-6 text-right">
            <div class="btn-group" role="group">
                <a href="{{ route('admin.landing-pages.sections.create', $landingPage) }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> 新規セクション
                </a>
                <a href="{{ route('admin.landing-pages.preview', $landingPage) }}" class="btn btn-secondary" target="_blank">
                    <i class="fas fa-desktop"></i> プレビュー
                </a>
                <a href="{{ route('admin.landing-pages.edit', $landingPage) }}" class="btn btn-info">
                    <i class="fas fa-edit"></i> ランディングページ編集
                </a>
            </div>
        </div>
    </div>

    @if($landingPage->sections->isEmpty())
        <div class="alert alert-info">
            セクションがまだ作成されていません。
        </div>
    @else
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">セクション一覧（ドラッグ&ドロップで並び替え）</h5>
            </div>
            <div class="card-body">
                <ul class="list-group" id="sections-list">
                    @foreach($landingPage->sections->sortBy('order') as $section)
                        <li class="list-group-item section-item d-flex justify-content-between align-items-center" data-id="{{ $section->id }}">
                            <div class="d-flex align-items-center">
                                <span class="section-handle mr-3">
                                    <i class="fas fa-grip-vertical"></i>
                                </span>
                                <div>
                                    <h5 class="mb-1">{{ $section->title }}</h5>
                                    <p class="mb-0 text-muted">
                                        タイプ: {{ $section->type }} |
                                        カード数: {{ $section->cards->count() }} |
                                        順序: {{ $section->order }}
                                    </p>
                                </div>
                            </div>
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
                                <form action="{{ route('admin.sections.destroy', $section) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="削除" onclick="return confirm('本当に削除しますか？')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="form-group">
        <a href="{{ route('admin.landing-pages.show', $landingPage) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> ランディングページ詳細に戻る
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sectionsList = document.getElementById('sections-list');

        if (sectionsList) {
            new Sortable(sectionsList, {
                animation: 150,
                handle: '.section-handle',
                ghostClass: 'sortable-ghost',
                onEnd: function() {
                    const sections = [];
                    document.querySelectorAll('#sections-list .section-item').forEach(item => {
                        sections.push(item.dataset.id);
                    });

                    // 並び順を保存
                    fetch('{{ route("admin.sections.reorder") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ sections: sections })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // 成功メッセージを表示
                            const alert = document.createElement('div');
                            alert.className = 'alert alert-success alert-flash';
                            alert.textContent = '並び順が保存されました';
                            document.body.appendChild(alert);

                            setTimeout(() => {
                                alert.remove();
                            }, 3000);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // エラーメッセージを表示
                        const alert = document.createElement('div');
                        alert.className = 'alert alert-danger alert-flash';
                        alert.textContent = '並び順の保存に失敗しました';
                        document.body.appendChild(alert);

                        setTimeout(() => {
                            alert.remove();
                        }, 3000);
                    });
                }
            });
        }
    });
</script>
@endsection
