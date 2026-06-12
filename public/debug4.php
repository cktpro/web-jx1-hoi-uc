<?php
ob_start();
ini_set('session.save_path', '/tmp');
session_start();
define('APP_PATH', dirname(__DIR__));
require APP_PATH . '/config/app.php';
require APP_PATH . '/config/database.php';
require APP_PATH . '/core/Router.php';
require APP_PATH . '/core/Controller.php';
require APP_PATH . '/core/Model.php';
spl_autoload_register(function(string $class): void {
    $paths = [APP_PATH.'/app/Controllers/'.$class.'.php', APP_PATH.'/app/Models/'.$class.'.php'];
    foreach ($paths as $path) { if (file_exists($path)) { require_once $path; return; } }
});
require APP_PATH . '/includes/helpers.php';
echo "SESSION blog_admin: " . ($_SESSION['blog_admin'] ?? 'NOT SET');
echo "\nEmpty check: "; var_dump(empty($_SESSION['blog_admin']));
