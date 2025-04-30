@extends('layouts.admin')

@section('content')
<div class="container">
	<div class="row mb-4">
		<div class="col-md-12">
			<h1>セクション作成</h1>
			<p class="text-muted">ランディングページ: {{ $landingPage->title }}</p>
		</div>
	</div>

	<div class="card">
		<div class="card-body">
			<form action="{{ route('admin.landing-pages.sections.store', $landingPage) }}" method="POST" enctype="multipart/form-data">
				@include('admin.landing-pages.sections._form')
			</form>
		</div>
	</div>
</div>
@endsection
