@extends('front.layout')

@section('title', '譲渡金/寄付金について | いろねこ')

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
            content: "💰";
            position: absolute;
            left: 0;
        }

        .important-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 1.5rem;
            margin: 2rem 0;
            border-radius: 8px;
        }

        .important-box strong {
            color: #856404;
        }

        .highlight-box {
            background: var(--bg-light);
            padding: 1.5rem;
            border-left: 4px solid var(--primary-color);
            border-radius: 8px;
            margin: 1.5rem 0;
        }

        .support-box {
            background: linear-gradient(135deg, rgba(255, 153, 102, 0.1), rgba(102, 204, 204, 0.1));
            padding: 2rem;
            border-radius: 15px;
            margin: 2rem 0;
            text-align: center;
        }

        .support-box h3 {
            color: var(--primary-color);
            margin-top: 0;
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
@section('content')
    <section class="page-header" style="background-image: url('{{ asset('images/header.webp') }}');">
        <h1>譲渡金/寄付金について</h1>
        <p>活動資金の透明性について</p>
    </section>

    <x-breadcrumb :items="[['label' => '譲渡金/寄付金について', 'url' => '']]" />

    <section class="container">
        <!-- 私たちの活動について -->
        <div class="section">
            <h2>私たちの活動について</h2>

            <div class="important-box">
                <p><strong>重要なお知らせ</strong></p>
                <p>私たちは、野良猫を保護しているのではありません。<br>
                    <strong>ブリーダーから純血種の猫を引き取り</strong>、新しい家族を探す活動をしています。
                </p>
            </div>

            <p>ブリーダーを卒業した猫や、ペットショップに行けなかった猫たち。<br>
                これらの純血種の猫たちは、行き場を失うと処分されてしまう可能性があります。</p>

            <p>私たちは、そうした猫たちを<strong>ブリーダーから引き取る際に、適正な金額をお支払い</strong>しています。<br>
                そして、医療ケアを施し、新しい家族を見つけるお手伝いをしています。</p>
        </div>

        <!-- 譲渡金について -->
        <div class="section">
            <h2>譲渡金について</h2>

            <p>譲渡金は、以下の実費をカバーするためにいただいております。</p>

            <h3>譲渡金の内訳</h3>
            <ul>
                <li><strong>ブリーダーへの引き取り費用</strong><br>
                    猫をブリーダーから引き取る際の費用です</li>

                <li><strong>医療費</strong><br>
                    ワクチン接種、健康診断、去勢・避妊手術など</li>

                <li><strong>フード代</strong><br>
                    預かり期間中の高品質なキャットフード</li>

                <li><strong>消耗品費</strong><br>
                    トイレ砂、おもちゃ、爪とぎなど</li>

                <li><strong>設備費</strong><br>
                    ケージ、トイレ、食器などの購入費用</li>

                <li><strong>交通費</strong><br>
                    譲渡会の開催、動物病院への通院など</li>
            </ul>

            <div class="highlight-box">
                <p><strong>譲渡金の金額について</strong></p>
                <p>猫の年齢、健康状態、必要な医療ケアの内容により、金額が変動します。<br>
                    詳しい金額は、<a href="{{ route('contact') }}">お問い合わせ</a>時に個別にご説明いたします。</p>
            </div>

            <p>私たちの活動は、野良猫保護とは異なるボランティアモデルです。<br>
                純血種の猫を救うために、適正な費用が必要となることをご理解ください。</p>
        </div>

        <!-- 寄付・支援について -->
        <div class="section">
            <h2>寄付・支援について</h2>

            <p>猫たちのための活動を続けていくために、皆様からのご支援を心よりお待ちしております。</p>

            <h3>ご支援の方法</h3>

            <div class="support-box">
                <h3>💕 寄付金</h3>
                <p>活動資金として、寄付金を受け付けております。<br>
                    詳細は<a href="{{ route('contact') }}">お問い合わせ</a>ください。</p>
            </div>

            <div class="support-box">
                <h3>🎁 物資支援</h3>
                <p>以下のような物資のご支援も大歓迎です。</p>
                <ul style="text-align: left; display: inline-block; margin-top: 1rem;">
                    <li>キャットフード（プレミアムフード）</li>
                    <li>猫用トイレ砂</li>
                    <li>おもちゃ</li>
                    <li>ケージ、キャリーケース</li>
                    <li>爪とぎ</li>
                    <li>ペットシーツ</li>
                </ul>
            </div>

            <div class="support-box">
                <h3>🏠 預かりボランティア募集</h3>
                <p>猫を一時的にご自宅で預かっていただけるボランティアを募集しています。<br>
                    猫の飼育経験がある方、温かい環境を提供できる方、ぜひご協力ください。</p>
                <p style="margin-top: 1rem;">
                    <a class="btn" href="{{ route('contact') }}">お問い合わせ</a>
                </p>
            </div>
        </div>

        <!-- 透明性について -->
        <div class="section">
            <h2>活動資金の透明性</h2>

            <p>いただいた譲渡金や寄付金は、すべて<strong>猫たちのため</strong>に使われています。</p>

            <p>私たちはボランティア団体であり、利益を目的とした活動は行っておりません。<br>
                すべての資金は、猫たちの健康と幸せのために、責任を持って使わせていただきます。</p>

            <div class="highlight-box">
                <p>ご不明な点やご質問がございましたら、<a href="{{ route('contact') }}">お問い合わせフォーム</a>よりお気軽にご連絡ください。</p>
            </div>
        </div>
    </section>
@endsection
