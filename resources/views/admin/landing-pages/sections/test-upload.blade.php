@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>テストアップロード</h1>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.landing-pages.sections.store', 1) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">タイトル</label>
                    <input type="text" class="form-control" id="title" name="title" value="テストセクション">
                </div>
                <input type="hidden" name="type" value="text">
                <div class="form-group">
                    <label for="content">テキスト内容</label>
                    <textarea class="form-control" id="content" name="content" rows="5">テストコンテンツ</textarea>
                </div>
                <div class="form-group">
                    <label for="bg_image">背景画像</label>
                    <input type="file" class="form-control-file" id="bg_image" name="bg_image">
                </div>
                <button type="submit" class="btn btn-primary">送信</button>
            </form>
        </div>
    </div>
</div>
@endsection
