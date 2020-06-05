<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品管理ページ</title>
    <link rel="stylesheet" href="<?php print h(STYLESHEET_PATH . 'admin.css'); ?>">
</head>
<body>
<h1>商品管理ツール</h1>
    <a href="<?php print h(ADMIN_USER_URL); ?>">ユーザ管理ページ</a> <!--未処理！！！-->
    <a href="<?php print h(LOGOUT_URL); ?>">ログアウト</a>
    <h2>新規商品追加</h2>
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
    <form method="post" enctype="multipart/form-data" action="admin_insert_item.php">
        <p>名前：<input type="text" name="name"></p>
        <p>値段：<input type="text" name="price"></p>
        <p>個数：<input type="text" name="stock" ></p>
        <p>種類：<input type="radio" name="type" value="0">0:ダージリン</p>
        <p class="types"><input type="radio" name="type" value="1">1:アッサム</p>
        <p class="types"><input type="radio" name="type" value="2">2:ニルギリ</p>
        <p class="types"><input type="radio" name="type" value="3">3:ウバ</p>
        <p class="types"><input type="radio" name="type" value="4">4:ケニア</p>
        <p class="types"><input type="radio" name="type" value="5">5:フレーバードティー</p>
        <p>コメント：<input type="text" name="comment" style="width:500px;"></p>
        <p><input type="file" name="image"></p>
        <p>
            <select name="status"> <!--disabled 追加で無効化-->
                <option value="0">非公開</option>
                <option value="1">公開</option>
            </select>
            <span class="icon"></span>
        </p>
        <p><input type="submit" name="submit" value="商品を追加"></p>
        <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
    </form>
    
    <h2>商品情報変更</h2>
    <p>商品一覧</p>
    <table>
        <tr>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>在庫数</th>
            <th>種類</th>
            <th>コメント</th>
            <th>ステータス</th>
            <th>削除</th>
        </tr>
        
        <?php foreach ($items as $value) { ?>
            <tr class="<?php if ($value['status'] === ITEM_STATUS_CLOSE) { ?> background <?php } ?>">
                <form method="post" action="admin_change_stock.php">
                    <td><img src="<?php print h(IMAGE_PATH . $value['img']); ?>"></td>
                    <td><?php print h($value['name']); ?></td>
                    <td><?php print h($value['price']); ?>円</td>
                    <td><input type="text"  class="text_align_right"  name="update_stock" value="<?php print h($value['stock']); ?>">&nbsp;個&nbsp;<input type="submit" value="変更"></td>
                    <td><?php print h($value['type']); ?></td> <!--紅茶の種類表示-->
                    <td><?php print h($value['comment']); ?></td><!--紅茶のコメント表示-->
                    <input type="hidden" name="item_id" value="<?php print h($value['item_id']); ?>">
                    <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
                </form>
                <form method="post" action="admin_change_status.php">
                    <?php if ($value['status'] === ITEM_STATUS_OPEN) { ?>
                        <td><input type="submit" value="公開 → 非公開"></td>
                        <input type="hidden" name="change_status" value="0">
                    <?php } else { ?>
                        <td><input type="submit" value="非公開 → 公開"></td>
                        <input type="hidden" name="change_status" value="1">
                    <?php } ?>
                    <input type="hidden" name="item_id" value="<?php print h($value['item_id']); ?>">
                    <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
                </form>
                <form method="post" action="admin_delete_item.php">
                    <td><input type="submit" value="削除"></td>
                    <input type="hidden" name="item_id" value="<?php print h($value['item_id']); ?>">
                    <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
                </form>
            <tr>
        <?php } ?>
        
    </table>
</body>
</html>