@extends('front.layout')

@section('title', '譲渡会情報 | いろねこ')

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

    .event-card {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: var(--shadow);
        margin-bottom: 2rem;
        border-left: 5px solid var(--secondary-color);
    }

    .event-date {
        display: inline-block;
        background: var(--secondary-color);
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 25px;
        font-weight: bold;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .event-time {
        display: inline-block;
        background: var(--accent-color);
        padding: 0.3rem 1rem;
        border-radius: 15px;
        margin-left: 1rem;
    }

    .event-info {
        margin: 1.5rem 0;
    }

    .event-info p {
        margin: 0.5rem 0;
        line-height: 1.8;
    }

    .participating-cats {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 2px solid #eee;
    }

    .participating-cats h4 {
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .cat-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .cat-badge {
        display: inline-block;
        background: var(--bg-light);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        color: var(--text-dark);
        text-decoration: none;
        transition: background 0.3s;
    }

    .cat-badge:hover {
        background: var(--accent-color);
    }

    .no-events {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--bg-light);
        border-radius: 15px;
        margin: 2rem 0;
    }

    .no-events p {
        font-size: 1.2rem;
        color: var(--text-light);
    }
</style>
@endsection

@section('content')
<section class="page-header">
    <h1>譲渡会情報</h1>
    <p>猫たちとの出会いの場です</p>
</section>

<section class="container">
    @if($events->count() > 0)
        @foreach($events as $event)
            <div class="event-card">
                <div>
                    <span class="event-date">
                        {{ $event->event_date->format('Y年m月d日') }}（{{ ['日', '月', '火', '水', '木', '金', '土'][$event->event_date->dayOfWeek] }}）
                    </span>
                    <span class="event-time">
                        {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}〜{{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                    </span>
                </div>

                <h2 style="color: var(--primary-color); margin: 1rem 0; font-size: 1.8rem;">
                    {{ $event->title }}
                </h2>

                @if($event->description)
                    <p style="margin: 1rem 0;">{{ $event->description }}</p>
                @endif

                <div class="event-info">
                    <p><strong>📍 会場:</strong> {{ $event->venue }}</p>
                    @if($event->address)
                        <p><strong>住所:</strong> {{ $event->address }}</p>
                    @endif
                    @if($event->access_info)
                        <p><strong>アクセス:</strong> {{ $event->access_info }}</p>
                    @endif
                    @if($event->notes)
                        <p><strong>📝 注意事項:</strong> {{ $event->notes }}</p>
                    @endif
                </div>

                @if($event->cats->count() > 0)
                    <div class="participating-cats">
                        <h4>🐱 参加予定の猫たち</h4>
                        <div class="cat-badges">
                            @foreach($event->cats as $cat)
                                <a href="{{ route('cats.detail', $cat) }}" class="cat-badge">
                                    {{ $cat->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    @else
        <div class="no-events">
            <p>現在予定されている譲渡会はありません。</p>
            <p style="margin-top: 1rem;">次回の開催をお楽しみに!</p>
        </div>
    @endif
</section>
@endsection
