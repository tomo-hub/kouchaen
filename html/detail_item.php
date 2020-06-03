<?php
// 設定ファイルの読み込み
require_once '../conf/const.php';
// 関数ファイルの読み込み
require_once '../model/functions.php';
require_once '../model/user.php';
require_once '../model/item.php';

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
$name = $user['username'];
$user_id = $user['user_id'];

// 受け取った情報を変数にいれる
$item_id = get_post('item_id');
// 商品一覧で選んだ商品の詳細情報を取得
$choice_item = get_choice_item($db, $item_id);

$cart_items = get_cart_items_amount($db, $user_id);
// カートの個数表示
$totalcart = total_cart_items($cart_items);
// すでにカートにいれている商品に印をつける
$cartitem_icon = cart_items_check($cart_items);
// 商品一覧で選んだ商品の購入数を取得
$item_amount = get_choice_item_amount($db, $user_id, $item_id);
$cartitem_amount = $item_amount['amount'];

// トークンの生成を変数にいれる
$token = get_csrf_token();

// VIEWファイルの読み込み
include_once VIEW_PATH . 'detail_item_view.php';