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
    <div class="ft-inner">

        <div class="ft-col ft-brand">
            <div class="ft-logo">
                <a href="/"><img src="/assets/imgs/logo.webp" alt="<?= htmlspecialchars($config['title'] ?? 'Game') ?>"></a>
            </div>
            <p class="ft-desc"><?= htmlspecialchars($config['descr'] ?? 'Game nhập vai kiếm hiệp hàng đầu Việt Nam') ?></p>
            <div class="ft-social">
                <?php if (!empty($config['link_hotro'])): ?>
                <a href="<?= htmlspecialchars($config['link_hotro']) ?>" target="_blank" title="Fanpage"><i class="fa-brands fa-facebook"></i></a>
                <?php endif; ?>
                <?php if (!empty($config['link_congdong'])): ?>
                <a href="<?= htmlspecialchars($config['link_congdong']) ?>" target="_blank" title="Cộng đồng"><i class="fa-solid fa-users"></i></a>
                <?php endif; ?>
                <?php if (!empty($config['link_huongdan'])): ?>
                <a href="<?= htmlspecialchars($config['link_huongdan']) ?>" target="_blank" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
                <?php endif; ?>
            </div>
        </div>

        <div class="ft-col">
            <div class="ft-col-title">Liên kết</div>
            <ul class="ft-links">
                <li><a href="/tin-tuc">Tin tức</a></li>
                <li><a href="/su-kien">Sự kiện</a></li>
                <li><a href="/cam-nang">Cẩm nang</a></li>
                <li><a href="/tinh-nang">Tính năng</a></li>
                <?php if (!empty($config['link_dangky'])): ?>
                <li><a href="<?= htmlspecialchars($config['link_dangky']) ?>" target="_blank">Đăng ký tài khoản</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="ft-col">
            <div class="ft-col-title">Hỗ trợ</div>
            <ul class="ft-links">
                <?php if (!empty($config['link_hotro'])): ?>
                <li><a href="<?= htmlspecialchars($config['link_hotro']) ?>" target="_blank">Fanpage hỗ trợ</a></li>
                <?php endif; ?>
                <?php if (!empty($config['link_congdong'])): ?>
                <li><a href="<?= htmlspecialchars($config['link_congdong']) ?>" target="_blank">Group cộng đồng</a></li>
                <?php endif; ?>
                <?php if (!empty($config['link_huongdan_nap'])): ?>
                <li><a href="<?= htmlspecialchars($config['link_huongdan_nap']) ?>" target="_blank">Hướng dẫn nạp KNB</a></li>
                <?php endif; ?>
                <?php if (!empty($config['link_datquyenvip'])): ?>
                <li><a href="<?= htmlspecialchars($config['link_datquyenvip']) ?>" target="_blank">Đặt quyền VIP</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="ft-col">
            <div class="ft-col-title">Tải game</div>
            <div class="ft-download">
                <?php if (!empty($config['taigame'])): ?>
                <a href="<?= htmlspecialchars($config['taigame']) ?>" target="_blank" class="ft-dl-btn a-link-download">
                    <i class="fa-brands fa-google-play"></i> Android
                </a>
                <?php endif; ?>
                <?php if (!empty($config['taigameios'])): ?>
                <a href="<?= htmlspecialchars($config['taigameios']) ?>" target="_blank" class="ft-dl-btn a-link-download-miniclient">
                    <i class="fa-brands fa-app-store-ios"></i> iOS 
                </a>
                <?php endif; ?>
            </div>
            <?php if (!empty($config['phone'])): ?>
            <div class="ft-contact">
                <i class="fa fa-phone-square"></i> Hotline: <strong><?= htmlspecialchars($config['phone']) ?></strong>
            </div>
            <?php endif; ?>
        </div>

    </div>

    <div class="ft-bottom">
        <span>&copy; <?= date('Y') ?> <?= htmlspecialchars($config['title'] ?? 'JX1') ?>. All rights reserved.</span>
    </div>
</footer>

<style>

.ft-inner {
    max-width: 960px;
    margin: 0 auto;
    padding: 32px 20px 24px;
    display: flex;
    gap: 32px;
    flex-wrap: wrap;
    justify-content: space-between;
}
.ft-col { flex: 1; min-width: 150px; }
.ft-brand { flex: 1.5; }

.ft-logo {
    margin-bottom: 12px;
}
.ft-logo img {
    max-height: 110px;
    width: auto;
    display: block;
}
.ft-desc {
    color: #8a7a5a;
    font-size: 12px;
    line-height: 1.7;
    margin-bottom: 14px;
}
.ft-social { display: flex; gap: 8px; }
.ft-social a {
    width: 30px; height: 30px;
    background: rgba(212,168,67,.12);
    border: 1px solid rgba(212,168,67,.25);
    border-radius: 4px;
    display: flex; align-items: center; justify-content: center;
    color: #d4a843; font-size: 14px;
    text-decoration: none;
    transition: background .2s, color .2s;
}
.ft-social a:hover { background: #d4a843; color: #0e0b07; }

.ft-col-title {
    font-size: 11px;
    font-weight: 700;
    color: #d4a843;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 12px;
    padding-bottom: 6px;
    border-bottom: 1px solid rgba(212,168,67,.2);
}
.ft-links { list-style: none; padding: 0; margin: 0; }
.ft-links li { margin-bottom: 7px; }
.ft-links a {
    color: #8a7a5a;
    font-size: 12px;
    text-decoration: none;
    transition: color .2s;
}
.ft-links a:hover { color: #d4a843; }

.ft-download { display: flex; flex-direction: column; gap: 7px; margin-bottom: 14px; }
.ft-dl-btn {
    display: flex; align-items: center; gap: 8px;
    background: rgba(212,168,67,.08);
    border: 1px solid rgba(212,168,67,.2);
    border-radius: 4px;
    padding: 7px 12px;
    color: #c8a84a; font-size: 12px; text-decoration: none !important;
    transition: background .2s, color .2s;
}
.ft-dl-btn:hover { background: #d4a843; color: #0e0b07; text-decoration: none !important; }
.ft-dl-btn i { font-size: 15px; }
.ft-contact { color: #8a7a5a; font-size: 12px; }
.ft-contact strong { color: #d4a843; }

.ft-bottom {
    border-top: 1px solid rgba(212,168,67,.12);
    text-align: center;
    padding: 12px 20px;
    color: #5a4a30;
    font-size: 11px;
}

@media (max-width: 768px) {
    .ft-inner { gap: 20px; padding: 24px 16px 16px; }
    .ft-col, .ft-brand { flex: 0 0 calc(50% - 10px); min-width: 0; }
}
@media (max-width: 480px) {
    .ft-col, .ft-brand { flex: 0 0 100%; }
}
</style>
