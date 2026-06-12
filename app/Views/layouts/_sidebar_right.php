<div class="right__containner">
    <div class="right__content">
        <a class="right__tongkim-notify" title="Xử phạt tống kim" href="/tin-tuc/thong-bao-cac-van-de-tong-kim.html"></a>

        <!-- Tính năng mới cập nhật (catID=2) -->
        <div class="right__new-feature--content">
            <ul class="new__features-list custom-scrollbar">
                <?php foreach ($features ?? [] as $post): ?>
                <li>
                    <a class="new__features-title" href="/<?= htmlspecialchars($post['postSlug']) ?>.html">
                        <?= htmlspecialchars($post['postTitle']) ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Fanpage Facebook -->
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous"
            src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v11.0"></script>
        <div class="right__fanpage--content">
            <div class="social">
                <div class="fb-page"
                    data-href="<?= htmlspecialchars($config['link_hotro'] ?? '') ?>"
                    data-tabs="timeline"
                    data-width="210"
                    data-height="70"
                    data-small-header="false"
                    data-adapt-container-width="true"
                    data-hide-cover="false"
                    data-show-facepile="true">
                    <blockquote cite="<?= htmlspecialchars($config['link_hotro'] ?? '') ?>" class="fb-xfbml-parse-ignore">
                        <a href="<?= htmlspecialchars($config['link_hotro'] ?? '') ?>">Fanpage</a>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
</div>
