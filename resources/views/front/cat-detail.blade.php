@extends('front.layout')

@section('title', $cat->name . ' | 保護猫紹介 | いろねこ')

@section('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 3rem 2rem;
        text-align: center;
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

    @media (max-width: 768px) {
        .cat-detail {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<section class="page-header">
    <h1>{{ $cat->name }}</h1>
</section>

<section class="container">
    <div class="cat-detail">
        <div class="cat-images">
            @if($cat->images && count($cat->images) > 0)
                <img src="{{ Storage::url($cat->images[0]) }}" alt="{{ $cat->name }}" class="main-image" id="mainImage">
                @if(count($cat->images) > 1)
                    <div class="thumbnail-grid">
                        @foreach($cat->images as $image)
                            <img src="{{ Storage::url($image) }}" alt="{{ $cat->name }}" class="thumbnail" onclick="changeMainImage('{{ Storage::url($image) }}')">
                        @endforeach
                    </div>
                @endif
            @else
                <div class="placeholder-image">🐱</div>
            @endif
        </div>

        <div class="cat-info-section">
            <span class="status-badge {{ $cat->status === 'available' ? 'status-available' : 'status-reserved' }}">
                @if($cat->status === 'fostering') 預かり前
                @elseif($cat->status === 'available') 募集中
                @elseif($cat->status === 'reserved') 予約済み
                @else 譲渡済み
                @endif
            </span>

            <table class="info-table">
                <tr>
                    <th>名前</th>
                    <td>{{ $cat->name }}</td>
                </tr>
                <tr>
                    <th>年齢</th>
                    <td>{{ $cat->age ?? '不明' }}</td>
                </tr>
                @if($cat->birthday)
                <tr>
                    <th>誕生日</th>
                    <td>{{ $cat->birthday }}</td>
                </tr>
                @endif
                <tr>
                    <th>性別</th>
                    <td>
                        {{ $cat->gender === 'male' ? 'オス' : 'メス' }}
                        @if($cat->is_neutered)
                            （{{ $cat->gender === 'male' ? '去勢' : '避妊' }}済み）
                        @endif
                    </td>
                </tr>
                @if($cat->fur_type)
                <tr>
                    <th>毛質</th>
                    <td>{{ $cat->fur_type }}</td>
                </tr>
                @endif
                @if($cat->fur_color)
                <tr>
                    <th>毛色</th>
                    <td>{{ $cat->fur_color }}</td>
                </tr>
                @endif
                @if($cat->eye_color)
                <tr>
                    <th>目の色</th>
                    <td>{{ $cat->eye_color }}</td>
                </tr>
                @endif
                @if($cat->protection_date)
                <tr>
                    <th>保護日</th>
                    <td>{{ $cat->protection_date->format('Y年m月d日') }}</td>
                </tr>
                @endif
            </table>

            @if($cat->personality)
            <h3 style="margin-top: 2rem; color: var(--primary-color);">性格</h3>
            <p style="margin: 1rem 0;">{{ $cat->personality }}</p>
            @endif

            @if($cat->health_info)
            <h3 style="margin-top: 2rem; color: var(--primary-color);">健康状態</h3>
            <p style="margin: 1rem 0;">{{ $cat->health_info }}</p>
            @endif

            @if($cat->description)
            <h3 style="margin-top: 2rem; color: var(--primary-color);">その他</h3>
            <p style="margin: 1rem 0;">{{ $cat->description }}</p>
            @endif

            @if($cat->reason_for_protection)
            <h3 style="margin-top: 2rem; color: var(--primary-color);">保護の経緯</h3>
            <p style="margin: 1rem 0;">{{ $cat->reason_for_protection }}</p>
            @endif

            <div style="margin-top: 2rem; text-align: center;">
                <a href="{{ route('contact') }}" class="btn">この子について問い合わせる</a>
            </div>
        </div>
    </div>

    <div style="text-align: center;">
        <a href="{{ route('cats') }}" class="btn" style="background: #666;">← 保護猫一覧に戻る</a>
    </div>
</section>

<script>
function changeMainImage(src) {
    document.getElementById('mainImage').src = src;
}
</script>
@endsection
