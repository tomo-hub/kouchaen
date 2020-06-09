<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>登録ページ</title>
    <link rel="stylesheet" href="<?php print h(STYLESHEET_PATH . 'signup.css'); ?>">
</head>
<body>
    <?php include VIEW_PATH . 'templates/header.php'; ?>
    <main>
        <div>
            <form method="post" action="signup_process.php">
                <h3>会員登録</h3>
                <p class="right">ユーザ名：<input type="text" name="username"></p>
                <p class="right">パスワード：<input type="password" name="password"></p>
                <p class="right">パスワード：<input type="password" name="password_confirmation"></p><span>（確認用）</span>
                <?php include VIEW_PATH . 'templates/messages.php'; ?>
                <p class="lowercase">●ユーザ名とパスワードは半角英数字かつ<br>文字数は6文字以上で入力してください</p>
                <input type="submit" value="登録" class="register">
                <p class="lowercase_login">すでに会員登録をされているお客様は</p>
                <a href="<?php print h(LOGIN_URL); ?>">ログインページへ</a>
                <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
            </form>
        </div>
    </main>
</body>
</html>