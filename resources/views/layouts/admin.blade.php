<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }} - 管理画面</title>

	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.bunny.net">
	<link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

	<!-- Bootstrap CSS -->
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

	<style>
		.sidebar {
			min-height: calc(100vh - 56px);
			background-color: #f8f9fa;
			padding-top: 20px;
		}
		.sidebar .nav-link {
			color: #333;
		}
		.sidebar .nav-link:hover {
			background-color: #e9ecef;
		}
		.sidebar .nav-link.active {
			background-color: #007bff;
			color: white;
		}
		.content-wrapper {
			padding: 20px;
		}
		.alert-flash {
			position: fixed;
			top: 20px;
			right: 20px;
			z-index: 9999;
		}
	</style>

	@yield('styles')
</head>
<body>
	<div id="app">
		<nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
			<div class="container-fluid">
				<a class="navbar-brand" href="{{ url('/admin') }}">
					{{ config('app.name', 'Laravel') }} 管理画面
				</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<!-- Left Side Of Navbar -->
					<ul class="navbar-nav me-auto">

					</ul>

					<!-- Right Side Of Navbar -->
					<ul class="navbar-nav ms-auto">
						<!-- Authentication Links -->
						@guest
							@if (Route::has('login'))
								<li class="nav-item">
									<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
								</li>
							@endif

							@if (Route::has('register'))
								<li class="nav-item">
									<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
								</li>
							@endif
						@else
							<li class="nav-item dropdown">
								<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
									{{ Auth::user()->name }}
								</a>

								<div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
									<a class="dropdown-item" href="{{ route('logout') }}"
									   onclick="event.preventDefault();
													 document.getElementById('logout-form').submit();">
										{{ __('Logout') }}
									</a>

									<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
										@csrf
									</form>
								</div>
							</li>
						@endguest
					</ul>
				</div>
			</div>
		</nav>

		<div class="container-fluid">
			<div class="row">
				@auth
					<div class="col-md-2 sidebar">
						<div class="list-group">
							<a href="{{ route('admin.landing-pages.index') }}" class="list-group-item list-group-item-action">
								<i class="fas fa-tachometer-alt mr-2"></i> ダッシュボード
							</a>
							<a href="{{ route('admin.landing-pages.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.landing-pages.*') ? 'active' : '' }}">
								<i class="fas fa-file-alt mr-2"></i> ランディングページ
							</a>
						</div>
					</div>
				@endauth

				<div class="col-md-{{ Auth::check() ? '10' : '12' }} content-wrapper">
					<!-- フラッシュメッセージ -->
					@if (session('success'))
						<div class="alert alert-success alert-flash">
							{{ session('success') }}
						</div>
					@endif

					@if (session('error'))
						<div class="alert alert-danger alert-flash">
							{{ session('error') }}
						</div>
					@endif

					@yield('content')
				</div>
			</div>
		</div>
	</div>

	<!-- Bootstrap JS, Popper.js, and jQuery -->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

	<script>
		// フラッシュメッセージを5秒後に消す
		$(document).ready(function() {
			setTimeout(function() {
				$('.alert-flash').fadeOut('slow');
			}, 5000);
		});
	</script>

	@yield('scripts')
</body>
</html>
