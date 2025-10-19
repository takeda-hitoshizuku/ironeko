<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'いろいろ🎶いろんな猫の会（いろねこ）')</title>
    <meta name="description" content="@yield('description', '保護猫の譲渡活動を行っている「いろいろ🎶いろんな猫の会」(いろねこ)の公式サイトです。')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #ff9966;
            --secondary-color: #66cccc;
            --accent-color: #ffcc66;
            --text-dark: #333;
            --text-light: #666;
            --bg-light: #fff8f0;
            --shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Hiragino Kaku Gothic ProN', 'Hiragino Sans', Meiryo, sans-serif;
            line-height: 1.8;
            color: var(--text-dark);
        }

        header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow);
        }

        .hero {
            background-size: cover;
            background-position: center;
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

        .hero h1,
        .hero p {
            position: relative;
            z-index: 2;
        }

        nav {
            /* max-width: 1400px; */
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
            color: white;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s;
        }

        .nav-links a:hover {
            opacity: 0.8;
        }

        /* ハンバーガーメニューボタン */
        .hamburger {
            display: none;
            flex-direction: column;
            justify-content: center;
            gap: 5px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            width: 40px;
            height: 40px;
            position: relative;
        }

        .hamburger span {
            width: 100%;
            height: 3px;
            background: white;
            border-radius: 3px;
            transition: all 0.3s ease;
            position: absolute;
            left: 0;
        }

        .hamburger span:nth-child(1) {
            top: 8px;
        }

        .hamburger span:nth-child(2) {
            top: 50%;
            transform: translateY(-50%);
        }

        .hamburger span:nth-child(3) {
            bottom: 8px;
        }

        .hamburger.active span:nth-child(1) {
            top: 50%;
            transform: translateY(-50%) rotate(45deg);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            bottom: 50%;
            transform: translateY(50%) rotate(-45deg);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 4rem 2rem;
        }

        .btn {
            display: inline-block;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: var(--shadow);
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        footer {
            background: var(--text-dark);
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: 4rem;
        }

        footer>* {
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        .footer-links {
            margin-top: 1.5rem;
            font-size: 0.85rem;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            margin: 0 0.5rem;
            transition: opacity 0.3s;
        }

        .footer-links a:hover {
            opacity: 0.7;
            text-decoration: underline;
        }

        .footer-links span {
            color: rgba(255, 255, 255, 0.5);
        }

        @media (max-width: 768px) {
            .footer-links {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }

            .footer-links span {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .hamburger {
                display: flex;
            }

            .nav-links {
                position: fixed;
                top: 70px;
                right: -100%;
                width: 70%;
                max-width: 300px;
                height: calc(100vh - 70px);
                background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
                flex-direction: column;
                padding: 2rem;
                gap: 1.5rem;
                transition: right 0.3s;
                box-shadow: -5px 0 15px rgba(0, 0, 0, 0.2);
            }

            .nav-links.active {
                right: 0;
            }

            .nav-links li {
                opacity: 0;
                transform: translateX(20px);
                transition: all 0.3s;
            }

            .nav-links.active li {
                opacity: 1;
                transform: translateX(0);
            }

            .nav-links.active li:nth-child(1) {
                transition-delay: 0.1s;
            }

            .nav-links.active li:nth-child(2) {
                transition-delay: 0.2s;
            }

            .nav-links.active li:nth-child(3) {
                transition-delay: 0.3s;
            }

            .nav-links.active li:nth-child(4) {
                transition-delay: 0.4s;
            }

            .nav-links.active li:nth-child(5) {
                transition-delay: 0.5s;
            }

            .nav-links.active li:nth-child(6) {
                transition-delay: 0.6s;
            }

            .nav-links.active li:nth-child(7) {
                transition-delay: 0.7s;
            }

            .nav-links.active li:nth-child(8) {
                transition-delay: 0.8s;
            }

            .nav-links.active li:nth-child(9) {
                transition-delay: 0.9s;
            }

            .nav-links.active li:nth-child(10) {
                transition-delay: 1.0s;
            }

            .nav-links a {
                font-size: 1.1rem;
            }
        }

        .footer-links {
            margin-top: 1.5rem;
            font-size: 0.85rem;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            margin: 0 0.5rem;
            transition: opacity 0.3s;
        }

        .footer-links a:hover {
            opacity: 0.7;
            text-decoration: underline;
        }

        .footer-links span {
            color: rgba(255, 255, 255, 0.5);
        }

        @media (max-width: 768px) {
            .footer-links {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }

            .footer-links span {
                display: none;
            }
        }

        .breadcrumb-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem 2rem;
            background: var(--bg-light);
        }

        .breadcrumb {
            display: flex;
            flex-wrap: wrap;
            list-style: none;
            padding: 0;
            margin: 0;
            font-size: 0.9rem;
        }

        .breadcrumb-item {
            display: flex;
            align-items: center;
        }

        .breadcrumb-item+.breadcrumb-item:before {
            content: "›";
            padding: 0 0.5rem;
            color: var(--text-light);
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
            transition: opacity 0.3s;
        }

        .breadcrumb-item a:hover {
            opacity: 0.7;
            text-decoration: underline;
        }

        .breadcrumb-item.active {
            color: var(--text-dark);
        }

        @media (max-width: 768px) {
            .breadcrumb-container {
                padding: 0.8rem 1rem;
            }

            .breadcrumb {
                font-size: 0.85rem;
            }
        }
    </style>
    @yield('styles')
</head>

<body>
    <header>
        <nav>
            <a class="logo" href="{{ route('home') }}">いろいろ🎶いろんな猫の会</a>

            <!-- ハンバーガーメニューボタン -->
            <button class="hamburger" id="hamburger" aria-label="メニュー">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <ul class="nav-links" id="navLinks">
                <li><a href="{{ route('home') }}">ホーム</a></li>
                <li><a href="{{ route('about') }}">私たちについて</a></li>
                <li><a href="{{ route('cats') }}">保護猫紹介</a></li>
                <li><a href="{{ route('events') }}">譲渡会</a></li>
                <li><a href="{{ route('requirements') }}">譲渡条件</a></li>
                <li><a href="{{ route('support') }}">譲渡金/寄付金</a></li>
                <li><a href="{{ route('activity') }}">活動報告</a></li>
                <li><a href="{{ route('articles') }}">記事</a></li>
                <li><a href="{{ route('contact') }}">お問い合わせ</a></li>
                <li><a href="{{ route('privacy') }}">プライバシーポリシー</a></li>
            </ul>
        </nav>
    </header>

    @yield('content')

    <footer>
        <p>&copy; 2025 いろいろ🎶いろんな猫の会(いろねこ) All rights reserved.</p>
        <p style="margin-top: 0.5rem; font-size: 0.85rem; opacity: 0.8;">
            本サイトはボランティアにより運営されています
        </p>

        <!-- フッターリンク -->
        <nav class="footer-links">
            <a href="{{ route('about') }}">私たちについて</a>
            <span>|</span>
            <a href="{{ route('support') }}">譲渡金/寄付金</a>
            <span>|</span>
            <a href="{{ route('requirements') }}">譲渡条件</a>
            <span>|</span>
            <a href="{{ route('contact') }}">お問い合わせ</a>
            <span>|</span>
            <a href="{{ route('privacy') }}">プライバシーポリシー</a>
            <span>|</span>
            <a href="{{ route('sitemap') }}">サイトマップ</a>
        </nav>

        <p style="margin-top: 1rem; font-size: 0.9rem;">
            ※ 当サイトに掲載されている写真・文章等の無断転載を禁じます
        </p>
    </footer>

    <script>
        // ハンバーガーメニューの制御
        const hamburger = document.getElementById('hamburger');
        const navLinks = document.getElementById('navLinks');

        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            navLinks.classList.toggle('active');
        });

        // メニュー項目をクリックしたら閉じる
        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                hamburger.classList.remove('active');
                navLinks.classList.remove('active');
            });
        });

        // メニュー外をクリックしたら閉じる
        document.addEventListener('click', (e) => {
            if (!hamburger.contains(e.target) && !navLinks.contains(e.target)) {
                hamburger.classList.remove('active');
                navLinks.classList.remove('active');
            }
        });
    </script>
</body>

</html>
