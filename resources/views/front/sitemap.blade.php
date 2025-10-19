@extends('front.layout')

@section('title', 'サイトマップ | いろねこ')

@section('styles')
    <style>
        .page-header {
            background-size: 100% auto;
            background-position: center top;
            background-repeat: no-repeat;
            color: white;
            padding: 8rem 2rem;
            text-align: center;
            position: relative;
            z-index: 0;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: -1;
        }

        .page-header h1,
        .page-header p {
            position: relative;
            z-index: 1;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .sitemap-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .sitemap-section {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .sitemap-section h2 {
            color: var(--primary-color);
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--primary-color);
        }

        .sitemap-section ul {
            list-style: none;
            padding: 0;
        }

        .sitemap-section ul li {
            margin-bottom: 1rem;
        }

        .sitemap-section ul li a {
            color: var(--text-dark);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
            padding: 0.5rem;
            border-radius: 8px;
        }

        .sitemap-section ul li a:hover {
            background: var(--bg-light);
            color: var(--primary-color);
            padding-left: 1rem;
        }

        .sitemap-section ul li a:before {
            content: "→";
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .sitemap-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <section class="page-header" style="background-image: url('{{ asset('images/header.webp') }}');">
        <h1>サイトマップ</h1>
        <p>全ページ一覧</p>
    </section>

    <x-breadcrumb :items="[['label' => 'サイトマップ', 'url' => '']]" />

    <section class="container">
        <div class="sitemap-grid">
            <!-- メインページ -->
            <div class="sitemap-section">
                <h2>メインページ</h2>
                <ul>
                    <li><a href="{{ route('home') }}">トップページ</a></li>
                    <li><a href="{{ route('about') }}">私たちについて</a></li>
                    <li><a href="{{ route('support') }}">譲渡金/寄付金について</a></li>
                </ul>
            </div>

            <!-- 保護猫 -->
            <div class="sitemap-section">
                <h2>保護猫</h2>
                <ul>
                    <li><a href="{{ route('cats') }}">保護猫一覧</a></li>
                    <li><a href="{{ route('requirements') }}">譲渡条件</a></li>
                </ul>
            </div>

            <!-- イベント・活動 -->
            <div class="sitemap-section">
                <h2>イベント・活動</h2>
                <ul>
                    <li><a href="{{ route('events') }}">譲渡会</a></li>
                    <li><a href="{{ route('activity') }}">活動報告</a></li>
                </ul>
            </div>

            <!-- お役立ち情報 -->
            <div class="sitemap-section">
                <h2>お役立ち情報</h2>
                <ul>
                    <li><a href="{{ route('articles') }}">記事一覧</a></li>
                    <li><a href="{{ route('articles', ['category' => 'preparation']) }}">お迎え準備</a></li>
                    <li><a href="{{ route('articles', ['category' => 'health']) }}">健康管理</a></li>
                    <li><a href="{{ route('articles', ['category' => 'behavior']) }}">しつけ・行動</a></li>
                    <li><a href="{{ route('articles', ['category' => 'basics']) }}">猫の基礎知識</a></li>
                    <li><a href="{{ route('articles', ['category' => 'goods']) }}">おすすめグッズ</a></li>
                </ul>
            </div>

            <!-- お問い合わせ・その他 -->
            <div class="sitemap-section">
                <h2>お問い合わせ・その他</h2>
                <ul>
                    <li><a href="{{ route('contact') }}">お問い合わせ</a></li>
                    <li><a href="{{ route('privacy') }}">プライバシーポリシー</a></li>
                </ul>
            </div>
        </div>
    </section>
@endsection
