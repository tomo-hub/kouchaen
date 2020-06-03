<?php
// var_dump
function dd($var){
    var_dump($var);
    exit();
  }

// 指定したURLにとぶ
function redirect_to($url){
  header('Location: ' . $url);
  exit;
}

// セッションに変数をセットされているか
function get_session($name){
  if(isset($_SESSION[$name]) === true){
    return $_SESSION[$name];
  };
  return '';
}

// GETの取得の確認
function get_get($name){
    if(isset($_GET[$name]) === true){
      return $_GET[$name];
    };
    return '';
}
  
// POSTの取得の確認
function get_post($name){
    if(isset($_POST[$name]) === true){
        return $_POST[$name];
    };
    return '';
}  

function get_file($name){
    if(isset($_FILES[$name]) === true){
      return $_FILES[$name];
    };
    return array();
}

function is_logined(){
  return get_session('user_id') !== '';
}


function set_session($name, $value){
  $_SESSION[$name] = $value;
}

// エラー
function set_error($error){
  $_SESSION['__errors'][] = $error;
}

function get_errors(){
  $errors = get_session('__errors');
  if($errors === ''){
    return array();
  }
  set_session('__errors',  array());
  return $errors;
}

function set_message($message){
    $_SESSION['__messages'][] = $message;
}
  
function get_messages(){
    $messages = get_session('__messages');
    if($messages === ''){
      return array();
    }
    set_session('__messages',  array());
    return $messages;
}

function upload_image($image){
// HTTP POST でファイルがアップロードされたかどうかチェック
    if (is_uploaded_file($image['tmp_name']) === TRUE) {
    // 画像の拡張子を取得
        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        // 指定の拡張子であるかどうかチェック
        if ($extension === 'jpg' || $extension === 'jpeg' || $extension === 'png') {
            $new_img_filename = '';
            // 保存する新しいファイル名の生成（ユニークな値を設定する）
            $new_img_filename = sha1(uniqid(mt_rand(), true)). '.' . $extension;
            // 同名ファイルが存在するかどうかチェック
            if (is_file(IMAGE_PATH . $new_img_filename) !== TRUE) {
                // アップロードされたファイルを指定ディレクトリに移動して保存
                if (move_uploaded_file($image['tmp_name'], IMAGE_PATH . $new_img_filename) !== TRUE) {
                    set_error('ファイルアップロードに失敗しました');
                }
            } else {
                set_error('ファイルアップロードに失敗しました。再度お試しください。');
            }
        } else {
            set_error('ファイル形式が異なります。画像ファイルはJPEGとPNGのみ利用可能です。');
        }
    } else {
        set_error('ファイルを選択してください');
    }
    return $new_img_filename;
}

// エスケープ処理
function h($h){
  return htmlspecialchars($h, ENT_QUOTES, 'UTF-8');
}

// ランダムな文字列を生成
function get_random_string($length = 20){
  return substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, $length);
}

// トークンの生成
function get_csrf_token(){
  // get_random_string()はユーザー定義関数。
  $token = get_random_string(30);
  // set_session()はユーザー定義関数。
  set_session('csrf_token', $token);
  return $token;
}

// トークンのチェック
function is_valid_csrf_token($token){
  if($token === '') {
    return false;
  }
  // get_session()はユーザー定義関数
  return $token === get_session('csrf_token');
}