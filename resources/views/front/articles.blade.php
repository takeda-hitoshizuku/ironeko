@extends('front.layout')

@section('title', '記事一覧 | いろねこ')

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

        .category-filter {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
            margin-bottom: 3rem;
            padding: 2rem;
            background: var(--bg-light);
            border-radius: 15px;
        }

        .category-btn {
            padding: 0.6rem 1.5rem;
            background: white;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
        }

        .category-btn:hover,
        .category-btn.active {
            background: var(--primary-color);
            color: white;
        }

        .articles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .article-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
        }

        .article-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        .article-thumbnail {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: var(--bg-light);
        }

        .article-content {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .article-category {
            display: inline-block;
            padding: 0.3rem 1rem;
            background: var(--accent-color);
            color: var(--text-dark);
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
            margin-bottom: 1rem;
            width: fit-content;
        }

        .article-title {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 1rem;
            line-height: 1.4;
        }

        .article-date {
            color: var(--text-light);
            font-size: 0.9rem;
            margin-top: auto;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 3rem;
        }

        .pagination a,
        .pagination span {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            color: var(--text-dark);
            transition: all 0.3s;
        }

        .pagination a:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .pagination .active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .no-articles {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-light);
        }

        @media (max-width: 768px) {
            .articles-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
@section('content')
    <section class="page-header" style="background-image: url('{{ asset('images/header.webp') }}');">
        <h1>記事一覧</h1>
        <p>猫との暮らしに役立つ情報</p>
    </section>

    <x-breadcrumb :items="[['label' => '記事一覧', 'url' => '']]" />

    <section class="container">
        <!-- カテゴリフィルター -->
        <div class="category-filter">
            <a class="category-btn {{ !$category ? 'active' : '' }}" href="{{ route('articles') }}">
                すべて
            </a>
            @foreach ($categories as $key => $label)
                <a class="category-btn {{ $category === $key ? 'active' : '' }}"
                    href="{{ route('articles', ['category' => $key]) }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <!-- 記事グリッド -->
        @if ($articles->count() > 0)
            <div class="articles-grid">
                @foreach ($articles as $article)
                    <a class="article-card" href="{{ route('articles.detail', $article->slug) }}">
                        @if ($article->thumbnail)
                            <img class="article-thumbnail" src="{{ Storage::url($article->thumbnail) }}"
                                alt="{{ $article->title }}">
                        @else
                            <img class="article-thumbnail" src="{{ asset('images/no-image.png') }}" alt="No Image">
                        @endif

                        <div class="article-content">
                            <span class="article-category">{{ $article->category_name }}</span>
                            <h2 class="article-title">{{ $article->title }}</h2>
                            <p class="article-date">{{ $article->published_at->format('Y年m月d日') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- ページネーション -->
            <div class="pagination">
                {{ $articles->links() }}
            </div>
        @else
            <div class="no-articles">
                <p>記事がまだありません。</p>
            </div>
        @endif
    </section>
@endsection
