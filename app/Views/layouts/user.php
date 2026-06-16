<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tài khoản | <?= htmlspecialchars($config['title'] ?? APP_NAME) ?></title>
    <link rel="shortcut icon" href="/favicon.ico">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="/assets/js/jquery-4.0.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
        body { background: #f4f6fb; font-family: 'Segoe UI', sans-serif; min-height: 100vh; color: #333; }

        /* Topbar */
        .u-topbar {
            background: #fff;
            border-bottom: 1px solid #e0e4ef;
            height: 56px;
            display: flex;
            align-items: center;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 4px rgba(0,0,0,.06);
        }
        .u-topbar .brand {
            font-size: 18px;
            font-weight: 700;
            color: #c8922a;
            text-decoration: none;
            margin-right: auto;
        }
        .u-topbar .brand span { color: #333; }
        .u-topbar .top-links a {
            color: #555;
            text-decoration: none;
            margin-left: 20px;
            font-size: 13px;
            transition: color .2s;
        }
        .u-topbar .top-links a:hover { color: #c8922a; }
        .u-topbar .top-links .username { color: #c8922a; font-weight: 600; }

        /* Layout */
        .u-wrapper { display: flex; min-height: calc(100vh - 56px); }

        /* Sidebar */
        .u-sidebar {
            width: 220px;
            background: #fff;
            border-right: 1px solid #e0e4ef;
            flex-shrink: 0;
            padding: 20px 0;
        }
        .u-sidebar .avatar-box {
            text-align: center;
            padding: 0 16px 18px;
            border-bottom: 1px solid #e0e4ef;
            margin-bottom: 10px;
        }
        .u-sidebar .avatar-icon {
            width: 58px; height: 58px;
            background: linear-gradient(135deg, #e8a820, #c8922a);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px;
            color: #fff;
            margin: 0 auto 10px;
        }
        .u-sidebar .avatar-name { font-weight: 700; font-size: 14px; color: #222; }
        .u-sidebar .avatar-coin { font-size: 12px; color: #c8922a; margin-top: 3px; }

        .u-sidebar .nav-section {
            padding: 8px 16px 2px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #aaa;
            font-weight: 600;
        }
        .u-sidebar a.nav-item {
            display: flex;
            align-items: center;
            padding: 9px 20px;
            color: #555;
            text-decoration: none;
            font-size: 13px;
            border-left: 3px solid transparent;
            transition: all .15s;
        }
        .u-sidebar a.nav-item i { width: 20px; margin-right: 10px; font-size: 13px; color: #aaa; }
        .u-sidebar a.nav-item:hover { color: #c8922a; background: #fdf6ec; }
        .u-sidebar a.nav-item:hover i { color: #c8922a; }
        .u-sidebar a.nav-item.active {
            color: #c8922a;
            border-left-color: #c8922a;
            background: #fdf6ec;
            font-weight: 600;
        }
        .u-sidebar a.nav-item.active i { color: #c8922a; }

        /* Content */
        .u-content { flex: 1; padding: 28px; min-width: 0; }

        /* Cards */
        .u-card {
            background: #fff;
            border: 1px solid #e0e4ef;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 1px 4px rgba(0,0,0,.04);
        }
        .u-card-header {
            padding: 14px 20px;
            border-bottom: 1px solid #e0e4ef;
            font-weight: 600;
            font-size: 14px;
            color: #c8922a;
        }
        .u-card-body { padding: 20px; }

        /* Form */
        .form-control {
            background: #fff;
            border: 1px solid #d0d5e8;
            color: #333;
            border-radius: 6px;
            font-size: 14px;
        }
        .form-control:focus {
            border-color: #c8922a;
            box-shadow: 0 0 0 2px rgba(200,146,42,.15);
            color: #333;
        }
        label { color: #555; font-size: 13px; margin-bottom: 4px; }

        /* Buttons */
        .btn-gold {
            background: linear-gradient(135deg, #e8a820, #c8922a);
            color: #fff;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            padding: 8px 24px;
            font-size: 14px;
        }
        .btn-gold:hover { background: linear-gradient(135deg, #f0b830, #d4a030); color: #fff; }

        /* Stat boxes */
        .stat-box {
            background: #fff;
            border: 1px solid #e0e4ef;
            border-radius: 8px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 1px 4px rgba(0,0,0,.04);
        }
        .stat-box .stat-icon {
            width: 46px; height: 46px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }
        .stat-box .stat-val { font-size: 20px; font-weight: 700; color: #222; line-height: 1; }
        .stat-box .stat-lbl { font-size: 11px; color: #999; margin-top: 3px; }

        /* Quick actions */
        .action-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 12px; }
        .action-item {
            background: #f8f9fd;
            border: 1px solid #e0e4ef;
            border-radius: 8px;
            padding: 18px 12px;
            text-align: center;
            text-decoration: none;
            color: #555;
            transition: all .2s;
        }
        .action-item:hover {
            border-color: #c8922a;
            color: #c8922a;
            background: #fdf6ec;
            transform: translateY(-2px);
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(200,146,42,.12);
        }
        .action-item i { font-size: 22px; display: block; margin-bottom: 8px; color: #c8922a; }
        .action-item span { font-size: 12px; font-weight: 600; }

        /* Alert */
        .u-alert { padding: 11px 16px; border-radius: 6px; font-size: 13px; margin-bottom: 14px; }
        .u-alert-success { background: #eafaf0; border: 1px solid #b7e4c7; color: #2d7a4f; }
        .u-alert-danger  { background: #fff0f0; border: 1px solid #f5c2c7; color: #c0392b; }

        @media (max-width: 768px) {
            .u-sidebar { display: none; }
            .u-content { padding: 16px; }
        }
    </style>
</head>
<body>

<div class="u-topbar">
    <a href="/user" class="brand">JX1 <span>Portal</span></a>
    <div class="top-links">
        <span class="username"><i class="fa fa-user-circle-o mr-1"></i><?= htmlspecialchars($_SESSION['username'] ?? '') ?></span>
        <a href="/"><i class="fa fa-home mr-1"></i>Trang chủ</a>
        <a href="/user/logout"><i class="fa fa-sign-out mr-1"></i>Đăng xuất</a>
    </div>
</div>

<div class="u-wrapper">
    <aside class="u-sidebar">
        <div class="avatar-box">
            <div class="avatar-icon"><i class="fa fa-user"></i></div>
            <div class="avatar-name"><?= htmlspecialchars($_SESSION['username'] ?? '') ?></div>
            <?php if (!empty($user['KCoin'])): ?>
            <div class="avatar-coin"><i class="fa fa-circle mr-1" style="font-size:8px;"></i><?= number_format($user['KCoin']) ?> KNB</div>
            <?php endif; ?>
        </div>

        <div class="nav-section">Tổng quan</div>
        <a href="/user" class="nav-item <?= $_SERVER['REQUEST_URI'] === '/user' ? 'active' : '' ?>">
            <i class="fa fa-tachometer"></i> Dashboard
        </a>

        <div class="nav-section">Nạp KNB</div>
        <a href="/user/payment/napknb" class="nav-item <?= str_contains($_SERVER['REQUEST_URI'], '/payment/napknb') ? 'active' : '' ?>">
            <i class="fa fa-plus-circle"></i> Nạp KNB
        </a>

        <div class="nav-section">Tiện ích</div>
        <a href="/user/giftcode" class="nav-item <?= str_contains($_SERVER['REQUEST_URI'], '/giftcode') ? 'active' : '' ?>">
            <i class="fa fa-gift"></i> Gift code
        </a>
        <a href="/user/payment/history" class="nav-item <?= str_contains($_SERVER['REQUEST_URI'], '/history') ? 'active' : '' ?>">
            <i class="fa fa-history"></i> Lịch sử nạp
        </a>
        <a href="/user/change-password" class="nav-item <?= str_contains($_SERVER['REQUEST_URI'], '/change-password') ? 'active' : '' ?>">
            <i class="fa fa-key"></i> Đổi mật khẩu
        </a>
    </aside>

    <main class="u-content">
        <?php include APP_PATH . '/app/Views/' . $content_view . '.php'; ?>
    </main>
</div>

</body>
</html>
