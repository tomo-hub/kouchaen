<?php
// 設定ファイルの読み込み
require_once '../conf/const.php';
// 関数ファイルの読み込み
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'carts.php';

// セッションスタート
session_start();
// ログインしていなかったら（ユーザIDが登録されていなかったら）トップページへ遷移
if(is_logined() === false){
  redirect_to(TOP_URL);
}

// データベース接続関数を変数にいれる
$db = get_db_connect();
$user = get_login_user($db);

// ユーザ情報を変数にいれる
$name = $user['username'];
$user_id = $user['user_id'];

// ユーザのカート情報を変数にいれる
$carts = get_user_carts($db, $user_id);

// カートの中身の合計数を変数にいれる
$total_price = sum_carts($carts);

// 公開だったものが非公開になってしまった場合のエラー
if(status_error($carts) === false){
    set_error('商品エラー');
}
// 購入数が在庫数よりも多い場合のエラー
if(stock_error($carts) === false){
    set_error('商品エラー');
}

$cart_items = get_cart_items_amount($db, $user_id);
// カートの個数表示
$totalcart = total_cart_items($cart_items);

// トークンの生成を変数にいれる
$token = get_csrf_token();

// VIEWファイルの読み込み
include_once VIEW_PATH . 'cart_view.php';