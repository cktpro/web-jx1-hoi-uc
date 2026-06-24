<div class="center__container-item search__container-wrap">
    <form action="/tim-kiem" method="get" class="search__container">
        <div class="search__content">
            <input type="text" name="keyword" value="<?= htmlspecialchars($keyword ?? '') ?>"
                   placeholder="Nhập từ khoá tìm kiếm" autofocus required>
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

<style>
.search-results-tab.post__button.post__active::before,
.search-results-tab.post__button::after { display: none !important; }
</style>
<div class="center__container-item post__container">
    <div class="post__content">
        <div class="post__tabs">
            <div class="post__button post__active search-results-tab">
                Kết quả tìm kiếm<?= !empty($keyword) ? ': "' . htmlspecialchars($keyword) . '"' : '' ?>
            </div>
        </div>
        <div class="post__sections">
            <div class="post__content post__active" data-content>
                <div class="post__data list-news">
                    <div class="tin-tuc view">
                        <?php if (empty($results)): ?>
                        <p style="padding:20px 10px;color:#aaa;text-align:center;">
                            <?= !empty($keyword) ? 'Không tìm thấy kết quả nào.' : 'Nhập từ khoá để tìm kiếm.' ?>
                        </p>
                        <?php else: ?>
                        <ul class="list custom-scrollbar" style="max-height:none;">
                            <li>
                                <?php foreach ($results as $post): ?>
                                <a class="post__title" href="<?= post_url($post) ?>"
                                   title="<?= htmlspecialchars($post['Title']) ?>">
                                    <span class="time">[<?= date('d/m/y', strtotime($post['DateTime'])) ?>]</span>
                                    <?= htmlspecialchars($post['Title']) ?>
                                </a>
                                <?php endforeach; ?>
                            </li>
                        </ul>
                        <p style="padding:8px 10px;color:#aaa;font-size:13px;">
                            Tìm thấy <?= count($results) ?> kết quả.
                        </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
