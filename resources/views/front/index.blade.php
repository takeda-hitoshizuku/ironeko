@extends('front.layout')

@section('title', 'いろいろ🎶いろんな猫の会（いろねこ）| ホーム')

@section('styles')
<style>
    .hero {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
        padding: 6rem 2rem;
        text-align: center;
    }

    .hero h1 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .hero p {
        font-size: 1.2rem;
        margin-bottom: 2rem;
    }

    .section-title {
        text-align: center;
        font-size: 2rem;
        margin-bottom: 3rem;
        color: var(--primary-color);
    }

    .cats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .cat-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: transform 0.3s;
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .cat-card:hover {
        transform: scale(1.05);
    }

    .cat-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .cat-info {
        padding: 1.5rem;
    }

    .cat-info h3 {
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .event-card {
        background: var(--bg-light);
        padding: 2rem;
        border-radius: 15px;
        border-left: 5px solid var(--secondary-color);
        margin-bottom: 2rem;
    }

    .event-date {
        display: inline-block;
        background: var(--secondary-color);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .timeline {
        position: relative;
        padding: 2rem 0;
    }

    .timeline-item {
        margin-bottom: 2rem;
        padding-left: 3rem;
        position: relative;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 15px;
        height: 15px;
        background: var(--secondary-color);
        border-radius: 50%;
    }

    .timeline-date {
        color: var(--text-light);
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
</style>
@endsection

@section('content')
<section class="hero">
    <h1>いろいろ🎶いろんな猫の会（いろねこ）</h1>
    <p>すべての猫に幸せな家族を見つけるために</p>
    <a href="{{ route('events') }}" class="btn">次回の譲渡会を見る</a>
</section>

<section class="container">
    <h2 class="section-title">里親募集中の猫たち</h2>
    <div class="cats-grid">
        @forelse($recentCats as $cat)
            <a href="{{ route('cats.detail', $cat) }}" class="cat-card">
                @if($cat->images && count($cat->images) > 0)
                    <img src="{{ Storage::url($cat->images[0]) }}" alt="{{ $cat->name }}" class="cat-image">
                @else
                    <div class="cat-image" style="background: linear-gradient(135deg, #f5f5f5, #e0e0e0); display: flex; align-items: center; justify-content: center; font-size: 4rem;">
                        🐱
                    </div>
                @endif
                <div class="cat-info">
                    <h3>{{ $cat->name }}</h3>
                    <p>
                        <strong>年齢:</strong> {{ $cat->age ?? '不明' }}<br>
                        <strong>性別:</strong> {{ $cat->gender === 'male' ? 'オス' : 'メス' }}
                        @if($cat->is_neutered)（{{ $cat->gender === 'male' ? '去勢' : '避妊' }}済）@endif
                    </p>
                </div>
            </a>
        @empty
            <p>現在募集中の猫はいません。</p>
        @endforelse
    </div>
    <div style="text-align: center;">
        <a href="{{ route('cats') }}" class="btn">もっと見る</a>
    </div>
</section>

<section class="container" style="background: var(--bg-light);">
    <h2 class="section-title">譲渡会情報</h2>
    @forelse($upcomingEvents as $event)
        <div class="event-card">
            <span class="event-date">{{ $event->event_date->format('Y年m月d日(D)') }}</span>
            <h3>{{ $event->title }}</h3>
            <p>
                <strong>時間:</strong> {{ $event->start_time->format('H:i') }}〜{{ $event->end_time->format('H:i') }}<br>
                <strong>場所:</strong> {{ $event->venue }}
            </p>
        </div>
    @empty
        <p style="text-align: center;">現在予定されている譲渡会はありません。</p>
    @endforelse
    <div style="text-align: center; margin-top: 2rem;">
        <a href="{{ route('events') }}" class="btn">すべての譲渡会を見る</a>
    </div>
</section>

<section class="container">
    <h2 class="section-title">活動報告</h2>
    <div class="timeline">
        @forelse($recentPosts as $post)
            <div class="timeline-item">
                <div class="timeline-date">{{ $post->post_date->format('Y年m月d日') }}</div>
                <h3>{{ $post->title }}</h3>
                <p>{!! Str::limit(strip_tags($post->content), 100) !!}</p>
            </div>
        @empty
            <p>活動報告はまだありません。</p>
        @endforelse
    </div>
    <div style="text-align: center;">
        <a href="{{ route('activity') }}" class="btn">もっと見る</a>
    </div>
</section>
@endsection
