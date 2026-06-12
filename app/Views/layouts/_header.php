<?php
$linkDangky     = $config['link_dangky']     ?? '#';
$linkHotro      = $config['link_hotro']      ?? '#';
$linkCongdong   = $config['link_congdong']   ?? '#';
$linkTaigame    = $config['taigame']         ?? '#';
$linkTaigameios = $config['taigameios']      ?? '#';
$logo           = $config['logo_Img']        ?? '/assets/imgs/logo.png';
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
