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

// 受け取った選択された並び替え順を変数にいれる
$sort = get_get('sort');

// 現在のページ番号を変数にいれる
if(get_get('page') === ''){
    $now_page = 1;
}else{
    $now_page = get_get('page');
}
// SQLのLIMIT句用(8個ずつ商品を取得する)
$limit_page_number = ($now_page - 1) * 8;

// 検索や並び替えで取得した商品一覧
$items = get_itemlist_items($db, $sort, $limit_page_number, $sql_kind, $type, $keyword);


$all_items = get_all_open_items($db);
// 全ての商品の合計
$total_items = count($all_items);
// 総ページ数を変数にいれる(端数切り上げ)
$total_pages = ceil($total_items / 8);



$cart_items = get_cart_items_amount($db, $user_id);
// カートの個数表示
$totalcart = total_cart_items($cart_items);
// すでにカートにいれている商品に印をつける
$cartitem_icon = cart_items_check($cart_items);


// トークンの生成を変数にいれる
$token = get_csrf_token();

// VIEWファイルの読み込み
include_once VIEW_PATH . 'itemlist_view.php';