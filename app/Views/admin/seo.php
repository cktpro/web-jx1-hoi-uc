<?php $saved = isset($_GET['saved']); ?>

<?php if ($saved): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fa fa-check-circle mr-2"></i> Lưu cài đặt SEO thành công!
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
<?php endif; ?>

<form method="post" action="/admin/seo">
<div class="row">
    <!-- Cột trái: SEO & Giao diện -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <span><i class="fa fa-search text-primary"></i> Thông tin SEO</span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Tiêu đề trang (Title)</label>
                    <input type="text" name="title" class="form-control"
                           value="<?= htmlspecialchars($cfg['title'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Mô tả (Description)</label>
                    <textarea name="descr" class="form-control" rows="3"><?= htmlspecialchars($cfg['descr'] ?? '') ?></textarea>
                </div>
                <div class="form-group">
                    <label>Từ khóa (Keywords)</label>
                    <textarea name="keywords" class="form-control" rows="3"><?= htmlspecialchars($cfg['keywords'] ?? '') ?></textarea>
                    <small class="text-muted">Cách nhau bằng dấu phẩy</small>
                </div>
                <div class="form-group">
                    <label>Ảnh OG Image (URL)</label>
                    <input type="text" name="og_image" class="form-control"
                           value="<?= htmlspecialchars($cfg['og_image'] ?? '') ?>">
                    <?php if (!empty($cfg['og_image'])): ?>
                    <img src="<?= htmlspecialchars($cfg['og_image']) ?>" class="mt-2 rounded"
                         style="max-height:80px;" alt="OG preview">
                    <?php endif; ?>
                    <small class="text-muted">Khuyến nghị: 600×315px</small>
                </div>
                <div class="form-group">
                    <label>Số điện thoại</label>
                    <input type="text" name="phone" class="form-control"
                           value="<?= htmlspecialchars($cfg['phone'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Thông báo / Tips</label>
                    <textarea name="tips" class="form-control" rows="2"><?= htmlspecialchars($cfg['tips'] ?? '') ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Cột phải: Links -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <span><i class="fa fa-link text-success"></i> Liên kết tải game</span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Link tải Android (APK)</label>
                    <input type="text" name="taigame" class="form-control"
                           value="<?= htmlspecialchars($cfg['taigame'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Link tải iOS</label>
                    <input type="text" name="taigameios" class="form-control"
                           value="<?= htmlspecialchars($cfg['taigameios'] ?? '') ?>">
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <span><i class="fa fa-external-link text-warning"></i> Liên kết hệ thống</span>
            </div>
            <div class="card-body">
                <?php
                $links = [
                    'link_dangky'        => 'Đăng ký / Đăng nhập',
                    'link_napthe'        => 'Nạp thẻ',
                    'link_hotro'         => 'Fanpage hỗ trợ',
                    'link_congdong'      => 'Group cộng đồng',
                    'link_huongdan'      => 'Hướng dẫn tải game',
                    'link_huongdan_nap'  => 'Hướng dẫn nạp kim',
                    'link_datquyenvip'   => 'Đặt quyền VIP',
                    'link_auto'          => 'Link Auto',
                ];
                foreach ($links as $field => $label): ?>
                <div class="form-group">
                    <label><?= $label ?></label>
                    <input type="text" name="<?= $field ?>" class="form-control"
                           value="<?= htmlspecialchars($cfg[$field] ?? '') ?>">
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div class="d-flex mb-4">
    <button type="submit" class="btn btn-primary mr-2">
        <i class="fa fa-save"></i> Lưu cài đặt
    </button>
    <a href="/" target="_blank" class="btn btn-outline-secondary">
        <i class="fa fa-eye"></i> Xem trang chủ
    </a>
</div>
</form>
