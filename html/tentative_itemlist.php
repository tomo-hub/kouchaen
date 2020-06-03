<?php
// 設定ファイルの読み込み
require_once '../conf/const.php';
// 関数ファイルの読み込み
require_once '../model/functions.php';
require_once '../model/item.php';


// データベース接続関数を変数にいれる
$db = get_db_connect();

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


// トークンの生成を変数にいれる
$token = get_csrf_token();

// VIEWファイルの読み込み
include_once VIEW_PATH . 'tentative_itemlist_view.php';