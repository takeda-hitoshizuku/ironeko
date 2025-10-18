@extends('front.layout')

@section('title', '保護猫紹介 | いろねこ')

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

    .cats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
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
        height: 300px;
        object-fit: cover;
    }

    .cat-placeholder {
        width: 100%;
        height: 300px;
        background: linear-gradient(135deg, #f5f5f5, #e0e0e0);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 5rem;
    }

    .cat-info {
        padding: 1.5rem;
    }

    .cat-info h3 {
        color: var(--primary-color);
        margin-bottom: 0.5rem;
        font-size: 1.3rem;
    }

    .cat-status {
        display: inline-block;
        padding: 0.3rem 0.8rem;
        border-radius: 15px;
        font-size: 0.9rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .status-available {
        background: #d4edda;
        color: #155724;
    }

    .status-reserved {
        background: #fff3cd;
        color: #856404;
    }
</style>
@endsection

@section('content')
<section class="page-header">
    <h1>保護猫紹介</h1>
    <p>新しい家族を待っている猫たちです</p>
</section>

<section class="container">
    @if($cats->count() > 0)
        <div class="cats-grid">
            @foreach($cats as $cat)
                <a href="{{ route('cats.detail', $cat) }}" class="cat-card">
                    @if($cat->images && count($cat->images) > 0)
                        <img src="{{ Storage::url($cat->images[0]) }}" alt="{{ $cat->name }}" class="cat-image">
                    @else
                        <div class="cat-placeholder">🐱</div>
                    @endif
                    <div class="cat-info">
                        <span class="cat-status {{ $cat->status === 'available' ? 'status-available' : 'status-reserved' }}">
                            {{ $cat->status === 'available' ? '募集中' : '予約済み' }}
                        </span>
                        <h3>{{ $cat->name }}</h3>
                        <p>
                            <strong>年齢:</strong> {{ $cat->age ?? '不明' }}<br>
                            <strong>性別:</strong> {{ $cat->gender === 'male' ? 'オス' : 'メス' }}
                            @if($cat->is_neutered)（{{ $cat->gender === 'male' ? '去勢' : '避妊' }}済）@endif<br>
                            @if($cat->fur_color)
                                <strong>毛色:</strong> {{ $cat->fur_color }}
                            @endif
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <p style="text-align: center; padding: 4rem 0; font-size: 1.2rem;">
            現在募集中の猫はいません。
        </p>
    @endif
</section>
@endsection
