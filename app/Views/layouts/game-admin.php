<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Game Admin Panel</title>
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="stylesheet" href="/assets/admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/admin/css/style.css">
    <script src="/assets/admin/js/jquery.min.js"></script>
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper">
        <ul class="nav sidebar-nav">
            <li class="sidebar-brand"><a href="/game-admin">Game Admin</a></li>
            <li><a href="/game-admin/users"><i class="fa fa-users"></i> Tài khoản</a></li>
            <li><a href="/game-admin/add-points"><i class="fa fa-plus-circle"></i> Cộng điểm</a></li>
            <li><a href="/game-admin/servers"><i class="fa fa-server"></i> Server</a></li>
            <li><a href="/game-admin/payment-logs"><i class="fa fa-history"></i> Log nạp</a></li>
            <li><a href="/game-admin/logout"><i class="fa fa-sign-out"></i> Đăng xuất</a></li>
        </ul>
    </nav>
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <?php include APP_PATH . '/app/Views/' . $content_view . '.php'; ?>
        </div>
    </div>
</div>
<script src="/assets/admin/js/bootstrap.min.js"></script>
</body>
</html>
