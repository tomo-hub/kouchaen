<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
    <link rel="stylesheet" href="<?php print h(STYLESHEET_PATH . 'login.css'); ?>">
</head>
<body>
    <?php include VIEW_PATH . 'templates/header.php'; ?>
    <main>
        <div>
            <form method="post" action="login_process.php">
                <h3>ログイン</h3>
                <p class="right">ユーザ名：<input type="text" name="username"></p>
                <p class="right">パスワード：<input type="password" name="password"></p>
                <?php include VIEW_PATH . 'templates/messages.php'; ?>
                <p class="lowercase">●ユーザ名とパスワードは半角英数字かつ<br>文字数は6文字以上で入力してください</p>
                <input type="submit" value="ログイン" class="login">
                <p class="lowercase_login">まだ会員登録をされていないお客様は</p>
                <a href="<?php print h(SIGNUP_URL); ?>">会員登録ページへ</a>
                <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
            </form>
        </div>
    </main>
</body>
</html>