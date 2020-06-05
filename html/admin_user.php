<?php
// 設定ファイルの読み込み
require_once '../conf/const.php';
// 関数ファイルの読み込み
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';

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

// 全ての商品情報を変数にいれる
$users = get_all_users($db);


// VIEWファイルの読み込み
include_once VIEW_PATH . '/admin_user_view.php';
