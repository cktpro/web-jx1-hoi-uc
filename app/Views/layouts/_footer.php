<div class="content-right">
    <div class="inner">
        <a href="<?= htmlspecialchars($config['taigame'] ?? '#') ?>" class="download"></a>
        <a href="<?= htmlspecialchars($config['link_hotro'] ?? '#') ?>" class="trade"></a>
        <a href="<?= htmlspecialchars($config['link_hotro'] ?? '#') ?>" class="fanpage" target="_blank"></a>
        <a href="<?= htmlspecialchars($config['link_congdong'] ?? '#') ?>" class="group" target="_blank"></a>
        <a href="#" class="totop" id="totop"></a>
    </div>
</div>

<footer>
    <div class="footer-content">
        <div class="footer-inner">

            <!-- Cột 1: Thương hiệu -->
            <div class="footer-col footer-brand">
                <div class="footer-logo"><?= htmlspecialchars($config['title'] ?? 'JX1') ?></div>
                <p class="footer-desc"><?= htmlspecialchars($config['descr'] ?? 'Game nhập vai kiếm hiệp hàng đầu Việt Nam') ?></p>
                <div class="footer-social">
                    <?php if (!empty($config['link_hotro'])): ?>
                    <a href="<?= htmlspecialchars($config['link_hotro']) ?>" target="_blank" class="footer-social-btn" title="Fanpage">
                        <i class="fa fa-facebook"></i>
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($config['link_congdong'])): ?>
                    <a href="<?= htmlspecialchars($config['link_congdong']) ?>" target="_blank" class="footer-social-btn" title="Cộng đồng">
                        <i class="fa fa-users"></i>
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($config['link_huongdan'])): ?>
                    <a href="<?= htmlspecialchars($config['link_huongdan']) ?>" target="_blank" class="footer-social-btn" title="Hướng dẫn">
                        <i class="fa fa-youtube-play"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Cột 2: Liên kết nhanh -->
            <div class="footer-col">
                <div class="footer-col-title">Liên kết</div>
                <ul class="footer-links">
                    <li><a href="/tin-tuc"><i class="fa fa-angle-right mr-1"></i>Tin tức</a></li>
                    <li><a href="/su-kien"><i class="fa fa-angle-right mr-1"></i>Sự kiện</a></li>
                    <li><a href="/cam-nang"><i class="fa fa-angle-right mr-1"></i>Cẩm nang</a></li>
                    <li><a href="/tinh-nang"><i class="fa fa-angle-right mr-1"></i>Tính năng</a></li>
                    <?php if (!empty($config['link_dangky'])): ?>
                    <li><a href="<?= htmlspecialchars($config['link_dangky']) ?>" target="_blank"><i class="fa fa-angle-right mr-1"></i>Đăng ký tài khoản</a></li>
                    <?php endif; ?>
                    <?php if (!empty($config['link_napthe'])): ?>
                    <li><a href="<?= htmlspecialchars($config['link_napthe']) ?>" target="_blank"><i class="fa fa-angle-right mr-1"></i>Nạp thẻ</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Cột 3: Hỗ trợ -->
            <div class="footer-col">
                <div class="footer-col-title">Hỗ trợ</div>
                <ul class="footer-links">
                    <?php if (!empty($config['link_hotro'])): ?>
                    <li><a href="<?= htmlspecialchars($config['link_hotro']) ?>" target="_blank"><i class="fa fa-angle-right mr-1"></i>Fanpage hỗ trợ</a></li>
                    <?php endif; ?>
                    <?php if (!empty($config['link_congdong'])): ?>
                    <li><a href="<?= htmlspecialchars($config['link_congdong']) ?>" target="_blank"><i class="fa fa-angle-right mr-1"></i>Group cộng đồng</a></li>
                    <?php endif; ?>
                    <?php if (!empty($config['link_huongdan_nap'])): ?>
                    <li><a href="<?= htmlspecialchars($config['link_huongdan_nap']) ?>" target="_blank"><i class="fa fa-angle-right mr-1"></i>Hướng dẫn nạp KNB</a></li>
                    <?php endif; ?>
                    <?php if (!empty($config['link_datquyenvip'])): ?>
                    <li><a href="<?= htmlspecialchars($config['link_datquyenvip']) ?>" target="_blank"><i class="fa fa-angle-right mr-1"></i>Đặt quyền VIP</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Cột 4: Tải game & liên hệ -->
            <div class="footer-col">
                <div class="footer-col-title">Tải game</div>
                <div class="footer-download">
                    <?php if (!empty($config['taigame'])): ?>
                    <a href="<?= htmlspecialchars($config['taigame']) ?>" target="_blank" class="footer-dl-btn a-link-download">
                        <i class="fa fa-android"></i> Android / PC
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($config['taigameios'])): ?>
                    <a href="<?= htmlspecialchars($config['taigameios']) ?>" target="_blank" class="footer-dl-btn a-link-download-miniclient">
                        <i class="fa fa-apple"></i> iOS / Mini Client
                    </a>
                    <?php endif; ?>
                </div>
                <?php if (!empty($config['phone'])): ?>
                <div class="footer-contact">
                    <i class="fa fa-phone-square mr-1"></i>
                    Hotline: <strong><?= htmlspecialchars($config['phone']) ?></strong>
                </div>
                <?php endif; ?>
            </div>

        </div>

        <div class="footer-bottom">
            <span>&copy; <?= date('Y') ?> <?= htmlspecialchars($config['title'] ?? 'JX1') ?>. All rights reserved.</span>
        </div>
    </div>
</footer>

<style>
footer {
    background: url('/assets/imgs/bg-footer.png') top center no-repeat;
    background-color: #0d0d1a;
    height: auto !important;
    padding-top: 40px;
}
.footer-content { width: 100%; }
.footer-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px 30px;
    display: flex;
    gap: 40px;
    flex-wrap: wrap;
}
.footer-col { flex: 1; min-width: 180px; }
.footer-brand { flex: 1.4; }
.footer-logo {
    font-size: 22px;
    font-weight: 800;
    color: #e8c96d;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 10px;
}
.footer-desc { color: #aaa; font-size: 12px; line-height: 1.7; margin-bottom: 14px; }
.footer-social { display: flex; gap: 8px; }
.footer-social-btn {
    width: 34px; height: 34px;
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    color: #ccc; font-size: 15px;
    text-decoration: none;
    transition: all .2s;
}
.footer-social-btn:hover { background: #e8c96d; color: #000; border-color: #e8c96d; }
.footer-col-title {
    font-size: 13px;
    font-weight: 700;
    color: #e8c96d;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 14px;
    padding-bottom: 8px;
    border-bottom: 1px solid rgba(255,255,255,.08);
}
.footer-links { list-style: none; padding: 0; margin: 0; }
.footer-links li { margin-bottom: 8px; }
.footer-links a { color: #aaa; text-decoration: none; font-size: 12px; transition: color .2s; }
.footer-links a:hover { color: #e8c96d; }
.footer-download { display: flex; flex-direction: column; gap: 8px; margin-bottom: 16px; }
.footer-dl-btn {
    display: flex; align-items: center; gap: 8px;
    background: rgba(255,255,255,.07);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 6px;
    padding: 8px 14px;
    color: #ddd; font-size: 12px; text-decoration: none;
    transition: all .2s;
}
.footer-dl-btn:hover { background: #e8c96d; color: #000; border-color: #e8c96d; }
.footer-dl-btn i { font-size: 16px; }
.footer-contact { color: #aaa; font-size: 12px; }
.footer-contact strong { color: #e8c96d; }
.footer-bottom {
    border-top: 1px solid rgba(255,255,255,.08);
    text-align: center;
    padding: 14px 20px;
    color: #666;
    font-size: 11px;
}
@media (max-width: 768px) {
    .footer-inner { flex-direction: column; gap: 24px; }
    .footer-col { min-width: unset; }
}
</style>
