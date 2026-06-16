<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">
    <meta name="keywords" content="<?= htmlspecialchars($config['keywords'] ?? '') ?>">
    <meta name="description" content="<?= htmlspecialchars(mb_substr(strip_tags($post['Context'] ?? ''), 0, 160) ?: ($config['descr'] ?? '')) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($post['Title'] ?? $config['title'] ?? '') ?>">
    <meta property="og:description" content="<?= htmlspecialchars(mb_substr(strip_tags($post['Context'] ?? ''), 0, 160) ?: ($config['descr'] ?? '')) ?>">
    <meta property="og:image" content="<?= htmlspecialchars($config['og_image'] ?? '') ?>">
    <link rel="shortcut icon" href="/assets/imgs/favicon.ico">
    <title><?= htmlspecialchars($post['Title'] ?? '') ?> - <?= htmlspecialchars($config['title'] ?? APP_NAME) ?></title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="/assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="/assets/js/swiper-bundle.min.js"></script>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/jquery.cookie.js"></script>
    <script src="/assets/js/jquery.mCustomScrollbar.js"></script>
    <script src="/assets/js/main.js"></script>
    <base href="<?= APP_URL ?>/">
</head>
<body class="wrapper-body subpage">

<?php
// Header (nav)
$linkDangky   = $config['link_dangky']   ?? '#';
$linkHotro    = $config['link_hotro']    ?? '#';
$linkCongdong = $config['link_congdong'] ?? '#';
$linkTaigame  = $config['link_taigame']  ?? '#';
$linkTaigameios = $config['link_taigameios'] ?? '#';
$logo = $config['logo_Img'] ?? '/assets/imgs/logo.png';
?>
<header>
    <div class="header">
        <nav class="nav container">
            <a href="/"><img src="<?= htmlspecialchars($logo) ?>" alt="<?= htmlspecialchars($config['title'] ?? '') ?>" class="nav__logo"></a>
            <div class="nav__menu">
                <ul class="nav__list">
                    <li class="nav__item"><a href="/">Trang chủ</a></li>
                    <li class="nav__item"><a href="/tin-tuc">Tin tức</a></li>
                    <li class="nav__item"><a href="/su-kien">Sự kiện</a></li>
                    <li class="nav__item"><a href="/tinh-nang">Tính Năng</a></li>
                    <li class="nav__item"><a href="<?= htmlspecialchars($linkHotro) ?>" target="_blank">Fanpage</a></li>
                    <li class="nav__item"><a href="<?= htmlspecialchars($linkCongdong) ?>" target="_blank">Group</a></li>
                </ul>
            </div>
            <div class="nav__menu-mobile">
                <div class="menu__mobile-content">
                    <div class="menu__mobile-item">
                        <a href="/"><img src="<?= htmlspecialchars($logo) ?>" alt="" class="nav__logo-mobile"></a>
                    </div>
                    <div class="menu__mobile-item btn-list">
                        <a href="#" class="btn btn-download btn-dropdown-dl"><span></span></a>
                        <a href="<?= htmlspecialchars($linkDangky) ?>" target="_blank" class="btn btn-account"></a>
                        <a href="<?= htmlspecialchars($linkDangky) ?>" target="_blank" class="btn btn-payments"></a>
                        <div class="menu-dropdown-list">
                            <ul>
                                <li><a href="<?= htmlspecialchars($linkTaigame) ?>">Android APK</a></li>
                                <li><a href="<?= htmlspecialchars($linkTaigameios) ?>">iPhone IOS</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="menu__mobile-item">
                        <a href="#" class="swapmenu menu__mobile-item"></a>
                        <div class="menu-mobile">
                            <ul>
                                <li><a href="/">Trang chủ</a></li>
                                <li><a href="/tin-tuc">Tin tức</a></li>
                                <li><a href="/su-kien">Sự kiện</a></li>
                                <li><a href="/tinh-nang">Tính Năng</a></li>
                                <li><a href="<?= htmlspecialchars($linkHotro) ?>" target="_blank">Fanpage</a></li>
                                <li><a href="<?= htmlspecialchars($linkCongdong) ?>" target="_blank">Group</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>

<main class="main">
    <div class="home__container container">
        <div class="detail__container">
            <div class="detail__content">
                <?php include APP_PATH . '/app/Views/' . $content_view . '.php'; ?>
            </div>
        </div>
    </div>
</main>

<?php include APP_PATH . '/app/Views/layouts/_footer.php'; ?>
</body>
</html>
