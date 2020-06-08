<?php
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

// 全ての商品を取得
function get_items($db, $is_open = false){
    $sql = '
      SELECT
        ec_item_master.item_id,
        ec_item_master.name,
        ec_item_master.price,
        ec_item_master.img,
        ec_item_stock.stock,
        ec_item_master.status,
        ec_item_master.type,
        ec_item_master.comment 
      FROM
        ec_item_master 
      JOIN ec_item_stock 
      ON ec_item_master.item_id = ec_item_stock.item_id
    ';
    if($is_open === true){
      $sql .= '
        WHERE status = 1
      ';
    }
    return fetch_all_query($db, $sql);
}

// 全ての商品を取得
function get_all_items($db){
  return get_items($db);
}

// 全ての公開商品を取得
function get_all_open_items($db){
    return get_items($db, true);
}




function regist_item($db, $name, $price, $stock, $status, $type, $comment, $image){
    $new_img_filename = upload_image($image);
    return regist_item_transaction($db, $name, $price, $stock, $status, $type, $comment, $new_img_filename);
}
  
function regist_item_transaction($db, $name, $price, $stock, $status, $type, $comment, $new_img_filename){
    $db->beginTransaction();
    if(insert_item($db, $name, $price, $status, $type, $comment, $new_img_filename)
    && (insert_itemstock($db, $stock))){
      $db->commit();
      return true;
    }
    $db->rollback();
    return false;
}

// 商品の追加
function insert_item($db, $name, $price, $status, $type, $comment, $new_img_filename){
    $datetime = NOW_DATE;
    $update_datetime = UPDATE_DATE;
    $sql = "
      INSERT INTO
        ec_item_master(
            name, 
            price, 
            img, 
            status, 
            type, 
            comment, 
            createdate, 
            updatedate 
        )
      VALUES(:name, :price, :new_img_filename, :status, :type, :comment, :datetime, :update_datetime);
    ";
    $params = array(':name' => $name ,':price' => $price ,':new_img_filename' => $new_img_filename ,':status' => $status ,':type' => $type ,':comment' => $comment ,':datetime' => $datetime ,':update_datetime' => $update_datetime);
    return execute_query($db, $sql, $params);
}

function insert_itemstock($db, $stock){
    $item_id = $db->lastInsertId('item_id');
    $datetime = NOW_DATE;
    $update_datetime = UPDATE_DATE;
    $sql = "
      INSERT INTO
        ec_item_stock(
            item_id, 
            stock, 
            createdate, 
            updatedate 
        )
      VALUES(:item_id, :stock, :datetime, :update_datetime);
    ";
    $params = array(':item_id' => $item_id ,':stock' => $stock , ':datetime' => $datetime ,':update_datetime' => $update_datetime);
    return execute_query($db, $sql, $params);
}

// 商品の在庫数更新
function update_item_stock($db, $item_id, $stock){
    $update_datetime = UPDATE_DATE;
    $sql = "
      UPDATE
        ec_item_stock
      SET
        stock = :stock, 
        updatedate = :update_datetime 
      WHERE
        item_id = :item_id
      LIMIT 1
    ";
    $params = array(':stock' => $stock ,':item_id' => $item_id ,':update_datetime' => $update_datetime);
    return execute_query($db, $sql, $params);
}

// 商品のステータス変更
function update_item_status($db, $item_id, $status){
    $update_datetime = UPDATE_DATE;
    $sql = "
      UPDATE
        ec_item_master 
      SET
        status = :status, 
        updatedate = :update_datetime 
      WHERE
        item_id = :item_id
      LIMIT 1
    ";
    $params = array(':status' => $status ,':item_id' => $item_id ,':update_datetime' => $update_datetime);
    return execute_query($db, $sql, $params);
}

// 商品削除
function destroy_item($db, $item_id){
    $db->beginTransaction();
    if(delete_item($db, $item_id)
      && delete_itemstock($db, $item_id)){
      $db->commit();
      return true;
    }
    $db->rollback();
    return false;
}

// 商品削除
function delete_item($db, $item_id){
    $sql = "
      DELETE FROM
        ec_item_master
      WHERE
        item_id = :item_id
      LIMIT 1
    ";
    $params = array(':item_id' => $item_id);
    return execute_query($db, $sql, $params);
}

function delete_itemstock($db, $item_id){
    $sql = "
      DELETE FROM
        ec_item_stock
      WHERE
        item_id = :item_id
      LIMIT 1
    ";
    $params = array(':item_id' => $item_id);
    return execute_query($db, $sql, $params);
}

// カートの中に入っている商品の個数を取得
function get_cart_items_amount($db, $user_id){
    $sql = "
      SELECT 
      item_id,amount 
      FROM
        ec_cart 
      WHERE user_id = :user_id
    ";
    $params = array(':user_id' => $user_id);
    return fetch_all_query($db, $sql, $params);
}

// カートの中身に入っている商品の個数をそれぞれ配列にいれていく
function total_cart_items($amount){
    $total = array();
    foreach($amount as $value){
        $total[] = $value['amount'];
    }
    // 配列の中身の合計を算出
    $totalcart = '';
    $totalcart = array_sum($total);
    return $totalcart;
}

// すでに商品をカートにいれているかチェックするために商品IDを配列にいれておく
function cart_items_check($item_id){
    $cartitem = array();
    foreach ($item_id as $value) {
        $cartitem[] = $value['item_id'];
    }
    return $cartitem;
}

// 商品詳細情報を取得
function get_choice_item($db, $item_id){
    $sql = "
      SELECT 
        ec_item_master.item_id,
        ec_item_master.name,
        ec_item_master.price,
        ec_item_master.img,
        ec_item_master.comment,
        ec_item_stock.stock 
      FROM
        ec_item_master 
      JOIN ec_item_stock ON ec_item_master.item_id = ec_item_stock.item_id 
      WHERE ec_item_master.item_id = :item_id
    ";
    $params = array(':item_id' => $item_id);
    return fetch_query($db, $sql, $params);
}

// 選択された商品の購入数を取得
function get_choice_item_amount($db, $user_id, $item_id){
    $sql = "
      SELECT 
        amount 
      FROM 
        ec_cart 
      WHERE user_id = :user_id AND item_id = :item_id
    ";
    $params = array(':user_id' => $user_id, ':item_id' => $item_id);
    return fetch_query($db, $sql, $params);
}

// 購入完了後の在庫数を購入数分減らす
function is_foreach_decrease_stock($db, $carts){
    foreach($carts as $value){
        $stock = $value['stock']-$value['amount'];
        if(update_item_stock($db, $value['item_id'], $stock) === false){
            return false;
        }
    }
    return true;
}



// 全ての商品を取得(ページネーション)
function get_all_open_items_page($db, $limit_page_number){
  $sql = '
    SELECT
      ec_item_master.item_id,
      ec_item_master.name,
      ec_item_master.price,
      ec_item_master.img,
      ec_item_stock.stock 
    FROM
      ec_item_master 
    JOIN ec_item_stock 
    ON ec_item_master.item_id = ec_item_stock.item_id 
    WHERE ec_item_master.status = 1 
    LIMIT :limit_page_number, 8
  ';
  $params = array(':limit_page_number' => $limit_page_number);
  return fetch_all_query($db, $sql, $params);
}
// キーワード検索の商品を取得
function get_keyword_items($db, $keyword, $limit_page_number){
  $sql = "
    SELECT 
    ec_item_master.item_id,
    ec_item_master.name,
    ec_item_master.price,
    ec_item_master.img,
    ec_item_stock.stock 
    FROM
      ec_item_master 
    JOIN ec_item_stock 
    ON ec_item_master.item_id = ec_item_stock.item_id 
    WHERE ec_item_master.status = 1 AND CONCAT(ec_item_master.comment, ec_item_master.name) LIKE :keyword 
    LIMIT :limit_page_number, 8
  ";
  $params = array(':keyword' => '%' . $keyword . '%' , ':limit_page_number' => $limit_page_number);
  return fetch_all_query($db, $sql, $params);
}
// カテゴリ検索の商品を取得
function get_category_items($db, $type, $limit_page_number){
  $sql = "
    SELECT 
    ec_item_master.item_id,
    ec_item_master.name,
    ec_item_master.price,
    ec_item_master.img,
    ec_item_stock.stock 
    FROM
      ec_item_master 
    JOIN ec_item_stock 
    ON ec_item_master.item_id = ec_item_stock.item_id 
    WHERE ec_item_master.status = 1 AND ec_item_master.type = :type 
    LIMIT :limit_page_number, 8
  ";
  $params = array(':type' => $type , ':limit_page_number' => $limit_page_number);
  return fetch_all_query($db, $sql, $params);
}


// 新着順の商品情報取得
function get_new_arrival_items($db,$limit_page_number){
  $sql = '
    SELECT
      ec_item_master.item_id,
      ec_item_master.name,
      ec_item_master.price,
      ec_item_master.img,
      ec_item_stock.stock 
    FROM
      ec_item_master 
    JOIN 
      ec_item_stock 
    ON 
      ec_item_master.item_id = ec_item_stock.item_id 
    WHERE 
      ec_item_master.status = 1 
    ORDER BY ec_item_master.createdate DESC 
    LIMIT :limit_page_number, 8
  ';
  $params = array(':limit_page_number' => $limit_page_number);
  return fetch_all_query($db, $sql,$params);
}
// 新着順のキーワード検索の商品を取得
function get_keyword_new_arrival_items($db, $keyword, $limit_page_number){
  $sql = '
    SELECT
      ec_item_master.item_id,
      ec_item_master.name,
      ec_item_master.price,
      ec_item_master.img,
      ec_item_stock.stock 
    FROM
      ec_item_master 
    JOIN 
      ec_item_stock 
    ON 
      ec_item_master.item_id = ec_item_stock.item_id 
    WHERE 
      ec_item_master.status = 1 AND CONCAT(ec_item_master.comment, ec_item_master.name) LIKE :keyword 
    ORDER BY ec_item_master.createdate DESC 
    LIMIT :limit_page_number, 8
  ';
  $params = array(':keyword' => '%' . $keyword . '%' , ':limit_page_number' => $limit_page_number);
  return fetch_all_query($db, $sql,$params);
}
// 新着順のカテゴリ検索の商品を取得
function get_category_new_arrival_items($db, $type, $limit_page_number){
  $sql = '
    SELECT
      ec_item_master.item_id,
      ec_item_master.name,
      ec_item_master.price,
      ec_item_master.img,
      ec_item_stock.stock 
    FROM
      ec_item_master 
    JOIN 
      ec_item_stock 
    ON 
      ec_item_master.item_id = ec_item_stock.item_id 
    WHERE 
      ec_item_master.status = 1 AND ec_item_master.type = :type 
    ORDER BY ec_item_master.createdate DESC 
    LIMIT :limit_page_number, 8
  ';
  $params = array(':type' => $type , ':limit_page_number' => $limit_page_number);
  return fetch_all_query($db, $sql,$params);
}


// 価格の安い順の商品情報取得
function get_cheap_price_items($db,$limit_page_number){
  $sql = '
    SELECT
      ec_item_master.item_id,
      ec_item_master.name,
      ec_item_master.price,
      ec_item_master.img,
      ec_item_stock.stock 
    FROM
      ec_item_master 
    JOIN 
      ec_item_stock 
    ON 
      ec_item_master.item_id = ec_item_stock.item_id 
    WHERE 
      ec_item_master.status = 1 
    ORDER BY price 
    LIMIT :limit_page_number, 8
  ';
  $params = array(':limit_page_number' => $limit_page_number);
  return fetch_all_query($db, $sql, $params);
}
// 価格の安い順のキーワード検索の商品を取得
function get_keyword_cheap_price_items($db, $keyword, $limit_page_number){
  $sql = '
    SELECT
      ec_item_master.item_id,
      ec_item_master.name,
      ec_item_master.price,
      ec_item_master.img,
      ec_item_stock.stock 
    FROM
      ec_item_master 
    JOIN 
      ec_item_stock 
    ON 
      ec_item_master.item_id = ec_item_stock.item_id 
    WHERE 
      ec_item_master.status = 1 AND CONCAT(ec_item_master.comment, ec_item_master.name) LIKE :keyword 
    ORDER BY price 
    LIMIT :limit_page_number, 8
  ';
  $params = array(':keyword' => '%' . $keyword . '%' , ':limit_page_number' => $limit_page_number);
  return fetch_all_query($db, $sql, $params);
}
// 価格の安い順のカテゴリ検索の商品を取得
function get_category_cheap_price_items($db, $type, $limit_page_number){
  $sql = '
    SELECT
      ec_item_master.item_id,
      ec_item_master.name,
      ec_item_master.price,
      ec_item_master.img,
      ec_item_stock.stock 
    FROM
      ec_item_master 
    JOIN 
      ec_item_stock 
    ON 
      ec_item_master.item_id = ec_item_stock.item_id 
    WHERE 
      ec_item_master.status = 1 AND ec_item_master.type = :type 
    ORDER BY price 
    LIMIT :limit_page_number, 8
  ';
  $params = array(':type' => $type , ':limit_page_number' => $limit_page_number);
  return fetch_all_query($db, $sql, $params);
}

// 価格の高い順の商品情報取得
function get_high_price_items($db,$limit_page_number){
  $sql = '
    SELECT
      ec_item_master.item_id,
      ec_item_master.name,
      ec_item_master.price,
      ec_item_master.img,
      ec_item_stock.stock 
    FROM
      ec_item_master 
    JOIN 
      ec_item_stock 
    ON 
      ec_item_master.item_id = ec_item_stock.item_id 
    WHERE 
      ec_item_master.status = 1 
    ORDER BY price DESC 
    LIMIT :limit_page_number, 8
  ';
  $params = array(':limit_page_number' => $limit_page_number);
  return fetch_all_query($db, $sql, $params);
}
// 価格の高い順のキーワード検索の商品を取得
function get_keyword_high_price_items($db, $keyword, $limit_page_number){
  $sql = '
    SELECT
      ec_item_master.item_id,
      ec_item_master.name,
      ec_item_master.price,
      ec_item_master.img,
      ec_item_stock.stock 
    FROM
      ec_item_master 
    JOIN 
      ec_item_stock 
    ON 
      ec_item_master.item_id = ec_item_stock.item_id 
    WHERE 
      ec_item_master.status = 1 AND CONCAT(ec_item_master.comment, ec_item_master.name) LIKE :keyword 
    ORDER BY price DESC 
    LIMIT :limit_page_number, 8
  ';
  $params = array(':keyword' => '%' . $keyword . '%' , ':limit_page_number' => $limit_page_number);
  return fetch_all_query($db, $sql, $params);
}
// 価格の高い順のカテゴリ検索の商品を取得
function get_category_high_price_items($db, $type, $limit_page_number){
  $sql = '
    SELECT
      ec_item_master.item_id,
      ec_item_master.name,
      ec_item_master.price,
      ec_item_master.img,
      ec_item_stock.stock 
    FROM
      ec_item_master 
    JOIN 
      ec_item_stock 
    ON 
      ec_item_master.item_id = ec_item_stock.item_id 
    WHERE 
      ec_item_master.status = 1 AND ec_item_master.type = :type 
    ORDER BY price DESC 
    LIMIT :limit_page_number, 8
  ';
  $params = array(':type' => $type , ':limit_page_number' => $limit_page_number);
  return fetch_all_query($db, $sql, $params);
}


function get_itemlist_items($db, $sort, $limit_page_number, $sql_kind, $type, $keyword){
  // 公開している新着順の商品情報を変数にいれる
  if($sort === 'new_arrival'){
    $items = new_arrival_items($db,$limit_page_number, $sql_kind, $type, $keyword);
  // 公開している価格の安い順の商品情報を変数にいれる
  }else if($sort === 'cheap_price'){
    $items = cheap_price_items($db,$limit_page_number, $sql_kind, $type, $keyword);
  // 公開している価格の高い順の商品情報を変数にいれる
  }else if($sort === 'high_price'){
    $items = high_price_items($db,$limit_page_number, $sql_kind, $type, $keyword);
  // 公開している商品情報を変数にいれる
  }else{
    $items = all_open_items_page($db, $limit_page_number, $sql_kind, $type, $keyword);
  }
  return $items;
}

// 新着順の場合
function new_arrival_items($db, $limit_page_number, $sql_kind, $type, $keyword){
  // キーワード検索時の商品
  if($sql_kind === 'keyword_search'){
    $items = get_keyword_new_arrival_items($db, $keyword, $limit_page_number);
  // カテゴリ検索時の商品
  }else if($sql_kind === 'category_search'){
    $items = get_category_new_arrival_items($db, $type, $limit_page_number);
  // 商品一覧
  }else{
    $items = get_new_arrival_items($db, $limit_page_number);
  }
  return $items;
}

// 価格の安い順の場合
function cheap_price_items($db, $limit_page_number, $sql_kind, $type, $keyword){
  // キーワード検索時の商品
  if($sql_kind === 'keyword_search'){
    $items = get_keyword_cheap_price_items($db, $keyword, $limit_page_number);
  // カテゴリ検索時の商品
  }else if($sql_kind === 'category_search'){
    $items = get_category_cheap_price_items($db, $type, $limit_page_number);
  // 商品一覧
  }else{
    $items = get_cheap_price_items($db, $limit_page_number);
  }
  return $items;
}

// 価格の高い順の場合
function high_price_items($db, $limit_page_number, $sql_kind, $type, $keyword){
  // キーワード検索時の商品
  if($sql_kind === 'keyword_search'){
    $items = get_keyword_high_price_items($db, $keyword, $limit_page_number);
  // カテゴリ検索時の商品
  }else if($sql_kind === 'category_search'){
    $items = get_category_high_price_items($db, $type, $limit_page_number);
  // 商品一覧
  }else{
    $items = get_high_price_items($db, $limit_page_number);
  }
  return $items;
}

// 並び替えしない場合
function all_open_items_page($db,$limit_page_number, $sql_kind, $type, $keyword){
  // キーワード検索時の商品
  if($sql_kind === 'keyword_search'){
    $items = get_keyword_items($db, $keyword, $limit_page_number);
  // カテゴリ検索時の商品
  }else if($sql_kind === 'category_search'){
    $items = get_category_items($db, $type, $limit_page_number);
  // 商品一覧
  }else{
    $items = get_all_open_items_page($db, $limit_page_number);
  }
  return $items;
}
