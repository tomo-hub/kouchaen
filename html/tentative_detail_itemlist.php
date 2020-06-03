<?php
// 設定ファイルの読み込み
require_once '../conf/const.php';
// 関数ファイルの読み込み
require_once '../model/functions.php';
require_once '../model/item.php';


// データベース接続関数を変数にいれる
$db = get_db_connect();

// 検索したときに送られてきた情報を変数にいれる
$item_id = get_post('item_id');
// 商品一覧で選んだ商品の詳細情報を取得
$choice_item = get_choice_item($db, $item_id);



// VIEWファイルの読み込み
include_once VIEW_PATH . 'tentative_detail_itemlist_view.php';