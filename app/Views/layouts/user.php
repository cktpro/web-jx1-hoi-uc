<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Quản lý tài khoản | <?= htmlspecialchars($config['title'] ?? APP_NAME) ?></title>
    <link rel="shortcut icon" href="/favicon.ico">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/user-style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/user">
            <img src="/assets/frontend/home/assets/images/icon-game.png" width="40px">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbarMain">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="/user"><i class="fa fa-home"></i> Trang chủ</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"><i class="fa fa-credit-card"></i> Nạp xu</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/user/payment/card">Nạp thẻ cào</a>
                        <a class="dropdown-item" href="/user/payment/bank">Nạp ngân hàng</a>
                        <a class="dropdown-item" href="/user/payment/momo">Nạp Momo</a>
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link" href="/user/exchange"><i class="fa fa-exchange"></i> Nạp game</a></li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"><i class="fa fa-list"></i> Tính năng</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/user/payment/history"><i class="fa fa-history"></i> Lịch sử nạp</a>
                        <a class="dropdown-item" href="/user/change-password"><i class="fa fa-key"></i> Đổi mật khẩu</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="fa fa-user"></i> <?= htmlspecialchars($_SESSION['username'] ?? '') ?>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/user/logout"><i class="fa fa-sign-out"></i> Đăng xuất</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container" style="margin-top: 80px;">
    <?php include APP_PATH . '/app/Views/' . $content_view . '.php'; ?>
</div>

<footer class="footer-basic mt-4">
    <ul class="list-inline text-center">
        <li class="list-inline-item"><a href="/">Trang chủ</a></li>
        <li class="list-inline-item"><a href="#">Chính sách</a></li>
    </ul>
    <p class="text-center">© <?= date('Y') ?> <?= htmlspecialchars($config['title'] ?? '') ?></p>
</footer>
</body>
</html>
