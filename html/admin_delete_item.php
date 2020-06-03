<?php
// 設定ファイルの読み込み
require_once '../conf/const.php';
// 関数ファイルの読み込み
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

// セッションスタート
session_start();
// ログインしていなかったら（ユーザIDが登録されていなかったら）トップページへ遷移
if(is_logined() === false){
    redirect_to(TOP_URL);
}
// データベース接続関数を変数にいれる
$db = get_db_connect();
$user = get_login_user($db);

// ユーザが管理者でなかった場合、ログインページへ遷移
if($user['username'] !== 'admin'){
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


// $_POSTで受け取った商品IDを変数にいれる
$item_id = get_post('item_id');

// 商品削除
if(destroy_item($db, $item_id) === true){
  set_message('商品を削除しました。');
// それ以外エラー
} else {
  set_error('商品削除に失敗しました。');
}


// 商品管理ページへ遷移
redirect_to(ADMIN_URL);