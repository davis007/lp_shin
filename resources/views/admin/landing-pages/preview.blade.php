<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $landingPage->meta_description }}">
    <title>{{ $landingPage->title }}</title>
    <!-- Bootstrap 4.5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Custom Styles -->

    <style>
        /* 基本スタイル */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-snap-type: y mandatory;
            overflow-y: scroll;
        }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;
            position: relative;
        }

        /* プレビューバー */
        .preview-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #333;
            color: white;
            padding: 10px;
            z-index: 2000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .preview-bar a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
        }
        .preview-bar a:hover {
            text-decoration: underline;
        }
        .preview-bar .badge {
            margin-left: 10px;
        }

        /* ヘッダースタイル */
        header {
            position: fixed;
            top: 60px; /* プレビューバーの高さ分下げる */
            left: 0;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            padding: 0.8rem 0;
        }

        #site-title {
            font-size: 1.5rem;
            margin: 0;
            color: #333;
            font-weight: 600;
        }

        .burger-menu {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #333;
            cursor: pointer;
            padding: 0.25rem 0.5rem;
        }

        .burger-menu:focus {
            outline: none;
            box-shadow: none;
        }

        .dropdown-menu {
            border-radius: 0.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: none;
            padding: 0.5rem 0;
        }

        .dropdown-item {
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            color: #333;
            transition: background-color 0.2s;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #0066cc;
        }

        /* サイドナビゲーション */
        .side-navigation {
            position: fixed;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            flex-direction: column;
            gap: 15px;
            z-index: 1000;
        }

        .nav-button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s, background-color 0.3s;
        }

        .nav-button:hover {
            transform: scale(1.1);
            background-color: #0066cc;
            color: white;
        }

        .nav-button:focus {
            outline: none;
        }

        /* メインコンテンツ */
        main {
            padding-top: 120px; /* ヘッダー + プレビューバーの高さ分 */
            padding-bottom: 100px; /* フッターの高さ分 */
        }

        .section {
            height: 100vh;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            scroll-snap-align: start;
            position: relative;
            overflow: hidden;
        }

        /* セクションA: 画像表示タイプ */
        .image-container {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .main-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            max-width: 750px;
        }

        /* セクションB: デザイン文章タイプ */
        .bg-image-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: -1;
        }

        .bg-image {
            width: 100%;
            max-width: 750px;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.7);
        }

        .content-wrapper {
            width: 100%;
            max-width: 750px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            text-align: center;
            z-index: 1;
            margin: 0 auto;
            position: relative;
        }

        .content-container {
            background-color: rgba(255, 255, 255, 0.85);
            padding: 2rem;
            border-radius: 1rem;
            max-width: 750px;
            width: 90%;
            margin: 0 auto;
        }

        .content-container h2 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .content-container p {
            font-size: 1rem;
            color: #555;
        }

        /* セクションC: 横スライドタイプ */
        .slider-container {
            width: 100%;
            max-width: 750px;
            margin: 2rem auto 0;
            position: relative;
        }

        .card-slider {
            width: 100%;
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            padding: 1rem 0;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE and Edge */
        }

        /* Chrome, Safari and Opera */
        .card-slider::-webkit-scrollbar {
            display: none;
            width: 0;
            height: 0;
        }

        .slider-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .slider-arrow.prev {
            left: -20px;
        }

        .slider-arrow.next {
            right: -20px;
        }

        .card {
            margin: 0 0.5rem;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: none;
            flex: 0 0 auto;
            width: 250px;
            scroll-snap-align: start;
        }

        .card-img-top {
            height: 0;
            padding-bottom: 100%; /* 1:1 aspect ratio for square images */
            position: relative;
            overflow: hidden;
        }

        .card-img-top img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            max-width: 750px;
        }

        .card-body {
            padding: 1.25rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .card-text {
            font-size: 0.9rem;
            color: #666;
        }

        /* セクションE: Q&Aアコーディオン */
        .qa-section {
            background-color: #f8f9fa;
        }

        .qa-container {
            width: 100%;
            max-width: 750px;
            margin: 0 auto;
        }

        .qa-description {
            margin-bottom: 2rem;
            color: #666;
        }

        .qa-item {
            margin-bottom: 1rem;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .qa-question {
            padding: 1rem 1.5rem;
            background-color: #fff;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s;
        }

        .qa-question:hover {
            background-color: #f0f0f0;
        }

        .qa-question h3 {
            font-size: 1.1rem;
            margin: 0;
            font-weight: 600;
            color: #333;
        }

        .toggle-icon {
            font-size: 0.9rem;
            color: #0066cc;
            transition: transform 0.3s;
        }

        .qa-question[aria-expanded="true"] .toggle-icon {
            transform: rotate(45deg);
        }

        .qa-answer {
            padding: 0 1.5rem 1.5rem;
            background-color: #fff;
        }

        /* フッター */
        #fixed-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
            z-index: 1050;
        }

        /* モーダルのz-index調整 */
        .modal {
            z-index: 9999 !important;
        }
        .modal-backdrop {
            z-index: 9998 !important;
        }
        .modal-open {
            overflow: auto !important;
            padding-right: 0 !important;
        }

        .footer-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            max-width: 750px;
            margin: 0 auto;
            width: 100%;
        }

        .micro-copy {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .cta-button {
            display: block;
            width: 100%;
            max-width: 750px;
            background-color: #0066cc;
            color: white;
            text-align: center;
            padding: 0.75rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            box-shadow: 0 4px 8px rgba(0, 102, 204, 0.3);
        }

        .cta-button:hover {
            background-color: #0055aa;
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 102, 204, 0.4);
        }

        /* アニメーション */
        .section {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s, transform 0.5s;
        }

        .section.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* レスポンシブ対応 */
        @media (max-width: 768px) {
            header {
                top: 40px; /* プレビューバーの高さ分下げる（モバイル用） */
            }

            main {
                padding-top: 100px; /* ヘッダー + プレビューバーの高さ分（モバイル用） */
            }

            .preview-bar {
                padding: 5px;
                font-size: 0.8rem;
            }

            .preview-bar a {
                margin-left: 8px;
            }
        }
    </style>
</head>
<body>
    @if(Route::currentRouteName() == 'admin.landing-pages.preview')
    <div class="preview-bar">
        <div>
            <strong>プレビュー:</strong> {{ $landingPage->title }}
            @if($landingPage->is_published)
                <span class="badge bg-success">公開中</span>
            @else
                <span class="badge bg-secondary">非公開</span>
            @endif
        </div>
        <div>
            <a href="{{ route('admin.landing-pages.edit', $landingPage) }}">編集する</a>
            <a href="{{ route('admin.landing-pages.sections.index', $landingPage) }}">セクション管理</a>
            <a href="{{ route('admin.landing-pages.index') }}">一覧に戻る</a>
        </div>
    </div>
    @endif

    <!-- ヘッダー -->
    <header style="{{ Route::currentRouteName() != 'admin.landing-pages.preview' ? 'top: 0;' : '' }}">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-8">
                    <h1 id="site-title">{{ $landingPage->title }}</h1>
                </div>
                <div class="col-4 text-right">
                    <div class="dropdown">
                        <button class="btn burger-menu" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            @foreach($landingPage->sections->sortBy('order') as $section)
                                <a class="dropdown-item" href="#section{{ $section->id }}">{{ $section->title }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- サイドナビゲーション（モバイルのみ表示） -->
    <div class="side-navigation d-md-none">
        <button id="prevSection" class="nav-button"><i class="fas fa-chevron-up"></i></button>
        <button id="nextSection" class="nav-button"><i class="fas fa-chevron-down"></i></button>
    </div>

    <!-- メインコンテンツ -->
    <main style="{{ Route::currentRouteName() != 'admin.landing-pages.preview' ? 'padding-top: 60px;' : '' }}">
        @if($landingPage->sections->isEmpty())
            <div class="container py-5 text-center">
                <div class="alert alert-info">
                    <h4>セクションがまだ作成されていません</h4>
                    <p>このランディングページにはセクションがありません。セクションを追加してコンテンツを作成してください。</p>
                    <a href="{{ route('admin.landing-pages.sections.create', $landingPage) }}" class="btn btn-primary">
                        セクションを追加する
                    </a>
                </div>
            </div>
        @else
            @foreach($landingPage->sections->sortBy('order') as $section)
                <section id="section{{ $section->id }}" class="section {{ $loop->first ? 'active' : '' }}">
                    @if($section->type == 'header')
                        <!-- ヘッダーセクション -->
                        <div class="image-container">
                            <img src="{{ asset('storage/' . $section->image_path) }}" alt="{{ $section->title }}" class="main-image">
                        </div>
                    @elseif($section->type == 'text')
                        <!-- テキストセクション -->
                        <div class="bg-image-container">
                            @if($section->image_path)
                                <img src="{{ asset('storage/' . $section->image_path) }}" alt="背景画像" class="bg-image">
                            @endif
                        </div>
                        <div class="content-wrapper">
                            <div class="content-container">
                                <h2>{{ $section->title }}</h2>
                                @if($section->cards->isNotEmpty())
                                    {!! nl2br(e($section->cards->first()->content)) !!}
                                @else
                                    <p class="text-muted">このテキストセクションにはコンテンツがありません。</p>
                                @endif
                            </div>
                        </div>
                    @elseif($section->type == 'image')
                        <!-- 画像セクション -->
                        <div class="image-container">
                            @if($section->image_path)
                                <img src="{{ asset('storage/' . $section->image_path) }}" alt="{{ $section->title }}" class="main-image">
                            @elseif($section->cards->isNotEmpty() && $section->cards->first()->image_path)
                                <img src="{{ asset('storage/' . $section->cards->first()->image_path) }}" alt="{{ $section->cards->first()->title }}" class="main-image">
                            @else
                                <div class="bg-light p-5 rounded">
                                    <p class="text-muted">画像がありません</p>
                                </div>
                            @endif
                        </div>
                    @elseif($section->type == 'cards')
                        <!-- カードセクション -->
                        <div class="content-wrapper">
                            <div class="content-container">
                                <h2 class="section-title">{{ $section->title }}</h2>
                                <div class="slider-container">
                                    <div class="slider-arrow prev" onclick="scrollCards(this, -1)">
                                        <i class="fas fa-chevron-left"></i>
                                    </div>
                                    <div class="card-slider">
                                        @forelse($section->cards->sortBy('order') as $card)
                                            <div class="card">
                                                @if($card->image_path)
                                                    <div class="card-img-top">
                                                        <img src="{{ asset('storage/' . $card->image_path) }}" alt="{{ $card->title }}">
                                                    </div>
                                                @endif
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $card->title }}</h5>
                                                    <p class="card-text">{!! nl2br(e($card->content)) !!}</p>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="card w-100 text-center">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $section->title }}</h5>
                                                    <p class="card-text text-muted">ここにカードが表示されます</p>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                    <div class="slider-arrow next" onclick="scrollCards(this, 1)">
                                        <i class="fas fa-chevron-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($section->type == 'cta')
                        <!-- CTAセクション -->
                        <div class="content-wrapper">
                            <div class="content-container">
                                @if($section->cards->isNotEmpty())
                                    <h3>{{ $section->title }}</h3>
                                    @php
                                        $contentData = json_decode($section->cards->first()->content, true);
                                        $microcopy = $contentData['microcopy'] ?? $section->cards->first()->content;
                                        $buttonText = $contentData['button_text'] ?? '';
                                    @endphp
                                    <p class="lead">{!! nl2br(e($microcopy)) !!}</p>

                                    @if($section->cards->first()->title == 'modal')
                                        <!-- モーダルタイプのCTA -->
                                        <a href="#ctaModal{{ $section->id }}" data-toggle="modal" class="contact-btn">{{ $buttonText }}</a>

                                        <!-- QRコードモーダル -->
                                        <div class="modal fade" id="ctaModal{{ $section->id }}" tabindex="-1" role="dialog" aria-labelledby="ctaModalLabel{{ $section->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="ctaModalLabel{{ $section->id }}">{{ $section->title }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        @if($section->cards->first()->image_path)
                                                            <img src="{{ asset('storage/' . $section->cards->first()->image_path) }}" alt="QRコード" class="img-fluid" style="max-width: 300px;">
                                                            <p class="mt-3">上記のQRコードをスキャンしてください</p>
                                                        @else
                                                            <p class="text-muted">QRコードが設定されていません</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($section->cards->first()->title == 'link')
                                        <!-- リンクタイプのCTA -->
                                        <a href="{{ $section->cards->first()->image_path }}" target="_blank" class="contact-btn">{{ $buttonText }}</a>
                                    @endif
                                @else
                                    <h3>アクションを促すセクション</h3>
                                    <p class="text-muted">このCTAセクションにはコンテンツがありません。</p>
                                    <a href="#contactModal" data-toggle="modal" class="contact-btn">ボタン</a>
                                @endif
                            </div>
                        </div>
                    @elseif($section->type == 'footer')
                        <!-- フッターセクション -->
                        <div class="content-wrapper">
                            <div class="content-container">
                                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                                @if($section->cards->isNotEmpty())
                                    <p>{!! nl2br(e($section->cards->first()->content)) !!}</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </section>
            @endforeach
        @endif
    </main>

    <!-- お問い合わせモーダル -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactModalLabel">お問い合わせフォーム</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="contactForm" action="#" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">お名前</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">メールアドレス</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="message">お問い合わせ内容</label>
                            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                        </div>
                        <input type="hidden" name="source" value="LP: {{ $landingPage->title }}">
                        <button type="submit" class="btn btn-primary btn-block">送信する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- フッター -->
    <footer id="fixed-footer">
        <div class="container">
            <div class="footer-content">
                @php
                    // ランディングページのCTA設定を取得
                    $microcopy = $landingPage->cta_microcopy ?? 'お問い合わせはこちらから'; // デフォルト値
                    $buttonText = $landingPage->cta_button_text ?? 'お問い合わせ'; // デフォルト値
                    $ctaType = $landingPage->cta_type;
                    $linkUrl = $landingPage->cta_link_url ?? '#';
                    $qrImage = $landingPage->cta_qr_image;
                    $modalId = 'ctaModal';
                @endphp

                <p class="micro-copy">{{ $microcopy }}</p>
                @if($ctaType == 'modal')
                    <a href="#{{ $modalId }}" data-toggle="modal" class="cta-button">{{ $buttonText }}</a>
                @elseif($ctaType == 'link')
                    <a href="{{ $linkUrl }}" target="_blank" class="cta-button">{{ $buttonText }}</a>
                @else
                    <a href="#" class="cta-button">{{ $buttonText }}</a>
                @endif
            </div>
        </div>
    </footer>

    <!-- jQuery Popper.js Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <!-- Custom Scripts -->

    <!-- QRコードモーダル -->
    @if(isset($ctaType) && $ctaType == 'modal')
    <div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="{{ $modalId }}Label" aria-hidden="true" style="z-index: 9999;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="{{ $modalId }}Label">{{ $landingPage->title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 1.5rem; opacity: 0.8; text-shadow: none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    @if($qrImage)
                        <img src="{{ asset('storage/' . $qrImage) }}" alt="QRコード" class="img-fluid" style="max-width: 300px;">
                        <p class="mt-3">上記のQRコードをスキャンしてください</p>
                    @else
                        <p class="text-muted">QRコードが設定されていません</p>
                    @endif
                    <button type="button" class="btn btn-secondary mt-3" data-dismiss="modal">閉じる</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 要素の取得
            const sections = document.querySelectorAll('.section');
            const navLinks = document.querySelectorAll('.dropdown-item');
            const prevButton = document.getElementById('prevSection');
            const nextButton = document.getElementById('nextSection');
            const contactForm = document.getElementById('contactForm');
            const qaItems = document.querySelectorAll('.qa-item');

            // 初期表示時にアクティブなセクションを設定
            setActiveSection();

            // スクロールイベントのリスナーを追加
            window.addEventListener('scroll', function() {
                // スクロール位置によってアクティブなセクションを設定
                setActiveSection();
            });

            // ナビゲーションリンクのクリックイベント
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    // ドロップダウンメニューを閉じる
                    const dropdownToggle = document.getElementById('dropdownMenuButton');
                    if (dropdownToggle) {
                        $(dropdownToggle).dropdown('hide');
                    }

                    // クリックされたリンクのターゲットセクションを取得
                    const targetId = this.getAttribute('href');
                    const targetSection = document.querySelector(targetId);

                    // そのセクションにスムーズにスクロール
                    if (targetSection) {
                        targetSection.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            });

            // アクティブなセクションを設定する関数
            function setActiveSection() {
                // 現在のスクロール位置を取得
                const scrollPosition = window.scrollY;

                // 各セクションをチェック
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.offsetHeight;

                    // スクロール位置がセクション内にあるか確認
                    if (scrollPosition >= sectionTop - window.innerHeight / 3 &&
                        scrollPosition < sectionTop + sectionHeight - window.innerHeight / 3) {

                        // すべてのセクションからアクティブクラスを削除
                        sections.forEach(s => s.classList.remove('active'));

                        // 現在のセクションにアクティブクラスを追加
                        section.classList.add('active');

                        // ナビゲーションリンクの更新
                        const currentId = section.getAttribute('id');
                        navLinks.forEach(link => {
                            link.classList.remove('active');
                            if (link.getAttribute('href') === `#${currentId}`) {
                                link.classList.add('active');
                            }
                        });
                    }
                });
            }

            // 現在のセクションインデックスを取得する関数
            function getCurrentSectionIndex() {
                const scrollPosition = window.scrollY;
                let currentIndex = 0;

                sections.forEach((section, index) => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.offsetHeight;

                    if (scrollPosition >= sectionTop - window.innerHeight / 3 &&
                        scrollPosition < sectionTop + sectionHeight - window.innerHeight / 3) {
                        currentIndex = index;
                    }
                });

                return currentIndex;
            }

            // 前のセクションに移動
            if (prevButton) {
                prevButton.addEventListener('click', () => {
                    const currentIndex = getCurrentSectionIndex();
                    if (currentIndex > 0) {
                        sections[currentIndex - 1].scrollIntoView({ behavior: 'smooth' });
                    }
                });
            }

            // 次のセクションに移動
            if (nextButton) {
                nextButton.addEventListener('click', () => {
                    const currentIndex = getCurrentSectionIndex();
                    if (currentIndex < sections.length - 1) {
                        sections[currentIndex + 1].scrollIntoView({ behavior: 'smooth' });
                    }
                });
            }

            // カードスライダーのスクロール処理
            function scrollCards(arrow, direction) {
                const slider = arrow.parentElement.querySelector('.card-slider');
                if (slider) {
                    const cardWidth = 250 + 16; // カードの幅 + マージン
                    slider.scrollBy({ left: cardWidth * direction, behavior: 'smooth' });
                }
            }

            // グローバルスコープに関数を追加
            window.scrollCards = scrollCards;

            // Q&Aアコーディオンの処理
            qaItems.forEach(item => {
                const question = item.querySelector('.qa-question');
                const answer = item.querySelector('.qa-answer');
                const icon = item.querySelector('.toggle-icon i');

                if (question && answer && icon) {
                    question.addEventListener('click', function() {
                        // アコーディオンの開閉状態を切り替え
                        const isExpanded = this.getAttribute('aria-expanded') === 'true';

                        // アイコンの切り替え
                        if (!isExpanded) {
                            icon.classList.remove('fa-plus');
                            icon.classList.add('fa-minus');
                        } else {
                            icon.classList.remove('fa-minus');
                            icon.classList.add('fa-plus');
                        }
                    });
                }
            });

            // 画像のレスポンシブ対応
            function adjustImageDisplay() {
                // メイン画像の調整
                const mainImage = document.querySelector('.main-image');
                if (mainImage) {
                    if (window.innerWidth <= 750) {
                        mainImage.style.maxWidth = '100%';
                    } else {
                        mainImage.style.maxWidth = '750px';
                    }
                }

                // 背景画像の調整
                const bgImages = document.querySelectorAll('.bg-image');
                bgImages.forEach(bgImage => {
                    if (window.innerWidth <= 750) {
                        bgImage.style.maxWidth = '100%';
                    } else {
                        bgImage.style.maxWidth = '750px';
                    }
                });

                // コンテンツラッパーの調整
                const contentWrappers = document.querySelectorAll('.content-wrapper');
                contentWrappers.forEach(wrapper => {
                    if (window.innerWidth <= 750) {
                        wrapper.style.maxWidth = '100%';
                    } else {
                        wrapper.style.maxWidth = '750px';
                    }
                });
            }

            // 初期表示とリサイズ時に画像サイズを調整
            adjustImageDisplay();
            window.addEventListener('resize', adjustImageDisplay);

            // ページ読み込み完了時にも画像サイズを調整
            window.addEventListener('load', adjustImageDisplay);

            // PCサイズの場合はサイドナビゲーションを非表示
            function toggleSideNavigation() {
                const sideNav = document.querySelector('.side-navigation');
                if (sideNav) {
                    if (window.innerWidth > 768) {
                        sideNav.style.display = 'none';
                    } else {
                        sideNav.style.display = 'flex';
                    }
                }
            }

            // 初期表示とリサイズ時にサイドナビゲーションの表示を切り替え
            toggleSideNavigation();
            window.addEventListener('resize', toggleSideNavigation);

            // モーダルの表示時にオーバーレイのz-indexを調整
            $('.modal').on('shown.bs.modal', function () {
                $('.modal-backdrop').css('z-index', '9998');
                $(this).css('z-index', '9999');
            });
        });
    </script>
</body>
</html>
