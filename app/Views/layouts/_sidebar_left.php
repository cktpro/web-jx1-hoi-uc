<div class="left__container">
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
            <a href="<?= htmlspecialchars($config['link_napthe'] ?? '/user/payment/bank') ?>" target="_blank" class="user__btn-payment"></a>
        </div>
        <div class="user__btn-alone">
            <a href="<?= htmlspecialchars($config['link_dangky'] ?? '#') ?>" target="_blank" class="user__btn-info"></a>
        </div>
    </div>

    <div class="left__container-item left__container-timeline">
        <div class="tabdaily">
            <div class="list-news-daily">
                <div role="tabpanel" class="tab-pane-sv" id="may-chu-s1234">
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
                                <?php
                                $allActivities = hoatdong_load();
                                foreach (['t2','t3','t4','t5','t6','t7','cn'] as $i => $dayKey):
                                ?>
                                <div class="day <?= $dayKey ?> list-content-daily" <?= $i === 0 ? 'style="display:block"' : '' ?>>
                                    <div class="main-content custom-scrollbar">
                                        <?php foreach ($allActivities as $act): ?>
                                        <?php if ($act[$dayKey]): ?>
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
<script>
(function() {
    function trackDownload() {
        var url = '/ajax/track-download';
        if (navigator.sendBeacon) {
            navigator.sendBeacon(url, new FormData());
        } else if (window.$) {
            $.post(url);
        }
    }
    document.querySelectorAll('.a-link-download, .a-link-download-miniclient').forEach(function(el) {
        el.addEventListener('click', trackDownload);
    });
})();
</script>
