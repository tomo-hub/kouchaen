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


// トークンの生成を変数にいれる
$token = get_csrf_token();

// VIEWファイルの読み込み
include_once VIEW_PATH . 'tentative_itemlist_view.php';