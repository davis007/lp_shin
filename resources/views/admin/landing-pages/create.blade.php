@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>ランディングページ作成</h1>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.landing-pages.store') }}" method="POST" enctype="multipart/form-data">
                @include('admin.landing-pages._form')
            </form>
        </div>
    </div>
</div>
@endsection
