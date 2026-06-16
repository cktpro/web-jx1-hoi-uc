<div class="detail-content">
    <div class="head">
        <h3><?= htmlspecialchars($post['Title']) ?></h3>
        <p class="time">
            <?= date('d/m/Y', strtotime($post['DateTime'])) ?>
            &nbsp;|&nbsp;
            <a href="/<?= htmlspecialchars($post['Catagory']) ?>"><?= htmlspecialchars($post['Catagory']) ?></a>
        </p>
    </div>
    <div class="body">
        <div class="content">
            <?= $post['Context'] ?>
        </div>

        <?php if (!empty($related)): ?>
        <div class="detail__post-related">
            <div class="post__related-list">
                <?php foreach ($related as $r): ?>
                <div class="title">
                    <a class="tit" href="<?= post_url($r) ?>"
                       title="<?= htmlspecialchars($r['Title']) ?>" target="_blank" rel="nofollow">
                        <?= htmlspecialchars($r['Title']) ?>
                        <span class="time"><?= date('d/m', strtotime($r['DateTime'])) ?></span>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
