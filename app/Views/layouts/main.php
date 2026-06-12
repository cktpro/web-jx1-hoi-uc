<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">
    <meta name="keywords" content="<?= htmlspecialchars($config['keywords'] ?? '') ?>">
    <meta name="description" content="<?= htmlspecialchars($config['descr'] ?? '') ?>">
    <meta property="og:title" content="<?= htmlspecialchars($config['title'] ?? APP_NAME) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($config['descr'] ?? '') ?>">
    <meta property="og:image" content="<?= htmlspecialchars($config['og_image'] ?? '') ?>">
    <link rel="shortcut icon" href="/assets/imgs/favicon.ico">
    <title><?= htmlspecialchars($config['title'] ?? APP_NAME) ?></title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="/assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        /* Slide navigation buttons */
        .slide-btn-prev, .slide-btn-next {
            color: #d4a843 !important;
            width: 36px !important;
            height: 36px !important;
            background: rgba(0,0,0,.45);
            border-radius: 50%;
            top: 45% !important;
        }
        .slide-btn-prev::after, .slide-btn-next::after {
            font-size: 14px !important;
            font-weight: 900;
        }
        .slide-btn-prev { left: 8px !important; }
        .slide-btn-next { right: 8px !important; }
        /* Dots pagination */
        .swiper-pagination-bullet {
            width: 8px !important;
            height: 8px !important;
            background: rgba(255,255,255,.6) !important;
            opacity: 1 !important;
        }
        .swiper-pagination-bullet-active {
            background: #d4a843 !important;
            width: 20px !important;
            border-radius: 4px !important;
        }
        /* Fix slide image responsive */
        .slide__pc .slide__img,
        .slide__mobile .slide__img {
            width: 100% !important;
            overflow: hidden;
        }
        .slide__pc .slide__img img,
        .slide__mobile .slide__img img {
            width: 100% !important;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .slide__pc,
        .slide__mobile {
            overflow: hidden !important;
        }
        /* Fix pagination dots center on mobile */
        @media screen and (max-width: 992px) {
            .swiper-container-horizontal > .swiper-pagination-bullets {
                left: 0 !important;
                width: 100% !important;
                text-align: center !important;
            }
        }

        /* Fix các phần tử width cứng 758px gây tràn màn hình mobile */
        @media screen and (max-width: 992px) {
            .post__container {
                width: 100% !important;
                background-image: url('/assets/imgs/bg-post-tablet.png') !important;
                background-size: 100% 100% !important;
            }
        }

        /* Mobile sections: ẩn trên desktop, hiện trên mobile */
        .mobile-sections { display: none; }
        @media screen and (max-width: 992px) {
            .mobile-sections { display: block; }

            /* Top section: download + user + navbar */
            .mobile-top-sections {
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .mobile-left-top {
                display: flex;
                justify-content: center;
                gap: 10px;
                margin: 10px auto;
            }
            .mobile-navbar {
                display: flex;
                justify-content: center;
                margin: 6px auto;
            }
            .mobile-navbar {
                display: block !important;
                width: 100% !important;
            }
            .mobile-navbar .bottom__menu {
                display: grid !important;
                grid-template-columns: repeat(4, 1fr) !important;
                width: 100% !important;
            }
            .mobile-navbar .bottom__menu a,
            .mobile-navbar .bottom__menu-item-1,
            .mobile-navbar .bottom__menu-item-2,
            .mobile-navbar .bottom__menu-item-3,
            .mobile-navbar .bottom__menu-item-4 {
                display: block !important;
                width: 100% !important;
                height: calc(25vw * 65 / 122) !important;
                background-size: 100% 200% !important;
                background-position: top center !important;
                margin-left: 0 !important;
            }

            /* Bottom section: tính năng trên, hoạt động dưới */
            .mobile-bottom-sections {
                display: flex !important;
                flex-direction: column !important;
                align-items: center;
                padding: 4px 0;
                width: 100%;
            }
            .mobile-bottom-sections .mobile-features { order: 1; width: 100%; }
            .mobile-bottom-sections .mobile-timeline { order: 2; width: 100%; }

            /* Bottom: 2 ảnh thông báo full width, xếp dọc */
            .center__container-item.bottom__container {
                width: 100% !important;
                overflow: hidden !important;
            }
            .bottom__content {
                display: flex !important;
                flex-direction: row !important;
                width: 100% !important;
                max-width: 100% !important;
                overflow: hidden !important;
            }
            .bottom__content .bottom__tongkim-notify {
                display: block !important;
                width: 50% !important;
                height: calc(50vw * 134 / 239) !important;
                background-size: 100% 200% !important;
                background-position: top center !important;
                margin-right: 0 !important;
            }
            .bottom__content .bottom__tongkim-notify:hover {
                background-size: 100% 200% !important;
                background-position: bottom center !important;
            }
            .bottom__content .bottom__maintenance {
                width: 50% !important;
                height: calc(50vw * 134 / 239) !important;
                background-size: 100% 100% !important;
                margin-right: 0 !important;
            }
            .mobile-bottom-sections .right__new-feature--content {
                width: 100% !important;
                height: calc(100vw * 340 / 479) !important;
                background: url('/assets/imgs/bg-post.png') top center no-repeat !important;
                background-size: 100% auto !important;
                margin-bottom: 6px !important;
                padding: 6px 0 !important;
                overflow: hidden !important;
            }
            .mobile-bottom-sections .new__features-list {
                width: 100% !important;
                height: calc(100vw * 340 / 479 - 60px) !important;
                padding-top: 4px !important;
                padding-left: 8px !important;
            }
            .mobile-bottom-sections .new__features-list li {
                width: 100% !important;
            }
            .mobile-bottom-sections .left__container-timeline {
                width: 100% !important;
                height: calc(100vw * 340 / 479 + 200px) !important;
                background: url('/assets/imgs/bg-post.png') top center no-repeat !important;
                background-size: 100% 100% !important;
                margin-left: 0 !important;
                margin-bottom: 6px !important;
                padding: 6px 0 !important;
                overflow: hidden !important;
            }
            .mobile-bottom-sections .daily .daily-content .main-content {
                max-height: calc(100vw * 340 / 479 + 100px) !important;
                overflow-y: auto !important;
            }
            .mobile-section-title {
                display: block !important;
                width: 100% !important;
                text-align: center !important;
                color: #f5c518 !important;
                font-weight: 700 !important;
                font-size: 15px !important;
                padding: 8px 0 4px !important;
                text-transform: uppercase !important;
                letter-spacing: 0.5px !important;
                position: relative !important;
                z-index: 1 !important;
            }
            .mobile-bottom-sections .tabdaily {
                margin-top: 0 !important;
            }
            .mobile-bottom-sections .daily .daily-content .main-content {
                max-height: 240px !important;
            }
        }
    </style>
    <script src="/assets/js/swiper-bundle.min.js"></script>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/jquery.cookie.js"></script>
    <script src="/assets/js/jquery.mCustomScrollbar.js"></script>
    <script src="/assets/js/main.js"></script>
    <base href="<?= APP_URL ?>/">
</head>
<body>
<?php include APP_PATH . '/app/Views/layouts/_header.php'; ?>

<main class="main">
    <div class="home__container container">
        <?php include APP_PATH . '/app/Views/layouts/_sidebar_left.php'; ?>
        <div class="center__container">
            <?php include APP_PATH . '/app/Views/' . $content_view . '.php'; ?>
        </div>
        <?php include APP_PATH . '/app/Views/layouts/_sidebar_right.php'; ?>
    </div>
</main>

<?php include APP_PATH . '/app/Views/layouts/_footer.php'; ?>
</body>
</html>
