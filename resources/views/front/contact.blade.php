@extends('front.layout')

@section('title', 'お問い合わせ | いろねこ')

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

    .contact-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
        color: var(--text-dark);
    }

    .required {
        color: #dc3545;
        margin-left: 0.3rem;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 0.8rem;
        border: 2px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
        font-family: inherit;
        transition: border-color 0.3s;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--secondary-color);
    }

    .form-group textarea {
        min-height: 200px;
        resize: vertical;
    }

    .error-message {
        color: #dc3545;
        font-size: 0.9rem;
        margin-top: 0.3rem;
    }

    .success-message {
        background: #d4edda;
        color: #155724;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        border-left: 4px solid #28a745;
    }

    .submit-btn {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border: none;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: bold;
        cursor: pointer;
        transition: transform 0.3s;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
    }

    .info-section {
        background: var(--bg-light);
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 3rem;
    }

    .info-section h3 {
        color: var(--primary-color);
        margin-bottom: 1rem;
    }
</style>
@endsection

@section('content')
<section class="page-header">
    <h1>お問い合わせ</h1>
    <p>ご質問やご相談など、お気軽にお問い合わせください</p>
</section>

<section class="container">
    <div class="contact-container">
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <div class="info-section">
            <h3>お問い合わせについて</h3>
            <p>
                猫の譲渡、ボランティア、寄付に関するお問い合わせを受け付けています。<br>
                内容を確認次第、担当者よりご連絡させていただきます。<br>
                お急ぎの場合は、譲渡会会場にて直接スタッフにお声がけください。
            </p>
        </div>

        <form action="{{ route('contact.submit') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">お名前<span class="required">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">メールアドレス<span class="required">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">電話番号</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}">
                @error('phone')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="category">お問い合わせ種別<span class="required">*</span></label>
                <select id="category" name="category" required>
                    <option value="">選択してください</option>
                    <option value="adoption" {{ old('category') === 'adoption' ? 'selected' : '' }}>譲渡について</option>
                    <option value="volunteer" {{ old('category') === 'volunteer' ? 'selected' : '' }}>ボランティアについて</option>
                    <option value="donation" {{ old('category') === 'donation' ? 'selected' : '' }}>寄付について</option>
                    <option value="other" {{ old('category') === 'other' ? 'selected' : '' }}>その他</option>
                </select>
                @error('category')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="subject">件名</label>
                <input type="text" id="subject" name="subject" value="{{ old('subject') }}">
                @error('subject')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="message">お問い合わせ内容<span class="required">*</span></label>
                <textarea id="message" name="message" required>{{ old('message') }}</textarea>
                @error('message')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="submit-btn">送信する</button>
        </form>
    </div>
</section>
@endsection
