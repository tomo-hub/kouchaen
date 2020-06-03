<?php 
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

// ユーザのカート情報取得
function get_user_carts($db, $user_id){
    $sql = "
      SELECT 
        ec_item_master.item_id,
        ec_item_master.name,
        ec_item_master.price,
        ec_item_master.img,
        ec_item_master.status,
        ec_item_stock.stock,
        ec_cart.amount 
      FROM 
        ec_item_master 
      JOIN ec_cart ON ec_item_master.item_id = ec_cart.item_id 
      JOIN ec_item_stock ON ec_item_master.item_id = ec_item_stock.item_id 
      WHERE 
        ec_cart.user_id = :user_id
    ";
    $params = array(':user_id' => $user_id);
    return fetch_all_query($db, $sql, $params);
}

// カートの商品の値段の合計数を算出
function sum_carts($carts){
    $total = array();
    foreach($carts as $value){
        $total[] = $value['price'] * $value['amount'];
    }
    $total_price = '';
    $total_price = array_sum($total);
    return $total_price;
}

// 公開だったものが非公開になってしまった場合のエラーメッセージ
function status_error($carts){
    foreach($carts as $value){
        if($value['status'] === '0'){
            set_error($value['name'] . 'は購入できません');
            return false;
        }
    }
    return true;
}

// 購入数が在庫数よりも多い場合のエラーメッセージ
function stock_error($carts){
    foreach($carts as $value){
        if($value['stock'] < $value['amount']){
            set_error($value['name'] . 'の在庫数が足りません');
            return false;
        }
    }
    return true;
}

// カートに商品を追加
function add_cart($db, $user_id, $item_id, $quantity){
    $datetime = NOW_DATE;
    $update_datetime = UPDATE_DATE;
    $sql = "
    INSERT INTO 
        ec_cart (
            user_id, 
            item_id, 
            amount, 
            createdate, 
            updatedate 
        )
      VALUES(:user_id, :item_id, :quantity, :datetime, :update_datetime);
    ";
    $params = array(':user_id' => $user_id ,':item_id' => $item_id , ':quantity' => $quantity , ':datetime' => $datetime , ':update_datetime' => $update_datetime);
    return execute_query($db, $sql, $params);
}

// カートの中身に入っている商品の個数を取得
function get_item_amount($db, $user_id, $item_id){
    $sql = "
        SELECT 
            amount 
        FROM ec_cart 
        WHERE user_id = :user_id AND item_id = :item_id 
    ";
    $params = array(':user_id' => $user_id ,':item_id' => $item_id);
    return fetch_query($db, $sql, $params);
}

// 商品購入数を増やす
function up_amount_cart($db, $up_amount, $item_id){
    $update_datetime = UPDATE_DATE;
    $sql = "
      UPDATE
        ec_cart 
      SET
        amount = :up_amount, 
        updatedate = :update_datetime 
      WHERE
        item_id = :item_id
      LIMIT 1
    ";
    $params = array(':up_amount' => $up_amount ,':item_id' => $item_id ,':update_datetime' => $update_datetime);
    return execute_query($db, $sql, $params);
}

// カートの商品を削除
function delete_cart($db, $item_id){
  $sql = "
      DELETE FROM
        ec_cart 
      WHERE
        item_id = :item_id
      LIMIT 1
    ";
    $params = array(':item_id' => $item_id);
    return execute_query($db, $sql, $params);
}

// カートの商品の購入数を変更
function update_cart_amount($db, $quantity, $item_id){
  $update_datetime = UPDATE_DATE;
    $sql = "
      UPDATE
        ec_cart 
      SET
        amount = :quantity, 
        updatedate = :update_datetime 
      WHERE
        item_id = :item_id
      LIMIT 1
    ";
    $params = array(':quantity' => $quantity ,':update_datetime' => $update_datetime ,':item_id' => $item_id );
    return execute_query($db, $sql, $params);
}

// ユーザのカートの商品を全て削除
function delete_carts($db, $user_id){
  $sql = "
      DELETE FROM
        ec_cart 
      WHERE
        user_id = :user_id 
    ";
    $params = array(':user_id' => $user_id);
    return execute_query($db, $sql, $params);
}