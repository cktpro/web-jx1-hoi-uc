<div class="detail-content">
    <div class="head">
        <h3><?= htmlspecialchars($post['postTitle']) ?></h3>
        <p class="time">
            <?= date('d/m/Y', strtotime($post['postDate'])) ?>
            <?php foreach ($categories as $cat): ?>
            &nbsp;|&nbsp;
            <a href="/<?= htmlspecialchars($cat['catSlug']) ?>"><?= htmlspecialchars($cat['catTitle']) ?></a>
            <?php endforeach; ?>
        </p>
    </div>
    <div class="body">
        <div class="content">
            <?= $post['postCont'] ?>
        </div>

        <?php if (!empty($related)): ?>
        <div class="detail__post-related">
            <div class="post__related-list">
                <?php foreach ($related as $r): ?>
                <div class="title">
                    <a class="tit" href="/<?= htmlspecialchars($r['postSlug']) ?>.html"
                       title="<?= htmlspecialchars($r['postTitle']) ?>" target="_blank" rel="nofollow">
                        <?= htmlspecialchars($r['postTitle']) ?>
                        <span class="time"><?= date('d/m', strtotime($r['postDate'])) ?></span>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
