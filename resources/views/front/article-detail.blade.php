@extends('front.layout')

@section('title', $article->title . ' | いろねこ')

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
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .article-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .article-category {
            display: inline-block;
            padding: 0.4rem 1.2rem;
            background: var(--accent-color);
            color: var(--text-dark);
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .article-title {
            font-size: 2rem;
            line-height: 1.4;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        .article-date {
            color: var(--text-light);
            font-size: 0.95rem;
        }

        .article-thumbnail {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 2rem;
        }

        .article-body {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            line-height: 1.8;
            margin-bottom: 3rem;
        }

        .article-body h2 {
            color: var(--primary-color);
            margin-top: 2rem;
            margin-bottom: 1rem;
            font-size: 1.5rem;
            border-left: 4px solid var(--primary-color);
            padding-left: 1rem;
        }

        .article-body h3 {
            color: var(--text-dark);
            margin-top: 1.5rem;
            margin-bottom: 0.8rem;
            font-size: 1.2rem;
        }

        .article-body p {
            margin-bottom: 1rem;
        }

        .article-body ul,
        .article-body ol {
            margin-bottom: 1rem;
            padding-left: 2rem;
        }

        .article-body li {
            margin-bottom: 0.5rem;
        }

        .article-body img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin: 1.5rem 0;
        }

        .back-link {
            display: inline-block;
            padding: 0.8rem 2rem;
            background: var(--bg-light);
            color: var(--text-dark);
            text-decoration: none;
            border-radius: 50px;
            margin-bottom: 2rem;
            transition: all 0.3s;
        }

        .back-link:hover {
            background: var(--primary-color);
            color: white;
        }

        .related-articles {
            margin-top: 4rem;
            padding-top: 3rem;
            border-top: 2px solid #eee;
        }

        .related-articles h2 {
            text-align: center;
            font-size: 1.8rem;
            margin-bottom: 2rem;
            color: var(--primary-color);
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .related-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            text-decoration: none;
            color: inherit;
        }

        .related-card:hover {
            transform: translateY(-5px);
        }

        .related-thumbnail {
            width: 100%;
            height: 150px;
            object-fit: cover;
            background: var(--bg-light);
        }

        .related-content {
            padding: 1rem;
        }

        .related-title {
            font-size: 1rem;
            font-weight: bold;
            line-height: 1.4;
        }

        @media (max-width: 768px) {
            .article-title {
                font-size: 1.5rem;
            }

            .article-body {
                padding: 1.5rem;
            }

            .related-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <section class="page-header" style="background-image: url('{{ asset('images/header.webp') }}');">
        <h1>記事</h1>
        <p>猫との暮らしに役立つ情報</p>
    </section>

    <x-breadcrumb :items="[
        ['label' => '記事一覧', 'url' => route('articles')],
        ['label' => $article->category_name, 'url' => route('articles', ['category' => $article->category])],
        ['label' => $article->title, 'url' => ''],
    ]" />

    <section class="container">
        <a class="back-link" href="{{ route('articles') }}">← 記事一覧に戻る</a>

        <article>
            <div class="article-header">
                <span class="article-category">{{ $article->category_name }}</span>
                <h1 class="article-title">{{ $article->title }}</h1>
                <p class="article-date">{{ $article->published_at->format('Y年m月d日') }}</p>
            </div>

            @if ($article->thumbnail)
                <img class="article-thumbnail" src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}">
            @endif

            <div class="article-body">
                {!! $article->content !!}
            </div>
        </article>

        <!-- 関連記事 -->
        @if ($relatedArticles->count() > 0)
            <div class="related-articles">
                <h2>関連記事</h2>
                <div class="related-grid">
                    @foreach ($relatedArticles as $related)
                        <a class="related-card" href="{{ route('articles.detail', $related->slug) }}">
                            @if ($related->thumbnail)
                                <img class="related-thumbnail" src="{{ Storage::url($related->thumbnail) }}"
                                    alt="{{ $related->title }}">
                            @else
                                <img class="related-thumbnail" src="{{ asset('images/no-image.png') }}" alt="No Image">
                            @endif
                            <div class="related-content">
                                <h3 class="related-title">{{ $related->title }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
@endsection
