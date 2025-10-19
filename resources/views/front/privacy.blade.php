@extends('front.layout')

@section('title', 'プライバシーポリシー | いろねこ')

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

        .content-container {
            max-width: 800px;
            margin: 2rem auto;
            line-height: 1.8;
        }

        .content-container h2 {
            font-size: 1.5rem;
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .content-container ul {
            margin-left: 1.5rem;
            list-style: disc;
        }

        .content-container a {
            color: var(--secondary-color);
            text-decoration: underline;
        }
    </style>
@endsection

@section('content')
@section('content')
    <section class="page-header" style="background-image: url('{{ asset('images/header.webp') }}');">
        <h1>プライバシーポリシー</h1>
        <p>当サイトにおける個人情報の取り扱いについて</p>
    </section>

    <x-breadcrumb :items="[['label' => 'プライバシーポリシー', 'url' => '']]" />

    <section class="container">
        <div class="content-container">
            <p>
                「いろいろ🎶いろんな猫の会」（以下「当サイト」といいます）は、保護猫活動に関する情報を提供する目的で運営されております。当サイトでは、個人情報の適切な管理・保護を重要視しています。
            </p>

            <h2>1. 個人情報の収集について</h2>
            <p>当サイトでは、以下の情報をお問い合わせフォーム、譲渡申し込み、イベント参加申込等で取得する場合があります：</p>
            <ul>
                <li>氏名</li>
                <li>電話番号</li>
                <li>メールアドレス</li>
                <li>住所（譲渡申し込みの際）</li>
            </ul>
            <p>取得する情報の利用目的は、以下の通りです：</p>
            <ul>
                <li>保護猫の譲渡に関する情報提供・手続き</li>
                <li>譲渡会等のイベント開催のご案内</li>
                <li>お問い合わせへの対応</li>
                <li>譲渡後の猫の様子確認</li>
                <li>寄付・支援のお申し込み対応</li>
            </ul>

            <h2>2. 個人情報の利用および提供</h2>
            <p>
                取得した個人情報は、前述の利用目的の範囲内でのみ使用いたします。
                法令に基づく場合、または人命・財産の保護のために必要と判断される場合を除き、ご本人の同意なく第三者へ提供することはありません。
            </p>

            <h2>3. 個人情報の保存期間</h2>
            <p>
                取得した個人情報は、利用目的達成後、適切な期間保存した後、安全に廃棄いたします。
                ただし、譲渡した猫の記録については、猫の福祉のため必要な範囲で保管する場合があります。
            </p>

            <h2>4. セキュリティについて</h2>
            <p>
                個人情報の紛失、破壊、改ざん、不正アクセス等を防止するため、適切なセキュリティ対策を実施しています。
            </p>

            <h2>5. SNS連携について</h2>
            <p>
                当サイトでは、InstagramやLINEなどのSNSを通じて連絡を取らせていただく場合があります。
                これらのSNSでのやり取りについても、同様に個人情報保護に配慮いたします。
            </p>

            <h2>6. 写真・画像の取り扱いについて</h2>
            <p>
                譲渡後の猫の様子や写真を提供いただいた場合、当サイトのウェブサイトやSNS（Instagram等）で掲載をお願いすることがあります。
                その際は、必ず事前にご本人の了承を得た上で掲載いたします。
                また、掲載を希望されない場合は、いつでもお申し出ください。
            </p>

            <h2>7. アクセス解析について</h2>
            <p>
                当サイトでは、サービス向上のためGoogle アナリティクスを使用し、アクセス情報を分析しています。
                Google アナリティクスはCookieを使用して、個人を特定する情報を含まない形で統計データを収集しています。
                Cookieの使用を望まない場合は、ブラウザの設定でCookieを無効にすることができます。
            </p>

            <h2>8. 個人情報の開示・訂正・削除について</h2>
            <p>
                ご本人から個人情報の開示、訂正、削除等のご請求があった場合は、適切に対応いたします。
                ご希望される場合は、下記お問い合わせ先までご連絡ください。
            </p>

            <h2>9. プライバシーポリシーの変更について</h2>
            <p>
                本プライバシーポリシーは、法令の変更や当サイトの運営方針の変更に伴い、予告なく変更されることがあります。
                変更後のプライバシーポリシーは、当サイトに掲載した時点から効力を生じるものとします。
            </p>

            <h2>10. お問い合わせ</h2>
            <p>
                個人情報の取扱いに関するご質問やお問い合わせは、下記までご連絡ください。<br>
                <strong>Email:</strong> <a href="mailto:iroirocat1617@gmail.com">iroirocat1617@gmail.com</a>
            </p>

            <p style="text-align: right; margin-top: 3rem; color: #666;">
                制定日：2025年10月19日
            </p>
        </div>
    </section>
    @endsection@endsection
