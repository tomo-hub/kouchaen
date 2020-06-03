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
// ログインしていなかったら（ユーザIDが登録されていなかったら）ログインページへ遷移
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}
// 受け取った$tokenを変数にいれる
$csrf_token = get_post('csrf_token');
// もし$tokenが空でfalseだった場合ログインページへ遷移
if(is_valid_csrf_token($csrf_token) === false){
  redirect_to(LOGIN_URL);
}
// 保存したセッション変数を削除
unset($_SESSION['csrf_token']);

// データベース接続関数を変数にいれる
$db = get_db_connect();
$user = get_login_user($db);

// ユーザ情報を変数にいれる
$user_id = $user['user_id'];

// $_POSTで受け取った情報を変数にいれる
$item_id = get_post('item_id');
$quantity = get_post('quantity');

// ユーザのカート情報を変数にいれる
$carts = get_user_carts($db, $user_id);
// 購入数が在庫数よりも多い場合のエラー
foreach($carts as $value){
    if($quantity > $value['stock']){
        set_error('在庫数が足りません');
        redirect_to(CART_URL);
    }
}
// 受け取ったカートIDの購入数を変更する
if(update_cart_amount($db, $quantity, $item_id)){
  set_message('購入数を更新しました。');
// それ以外エラー
} else {
  set_error('購入数の更新に失敗しました。');
}

// カートページへ遷移
redirect_to(CART_URL);