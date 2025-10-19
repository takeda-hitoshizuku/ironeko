@extends('front.layout')

@section('title', $cat->name . ' | 保護猫紹介 | いろねこ')

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

        .cat-detail {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .cat-images {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            position: relative;
            /* 追加 */
        }

        .main-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: var(--shadow);
        }

        .thumbnail-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.5rem;
        }

        .thumbnail {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            transition: opacity 0.3s;
        }

        .thumbnail:hover {
            opacity: 0.8;
        }

        .cat-info-section {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: var(--shadow);
        }

        .info-table {
            width: 100%;
            margin: 1rem 0;
        }

        .info-table tr {
            border-bottom: 1px solid #eee;
        }

        .info-table th {
            text-align: left;
            padding: 1rem 0;
            width: 30%;
            color: var(--text-light);
        }

        .info-table td {
            padding: 1rem 0;
        }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: bold;
            font-size: 1rem;
        }

        .status-available {
            background: #d4edda;
            color: #155724;
        }

        .status-reserved {
            background: #fff3cd;
            color: #856404;
        }

        .placeholder-image {
            width: 100%;
            height: 400px;
            background: linear-gradient(135deg, #f5f5f5, #e0e0e0);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8rem;
            border-radius: 15px;
        }

        /* お気に入りボタン（詳細ページ用） */
        .favorite-btn-large {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 2rem;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            z-index: 10;
        }

        .favorite-btn-large:hover {
            transform: scale(1.1);
        }

        .favorite-btn-large.active {
            background: var(--primary-color);
        }

        .favorite-count-large {
            position: absolute;
            bottom: 1rem;
            right: 1rem;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            z-index: 10;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .cat-detail {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <section class="page-header" style="background-image: url('{{ asset('images/header.webp') }}');">
        <h1>{{ $cat->name }}</h1>
    </section>

    <!-- パンくずリスト -->
    <x-breadcrumb :items="[['label' => '保護猫一覧', 'url' => route('cats')], ['label' => $cat->name, 'url' => '']]" />

    <section class="container">
        <div class="cat-detail">
            <div class="cat-images">
                @if ($cat->images && count($cat->images) > 0)
                    <img class="main-image" id="mainImage" src="{{ Storage::url($cat->images[0]) }}" alt="{{ $cat->name }}">
                    @if (count($cat->images) > 1)
                        <div class="thumbnail-grid">
                            @foreach ($cat->images as $image)
                                <img class="thumbnail" src="{{ Storage::url($image) }}" alt="{{ $cat->name }}"
                                    onclick="changeMainImage('{{ Storage::url($image) }}')">
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="placeholder-image">🐱</div>
                @endif

                <!-- お気に入りボタン -->
                <button class="favorite-btn-large" data-cat-id="{{ $cat->id }}"
                    onclick="toggleFavorite(event, {{ $cat->id }})">
                    ❤️
                </button>

                <!-- お気に入り数 -->
                <div class="favorite-count-large">
                    ❤️ <span id="count-{{ $cat->id }}">{{ $cat->favorites_count }}</span>
                </div>
            </div>

            <div class="cat-info-section">
                <span class="status-badge {{ $cat->status === 'available' ? 'status-available' : 'status-reserved' }}">
                    @if ($cat->status === 'fostering')
                        預かり前
                    @elseif($cat->status === 'available')
                        募集中
                    @elseif($cat->status === 'reserved')
                        予約済み
                    @else
                        譲渡済み
                    @endif
                </span>

                <table class="info-table">
                    <tr>
                        <th>名前</th>
                        <td>{{ $cat->name }}</td>
                    </tr>
                    <tr>
                        <th>品種</th>
                        <td>{{ $cat->breed ?? '不明' }}</td>
                    </tr>
                    <tr>
                        <th>年齢</th>
                        <td>{{ $cat->age ?? '不明' }}</td>
                    </tr>
                    @if ($cat->birthday)
                        <tr>
                            <th>誕生日</th>
                            <td>{{ $cat->birthday }}</td>
                        </tr>
                    @endif
                    <tr>
                        <th>性別</th>
                        <td>
                            {{ $cat->gender === 'male' ? 'オス' : 'メス' }}
                            @if ($cat->is_neutered)
                                （{{ $cat->gender === 'male' ? '去勢' : '避妊' }}済み）
                            @endif
                        </td>
                    </tr>
                    @if ($cat->fur_type)
                        <tr>
                            <th>毛質</th>
                            <td>{{ $cat->fur_type }}</td>
                        </tr>
                    @endif
                    @if ($cat->fur_color)
                        <tr>
                            <th>毛色</th>
                            <td>{{ $cat->fur_color }}</td>
                        </tr>
                    @endif
                    @if ($cat->eye_color)
                        <tr>
                            <th>目の色</th>
                            <td>{{ $cat->eye_color }}</td>
                        </tr>
                    @endif
                    @if ($cat->protection_date)
                        <tr>
                            <th>保護日</th>
                            <td>{{ $cat->protection_date->format('Y年m月d日') }}</td>
                        </tr>
                    @endif
                </table>

                @if ($cat->personality)
                    <h3 style="margin-top: 2rem; color: var(--primary-color);">性格</h3>
                    <p style="margin: 1rem 0;">{{ $cat->personality }}</p>
                @endif

                @if ($cat->health_info)
                    <h3 style="margin-top: 2rem; color: var(--primary-color);">健康状態</h3>
                    <p style="margin: 1rem 0;">{{ $cat->health_info }}</p>
                @endif

                @if ($cat->description)
                    <h3 style="margin-top: 2rem; color: var(--primary-color);">その他</h3>
                    <p style="margin: 1rem 0;">{{ $cat->description }}</p>
                @endif

                @if ($cat->reason_for_protection)
                    <h3 style="margin-top: 2rem; color: var(--primary-color);">保護の経緯</h3>
                    <p style="margin: 1rem 0;">{{ $cat->reason_for_protection }}</p>
                @endif

                <a class="btn" href="{{ route('contact', ['cat_id' => $cat->id, 'cat_name' => $cat->name]) }}">
                    この子についてお問い合わせ
                </a>
            </div>
        </div>

        <div style="text-align: center;">
            <a class="btn" href="{{ route('cats') }}" style="background: #666;">← 保護猫一覧に戻る</a>
        </div>
    </section>

    <script>
        function changeMainImage(src) {
            document.getElementById('mainImage').src = src;
        }

        // お気に入り状態を復元
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
                        const btn = document.querySelector(`.favorite-btn-large[data-cat-id="${catId}"]`);
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
