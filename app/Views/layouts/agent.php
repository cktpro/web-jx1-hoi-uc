<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đại lý | <?= htmlspecialchars($config['title'] ?? APP_NAME) ?></title>
    <link rel="shortcut icon" href="/favicon.ico">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="/assets/js/jquery-4.0.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
        body { background: #f4f6fb; font-family: 'Segoe UI', sans-serif; min-height: 100vh; color: #333; }

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
        .u-topbar .brand { font-size: 18px; font-weight: 700; color: #2255cc; text-decoration: none; margin-right: auto; }
        .u-topbar .brand span { color: #333; }
        .u-topbar .badge-agent { background: linear-gradient(135deg,#2255cc,#1a3fa0); color:#fff; border-radius:4px; padding:2px 8px; font-size:10px; font-weight:700; letter-spacing:1px; margin-left:8px; vertical-align:middle; }
        .u-topbar .badge-super { background: linear-gradient(135deg,#b8860b,#d4a843); color:#fff; border-radius:4px; padding:2px 8px; font-size:10px; font-weight:700; letter-spacing:1px; margin-left:8px; vertical-align:middle; }
        .u-topbar .top-links a { color: #555; text-decoration: none; margin-left: 20px; font-size: 13px; }
        .u-topbar .top-links a:hover { color: #2255cc; }
        .u-topbar .top-links .username { color: #2255cc; font-weight: 600; }

        .u-wrapper { display: flex; min-height: calc(100vh - 56px); }

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
            background: linear-gradient(135deg, #2255cc, #1a3fa0);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; color: #fff;
            margin: 0 auto 10px;
        }
        .u-sidebar .avatar-name { font-weight: 700; font-size: 14px; color: #222; }
        .u-sidebar .avatar-sub { font-size: 11px; color: #2255cc; margin-top: 3px; font-weight: 600; letter-spacing: .5px; }

        .u-sidebar .nav-section { padding: 8px 16px 2px; font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #aaa; font-weight: 600; }
        .u-sidebar a.nav-item {
            display: flex; align-items: center;
            padding: 9px 20px;
            color: #555; text-decoration: none; font-size: 13px;
            border-left: 3px solid transparent;
            transition: all .15s;
        }
        .u-sidebar a.nav-item i { width: 20px; margin-right: 10px; font-size: 13px; color: #aaa; }
        .u-sidebar a.nav-item:hover { color: #2255cc; background: #eef2ff; }
        .u-sidebar a.nav-item:hover i { color: #2255cc; }
        .u-sidebar a.nav-item.active { color: #2255cc; border-left-color: #2255cc; background: #eef2ff; font-weight: 600; }
        .u-sidebar a.nav-item.active i { color: #2255cc; }

        .u-content { flex: 1; padding: 28px; min-width: 0; }

        .u-card { background: #fff; border: 1px solid #e0e4ef; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 1px 4px rgba(0,0,0,.04); }
        .u-card-header { padding: 14px 20px; border-bottom: 1px solid #e0e4ef; font-weight: 600; font-size: 14px; color: #2255cc; }
        .u-card-body { padding: 20px; }

        .form-control { background: #fff; border: 1px solid #d0d5e8; color: #333; border-radius: 6px; font-size: 14px; }
        .form-control:focus { border-color: #2255cc; box-shadow: 0 0 0 2px rgba(34,85,204,.12); color: #333; }
        label { color: #555; font-size: 13px; margin-bottom: 4px; }

        .btn-primary-agent { background: linear-gradient(135deg,#2255cc,#1a3fa0); color:#fff; border:none; border-radius:6px; font-weight:600; padding:8px 24px; }
        .btn-primary-agent:hover { background: linear-gradient(135deg,#2d63e0,#2255cc); color:#fff; }

        .stat-box { background:#fff; border:1px solid #e0e4ef; border-radius:8px; padding:16px 20px; display:flex; align-items:center; gap:14px; box-shadow:0 1px 4px rgba(0,0,0,.04); }
        .stat-box .stat-icon { width:46px;height:46px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0; }
        .stat-box .stat-val { font-size:20px;font-weight:700;color:#222;line-height:1; }
        .stat-box .stat-lbl { font-size:11px;color:#999;margin-top:3px; }

        .u-alert { padding:11px 16px;border-radius:6px;font-size:13px;margin-bottom:14px; }
        .u-alert-success { background:#eafaf0;border:1px solid #b7e4c7;color:#2d7a4f; }
        .u-alert-danger  { background:#fff0f0;border:1px solid #f5c2c7;color:#c0392b; }

        @media (max-width:768px) { .u-sidebar { display:none; } .u-content { padding:16px; } }
    </style>
</head>
<body>

<div class="u-topbar">
    <?php $isSA = (int)($_SESSION['agent_role'] ?? 0) === 3; ?>
    <a href="/dai-ly" class="brand">JX1 <span>Portal</span>
        <?php if ($isSA): ?>
            <span class="badge-super">ĐẠI LÝ TỔNG</span>
        <?php else: ?>
            <span class="badge-agent">ĐẠI LÝ</span>
        <?php endif; ?>
    </a>
    <div class="top-links">
        <span class="username"><i class="fa fa-user-circle-o mr-1"></i><?= htmlspecialchars($_SESSION['agent'] ?? '') ?></span>
        <a href="/"><i class="fa fa-home mr-1"></i>Trang chủ</a>
        <a href="/dai-ly/logout"><i class="fa fa-sign-out mr-1"></i>Đăng xuất</a>
    </div>
</div>

<div class="u-wrapper">
    <aside class="u-sidebar">
        <div class="avatar-box">
            <div class="avatar-icon"><i class="fa fa-briefcase"></i></div>
            <div class="avatar-name"><?= htmlspecialchars($_SESSION['agent'] ?? '') ?></div>
            <div class="avatar-sub">
                <?php if ($isSA): ?>
                    <i class="fa fa-star mr-1"></i>ĐẠI LÝ TỔNG
                <?php else: ?>
                    <i class="fa fa-star mr-1"></i>ĐẠI LÝ
                <?php endif; ?>
            </div>
        </div>

        <div class="nav-section">Tổng quan</div>
        <a href="/dai-ly" class="nav-item <?= $_SERVER['REQUEST_URI'] === '/dai-ly' ? 'active' : '' ?>">
            <i class="fa fa-tachometer"></i> Dashboard
        </a>

        <div class="nav-section">Người dùng</div>
        <a href="/dai-ly/users" class="nav-item <?= str_contains($_SERVER['REQUEST_URI'], '/dai-ly/users') ? 'active' : '' ?>">
            <i class="fa fa-users"></i> Quản lý người dùng
        </a>
        <?php if ($isSA): ?>
        <a href="/dai-ly/agents" class="nav-item <?= str_contains($_SERVER['REQUEST_URI'], '/dai-ly/agents') ? 'active' : '' ?>">
            <i class="fa fa-sitemap"></i> Quản lý đại lý
        </a>
        <?php endif; ?>

        <div class="nav-section">Tài khoản</div>
        <a href="/dai-ly/profile" class="nav-item <?= str_contains($_SERVER['REQUEST_URI'], '/dai-ly/profile') ? 'active' : '' ?>">
            <i class="fa fa-user-o"></i> Thông tin cá nhân
        </a>
    </aside>

    <main class="u-content">
        <?php include APP_PATH . '/app/Views/' . $content_view . '.php'; ?>
    </main>
</div>

</body>
</html>
