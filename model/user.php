<?php
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

// user_idが同じものをDBから取得
function get_user($db, $user_id){
  $sql = "
    SELECT
      user_id, 
      username,
      password 
    FROM
      ec_user
    WHERE
      user_id = :user_id
    LIMIT 1
  ";
  $params = array(':user_id' => $user_id);
  return fetch_query($db, $sql, $params);
}

// 全てのユーザを取得
function get_all_users($db){
  $sql = "
    SELECT 
      username, 
      createdate 
    FROM 
      ec_user 
  ";
  return fetch_all_query($db, $sql);
}

// user_nameが同じものをDBから取得
function get_user_by_name($db, $name){
  $sql = "
    SELECT
      user_id, 
      username,
      password 
    FROM
      ec_user
    WHERE
    username = :name
    LIMIT 1
  ";
  $params = array(':name' => $name);
  return fetch_query($db, $sql, $params);
}

function get_login_user($db){
  $login_user_id = get_session('user_id');

  return get_user($db, $login_user_id);
}

function login_as($db, $name, $password){
  $user = get_user_by_name($db, $name);
  if($user === false || password_verify($password, $user['password']) === false){
    return false;
  }
  set_session('user_id', $user['user_id']);
  return $user;
}

function is_admin($user){
    return $user['type'] === USER_TYPE_ADMIN;
}

// ユーザ登録
function regist_user($db, $name, $password) {
    if( is_valid_user($db, $name) === false || is_valid_password($password) === false){
      return false;
    }
    $hash = password_hash($password, PASSWORD_DEFAULT);
    return insert_user($db, $name, $hash);
}

function insert_user($db, $name, $password){
    $datetime = NOW_DATE;
    $sql = "
      INSERT INTO 
      ec_user (username, password, createdate) 
       VALUES (:name, :password, :datetime);
    ";
    $params = array(':name' => $name , ':password' => $password , ':datetime' => $datetime);
    return execute_query($db, $sql, $params);
}

function is_valid_user($db, $name){
    $is_valid = true;
    if(get_user_by_name($db, $name) !== false){
        set_error('すでに同じユーザー名が登録されています。');
        $is_valid = false;
    }
    if(is_valid_length($name, USER_NAME_LENGTH_MIN, USER_NAME_LENGTH_MAX) === false){
        set_error('ユーザー名は'. USER_NAME_LENGTH_MIN . '文字以上、' . USER_NAME_LENGTH_MAX . '文字以内で入力してください。');
        $is_valid = false;
    }
    if(is_alphanumeric($name) === false){
        set_error('ユーザー名は半角英数字で入力してください。');
        $is_valid = false;
    }
    return $is_valid;
}

function is_valid_password($password){
    $is_valid = true;
    if(is_valid_length($password, USER_PASSWORD_LENGTH_MIN, USER_PASSWORD_LENGTH_MAX) === false){
        set_error('パスワードは'. USER_PASSWORD_LENGTH_MIN . '文字以上、' . USER_PASSWORD_LENGTH_MAX . '文字以内で入力してください。');
        $is_valid = false;
    }
    if(is_alphanumeric($password) === false){
        set_error('パスワードは半角英数字で入力してください。');
        $is_valid = false;
    }
    return $is_valid;
}

function is_valid_length($string, $minimum_length, $maximum_length){
    $length = mb_strlen($string);
    return ($minimum_length <= $length) && ($length <= $maximum_length);
}
  
function is_alphanumeric($string){
    return is_valid_format($string, REGEXP_ALPHANUMERIC);
}
  
function is_valid_format($string, $format){
    if(preg_match($format, $string) !== 1){
        return false;
    }
    return true;
}