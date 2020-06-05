<?php
// 設定ファイルの読み込み
require_once '../conf/const.php';
// 関数ファイルの読み込み
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';

// セッションスタート
session_start();
// ログインしていたら（ユーザIDが登録されていたら）ホームへ遷移
if(is_logined() === true){
  redirect_to(HOME_URL);
}
// 受け取った$tokenを変数にいれる
$csrf_token = get_post('csrf_token');
// もし$tokenが空でfalseだった場合ログインページへ遷移
if(is_valid_csrf_token($csrf_token) === false){
  redirect_to(SIGNUP_URL);
}
// 保存したセッション変数を削除
unset($_SESSION['csrf_token']);

// $_POSTで受け取ったユーザ名を変数にいれる
$name = get_post('username');
// $_POSTで受け取ったパスワードを変数にいれる
$password = get_post('password');
// データベース接続関数を変数にいれる
$db = get_db_connect();


// ユーザ名、パスワードの文字数、半角英数字が条件外だった場合 登録ページへ遷移
try{
  $result = regist_user($db, $name, $password);
  if( $result=== false){
    set_error('ユーザー登録に失敗しました。');
    redirect_to(SIGNUP_URL);
  }
// ユーザ登録失敗エラー 登録ページへ遷移s
}catch(PDOException $e){
  set_error('ユーザー登録に失敗しました。');
  redirect_to(SIGNUP_URL);
}

// ユーザ登録完了 ホームへ遷移
set_message('ユーザー登録が完了しました。');
login_as($db, $name, $password);
redirect_to(LOGIN_URL);