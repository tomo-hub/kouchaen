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

// 受け取った$tokenを変数にいれる
$csrf_token = get_post('csrf_token');
// もし$tokenが空でfalseだった場合ログインページへ遷移
if(is_valid_csrf_token($csrf_token) === false){
  redirect_to(LOGIN_URL);
}
// 保存したセッション変数を削除
unset($_SESSION['csrf_token']);

// ユーザ情報を変数にいれる
$user_id = $user['user_id'];

// 送られてきた情報を変数にいれる
$sql_kind = get_post('sql_kind');
$item_id = get_post('item_id');
$quantity = get_post('quantity');


if($sql_kind === 'insert'){
    add_cart($db, $user_id, $item_id, $quantity);
}else if($sql_kind === 'up_amount'){
    $amount = get_item_amount($db, $user_id, $item_id);
    $up_amount = intval($amount['amount']) + 1;
    up_amount_cart($db, $up_amount, $item_id);
}


// ログインしたためホームへ遷移
redirect_to(CART_URL);