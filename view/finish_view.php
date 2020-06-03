<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>購入完了ページ</title>
    <link rel="stylesheet" href="<?php print h(STYLESHEET_PATH . 'finish.css'); ?>">
</head>
<body>
    <?php include VIEW_PATH . 'templates/header_itemlist.php'; ?>
    <main>
        <article>
        <?php include VIEW_PATH . 'templates/messages.php'; ?>
            <?php if(count(get_errors()) === 0){ ?>
                <p class="comment">ご購入ありがとうございます</p>
                <a href="<?php print h(HOME_URL); ?>">一覧ページへ戻る</a>
            <?php }else{ ?>
                <a href="<?php print h(CART_URL); ?>">トレーへ戻る</a>
            <?php } ?>
            <p class="total">合計：￥<?php print h($total_price); ?></p>
            
            <?php foreach($carts as $value){ ?>
            <div class="itembox">
                <p class="imgspace"><img src="<?php print h(IMAGE_PATH . $value['img']); ?>"></p>
                <div class="right">
                    <p><?php print h($value['name']); ?></p>
                    <p>￥<?php print h($value['price']); ?></p>
                    <p><?php print h($value['amount']); ?>個</p>
                </div>
            </div>
            <?php } ?>
        </article>
    </main>
</body>
</html>