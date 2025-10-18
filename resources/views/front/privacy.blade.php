@extends('front.layout')

@section('title', 'プライバシーポリシー | いろねこ')

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
<section class="page-header">
    <h1>プライバシーポリシー</h1>
    <p>当サイトにおける個人情報の取り扱いについてご説明いたします</p>
</section>

<section class="container">
    <div class="content-container">
        <p>
            「いろいろ🎶いろんな猫の会」（以下「当サイト」といいます）は、保護猫活動に関する情報を提供する
            目的で運営されております。当サイトでは、個人情報の適切な管理・保護を重要視しています。
        </p>

        <h2>1. 個人情報の収集について</h2>
        <p>当サイトでは、以下の情報をお問い合わせフォーム等で取得する場合があります：</p>
        <ul>
            <li>氏名</li>
            <li>電話番号</li>
            <li>メールアドレス</li>
        </ul>
        <p>取得する情報の利用目的は、以下の通りです：</p>
        <ul>
            <li>保護猫に関する情報の提供</li>
            <li>取材申し込みへの対応</li>
            <li>寄付の申込対応</li>
        </ul>

        <h2>2. 個人情報の利用および提供</h2>
        <p>
            取得した個人情報は、前述の利用目的の範囲内でのみ使用いたします。
            法令に基づく場合を除き、第三者への提供は行いません。
        </p>

        <h2>3. アクセス解析について</h2>
        <p>
            当サイトでは、サービス向上のため Google アナリティクスを使用し、アクセス情報を分析しています。
            これにより得られるデータは統計情報として処理され、個人を特定するものではありません。
        </p>

        <h2>4. お問い合わせ</h2>
        <p>
            個人情報の取扱いに関するお問い合わせは、下記までご連絡ください。<br>
            <a href="mailto:iroirocat1617@gmail.com">iroirocat1617@gmail.com</a>
        </p>
    </div>
</section>
@endsection
