@extends('front.layout')

@section('title', '私たちについて | いろねこ')

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
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .section {
            background: white;
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 3rem;
        }

        .section h2 {
            color: var(--primary-color);
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 3px solid var(--primary-color);
        }

        .section h3 {
            color: var(--text-dark);
            font-size: 1.3rem;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        .section p {
            line-height: 1.8;
            margin-bottom: 1rem;
            font-size: 1.05rem;
        }

        .section ul {
            list-style: none;
            padding: 0;
        }

        .section ul li {
            padding: 0.8rem 0 0.8rem 2rem;
            position: relative;
            line-height: 1.6;
        }

        .section ul li:before {
            content: "🐾";
            position: absolute;
            left: 0;
        }

        .highlight-box {
            background: var(--bg-light);
            padding: 1.5rem;
            border-left: 4px solid var(--primary-color);
            border-radius: 8px;
            margin: 1.5rem 0;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .stat-item {
            text-align: center;
            padding: 1.5rem;
            background: var(--bg-light);
            border-radius: 10px;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        .stat-label {
            font-size: 1rem;
            color: var(--text-dark);
            margin-top: 0.5rem;
        }

        @media (max-width: 768px) {
            .section {
                padding: 1.5rem;
            }

            .section h2 {
                font-size: 1.5rem;
            }
        }
    </style>
@endsection

@section('content')
    <!-- パンくずリスト -->
@section('content')
    <section class="page-header" style="background-image: url('{{ asset('images/header.webp') }}');">
        <h1>私たちについて</h1>
        <p>いろねこの活動をご紹介します</p>
    </section>

    <x-breadcrumb :items="[['label' => '私たちについて', 'url' => '']]" />

    <section class="container">
        <!-- 団体概要 -->
        <div class="section">
            <h2>「いろねこ」について</h2>
            <p><strong>「いろいろ🎶いろんな猫の会（いろねこ）」</strong>は、純血種の保護猫に新しい家族を見つけるボランティア団体です。</p>

            <p>ブリーダーを卒業した子や、ペットショップに行けなかった子など、それぞれが違う背景を持つ純血種の猫たちに、もう一度幸せになれる居場所を見つけるお手伝いをしています。</p>

            <div class="highlight-box">
                <p><strong>活動エリア:</strong> 東京都立川市周辺</p>
                <p><strong>主な活動:</strong> 譲渡会の開催、預かりボランティアによる一時保護、新しい家族とのマッチング</p>
            </div>
        </div>

        <!-- 活動実績 -->
        <div class="section">
            <h2>活動実績</h2>
            <div class="stats">
                <div class="stat-item">
                    <div class="stat-number">100+</div>
                    <div class="stat-label">譲渡実績</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">30年</div>
                    <div class="stat-label">主催者の経験</div>
                </div>
            </div>
            <p>これまでに<strong>100匹以上</strong>の純血種保護猫たちが、新しい家族のもとで幸せに暮らしています。</p>
        </div>

        <!-- 主催者について -->
        <div class="section">
            <h2>主催者について</h2>
            <p>主催者は、<strong>30年にわたるブリード経験</strong>と<strong>ショーキャット育成の実績</strong>を持つベテランです。</p>

            <p>長年の経験を通じて培った猫の知識と、ブリーダーとのネットワークを活かし、行き場を失った純血種の猫たちに新しい未来を届ける活動を行っています。</p>

            <div class="highlight-box">
                <p>純血種の特性や健康管理に精通しているからこそ、それぞれの猫に最適な家族をマッチングすることができます。</p>
            </div>
        </div>

        <!-- ボランティアメンバー -->
        <div class="section">
            <h2>ボランティアメンバー</h2>
            <p>主催者の理念に共感した、様々な経歴を持つ方々がボランティアとして協力してくれています。</p>

            <h3>メンバーの活動内容</h3>
            <ul>
                <li>預かりボランティア（猫を一時的に家庭で預かる）</li>
                <li>譲渡会でのゲスト対応</li>
                <li>SNSやウェブサイトでの広報活動</li>
                <li>譲渡後のフォローアップ</li>
                <li>イベント運営サポート</li>
            </ul>

            <h3>こんな方々が参加しています</h3>
            <ul>
                <li>猫好きの会社員・主婦</li>
                <li>動物看護師や獣医師の資格を持つ方</li>
                <li>デザイナー・エンジニアなどクリエイティブ職の方</li>
                <li>リタイア後に社会貢献したい方</li>
                <li>学生ボランティア</li>
            </ul>

            <div class="highlight-box">
                <p>預かりボランティアを随時募集しています!詳しくは<a href="{{ route('contact') }}">お問い合わせ</a>ください。</p>
            </div>
        </div>

        <!-- 本ウェブサイトについて -->
        <div class="section">
            <h2>本ウェブサイトについて</h2>
            <p>本ウェブサイトは、<strong>ボランティアメンバーにより無償で制作・運営</strong>されています。</p>

            <p>活動資金は猫たちのために使われており、ウェブサイトの制作・運営費用は一切かかっていません。すべて、猫を想う気持ちで作られています。</p>
        </div>
    </section>
@endsection
