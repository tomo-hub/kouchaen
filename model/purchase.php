<?php 
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

// 購入履歴テーブルに追加
function is_foreach_incert_purchase_history($db, $user_id, $carts){
    foreach($carts as $value){
        if(insert_purchase_history($db, $user_id, $value['item_id'], $value['amount']) === false){
            return false;
        }
    }
    return true;
}

function insert_purchase_history($db, $user_id, $item_id, $amount){
    $datetime = NOW_DATE;
    $update_datetime = UPDATE_DATE;
    $sql = "
    INSERT INTO 
        ec_purchase_history (
            user_id, 
            item_id, 
            purchase_amount, 
            createdate, 
            updatedate 
        )
      VALUES(:user_id, :item_id, :amount, :datetime, :update_datetime);
    ";
    $params = array(':user_id' => $user_id ,':item_id' => $item_id , ':amount' => $amount , ':datetime' => $datetime , ':update_datetime' => $update_datetime);
    return execute_query($db, $sql, $params);
}