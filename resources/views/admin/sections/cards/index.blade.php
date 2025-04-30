@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.css">
<style>
    .card-item {
        cursor: move;
        transition: background-color 0.3s;
    }
    .card-item:hover {
        background-color: #f8f9fa;
    }
    .card-item.sortable-ghost {
        opacity: 0.5;
        background-color: #e9ecef;
    }
    .card-handle {
        cursor: move;
        color: #adb5bd;
    }
    .card-thumbnail {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 4px;
    }
    /* スクロールバーを非表示にする */
    .list-group {
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none; /* IE and Edge */
    }
    .list-group::-webkit-scrollbar {
        display: none; /* Chrome, Safari, Opera */
        width: 0;
        height: 0;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>カード管理</h1>
            <p class="text-muted">
                セクション: {{ $section->title }} ({{ $section->type }}) |
                ランディングページ: {{ $section->landingPage->title }}
            </p>
        </div>
        <div class="col-md-6 text-right">
            <div class="btn-group" role="group">
                <a href="{{ route('admin.sections.cards.create', $section) }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> 新規カード
                </a>
                <a href="{{ route('admin.landing-pages.preview', $section->landingPage) }}" class="btn btn-secondary" target="_blank">
                    <i class="fas fa-desktop"></i> プレビュー
                </a>
                <a href="{{ route('admin.sections.edit', $section) }}" class="btn btn-info">
                    <i class="fas fa-edit"></i> セクション編集
                </a>
            </div>
        </div>
    </div>

    @if($section->cards->isEmpty())
        <div class="alert alert-info">
            カードがまだ作成されていません。
        </div>
    @else
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">カード一覧（ドラッグ&ドロップで並び替え）</h5>
            </div>
            <div class="card-body">
                <ul class="list-group" id="cards-list">
                    @foreach($section->cards->sortBy('order') as $card)
                        <li class="list-group-item card-item d-flex justify-content-between align-items-center" data-id="{{ $card->id }}">
                            <div class="d-flex align-items-center">
                                <span class="card-handle mr-3">
                                    <i class="fas fa-grip-vertical"></i>
                                </span>
                                @if($card->image_path)
                                    <img src="{{ asset('storage/' . $card->image_path) }}" alt="{{ $card->title }}" class="card-thumbnail mr-3">
                                @endif
                                <div>
                                    <h5 class="mb-1">{{ $card->title }}</h5>
                                    <p class="mb-0 text-muted">
                                        順序: {{ $card->order }} |
                                        作成日: {{ $card->created_at->format('Y-m-d') }}
                                    </p>
                                </div>
                            </div>
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
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="form-group">
        <a href="{{ route('admin.landing-pages.sections.index', $section->landingPage) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> セクション一覧に戻る
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cardsList = document.getElementById('cards-list');

        if (cardsList) {
            new Sortable(cardsList, {
                animation: 150,
                handle: '.card-handle',
                ghostClass: 'sortable-ghost',
                onEnd: function() {
                    const cards = [];
                    document.querySelectorAll('#cards-list .card-item').forEach(item => {
                        cards.push(item.dataset.id);
                    });

                    // 並び順を保存
                    fetch('{{ route("admin.sections.reorder") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ cards: cards })
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
