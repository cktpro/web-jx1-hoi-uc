<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Panel – JX1 Game</title>
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="stylesheet" href="/assets/admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/admin/font-awesome/css/font-awesome.min.css">
    <style>
        body { background-color: #f8f9fa; font-size: 14px; }

        /* Sidebar */
        #sidebar {
            width: 230px;
            min-height: 100vh;
            background: #343a40;
            flex-shrink: 0;
        }
        #sidebar .sidebar-brand {
            display: block;
            padding: 1rem 1.25rem;
            font-size: 1.1rem;
            font-weight: 700;
            color: #fff;
            background: #23272b;
            text-decoration: none;
            letter-spacing: .5px;
        }
        #sidebar .sidebar-brand span { color: #28a745; }
        #sidebar .nav-link {
            color: #adb5bd;
            padding: .65rem 1.25rem;
            border-left: 3px solid transparent;
            font-size: 13px;
        }
        #sidebar .nav-link:hover {
            color: #fff;
            background: #2c3136;
        }
        #sidebar .nav-link.active {
            color: #fff;
            background: #2c3136;
            border-left-color: #28a745;
        }
        #sidebar .nav-link i { width: 18px; margin-right: 8px; }
        #sidebar .sidebar-divider {
            border-top: 1px solid #4b545c;
            margin: .5rem 0;
        }
        #sidebar .sidebar-heading {
            padding: .5rem 1.25rem;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: #6c757d;
        }

        /* Top navbar */
        #topbar {
            height: 54px;
            background: #fff;
            border-bottom: 1px solid #dee2e6;
            padding: 0 1.25rem;
        }
        #topbar .navbar-brand { font-weight: 600; font-size: 14px; color: #495057; }
        #topbar .nav-item .nav-link { color: #495057; font-size: 13px; }
        #topbar .nav-item .nav-link:hover { color: #212529; }

        /* Cards / ibox */
        .card { border: none; box-shadow: 0 1px 4px rgba(0,0,0,.08); margin-bottom: 1.5rem; }
        .card-header {
            background: #fff;
            border-bottom: 1px solid #e9ecef;
            font-weight: 600;
            font-size: 13px;
            color: #495057;
            padding: .75rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card-header i { margin-right: 6px; }

        /* Stat cards */
        .stat-card .card-body { padding: 1.25rem; }
        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            color: #fff;
        }
        .stat-value { font-size: 1.75rem; font-weight: 700; line-height: 1; color: #212529; }
        .stat-label { font-size: 12px; color: #6c757d; margin-top: 2px; }

        /* Tables */
        .table thead th {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #6c757d;
            font-weight: 600;
            border-top: none;
            border-bottom-width: 1px;
            background: #f8f9fa;
        }
        .table td { font-size: 13px; vertical-align: middle; }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <nav id="sidebar">
        <a href="/admin" class="sidebar-brand">JX1 <span>Admin</span></a>

        <div class="sidebar-heading mt-2">Dashboard</div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= ($_SERVER['REQUEST_URI'] === '/admin') ? 'active' : '' ?>"
                   href="/admin">
                    <i class="fa fa-tachometer"></i> Tổng quan
                </a>
            </li>
        </ul>

        <div class="sidebar-divider"></div>
        <div class="sidebar-heading">Nội dung</div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/posts') ? 'active' : '' ?>"
                   href="/admin/posts">
                    <i class="fa fa-newspaper-o"></i> Bài viết
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($_SERVER['REQUEST_URI'] === '/admin/posts/add') ? 'active' : '' ?>"
                   href="/admin/posts/add">
                    <i class="fa fa-plus-circle"></i> Thêm bài viết
                </a>
            </li>
        </ul>

        <div class="sidebar-divider"></div>
        <div class="sidebar-heading">Cấu hình</div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/slide') ? 'active' : '' ?>"
                   href="/admin/slide">
                    <i class="fa fa-picture-o"></i> Quản lý Slide
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/hoatdong') ? 'active' : '' ?>"
                   href="/admin/hoatdong">
                    <i class="fa fa-calendar-check-o"></i> Hoạt động ngày
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/seo') ? 'active' : '' ?>"
                   href="/admin/seo">
                    <i class="fa fa-search"></i> Cài đặt SEO
                </a>
            </li>
        </ul>

        <div class="sidebar-divider"></div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="/admin/logout">
                    <i class="fa fa-sign-out"></i> Đăng xuất
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main -->
    <div class="d-flex flex-column flex-grow-1" style="min-width:0;">
        <!-- Top navbar -->
        <nav class="navbar d-flex align-items-center" id="topbar">
            <span class="navbar-brand mb-0">
                <i class="fa fa-circle text-success" style="font-size:8px;vertical-align:2px;margin-right:4px;"></i>
                Admin Panel
            </span>
            <ul class="navbar-nav ml-auto flex-row">
                <li class="nav-item mr-3">
                    <span class="nav-link">
                        <i class="fa fa-user-circle-o mr-1"></i>
                        <?= htmlspecialchars($_SESSION['blog_admin'] ?? '') ?>
                    </span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/logout">
                        <i class="fa fa-power-off mr-1 text-danger"></i> Đăng xuất
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page content -->
        <div class="p-4">
            <?php include APP_PATH . '/app/Views/' . $content_view . '.php'; ?>
        </div>
    </div>
</div>

<script src="/assets/admin/js/jquery-2.1.1.js"></script>
<script src="/assets/admin/js/bootstrap.min.js"></script>
</body>
</html>
