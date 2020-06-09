<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品詳細ページ</title>
    <link rel="stylesheet" href="<?php print h(STYLESHEET_PATH . 'detail_item.css'); ?>">
</head>
<body>
    <?php include VIEW_PATH . 'templates/header_index.php'; ?>
    <main>
        <article>
            <!--配列の中身を繰り返して表示-->
                <div class="flex">
                    <div class="left">
                        <a href="<?php print h(TENTATIVE_HOME_URL); ?>">戻る</a>
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
                    <!--在庫がある場合会員登録へボタンを表示-->
                    <?php }else{ ?>
                        <a href="<?php print h(SIGNUP_URL); ?>" class="register">会員登録へ</a>
                    <?php } ?>
                    </div>
                </div>
        </article>
    </main>
</body>
</html>