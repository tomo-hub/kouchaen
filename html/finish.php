<?php
// 設定ファイルの読み込み
require_once '../conf/const.php';
// 関数ファイルの読み込み
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'carts.php';
require_once MODEL_PATH . 'purchase.php';

// セッションスタート
session_start();
// ログインしていなかったら（ユーザIDが登録されていなかったら）ログインページへ遷移
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}
// データベース接続関数を変数にいれる
$db = get_db_connect();
$user = get_login_user($db);

// 受け取った$tokenを変数にいれる
$csrf_token = get_post('csrf_token');
// もし$tokenが空でfalseだった場合ログインページへ遷移
if(is_valid_csrf_token($csrf_token) === false){
  redirect_to(LOGIN_URL);
}
// 保存したセッション変数を削除
unset($_SESSION['csrf_token']);


// ユーザ情報を変数にいれる
$name = $user['username'];
$user_id = $user['user_id'];

// ユーザのカート情報を変数にいれる
$carts = get_user_carts($db, $user_id);

// カートの中身の合計数を変数にいれる
$total_price = sum_carts($carts);

// 公開だったものが非公開になってしまった場合のエラーメッセージ
if(status_error($carts) === false){
    set_error($value['name'] . 'は購入できません');
    redirect_to(CART_URL);
}
// 購入数が在庫数よりも多い場合のエラーメッセージ
if(stock_error($carts) === false){
    set_error($value['name'] . 'の在庫数が足りません');
    redirect_to(CART_URL);
}


$db->beginTransaction();
// 購入履歴テーブルに追加
if(is_foreach_incert_purchase_history($db, $user_id, $carts) === false){
  $db->rollback();
  redirect_to(CART_URL);
}
// 購入数分在庫数を減らす
if(is_foreach_decrease_stock($db, $carts) === false){
    $db->rollback();
    redirect_to(CART_URL);
}
// ユーザのカートの中身を全て削除
if(delete_carts($db, $user_id) === false){
    $db->rollback();
    redirect_to(CART_URL);
}
$db->commit();


$cart_items = get_cart_items_amount($db, $user_id);
// カートの個数表示
$totalcart = total_cart_items($cart_items);


// VIEWファイルの読み込み
include_once '../view/finish_view.php';