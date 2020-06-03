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


// ユーザ情報を変数にいれる
$name = $user['username'];
$user_id = $user['user_id'];

// 検索したときに送られてきた情報を変数にいれる
$sql_kind = get_get('sql_kind');
$keyword = get_get('keyword');
$type = get_get('type');

// キーワード検索時の商品
if($sql_kind === 'keyword_search'){
    $items = get_keyword_items($db, $keyword);
// カテゴリ検索時の商品
}else if($sql_kind === 'category_search'){
    $items = get_category_items($db, $type);
// 商品一覧
}else{
    $items = get_all_open_items($db);
}

$cart_items = get_cart_items_amount($db, $user_id);
// カートの個数表示
$totalcart = total_cart_items($cart_items);
// すでにカートにいれている商品に印をつける
$cartitem_icon = cart_items_check($cart_items);


// トークンの生成を変数にいれる
$token = get_csrf_token();

// VIEWファイルの読み込み
include_once VIEW_PATH . 'itemlist_view.php';