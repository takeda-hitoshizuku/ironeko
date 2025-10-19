@extends('front.layout')

@section('title', '譲渡条件について | いろねこ')

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
            /* ← これを追加 */
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
            /* ← 1 から -1 に変更 */
        }

        .page-header h1,
        .page-header p {
            position: relative;
            z-index: 1;
            /* ← 2 から 1 に変更 */
        }

        .intro-section {
            max-width: 900px;
            margin: 3rem auto;
            padding: 0 2rem;
            text-align: center;
        }

        .intro-section p {
            font-size: 1.1rem;
            line-height: 1.5;
            margin-bottom: 0.8rem;
        }

        .content-section {
            display: flex;
            align-items: center;
            gap: 3rem;
            max-width: 1200px;
            margin: 4rem auto;
            padding: 0 2rem;
        }

        .content-section:nth-child(even) {
            flex-direction: row-reverse;
        }

        .content-text {
            flex: 1;
        }

        .content-image {
            flex: 1;
            max-width: 500px;
        }

        .content-image img {
            width: 100%;
            height: auto;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: var(--primary-color);
        }

        .content-text p {
            font-size: 1rem;
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        .content-text ul {
            list-style: none;
            padding: 0;
        }

        .content-text ul li {
            padding: 0.2rem 0 0.2rem 2rem;
            position: relative;
            line-height: 1.2;
        }

        .content-text ul li:before {
            content: "🐾";
            position: absolute;
            left: 0;
        }

        .content-text ul li strong {
            color: var(--primary-color);
        }

        .note-box {
            background: var(--bg-light);
            border-left: 4px solid var(--primary-color);
            padding: 1.5rem;
            margin-top: 2rem;
            border-radius: 8px;
        }

        .note-box p {
            margin: 0;
            font-size: 0.95rem;
        }

        @media (max-width: 768px) {

            .content-section,
            .content-section:nth-child(even) {
                flex-direction: column;
            }

            .content-image {
                max-width: 100%;
            }

            .page-header h1 {
                font-size: 2rem;
            }

            .section-title {
                font-size: 1.5rem;
            }
        }
    </style>
@endsection

@section('content')
    <section class="page-header" style="background-image: url('{{ asset('images/header.webp') }}');">
        <h1>譲渡条件について</h1>
        <p>猫たちの幸せな未来のために</p>
    </section>

    <x-breadcrumb :items="[['label' => '譲渡条件', 'url' => '']]" />

    <div class="intro-section">
        <p>猫たちが新しいご家族のもとで、生涯幸せに暮らせますように。</p>
        <p>そんな願いを込めて、譲渡の際にお守りいただきたいことをまとめました。</p>
        <p>ご不明な点やご心配なことがあれば、お気軽にご相談ください。</p>
    </div>

    <!-- 譲渡条件セクション -->
    <section class="content-section">
        <div class="content-text">
            <h2 class="section-title">譲渡の条件</h2>
            <p>猫たちが安心して暮らせる環境を整えていただくため、以下の条件をお守りください。</p>
            <ul>
                <li><strong>ご家族全員の同意</strong>があること</li>
                <li><strong>ペット飼育可能な住宅</strong>であること</li>
                <li><strong>完全室内飼育</strong>をお約束いただけること(脱走防止対策を含む)</li>
                <li><strong>生涯にわたり責任を持って飼育</strong>していただけること</li>
                <li>猫の健康と安全を最優先に考え、<strong>適切な医療や世話</strong>をしていただけること</li>
                <li>転居など環境の変化がある場合は、<strong>必ず事前にご連絡</strong>いただくこと</li>
                <li>やむを得ず飼育継続が困難になった場合は、<strong>必ず当団体へご相談・返還</strong>いただくこと</li>
                <li>猫の様子を共有するため、<strong>定期的な連絡</strong>にご協力いただけること(LINE等)</li>
                <li>医療費等のサポートとして、<strong>譲渡金</strong>をお願いしています</li>
                <li>猫の飼育に必要な<strong>経済的負担が可能</strong>であること</li>
                <li><strong>適切な飼育環境</strong>を維持していただけること</li>
                <li><strong>第三者への譲渡は禁止</strong>です</li>
            </ul>
        </div>
        <div class="content-image">
            <img src="{{ asset('images/attention01.webp') }}" alt="譲渡条件についての画像">
        </div>
    </section>

    <!-- その他お願いしたいことセクション -->
    <section class="content-section">
        <div class="content-text">
            <h2 class="section-title">その他のお願い</h2>
            <p>必須ではありませんが、以下の点にもご協力いただけると幸いです。</p>
            <ul>
                <li>当団体の<strong>Instagramをフォロー</strong>していただけると嬉しいです</li>
                <li>譲渡後、猫の<strong>近況や写真</strong>を共有していただけると嬉しいです</li>
                <li>いただいた写真等をSNSで紹介させていただく場合は、<strong>事前にご相談</strong>します</li>
                <li><strong>ワクチン接種やマイクロチップ装着</strong>など、健康管理にご協力ください</li>
                <li>飼育について不安や疑問があれば、<strong>いつでもご相談</strong>ください</li>
                <li>万が一の際に<strong>猫を預けられる方</strong>がいると安心です</li>
                <li>ご自身の体調不良などで一時的に飼育が難しい場合も、<strong>遠慮なくご相談</strong>ください</li>
                <li>必要に応じて<strong>ご自宅を訪問</strong>させていただく場合があります</li>
            </ul>
        </div>
        <div class="content-image">
            <img src="{{ asset('images/attention02.webp') }}" alt="お願いしたいことについての画像">
        </div>
    </section>

    <!-- 譲渡をお断りする場合セクション -->
    <section class="content-section">
        <div class="content-text">
            <h2 class="section-title">譲渡が難しい場合</h2>
            <p>猫たちの幸せと安全のため、以下の場合は譲渡をお見送りさせていただくことがあります。</p>
            <ul>
                <li><strong>小さなお子様</strong>(目安:3歳未満)がいるご家庭</li>
                <li>里親様や猫の年齢から、<strong>終生飼育が困難</strong>と判断される場合</li>
                <li><strong>在宅時間が極端に短い</strong>ご家庭</li>
                <li>飼育継続に支障をきたす可能性のある<strong>ご病気</strong>をお持ちの場合</li>
                <li><strong>身分証明書のご提示</strong>にご協力いただけない場合</li>
                <li>既存ペットとの<strong>相性に問題</strong>がある場合</li>
                <li>近い将来の<strong>転居予定</strong>があり、安定した飼育環境が確保できない場合</li>
                <li>猫の飼育に必要な<strong>経済的負担が困難</strong>と判断される場合</li>
                <li>適切な飼育方法や動物愛護の観点で<strong>懸念がある</strong>場合</li>
                <li>過去の譲渡において<strong>トラブルがあった</strong>場合</li>
                <li>保護猫活動への<strong>ご理解が得られない</strong>場合</li>
            </ul>
            <div class="note-box">
                <p>譲渡は猫の幸せを最優先に判断させていただきます。<br>
                    上記に該当する場合でも、状況によってはご相談可能な場合もありますので、まずはお気軽にお問い合わせください。</p>
            </div>
        </div>
        <div class="content-image">
            <img src="{{ asset('images/attention03.webp') }}" alt="譲渡をお断りする場合についての画像">
        </div>
    </section>

@endsection
