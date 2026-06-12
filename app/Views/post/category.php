<div class="detail-content">
    <div class="head">
        <h3><?= htmlspecialchars($category['catTitle']) ?></h3>
        <p class="breadcrums">
            <a href="/">Trang chủ</a> / <span><?= htmlspecialchars($category['catTitle']) ?></span>
        </p>
    </div>
    <div class="body">
        <div class="nav">
            <ul>
                <?php foreach ($allCats as $cat): ?>
                <li>
                    <a href="/<?= htmlspecialchars($cat['catSlug']) ?>"
                       class="<?= $cat['catID'] == $category['catID'] ? 'active' : '' ?>">
                        <?= htmlspecialchars($cat['catTitle']) ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="items">
            <?php if (empty($posts)): ?>
            <p style="padding:20px;color:#aaa;">Chưa có bài viết nào.</p>
            <?php else: ?>
            <?php foreach ($posts as $post): ?>
            <div class="item">
                <div class="cover">
                    <a href="/<?= htmlspecialchars($post['postSlug']) ?>.html">
                        <img src="<?= htmlspecialchars($post['postImage'] ?? '') ?>"
                             alt="<?= htmlspecialchars($post['postTitle']) ?>"
                             onerror="this.src='/assets/imgs/no-image-cate.png'">
                    </a>
                </div>
                <div class="detail">
                    <h3>
                        <a href="/<?= htmlspecialchars($post['postSlug']) ?>.html">
                            <span class="time">[<?= date('d/m/y', strtotime($post['postDate'])) ?>]</span>
                            <?= htmlspecialchars($post['postTitle']) ?>
                        </a>
                    </h3>
                    <p><?= mb_substr(strip_tags(html_entity_decode($post['postCont'], ENT_QUOTES | ENT_HTML5, 'UTF-8')), 0, 200) ?>...</p>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php if ($total > $limit): ?>
        <div class="paging">
            <div class="paging-inner">
                <ul>
                    <?php
                    $totalPages = ceil($total / $limit);
                    $slug = $category['catSlug'];
                    if ($page > 1): ?>
                    <li><a href="/<?= $slug ?>?p=<?= $page - 1 ?>">&laquo;</a></li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="<?= $i == $page ? 'active' : '' ?>">
                        <a href="/<?= $slug ?>?p=<?= $i ?>"><?= $i ?></a>
                    </li>
                    <?php endfor; ?>
                    <?php if ($page < $totalPages): ?>
                    <li><a href="/<?= $slug ?>?p=<?= $page + 1 ?>">&raquo;</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
