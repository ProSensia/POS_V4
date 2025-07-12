<?php

    if($_SERVER['SERVER_NAME']=='localhost')
  {
    /** development config **/
    define('DB_NAME', 'pos_demo_db');
    define('HOST_NAME', 'localhost');
    define('HOST_USER', 'root');
    define('HOST_PASS', '');
    define('DB_DRIVER', 'mysql');
     define('DB_CHARSET', 'utf8mb4');
    define('DB_PORT', '3306');
    define('APP_ROOT', 'http://localhost/pos');
  }else{
    /** production config **/
    define('DB_NAME', 'prosdfwo_pos_db');
    define('HOST_NAME', 'premium281.web-hosting.com');
    define('HOST_USER', 'prosdfwo_pos_db');
    define('HOST_PASS', 'POS_db2025');
    define('DB_DRIVER', 'mysql');
    define('DB_CHARSET', 'utf8mb4');
    define('DB_PORT', '3306');
    define('APP_ROOT', 'https://www.mominkhan.prosensia.pk');
  }

  const DEBUG_MODE = true;
  define('APP_VERSION', 'v4');
  define('APP_COPYRIGHT', '&copy; '.date("Y"));
  define('APP_AUTHOR', 'hceTPREtalF');
  define('APP_AUTHOR_EMAIL', 'info@prosensia.pk');
  define('APP_AUTHOR_PHONE', '+92 3107717890');
  define('APP_AUTHOR_ADDRESS', 'Building C2, PAF-IAST, Mang, Haripur');
  define('APP_LANG_VERSION', 'PHP_8.1');
  define('APP_NAME', ['POS (Point Of Sales)','POS SYSTEM']);
  define('APP_CURRENCY', '₨');
  define('APP_THEME_COLOUR', 'tradewind');
  //cyan,tradewind,monalisa,blue,orange,green,blush,red
   const ENCRYPTION_METHOD = "AES-256-CBC";//
    const FET_SECRET_ENCRYPTION_KEY = "syKVTwlSZlAGEGEEvhe/NG+HICHxQhM0hpi2/ggsCqXnzwpk9c1DXa9Rind7vTou";
    const FET_SECRET_ENCRYPTION_KEY_IV = "8221db19adbd9f916ceb9638c7f906e5";