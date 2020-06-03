<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品詳細ページ</title>
    <link rel="stylesheet" href="<?php print h(STYLESHEET_PATH . 'detail_item.css'); ?>">
</head>
<body>
    <?php include VIEW_PATH . 'templates/header_itemlist.php'; ?>
    <main>
        <article>
            <?php include VIEW_PATH . 'templates/messages.php'; ?>
                <div class="flex">
                    <div class="left">
                        <a href="<?php print h(HOME_URL); ?>">戻る</a>
                        <p class="imgspace"><img src="<?php print h(IMAGE_PATH . $choice_item['img']); ?>"></p>
                    </div>
                    <div class="right">
                        <p><?php print h($choice_item['comment']); ?></p>
                        <p><?php print h($choice_item['name']); ?></p>
                        <p>￥<?php print h($choice_item['price']); ?></p>
                    </div>
                </div>
                <div class="linebox">
                    <div class="cartbuttonbox">
                    <!--在庫がゼロだった場合売り切れを表示-->
                    <?php if($choice_item['stock'] === 0){ ?>
                        <p><span class="soldout">売り切れ</span></p>
                    <!--在庫がある場合個数選択フォームとトレーにいれるボタンを表示-->
                    <?php }else{ ?>
                        <form method="post" action="item_add_cart.php">
                            <!--カートにすでに入っている商品ID（配列）の中に選択した商品IDがあった場合-->
                            <?php if(in_array($item_id,$cartitem_icon) == TRUE){ ?>
                                <?php if($cartitem_amount >= 10 || $cartitem_amount === $choice_item['stock']){ ?>
                                    <p class="carterr">この商品はこれ以上追加できません</p>
                                <?php }else{ ?>
                                    <input type="submit" value="トレーに入れる" class="cart">
                                    <input type="hidden" name="item_id" value="<?php print h($choice_item['item_id']); ?>">
                                    <input type="hidden" name="sql_kind" value="up_amount">
                                <?php } ?>
                            <!--カートにすでに入っている商品ID（配列）の中に選択した商品IDが無い場合トレーに入れるボタンを表示-->
                            <?php } else { ?>
                                <p>個数
                                    <select name="quantity">
                                        <option value="1">1</option>
                                        <?php if($choice_item['stock'] >= 2){ ?>
                                            <option value="2">2</option>
                                        <?php } ?>
                                        <?php if($choice_item['stock'] >= 3){ ?>
                                            <option value="3">3</option>
                                        <?php } ?>
                                        <?php if($choice_item['stock'] >= 4){ ?>
                                            <option value="4">4</option>
                                        <?php } ?>
                                        <?php if($choice_item['stock'] >= 5){ ?>
                                            <option value="5">5</option>
                                        <?php } ?>
                                        <?php if($choice_item['stock'] >= 6){ ?>
                                            <option value="6">6</option>
                                        <?php } ?>
                                        <?php if($choice_item['stock'] >= 7){ ?>
                                            <option value="7">7</option>
                                        <?php } ?>
                                        <?php if($choice_item['stock'] >= 8){ ?>
                                            <option value="8">8</option>
                                        <?php } ?>
                                        <?php if($choice_item['stock'] >= 9){ ?>
                                            <option value="9">9</option>
                                        <?php } ?>
                                        <?php if($choice_item['stock'] >= 10){ ?>
                                            <option value="10">10</option>
                                        <?php } ?>
                                    </select>
                                </p>
                                <input type="submit" value="トレーに入れる" class="cart">
                                <!--カートに追加する際の情報をhiddenで送る-->
                                <input type="hidden" name="item_id" value="<?php print h($choice_item['item_id']); ?>">
                                <input type="hidden" name="sql_kind" value="insert">
                            <?php } ?>
                            <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
                        </form>
                    <?php } ?>
                    </div>
                </div>
        </article>
    </main>
    </body>
</html>