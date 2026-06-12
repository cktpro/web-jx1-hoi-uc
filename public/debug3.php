<?php
define('APP_PATH', dirname(__DIR__));
require APP_PATH . '/config/app.php';
ini_set('session.save_path', '/tmp');
session_start();
echo "SESSION: "; var_dump($_SESSION);
echo "blog_admin empty? "; var_dump(empty($_SESSION['blog_admin']));
