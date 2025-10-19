@extends('front.layout')

@section('title', 'いろいろ🎶いろんな猫の会（いろねこ）| ホーム')

@section('styles')
    <style>
        .hero {
            background-size: 100% auto;
            background-position: center top;
            background-repeat: no-repeat;
            text-align: center;
            padding: 8rem 2rem;
            color: white;
            position: relative;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1;
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

        .about-section {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 3rem;
            align-items: center;
            margin-top: 2rem;
        }

        .about-image {
            width: 100%;
        }

        .about-image img {
            width: 100%;
            height: auto;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .about-content {
            padding: 1rem;
        }

        .about-content p {
            font-size: 1.05rem;
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }

        .about-content strong {
            color: var(--primary-color);
            font-weight: bold;
        }

        .about-content .message-text {
            background: var(--bg-light);
            padding: 1.5rem;
            border-left: 4px solid var(--primary-color);
            border-radius: 8px;
            font-style: italic;
            color: var(--text-dark);
            margin-top: 2rem;
        }

        .support-section {
            background: linear-gradient(135deg, rgba(255, 153, 102, 0.1), rgba(102, 204, 204, 0.1));
            padding: 3rem 2rem;
            border-radius: 15px;
            text-align: center;
        }

        .support-section p {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            .about-section {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .about-image img {
                max-width: 300px;
                margin: 0 auto;
                display: block;
            }
        }

        .cat-card-wrapper {
            position: relative;
        }

        .favorite-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: white;
            border: none;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.5rem;
            transition: all 0.3s;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            z-index: 10;
        }

        .favorite-btn:hover {
            transform: scale(1.1);
        }

        .favorite-btn.active {
            background: var(--primary-color);
        }

        .favorite-count {
            position: absolute;
            bottom: 5.5rem;
            right: 1rem;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            z-index: 10;
        }
    </style>
@endsection

@section('content')
    <section class="hero" style="background-image: url('{{ asset('images/header.webp') }}');">
        <h1>いろいろ🎶いろんな猫の会（いろねこ）</h1>
        <p>君の色に、ぴったりな猫がいる</p>
    </section>

    <section class="container">
        <h2 class="section-title">名前に込めた思い</h2>
        <div class="about-section">
            <div class="about-image">
                <img src="{{ asset('images/logo.jpg') }}" alt="いろねこ">
            </div>
            <div class="about-content">
                <p>いろいろな毛色、いろいろな性格、いろいろな過去。<br>
                    それぞれが違う"いろ"を持つ猫たちに、<br>
                    新しい居場所という未来の色を見つけてあげたい。</p>

                <p>「いろいろ🎶いろんな猫の会」は、<br>
                    純血種の保護猫を中心に、新しい家族を探すお手伝いをしています。</p>
            </div>
        </div>
    </section>

    <section class="container">
        <h2 class="section-title">里親募集中の猫たち</h2>
        <p>穏やかな子、元気いっぱいな子、
            少し人見知りだけど本当は甘えたい子。</p>
        <p>どの子も、あなたと出会う日を待っています。</p>
        <div class="cats-grid">
            @forelse($recentCats as $cat)
                <div class="cat-card-wrapper" style="position: relative;">
                    <a class="cat-card" href="{{ route('cats.detail', $cat) }}">
                        @if ($cat->images && count($cat->images) > 0)
                            <img class="cat-image" src="{{ Storage::url($cat->images[0]) }}" alt="{{ $cat->name }}">
                        @else
                            <div class="cat-image"
                                style="background: linear-gradient(135deg, #f5f5f5, #e0e0e0); display: flex; align-items: center; justify-content: center; font-size: 4rem;">
                                🐱
                            </div>
                        @endif
                        <div class="cat-info">
                            <h3>{{ $cat->name }}</h3>
                            <p>
                                <strong>年齢:</strong> {{ $cat->age ?? '不明' }}<br>
                                <strong>性別:</strong> {{ $cat->gender === 'male' ? 'オス' : 'メス' }}
                                @if ($cat->is_neutered)
                                    （{{ $cat->gender === 'male' ? '去勢' : '避妊' }}済）
                                @endif
                            </p>
                        </div>
                    </a>

                    <!-- ここに追加 -->
                    <button class="favorite-btn" data-cat-id="{{ $cat->id }}"
                        onclick="toggleFavorite(event, {{ $cat->id }})">
                        ❤️
                    </button>

                    <div class="favorite-count">
                        ❤️ <span id="count-{{ $cat->id }}">{{ $cat->favorites_count }}</span>
                    </div>
                </div>
            @empty
                <p>現在募集中の猫はいません。</p>
            @endforelse
        </div>
        <div style="text-align: center;">
            <a class="btn" href="{{ route('cats') }}">もっと見る</a>
        </div>
    </section>

    <section class="container">
        <h2 class="section-title">私たちについて</h2>
        <div class="section-content">
            <div class="about-content">
                <p><strong>「いろいろ🎶いろんな猫の会（いろねこ）」</strong>は、保護猫の新しい家族探しを行うボランティア団体です。</p>

                <p>主催は、<strong>30年にわたるブリード経験とショーキャット育成の実績を持つベテラン</strong>です。その理念に共感した様々な経歴を持つボランティアメンバーが、預かりや譲渡会のゲスト対応、広報活動などで協力しています。
                </p>

                <p>扱っているのは、<strong>純血種の保護猫たち</strong>。ブリーダーを卒業した子や、ペットショップに行けなかった子など、それぞれが違う背景を持ちながらも、もう一度幸せになれる場所を探しています。
                </p>

                <p class="message-text">猫たちに安心できる居場所を見つけてあげたい。<br>
                    そして、新しい家族との出会いを通じて、<br>
                    人と猫、どちらも笑顔になれる時間をつくりたい。<br>
                    それが<strong>「いろねこ」</strong>の願いです。</p>

                <div style="text-align: center; margin-top: 2rem;">
                    <a class="btn" href="{{ route('about') }}">詳しく見る</a>
                </div>
            </div>
        </div>
    </section>

    <section class="container" style="background: var(--bg-light);">
        <h2 class="section-title">譲渡会情報</h2>
        <p>「いろねこ」では、猫たちと新しい家族が出会える場として、定期的に譲渡会を開催しています。</p>

        <p>譲渡会では、実際に猫たちと触れ合いながら性格や暮らし方を知っていただけます。<br>
            スタッフやボランティアが一匹ずつの背景や特徴を丁寧にご説明し、<br>
            ご希望の方には、飼育環境や相性のご相談も承っています。</p>

        <p>「保護猫を迎えるのは初めて」という方もご安心ください。<br>
            譲渡までの流れや必要な準備についても、わかりやすくご案内しています。</p>

        <p>ぜひ一度、会場に足をお運びください。<br>
            あなたの"色"にぴったりな猫に出会えるかもしれません。</p>
        @forelse($upcomingEvents as $event)
            <div class="event-card">
                <span class="event-date">{{ $event->event_date->translatedFormat('Y年m月d日(D)') }}</span>
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
            <a class="btn" href="{{ route('events') }}">すべての譲渡会を見る</a>
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
            <a class="btn" href="{{ route('activity') }}">もっと見る</a>
        </div>
    </section>

    <section class="container">
        <div class="support-section">
            <h2 class="section-title" style="margin-bottom: 1.5rem;">ご支援のお願い</h2>
            <p>私たちは、ブリーダーから純血種の猫を引き取り、新しい家族を探す活動をしています。</p>
            <p>猫たちの医療費や生活費、引き取り費用など、活動を続けていくために皆様のご支援が必要です。</p>
            <div style="margin-top: 2rem;">
                <a class="btn" href="{{ route('support') }}">譲渡金/寄付金について</a>
            </div>
        </div>
    </section>
    <script>
        // ページ読み込み時にお気に入り状態を復元
        document.addEventListener('DOMContentLoaded', function() {
            updateFavoriteButtons();
        });

        function updateFavoriteButtons() {
            fetch('/api/favorites/user', {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                })
                .then(response => response.json())
                .then(data => {
                    data.favorites.forEach(catId => {
                        const btn = document.querySelector(`.favorite-btn[data-cat-id="${catId}"]`);
                        if (btn) {
                            btn.classList.add('active');
                        }
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        function toggleFavorite(event, catId) {
            event.preventDefault();
            event.stopPropagation();

            const btn = event.currentTarget;
            const isActive = btn.classList.contains('active');
            const url = `/favorites/${catId}`;
            const method = isActive ? 'DELETE' : 'POST';

            fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        btn.classList.toggle('active');

                        // カウント更新
                        const countElement = document.getElementById(`count-${catId}`);
                        if (countElement) {
                            countElement.textContent = data.count;
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
@endsection
