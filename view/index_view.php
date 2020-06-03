<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>トップページ</title>
    <link rel="stylesheet" href="<?php print h(STYLESHEET_PATH . 'index.css'); ?>">
</head>
<body>
    <?php include VIEW_PATH . 'templates/header_index.php'; ?>
    <main>
    <div class="imgspace">
        <img src="<?php print h(IMAGE_PATH . 'tea-party-1001654_1280.jpg'); ?>" class="mainimg">
    </div>
        <article>
            <p class="comment">様々な紅茶の種類からお好みの紅茶を<br>ご購入いただけます。<br>なじみのあるダージリンやアッサム、<br>フルーツを取り入れた香り豊かなフレーバードティー…<br>自分へのご褒美やプレゼントにも最適です。</p>
            <section>
            <div class="registerbox">
                <p>まずは簡単な新規会員登録から</p>
                <a href="<?php print h(SIGNUP_URL); ?>" class="register">会員登録</a>
            </div>
            <div class="registerbox">
                <p>商品閲覧はこちら</p>
                <a href="<?php print h(TENTATIVE_HOME_URL); ?>" class="register">商品一覧</a>
            </div>
            </section>
        </article>
    </main>
</body>
</html>