@extends('front.layout')

@section('title', 'お問い合わせ | いろねこ')

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

        /* ↓ ここから追加 */
        .notice-text {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 1rem;
            margin-top: 1rem;
            border-radius: 4px;
            font-size: 0.95rem;
        }

        .notice-text a {
            color: var(--primary-color);
            text-decoration: underline;
        }

        .checkbox-group {
            margin: 1.5rem 0;
        }

        .checkbox-label {
            display: inline-flex;
            align-items: flex-start;
            gap: 0.5rem;
            cursor: pointer;
            font-size: 0.95rem;
            vertical-align: top;
        }

        .checkbox-label input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin: 3px 0 0 0;
            cursor: pointer;
            flex-shrink: 0;
        }

        .checkbox-label>span {
            line-height: 1.6;
            display: inline-block;
        }

        .checkbox-label a {
            color: var(--primary-color);
            text-decoration: underline;
        }

        .g-recaptcha {
            display: none;
        }
    </style>
@endsection

@section('content')
    <section class="page-header" style="background-image: url('{{ asset('images/header.webp') }}');">
        <h1>お問い合わせ</h1>
        <p>ご質問やご相談など、お気軽にお問い合わせください</p>
    </section>

    <x-breadcrumb :items="[['label' => 'お問い合わせ', 'url' => '']]" />

    <section class="container">
        <div class="contact-container">
            @if (session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            <div class="info-section">
                <h3>お問い合わせについて</h3>
                <p>
                    猫の譲渡、ボランティア、取材、寄付に関するお問い合わせを受け付けています。<br>
                    内容を確認次第、担当者よりご連絡させていただきます。<br>
                    お急ぎの場合は、譲渡会会場にて直接スタッフにお声がけください。
                </p>
                <p class="notice-text">
                    ※ 営業目的のお問い合わせはご遠慮ください。<br>
                    ※ 里親希望の方は、<a href="{{ route('requirements') }}">譲渡条件のページ</a>をご確認の上、送信してください。
                </p>
            </div>

            <form id="contact-form" action="{{ route('contact.submit') }}" method="POST" onsubmit="onSubmit(event)">
                @csrf

                <div class="form-group">
                    <label for="name">お名前<span class="required">*</span></label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">メールアドレス<span class="required">*</span></label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">電話番号</label>
                    <input id="phone" name="phone" type="tel" value="{{ old('phone') }}">
                    @error('phone')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category">お問い合わせ種別<span class="required">*</span></label>
                    <select id="category" name="category" required>
                        <option value="">選択してください</option>
                        <option value="adoption" {{ old('category') === 'adoption' ? 'selected' : '' }}>譲渡について</option>
                        <option value="volunteer" {{ old('category') === 'volunteer' ? 'selected' : '' }}>ボランティアについて
                        </option>
                        <option value="donation" {{ old('category') === 'donation' ? 'selected' : '' }}>寄付について</option>
                        <option value="interview" {{ old('category') === 'interview' ? 'selected' : '' }}>取材について</option>
                        <option value="other" {{ old('category') === 'other' ? 'selected' : '' }}>その他</option>
                    </select>
                    @error('category')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 猫の情報があれば自動入力 -->
                @if (isset($catName))
                    <input name="cat_id" type="hidden" value="{{ $catId }}">
                    <div class="form-group">
                        <label>お問い合わせ対象の猫</label>
                        <input class="form-control" type="text" value="{{ $catName }}" readonly>
                    </div>
                @endif

                <!-- 件名に自動入力 -->
                <div class="form-group">
                    <label for="subject">件名<span class="required">*</span></label>
                    <input id="subject" name="subject" type="text"
                        value="{{ isset($catName) ? $catName . 'の譲渡について' : old('subject') }}" required>
                </div>

                <div class="form-group">
                    <label for="message">お問い合わせ内容<span class="required">*</span></label>
                    <textarea id="message" name="message" required>{{ old('message') }}</textarea>
                    @error('message')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- reCAPTCHA v3 (hidden) -->
                <input id="g-recaptcha-response" name="g-recaptcha-response" type="hidden">
                @error('g-recaptcha-response')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                <!-- プライバシーポリシー同意 -->
                <div class="form-group checkbox-group">
                    <label class="checkbox-label">
                        <input name="privacy_agreement" type="checkbox" value="1" required
                            {{ old('privacy_agreement') ? 'checked' : '' }}>
                        <span><a href="{{ route('privacy') }}" target="_blank">プライバシーポリシー</a>に同意する<span
                                class="required">*</span></span>
                    </label>
                    @error('privacy_agreement')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <button class="submit-btn" type="submit">送信する</button>
            </form>
        </div>
    </section>

    <!-- reCAPTCHA v3 script -->
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
    <script>
        function onSubmit(e) {
            e.preventDefault();
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {
                    action: 'contact'
                }).then(function(token) {
                    document.getElementById('g-recaptcha-response').value = token;
                    document.getElementById('contact-form').submit();
                });
            });
        }
    </script>
@endsection
