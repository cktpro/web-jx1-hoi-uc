<?php
ob_start();
session_start();

define('APP_PATH', dirname(__DIR__));

// Load .env
foreach (file(APP_PATH . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    if ($line[0] === '#' || !str_contains($line, '=')) continue;
    [$key, $val] = explode('=', $line, 2);
    $_ENV[trim($key)] = trim($val);
}

require APP_PATH . '/config/app.php';
require APP_PATH . '/config/database.php';
require APP_PATH . '/core/Router.php';
require APP_PATH . '/core/Controller.php';
require APP_PATH . '/core/Model.php';

// Autoload models & controllers
spl_autoload_register(function(string $class): void {
    $paths = [
        APP_PATH . '/app/Controllers/' . $class . '.php',
        APP_PATH . '/app/Models/' . $class . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

require APP_PATH . '/includes/helpers.php';

$router = new Router();

// ── Trang chủ & tìm kiếm ──────────────────────────────────────
$router->get('/', [HomeController::class, 'index']);
$router->get('/tim-kiem', [HomeController::class, 'search']);
$router->post('/ajax/track-download', [HomeController::class, 'trackDownload']);

// ── Bài viết ──────────────────────────────────────────────────
$router->get('/tin-tuc', [PostController::class, 'category']);
$router->get('/su-kien', [PostController::class, 'category']);
$router->get('/tinh-nang', [PostController::class, 'category']);
$router->get('/cam-nang', [PostController::class, 'category']);
$router->get('/t-{slug}', [PostController::class, 'tag']);
$router->get('/{slug}.html', [PostController::class, 'show']);

// ── Đại lý ────────────────────────────────────────────────────
$router->get('/dai-ly/login', [AgentController::class, 'loginForm']);
$router->post('/dai-ly/ajax/login', [AgentController::class, 'loginAjax']);
$router->get('/dai-ly/logout', [AgentController::class, 'logout']);
$router->get('/dai-ly', [AgentController::class, 'index']);
$router->get('/dai-ly/users', [AgentController::class, 'users']);
$router->post('/dai-ly/ajax/nap-knb', [AgentController::class, 'napKnbAjax']);
$router->post('/dai-ly/ajax/doi-mat-khau', [AgentController::class, 'changePasswordAjax']);
$router->post('/dai-ly/ajax/doi-sdt', [AgentController::class, 'changePhoneAjax']);
$router->post('/dai-ly/ajax/check-user', [AgentController::class, 'checkUserAjax']);
$router->get('/dai-ly/agents', [AgentController::class, 'agents']);
$router->post('/dai-ly/ajax/nap-knb-agent', [AgentController::class, 'napKnbAgentAjax']);
$router->get('/dai-ly/profile', [AgentController::class, 'profileForm']);
$router->post('/dai-ly/ajax/cap-nhat-thong-tin', [AgentController::class, 'profileUpdateAjax']);
$router->post('/dai-ly/ajax/doi-mat-khau-ca-nhan', [AgentController::class, 'ownPasswordAjax']);

// ── Auth người chơi ───────────────────────────────────────────
$router->get('/user/login', [AuthController::class, 'loginForm']);
$router->post('/user/ajax/login', [AuthController::class, 'loginAjax']);
$router->get('/user/register', [AuthController::class, 'registerForm']);
$router->post('/user/ajax/register', [AuthController::class, 'registerAjax']);
$router->get('/user/logout', [AuthController::class, 'logout']);

// ── Portal người chơi ─────────────────────────────────────────
$router->get('/user', [UserController::class, 'index']);
$router->get('/user/change-password', [UserController::class, 'changePasswordForm']);
$router->post('/user/ajax/change-password', [UserController::class, 'changePasswordAjax']);
$router->get('/user/exchange', [UserController::class, 'exchange']);
$router->post('/user/ajax/exchange', [UserController::class, 'exchangeAjax']);
$router->get('/user/giftcode', [UserController::class, 'giftcode']);

// ── Thanh toán ────────────────────────────────────────────────
$router->get('/user/payment/napknb', [PaymentController::class, 'napknbForm']);
$router->post('/user/ajax/payment/card', [PaymentController::class, 'cardAjax']);
$router->get('/user/payment/history', [PaymentController::class, 'history']);

// ── Admin blog ────────────────────────────────────────────────
$router->get('/admin/login', [AdminController::class, 'loginForm']);
$router->post('/admin/ajax/login', [AdminController::class, 'loginAjax']);
$router->get('/admin/logout', [AdminController::class, 'logout']);
$router->get('/admin', [AdminController::class, 'index']);
$router->get('/admin/posts', [AdminController::class, 'posts']);
$router->get('/admin/posts/add', [AdminController::class, 'addPostForm']);
$router->post('/admin/posts/add', [AdminController::class, 'addPost']);
$router->get('/admin/posts/edit/{id}', [AdminController::class, 'editPostForm']);
$router->post('/admin/posts/edit/{id}', [AdminController::class, 'editPost']);
$router->post('/admin/ajax/posts/edit/{id}', [AdminController::class, 'editPostAjax']);
$router->post('/admin/ajax/posts/featured', [AdminController::class, 'featuredToggleAjax']);
$router->get('/admin/posts/delete/{id}', [AdminController::class, 'deletePost']);
$router->get('/admin/config', [AdminController::class, 'config']);
$router->post('/admin/ajax/config/save', [AdminController::class, 'configSaveAjax']);
$router->get('/admin/seo', [AdminController::class, 'seo']);
$router->post('/admin/ajax/seo/save', [AdminController::class, 'seoSaveAjax']);
$router->get('/admin/slide', [AdminController::class, 'slide']);
$router->post('/admin/slide', [AdminController::class, 'slideSave']);
$router->get('/admin/hoatdong', [AdminController::class, 'hoatdong']);
$router->post('/admin/hoatdong/save', [AdminController::class, 'hoatdongSave']);
$router->get('/admin/hoatdong/delete/{id}', [AdminController::class, 'hoatdongDelete']);

// ── Game admin ────────────────────────────────────────────────
$router->get('/game-admin/login', [GameAdminController::class, 'loginForm']);
$router->post('/game-admin/ajax/login', [GameAdminController::class, 'loginAjax']);
$router->get('/game-admin/logout', [GameAdminController::class, 'logout']);
$router->get('/game-admin', [GameAdminController::class, 'index']);
$router->get('/game-admin/users', [GameAdminController::class, 'users']);
$router->get('/game-admin/add-points', [GameAdminController::class, 'addPoints']);
$router->post('/game-admin/add-points', [GameAdminController::class, 'addPoints']);
$router->post('/game-admin/ajax/reset-password', [GameAdminController::class, 'resetPassword']);
$router->get('/game-admin/servers', [GameAdminController::class, 'servers']);
$router->get('/game-admin/payment-logs', [GameAdminController::class, 'paymentLogs']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
