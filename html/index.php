<?php
// 設定ファイルの読み込み
require_once '../conf/const.php';
// 関数ファイルの読み込み
require_once '../model/functions.php';

// セッションスタート
session_start();
// ログインしていたらホームへ遷移
if(is_logined() === true){
  redirect_to(HOME_URL);
}

// VIEWファイルの読み込み
include_once '../view/index_view.php';