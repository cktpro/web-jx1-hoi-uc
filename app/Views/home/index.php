<div class="center__container-item search__container-wrap">
    <form action="/tim-kiem" method="get" class="search__container">
        <div class="search__content">
            <input type="text" name="keyword" placeholder="Nhập từ khoá tìm kiếm" autofocus required>
            <button class="btn-search" type="submit"></button>
        </div>
    </form>
</div>

<!-- Slide PC -->
<div class="center__container-item slide__container swiper-container slide__pc">
    <div class="swiper-wrapper">
        <?php foreach (['slide_img1','slide_img2','slide_img3','slide_img4'] as $key): ?>
        <?php $linkKey = str_replace('img', 'link', $key); ?>
        <div class="slide__content grid swiper-slide">
            <a class="slide__img" href="<?= htmlspecialchars($slides[$linkKey] ?? '#') ?>">
                <img src="<?= htmlspecialchars($slides[$key] ?? '') ?>" data-transition="fade"
                     onerror="this.src='/assets/imgs/slide-1.png'" alt="slide">
            </a>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="swiper-pagination swiper-pagination-slide"></div>
    <div class="swiper-button-prev slide-btn-prev"></div>
    <div class="swiper-button-next slide-btn-next"></div>
</div>

<!-- Slide Mobile -->
<div class="center__container-item slide__container swiper-container slide__mobile">
    <div class="swiper-wrapper">
        <?php foreach (['slide_duoi_img','slide_duoi_img1','slide_duoi_img2','slide_duoi_img3','slide_duoi_img4'] as $key): ?>
        <?php if (empty($slidesBottom[$key])) continue; ?>
        <div class="slide__content grid swiper-slide">
            <a class="slide__img" href="#">
                <img src="<?= htmlspecialchars($slidesBottom[$key]) ?>" data-transition="fade"
                     onerror="this.src='/assets/imgs/slide-1.png'" alt="slide">
            </a>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="swiper-pagination swiper-pagination-slide"></div>
    <div class="swiper-button-prev slide-btn-prev"></div>
    <div class="swiper-button-next slide-btn-next"></div>
</div>

<!-- Mobile only: Download + User + Navbar (trước news) -->
<div class="mobile-sections mobile-top-sections">

    <!-- Download & User buttons -->
    <div class="mobile-left-top">
        <div class="left__container-item download__container">
            <div class="download__cover"></div>
            <div class="download__line-moving">
                <div class="download__line-item-1"></div>
                <div class="download__line-item-2"></div>
            </div>
            <div>
                <div class="download__btn-large">
                    <a href="<?= htmlspecialchars($config['taigame'] ?? '#') ?>" target="_blank" class="btn-download-large a-link-download">
                        <img src="/assets/imgs/btn-download.png" alt="">
                    </a>
                </div>
                <div class="download__btn-list">
                    <a href="<?= htmlspecialchars($config['taigame'] ?? '#') ?>" class="btn-32gb a-link-download"></a>
                    <a href="<?= htmlspecialchars($config['taigameios'] ?? '#') ?>" class="btn-72mb a-link-download-miniclient"></a>
                </div>
            </div>
        </div>
        <div class="left__container-item user__container">
            <div class="user__btn-list">
                <a href="<?= htmlspecialchars($config['link_dangky'] ?? '#') ?>" target="_blank" class="user__btn-signup"></a>
                <a href="/user/payment/bank" target="_blank" class="user__btn-payment"></a>
            </div>
            <div class="user__btn-alone">
                <a href="<?= htmlspecialchars($config['link_dangky'] ?? '#') ?>" target="_blank" class="user__btn-info"></a>
            </div>
        </div>
    </div>

    <!-- Bottom navbar mobile -->
    <div class="mobile-navbar">
        <div class="bottom__menu">
            <a class="bottom__menu-item-1" href="<?= htmlspecialchars($config['link_hotro'] ?? '#') ?>" target="_blank"></a>
            <a class="bottom__menu-item-2" href="/tin-tuc"></a>
            <a class="bottom__menu-item-3" href="/tinh-nang"></a>
            <a class="bottom__menu-item-4" href="/cam-nang"></a>
        </div>
    </div>

</div>

<!-- Tabs tin tức -->
<div class="center__container-item post__container">
    <div class="post__content">
        <div class="post__tabs">
            <div class="post__button post__active" data-target="#news-tab-1" data-slug="tin-tuc">
                <i class="uil uil-graduation-cap post__icon"></i>Tin tức
            </div>
            <div class="post__button" data-target="#news-tab-2" data-slug="su-kien">
                <i class="uil uil-graduation-cap post__icon"></i>Sự kiện
            </div>
            <div class="post__button" data-target="#news-tab-4" data-slug="cam-nang">
                <i class="uil uil-graduation-cap post__icon"></i>Cẩm Nang
            </div>
            <div class="post__button-more server-moi">
                <a class="more" id="btn-more" href="/tin-tuc"></a>
            </div>
        </div>
        <div class="post__sections">
            <?php
            $tabs = [
                'news-tab-1' => $news ?? [],
                'news-tab-2' => $events ?? [],
                'news-tab-4' => $guides ?? [],
            ];
            foreach ($tabs as $tabId => $posts):
            ?>
            <div class="post__content <?= $tabId === 'news-tab-1' ? 'post__active' : '' ?>" data-content id="<?= $tabId ?>">
                <div class="post__data list-news">
                    <div class="tin-tuc view">
                        <ul class="list custom-scrollbar">
                            <li>
                                <?php foreach ($posts as $post): ?>
                                <a class="post__title" href="<?= post_url($post) ?>"
                                   target="_blank" rel="nofollow" title="<?= htmlspecialchars($post['Title']) ?>">
                                    <span class="time">[<?= date('d/m', strtotime($post['DateTime'])) ?>]</span>
                                    <?= htmlspecialchars($post['Title']) ?>
                                </a>
                                <?php endforeach; ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Mobile only: Hoạt động + Tính năng (sau news) -->
<div class="mobile-sections mobile-bottom-sections">

    <!-- Hoạt động ngày -->
    <div class="mobile-timeline">
        <div class="left__container-item left__container-timeline">
            <div class="mobile-section-title">Hoạt Động Hằng Ngày</div>
            <div class="tabdaily">
                <div class="list-news-daily">
                    <div role="tabpanel" class="tab-pane-sv" id="may-chu-mobile">
                        <div class="daily">
                            <div class="daily-inner">
                                <div class="tabs">
                                    <ul>
                                        <li class="tabs-item day-name-1"><a href="#" data-day="t2">T2</a></li>
                                        <li class="tabs-item day-name-2"><a href="#" data-day="t3">T3</a></li>
                                        <li class="tabs-item day-name-3"><a href="#" data-day="t4">T4</a></li>
                                        <li class="tabs-item day-name-4"><a href="#" data-day="t5">T5</a></li>
                                        <li class="tabs-item day-name-5"><a href="#" data-day="t6">T6</a></li>
                                        <li class="tabs-item day-name-6"><a href="#" data-day="t7">T7</a></li>
                                        <li class="tabs-item day-name-7"><a href="#" data-day="cn">CN</a></li>
                                    </ul>
                                </div>
                                <div class="daily-content">
                                    <?php $allActivities = hoatdong_load(); ?>
                                    <?php foreach (['t2','t3','t4','t5','t6','t7','cn'] as $i => $dayKey): ?>
                                    <div class="day <?= $dayKey ?> list-content-daily" <?= $i === 0 ? 'style="display:block"' : '' ?>>
                                        <div class="main-content custom-scrollbar">
                                            <?php foreach ($allActivities as $act): ?>
                                            <?php if (!empty($act[$dayKey])): ?>
                                            <div class="item">
                                                <div class="name"><?= htmlspecialchars($act['ten']) ?></div>
                                                <div class="time"><?= htmlspecialchars($act['thoigian']) ?></div>
                                            </div>
                                            <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mobile-features">
        <div class="right__new-feature--content">
            <div class="mobile-section-title">Tính Năng Mới Cập Nhật</div>
            <ul class="new__features-list custom-scrollbar">
                <?php foreach ($features ?? [] as $post): ?>
                <li>
                    <a class="new__features-title" href="<?= post_url($post) ?>">
                        <?= htmlspecialchars($post['Title']) ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<!-- Bottom menu -->
<div class="center__container-item bottom__container">
    <div class="bottom__content">
        <div class="bottom__maintenance"></div>
        <div class="bottom__menu">
            <a class="bottom__menu-item-1" href="<?= htmlspecialchars($config['link_hotro'] ?? '#') ?>" target="_blank"></a>
            <a class="bottom__menu-item-2" href="/tin-tuc" target="_self"></a>
            <a class="bottom__menu-item-3" href="/tinh-nang" target="_self"></a>
            <a class="bottom__menu-item-4" href="/cam-nang" target="_self"></a>
        </div>
    </div>
</div>
