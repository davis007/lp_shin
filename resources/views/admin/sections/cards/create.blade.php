@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>カード作成</h1>
            <p class="text-muted">
                セクション: {{ $section->title }} ({{ $section->type }}) |
                ランディングページ: {{ $section->landingPage->title }}
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.sections.cards.store', $section) }}" method="POST" enctype="multipart/form-data">
                @include('admin.sections.cards._form')
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
