<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'いろいろ🎶いろんな猫の会（いろねこ）')</title>
    <meta name="description" content="@yield('description', '保護猫の譲渡活動を行っている「いろいろ🎶いろんな猫の会」(いろねこ)の公式サイトです。')">
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
            --shadow: 0 2px 10px rgba(0,0,0,0.1);
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

        nav {
            max-width: 1200px;
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
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        footer {
            background: var(--text-dark);
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: 4rem;
        }

        @media (max-width: 768px) {
            .nav-links {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <header>
        <nav>
            <a href="{{ route('home') }}" class="logo">いろいろ🎶いろんな猫の会</a>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}">ホーム</a></li>
                <li><a href="{{ route('cats') }}">保護猫紹介</a></li>
                <li><a href="{{ route('events') }}">譲渡会</a></li>
                <li><a href="{{ route('activity') }}">活動報告</a></li>
                <li><a href="{{ route('contact') }}">お問い合わせ</a></li>
                <li><a href="{{ route('privacy') }}">プライバシーポリシー</a></li>
            </ul>
        </nav>
    </header>

    @yield('content')

    <footer>
        <p>&copy; 2025 いろいろ🎶いろんな猫の会（いろねこ）All rights reserved.</p>
        <p style="margin-top: 1rem; font-size: 0.9rem;">
            ※ 当サイトに掲載されている写真・文章等の無断転載を禁じます
        </p>
    </footer>
</body>
</html>
