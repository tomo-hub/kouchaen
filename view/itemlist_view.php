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
                        <input type="hidden" name="sort" value="<?php print h($sort); ?>">
                    </form>
                </li>
                <!--カテゴリ検索-->
                <li class="category">カテゴリ検索
                    <a href="/itemlist.php?sort=<?php print h($sort); ?>&type=0&sql_kind=category_search">ダージリン</a>
                    <a href="/itemlist.php?sort=<?php print h($sort); ?>&type=1&sql_kind=category_search">アッサム</a>
                    <a href="/itemlist.php?sort=<?php print h($sort); ?>&type=2&sql_kind=category_search">ニルギリ</a>
                    <a href="/itemlist.php?sort=<?php print h($sort); ?>&type=3&sql_kind=category_search">ウバ</a>
                    <a href="/itemlist.php?sort=<?php print h($sort); ?>&type=4&sql_kind=category_search">ケニア</a>
                    <a href="/itemlist.php?sort=<?php print h($sort); ?>&type=5&sql_kind=category_search">フレーバードティー</a>
                </li>
            </ul>
            <p>茶葉は、50g単位でお売りしております。</p>
        </nav>
        <article>
            <section class="head">
                
                <?php include VIEW_PATH . 'templates/messages.php'; ?>

                <!--商品の並び替え機能-->
                <div class="sort">
                    <form method="get" action="itemlist.php">
                        <select name="sort">
                        <option value="new_arrival" <?php if($sort === 'new_arrival'){ print h('selected'); } ?>>新着順</option>
                        <option value="cheap_price" <?php if($sort === 'cheap_price'){ print h('selected'); } ?>>価格の安い順</option>
                        <option value="high_price" <?php if($sort === 'high_price'){ print h('selected'); } ?>>価格の高い順</option>
                        </select>
                        <input type="submit" value="並び替え" class="sortbutton">
                        <input type="hidden" name="type" value="<?php print h($type); ?>">
                        <input type="hidden" name="keyword" value="<?php print h($keyword); ?>">
                        <input type="hidden" name="sql_kind" value="<?php print h($sql_kind); ?>">
                    </form>
                </div>
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
            <!--ページネーション-->
            <section class="foot">
                <div class="page">
                    <?php for($i = 1; $i <= $total_pages; $i++){ 
                        if ($i == $now_page) { ?>
                            <div class="nowpage"><span><?php print h($now_page);?></span></div>
                        <?php } else { ?>
                                <a href='/itemlist.php?page=<?php print h($i); ?>&sort=<?php print h($sort); ?>&type=<?php print h($type); ?>&keyword=<?php print h($keyword); ?>&sql_kind=<?php print h($sql_kind); ?>'><div class="linkpage"><?php print h($i); ?></div></a>
                        <?php } 
                    } ?>
                </div>
            </section>
        </article>
    </main>
</body>
</html>