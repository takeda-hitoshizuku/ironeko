@extends('front.layout')

@section('title', '譲渡会情報 | いろねこ')

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
            /* ← これを追加 */
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
            /* ← 1 から -1 に変更 */
        }

        .page-header h1,
        .page-header p {
            position: relative;
            z-index: 1;
            /* ← 2 から 1 に変更 */
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

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }
    </style>
@endsection

@section('content')
    <section class="page-header" style="background-image: url('{{ asset('images/header.webp') }}');">
        <h1>譲渡会情報</h1>
        <p>猫たちとの出会いの場です</p>
    </section>

    <x-breadcrumb :items="[['label' => '譲渡会', 'url' => '']]" />

    <section class="container">
        @if ($events->count() > 0)
            @foreach ($events as $event)
                <div class="event-card">
                    <div>
                        <span class="event-date">
                            {{ $event->event_date->translatedFormat('Y年m月d日(D)') }}
                        </span>
                        <span class="event-time">
                            {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}〜{{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                        </span>
                    </div>

                    <h2 style="color: var(--primary-color); margin: 1rem 0; font-size: 1.8rem;">
                        {{ $event->title }}
                    </h2>

                    @if ($event->description)
                        <p style="margin: 1rem 0;">{{ $event->description }}</p>
                    @endif

                    <div class="event-info">
                        <p><strong>📍 会場:</strong> {{ $event->venue }}</p>
                        @if ($event->address)
                            <p><strong>住所:</strong> {{ $event->address }}</p>

                            @if ($event->address)
                                <div style="margin-top: 1rem;">
                                    <iframe
                                        src="https://maps.google.com/maps?q={{ urlencode($event->address) }}&t=&z=15&ie=UTF8&iwloc=&output=embed"
                                        style="border:0; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);"
                                        width="100%" height="300" loading="lazy" allowfullscreen>
                                    </iframe>
                                </div>
                            @endif
                        @endif
                        @if ($event->access_info)
                            <p><strong>アクセス:</strong> {{ $event->access_info }}</p>
                        @endif
                        @if ($event->notes)
                            <p><strong>📝 注意事項:</strong> {{ $event->notes }}</p>
                        @endif
                    </div>

                    @if ($event->cats->count() > 0)
                        <div class="participating-cats">
                            <h4>🐱 参加予定の猫たち</h4>
                            <div class="cat-badges">
                                @foreach ($event->cats as $cat)
                                    <a class="cat-badge" href="{{ route('cats.detail', $cat) }}">
                                        {{ $cat->name }}
                                        {{ $cat->breed }}
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
