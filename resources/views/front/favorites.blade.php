@extends('front.layout')

@section('title', 'お気に入り | いろねこ')

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
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            position: relative;
        }

        .cat-card:hover {
            transform: translateY(-5px);
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
            bottom: 1rem;
            right: 1rem;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .no-favorites {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-light);
        }

        .no-favorites p {
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .cats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <section class="page-header" style="background-image: url('{{ asset('images/header.webp') }}');">
        <h1>お気に入り</h1>
        <p>気になる猫たちをチェック</p>
    </section>

    <!-- パンくずリスト -->
    <x-breadcrumb :items="[['label' => 'お気に入り', 'url' => '']]" />

    <section class="container">
        @if ($cats->count() > 0)
            <div class="cats-grid">
                @foreach ($cats as $cat)
                    <div class="cat-card">
                        <a href="{{ route('cats.detail', $cat) }}" style="text-decoration: none; color: inherit;">
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

                        <!-- お気に入りボタン -->
                        <button class="favorite-btn active" data-cat-id="{{ $cat->id }}"
                            onclick="toggleFavorite(event, {{ $cat->id }})">
                            ❤️
                        </button>

                        <!-- お気に入り数 -->
                        <div class="favorite-count">
                            ❤️ <span id="count-{{ $cat->id }}">{{ $cat->favorites_count }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-favorites">
                <p>お気に入りに追加した猫がまだいません。</p>
                <a class="btn" href="{{ route('cats') }}">保護猫一覧を見る</a>
            </div>
        @endif
    </section>

    <script>
        function toggleFavorite(event, catId) {
            event.preventDefault();
            event.stopPropagation();

            const btn = event.currentTarget;
            const isActive = btn.classList.contains('active');
            const url = isActive ? `/favorites/${catId}` : `/favorites/${catId}`;
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
                        if (isActive) {
                            // お気に入りから削除 → ページから消す
                            btn.closest('.cat-card').remove();

                            // 猫がいなくなったら「お気に入りなし」メッセージを表示
                            if (document.querySelectorAll('.cat-card').length === 0) {
                                location.reload();
                            }
                        }

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
