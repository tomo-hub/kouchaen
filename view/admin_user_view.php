<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザ管理ページ</title>
    <link rel="stylesheet" href="<?php print h(STYLESHEET_PATH . 'admin_user.css'); ?>">
</head>
<body>
<h1>ユーザ情報管理ツール</h1>
    <a href="<?php print h(ADMIN_URL); ?>">商品管理ページ</a>
    <a href="<?php print h(LOGOUT_URL); ?>">ログアウト</a>
    <h2>ユーザ情報一覧</h2>
    <table>
        <tr>
            <th>ユーザ名</th>
            <th>登録日</th>
        </tr>
        
        <?php foreach ($users as $value) { ?>
        <tr>
            <th><?php print h($value['username']); ?></th>
            <th><?php print h($value['createdate']); ?></th>
        <tr>
        <?php } ?>
    </table>
</body>
</html>