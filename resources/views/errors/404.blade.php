@extends('front.layout')

@section('title', 'ページが見つかりません | いろねこ')

@section('styles')
<style>
    .error-container {
        text-align: center;
        padding: 4rem 2rem;
        min-height: 60vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .error-code {
        font-size: 8rem;
        font-weight: bold;
        color: var(--primary-color);
        line-height: 1;
        margin-bottom: 1rem;
    }

    .error-cat {
        font-size: 5rem;
        margin-bottom: 1rem;
    }

    .error-message {
        font-size: 1.5rem;
        color: var(--text-dark);
        margin-bottom: 2rem;
    }

    .error-description {
        font-size: 1rem;
        color: var(--text-light);
        margin-bottom: 3rem;
        max-width: 500px;
    }

    @media (max-width: 768px) {
        .error-code {
            font-size: 5rem;
        }

        .error-cat {
            font-size: 3rem;
        }

        .error-message {
            font-size: 1.2rem;
        }
    }
</style>
@endsection

@section('content')
<div class="error-container">
    <div class="error-cat">🐱</div>
    <div class="error-code">404</div>
    <h1 class="error-message">ページが見つかりません</h1>
    <p class="error-description">
        お探しのページは移動または削除された可能性があります。<br>
        URLをご確認いただくか、トップページからお探しください。
    </p>
    <a href="{{ route('home') }}" class="btn">トップページへ戻る</a>
</div>
@endsection
