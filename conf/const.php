<?php
 
// データベースの接続情報
define('DB_HOST', 'mysql');       // MySQLのホスト名
define('DB_USER', 'wada');        // MySQLのユーザ名
define('DB_PASS', 'password');    // MySQLのパスワード
define('DB_NAME', 'kouchaen');    // MySQLのDB名
define('DB_CHARSET', 'utf8');     // MySQLのcharset
 
define('HTML_CHARACTER_SET', 'UTF-8');  // HTML文字エンコーディング


// ドキュメントルート
define('MODEL_PATH', $_SERVER['DOCUMENT_ROOT'] . '/../model/');
define('VIEW_PATH', $_SERVER['DOCUMENT_ROOT'] . '/../view/');

define('IMAGE_PATH', './img/');
define('STYLESHEET_PATH', './css/');
// define('IMAGE_DIR', $_SERVER['DOCUMENT_ROOT'] . './img/' );

// controllerのページ
define('TOP_URL', '/index.php');
define('TENTATIVE_HOME_URL', '/tentative_itemlist.php');
define('SIGNUP_URL', '/signup.php');
define('LOGIN_URL', '/login.php');
define('LOGOUT_URL', '/logout.php');
define('HOME_URL', '/itemlist.php');
define('DETAIL_ITEM_URL', '/detail_item.php');
define('CART_URL', '/cart.php');
define('FINISH_URL', '/finish.php');
define('ADMIN_URL', '/admin.php');

// 現在の日時
define('NOW_DATE', date('Y-m-d H:i:s'));
// 更新日時
define('UPDATE_DATE', date('Y-m-d H:i:s'));

// 正規表現
define('REGEXP_ALPHANUMERIC', '/\A[0-9a-zA-Z]+\z/'); // 半角英数字のみの正規表現
define('REGEXP_POSITIVE_INTEGER', '/\A([1-9][0-9]*|0)\z/'); // 半角数字のみの正規表現

// ユーザ名文字数制限
define('USER_NAME_LENGTH_MIN', 6);
define('USER_NAME_LENGTH_MAX', 100);
// パスワード文字数制限
define('USER_PASSWORD_LENGTH_MIN', 6);
define('USER_PASSWORD_LENGTH_MAX', 100);

// ユーザの種類
define('USER_TYPE_ADMIN', 1);
define('USER_TYPE_NORMAL', 2);

// 商品名文字数制限
define('ITEM_NAME_LENGTH_MIN', 1);
define('ITEM_NAME_LENGTH_MAX', 100);

// ステータス
define('ITEM_STATUS_OPEN', 1);
define('ITEM_STATUS_CLOSE', 0);

/* 
define('PERMITTED_ITEM_STATUSES', array(
  'open' => 1,
  'close' => 0,
));

define('PERMITTED_IMAGE_TYPES', array(
  IMAGETYPE_JPEG => 'jpg',
  IMAGETYPE_PNG => 'png',
));
*/
