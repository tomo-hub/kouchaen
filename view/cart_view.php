<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>カートページ</title>
    <link rel="stylesheet" href="<?php print h(STYLESHEET_PATH . 'cart.css'); ?>">
</head>
<body>
    <?php include VIEW_PATH . 'templates/header_itemlist.php'; ?>
    <main>
        <article>
            <div class="cartitem">
            <?php if(count($carts) === 0){ ?> 
                <P>カートの中身がありません</P>
            <?php } else { ?>
                <?php include VIEW_PATH . 'templates/messages.php'; ?>
                <?php foreach($carts as $value){ ?>
                <div class="flex">
                    <p class="imgspace"><img src="<?php print h(IMAGE_PATH . $value['img']); ?>"></p>
                    <div class="right">
                    <div class="nameprice">
                    <p><?php print h($value['name']); ?></p>
                    <p>￥<?php print h($value['price']); ?></p>
                    </div>
                    <div class="delamount">
                    <form method="post" class="deletebutton" action="cart_delete_cart.php">
                        <input type="submit" value="削除" class="delbutton">
                        <input type="hidden" name="item_id" value="<?php print h($value['item_id']); ?>">
                        <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
                    </form>
                    <form method="post" class="amount" action="cart_change_amount.php">
                        <p>個数
                            <select name="quantity">
                                <option value="1" <?php if($value['amount'] === 1){ print h('selected'); } ?>>1</option>
                                <option value="2" <?php if($value['amount'] === 2){ print h('selected'); } ?>>2</option>
                                <option value="3" <?php if($value['amount'] === 3){ print h('selected'); } ?>>3</option>
                                <option value="4" <?php if($value['amount'] === 4){ print h('selected'); } ?>>4</option>
                                <option value="5" <?php if($value['amount'] === 5){ print h('selected'); } ?>>5</option>
                                <option value="6" <?php if($value['amount'] === 6){ print h('selected'); } ?>>6</option>
                                <option value="7" <?php if($value['amount'] === 7){ print h('selected'); } ?>>7</option>
                                <option value="8" <?php if($value['amount'] === 8){ print h('selected'); } ?>>8</option>
                                <option value="9" <?php if($value['amount'] === 9){ print h('selected'); } ?>>9</option>
                                <option value="10" <?php if($value['amount'] === 10){ print h('selected'); } ?>>10</option>
                                <input type="submit" value="変更" class="change">
                                <input type="hidden" name="item_id" value="<?php print h($value['item_id']); ?>">
                                <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
                            </select>
                        </p>
                    </form>
                    </div>
                    </div>
                </div>
                <?php } ?>
            <?php } ?>
            </div>
            <div class="button">
                <?php if(count($carts) === 0 || count(get_errors()) !== 0){ ?>
                    <input type="button" value="購入する" class="no_purchasebutton">
                <?php } else { ?>
                <form method="post" action="finish.php" >
                    <input type="submit" value="購入する" class="purchasebutton">
                    <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
                </form>
                <?php } ?>
                <a href="<?php print h(HOME_URL); ?>" class="continuebutton">買い物を続ける</a>
                <p>トレーの合計：￥<?php print h($total_price); ?></p>
            </div>
        </article>
    </main>
</body>
</html>