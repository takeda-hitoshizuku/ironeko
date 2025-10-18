@extends('front.layout')

@section('title', '活動報告 | いろねこ')

@section('styles')
    <style>
        .page-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 4rem 2rem;
            text-align: center;
        }

        .page-header h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .post-card {
            background: white;
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }

        .post-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .post-date {
            color: var(--text-light);
            font-size: 0.95rem;
        }

        .post-category {
            display: inline-block;
            padding: 0.3rem 1rem;
            border-radius: 15px;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .category-adoption {
            background: #d4edda;
            color: #155724;
        }

        .category-rescue {
            background: #fff3cd;
            color: #856404;
        }

        .category-event {
            background: #d1ecf1;
            color: #0c5460;
        }

        .category-other {
            background: #e2e3e5;
            color: #383d41;
        }

        .post-title {
            font-size: 1.8rem;
            color: var(--primary-color);
            margin: 1rem 0;
        }

        .post-content {
            line-height: 1.8;
            color: var(--text-dark);
        }

        .post-images {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .post-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
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
            border-radius: 5px;
            text-decoration: none;
            background: white;
            color: var(--text-dark);
            border: 1px solid #ddd;
        }

        .pagination a:hover {
            background: var(--primary-color);
            color: white;
        }

        .pagination .active {
            background: var(--primary-color);
            color: white;
        }
    </style>
@endsection

@section('content')
    <section class="page-header">
        <h1>活動報告</h1>
        <p>いろねこの日々の活動をお伝えします</p>
    </section>

    <section class="container">
        @forelse($posts as $post)
            <article class="post-card">
                <div class="post-meta">
                    <span class="post-date">📅 {{ $post->post_date->format('Y年m月d日') }}</span>
                    <span class="post-category category-{{ $post->category }}">
                        @if ($post->category === 'adoption')
                            譲渡報告
                        @elseif($post->category === 'rescue')
                            保護報告
                        @elseif($post->category === 'event')
                            イベント報告
                        @else
                            その他
                        @endif
                    </span>
                </div>

                <h2 class="post-title">{{ $post->title }}</h2>

                <div class="post-content">
                    {!! $post->content !!}
                </div>

                @if ($post->images && count($post->images) > 0)
                    <div class="post-images">
                        @foreach ($post->images as $image)
                            <img class="post-image" src="{{ Storage::url($image) }}" alt="{{ $post->title }}">
                        @endforeach
                    </div>
                @endif
            </article>
        @empty
            <div style="text-align: center; padding: 4rem 0; background: var(--bg-light); border-radius: 15px;">
                <p style="font-size: 1.2rem; color: var(--text-light);">
                    活動報告はまだありません。
                </p>
            </div>
        @endforelse

        @if ($posts->hasPages())
            <div class="pagination">
                {{-- 前へ --}}
                @if ($posts->onFirstPage())
                    <span>« 前へ</span>
                @else
                    <a href="{{ $posts->previousPageUrl() }}">« 前へ</a>
                @endif

                {{-- ページ番号 --}}
                @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                    @if ($page == $posts->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- 次へ --}}
                @if ($posts->hasMorePages())
                    <a href="{{ $posts->nextPageUrl() }}">次へ »</a>
                @else
                    <span>次へ »</span>
                @endif
            </div>
        @endif
    </section>
@endsection
