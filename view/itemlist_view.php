<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品一覧ページ</title>
    <link rel="stylesheet" href="<?php print h(STYLESHEET_PATH . 'itemlist.css'); ?>">
</head>
<body>
    <?php include VIEW_PATH . 'templates/header_itemlist.php'; ?>
    <main>
        <nav>
            <ul>
                <!--キーワード検索-->
                <li class="keyword">
                    <form method="get" action="itemlist.php">
                        <input type="search" name="keyword" placeholder="キーワードで検索">
                        <input type="submit" name="submit" value="検索" class="search">
                        <input type="hidden" name="sql_kind" value="keyword_search">
                        <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
                    </form>
                </li>
                <!--カテゴリ検索-->
                <li class="category">カテゴリ検索
                    <form method="get" name="formA" action="itemlist.php">
                        <a href="javascript:formA.submit()">ダージリン<input type="hidden" name="type" value="0"></a>
                        <input type="hidden" name="sql_kind" value="category_search">
                        <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
                    </form>
                    <form method="get" name="formB">
                        <a href="javascript:formB.submit()">アッサム<input type="hidden" name="type" value="1"></a>
                        <input type="hidden" name="sql_kind" value="category_search">
                        <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
                    </form>
                    <form method="get" name="formC">
                        <a href="javascript:formC.submit()">ニルギリ<input type="hidden" name="type" value="2"></a>
                        <input type="hidden" name="sql_kind" value="category_search">
                        <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
                    </form>
                    <form method="get" name="formD">
                        <a href="javascript:formD.submit()">ウバ<input type="hidden" name="type" value="3"></a>
                        <input type="hidden" name="sql_kind" value="category_search">
                        <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
                    </form>
                    <form method="get" name="formE">
                        <a href="javascript:formE.submit()">ケニア<input type="hidden" name="type" value="4"></a>
                        <input type="hidden" name="sql_kind" value="category_search">
                        <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
                    </form>
                    <form method="get" name="formF">
                        <a href="javascript:formF.submit()">フレーバードティー<input type="hidden" name="type" value="5"></a>
                        <input type="hidden" name="sql_kind" value="category_search">
                        <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
                    </form>
                </li>
            </ul>
        </nav>
        <article>
            <section>
                <p>茶葉は、50g単位でお売りしております</p>
                <?php include VIEW_PATH . 'templates/messages.php'; ?>
            </section>
            
                <!--検索商品一覧-->
                <?php if ($sql_kind === 'keyword_search' || $sql_kind === 'category_search'){ ?>
                    <a href="<?php print h(HOME_URL); ?>" class="return">一覧へ戻る</a>
                    <!--検索結果がある場合-->
                    <?php if(count($items)!== 0){ ?> 
                        <section class="itemlist">
                        <!--配列の中身を繰り返して表示-->
                        <?php foreach($items as $value){?>
                            <form method="post" action="detail_item.php" name="formsearch<?php print $value['item_id']; ?>">
                                <div class="itembox">
                                    <a href="javascript:formsearch<?php print h($value['item_id']); ?>.submit()">
                                    <p class="imgspace"><img src="<?php print h(IMAGE_PATH . $value['img']); ?>"></p>
                                    <p class="itemname"><?php print h($value['name']); ?></p>
                                    <!--在庫がゼロだった場合売り切れを表示-->
                                    <?php if ($value['stock'] === 0){ ?>
                                        <p><span class="soldout">売り切れ</span></p>
                                    <!--在庫がある場合売価を表示-->
                                    <?php } else { ?>
                                        <p>￥<?php print h($value['price']); ?></p>
                                    <?php } ?>
                                    <input type="hidden" name="item_id" value="<?php print h($value['item_id']); ?>">
                                    <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
                                    <input type="submit" value="詳細へ"class="detailbutton">
                                    <!--カートにすでに入っている商品ID（配列）の中に選択した商品IDがあった場合-->
                                    <?php if(in_array($value['item_id'],$cartitem_icon) == TRUE){ ?>
                                        <span class="icon">●</span>
                                    <?php } ?>
                                    </a>
                                </div>
                            </form>
                        <?php } ?>
                        </section>
                    <!--検索結果がない場合-->
                    <?php }else{ ?>
                        <p>該当商品がありません</p>
                    <?php } ?>
                
                <!--一覧表示（デフォルト）-->
                <?php }else{ ?>
                <section class="itemlist">
                    <!--配列の中身を繰り返して表示-->
                    <?php foreach($items as $value){ ?>
                    <form method="post" action="detail_item.php" name="form<?php print h($value['item_id']); ?>">
                        <div class="itembox">
                            <a href="javascript:form<?php print h($value['item_id']); ?>.submit()">
                            <p class="imgspace"><img src="<?php print h(IMAGE_PATH . $value['img']); ?>"></p>
                            <p class="itemname"><?php print h($value['name']); ?></p>
                            <!--在庫がゼロだった場合売り切れを表示-->
                            <?php if ($value['stock'] === 0){ ?>
                                <p><span class="soldout">売り切れ</span></p>
                            <!--在庫がある場合売価を表示-->
                            <?php } else { ?>
                                <p>￥<?php print h($value['price']); ?></p>
                            <?php } ?>
                            <input type="hidden" name="item_id" value="<?php print h($value['item_id']); ?>">
                            <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
                            <input type="submit" value="詳細へ"class="detailbutton">
                            <!--カートにすでに入っている商品ID（配列）の中に選択した商品IDがあった場合-->
                            <?php if(in_array($value['item_id'],$cartitem_icon) == TRUE){ ?>
                                <span class="icon">●</span>
                            <?php } ?>
                            </a>
                        </div>
                    </form>
                    <?php } ?>
                <?php } ?>
                </section>
        </article>
    </main>
</body>
</html>