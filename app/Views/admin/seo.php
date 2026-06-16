<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0"><i class="fa fa-search text-primary mr-2"></i>Cài đặt SEO & Liên kết</h5>
    <div>
        <span id="save-msg" class="mr-2" style="font-size:13px;"></span>
        <button type="button" class="btn btn-primary btn-sm" onclick="saveSeo()">
            <i class="fa fa-save"></i> Lưu cài đặt
        </button>
        <a href="/" target="_blank" class="btn btn-outline-secondary btn-sm ml-1">
            <i class="fa fa-eye"></i> Xem trang chủ
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <span><i class="fa fa-search text-primary"></i> Thông tin SEO</span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Tiêu đề trang (Title)</label>
                    <input type="text" id="seo-title" class="form-control"
                           value="<?= htmlspecialchars($cfg['title'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Mô tả (Description)</label>
                    <textarea id="seo-descr" class="form-control" rows="3"><?= htmlspecialchars($cfg['descr'] ?? '') ?></textarea>
                </div>
                <div class="form-group">
                    <label>Từ khóa (Keywords)</label>
                    <textarea id="seo-keywords" class="form-control" rows="2"><?= htmlspecialchars($cfg['keywords'] ?? '') ?></textarea>
                    <small class="text-muted">Cách nhau bằng dấu phẩy</small>
                </div>
                <div class="form-group">
                    <label>OG Image (URL)</label>
                    <input type="text" id="seo-og_image" class="form-control"
                           value="<?= htmlspecialchars($cfg['og_image'] ?? '') ?>">
                    <?php if (!empty($cfg['og_image'])): ?>
                    <img src="<?= htmlspecialchars($cfg['og_image']) ?>" class="mt-2 rounded"
                         style="max-height:80px;" alt="OG preview">
                    <?php endif; ?>
                    <small class="text-muted">Khuyến nghị: 1200×630px</small>
                </div>
                <div class="form-group">
                    <label>Số điện thoại hỗ trợ</label>
                    <input type="text" id="seo-phone" class="form-control"
                           value="<?= htmlspecialchars($cfg['phone'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Thông báo / Tips</label>
                    <textarea id="seo-tips" class="form-control" rows="2"><?= htmlspecialchars($cfg['tips'] ?? '') ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <span><i class="fa fa-university text-info"></i> Thanh toán ngân hàng</span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Tên ngân hàng</label>
                    <input type="text" id="seo-bank_name" class="form-control" value="<?= htmlspecialchars($cfg['bank_name'] ?? '') ?>" placeholder="VD: Vietcombank">
                </div>
                <div class="form-group">
                    <label>Số tài khoản</label>
                    <input type="text" id="seo-bank_number" class="form-control" value="<?= htmlspecialchars($cfg['bank_number'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Chủ tài khoản</label>
                    <input type="text" id="seo-bank_owner" class="form-control" value="<?= htmlspecialchars($cfg['bank_owner'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Nội dung chuyển khoản</label>
                    <input type="text" id="seo-bank_content" class="form-control" value="<?= htmlspecialchars($cfg['bank_content'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Số Momo</label>
                    <input type="text" id="seo-momo_number" class="form-control" value="<?= htmlspecialchars($cfg['momo_number'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Tên tài khoản Momo</label>
                    <input type="text" id="seo-momo_owner" class="form-control" value="<?= htmlspecialchars($cfg['momo_owner'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>API Key nạp thẻ (thesieutoc)</label>
                    <input type="text" id="seo-keyapi" class="form-control" value="<?= htmlspecialchars($cfg['keyapi'] ?? '') ?>">
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <span><i class="fa fa-download text-success"></i> Link tải game</span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Link tải Android / PC</label>
                    <input type="text" id="seo-taigame" class="form-control"
                           value="<?= htmlspecialchars($cfg['taigame'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Link tải iOS / Mini Client</label>
                    <input type="text" id="seo-taigameios" class="form-control"
                           value="<?= htmlspecialchars($cfg['taigameios'] ?? '') ?>">
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <span><i class="fa fa-link text-warning"></i> Liên kết hệ thống</span>
            </div>
            <div class="card-body">
                <?php
                $links = [
                    'link_dangky'       => 'Đăng ký tài khoản',
                    'link_napthe'       => 'Nạp thẻ',
                    'link_hotro'        => 'Fanpage hỗ trợ',
                    'link_congdong'     => 'Group cộng đồng',
                    'link_huongdan'     => 'Hướng dẫn tải game',
                    'link_huongdan_nap' => 'Hướng dẫn nạp kim',
                    'link_datquyenvip'  => 'Đặt quyền VIP',
                    'link_auto'         => 'Link Auto',
                ];
                foreach ($links as $field => $label): ?>
                <div class="form-group">
                    <label><?= $label ?></label>
                    <input type="text" id="seo-<?= $field ?>" class="form-control"
                           value="<?= htmlspecialchars($cfg[$field] ?? '') ?>">
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
function saveSeo() {
    var $btn = $('button[onclick="saveSeo()"]');
    var $msg = $('#save-msg');

    $btn.prop('disabled', true);
    $msg.removeClass('text-success text-danger').html('<i class="fa fa-spinner fa-spin"></i> Đang lưu...');

    $.post('/admin/ajax/seo/save', {
        title:              $('#seo-title').val(),
        descr:              $('#seo-descr').val(),
        keywords:           $('#seo-keywords').val(),
        og_image:           $('#seo-og_image').val(),
        phone:              $('#seo-phone').val(),
        tips:               $('#seo-tips').val(),
        taigame:            $('#seo-taigame').val(),
        taigameios:         $('#seo-taigameios').val(),
        link_dangky:        $('#seo-link_dangky').val(),
        link_napthe:        $('#seo-link_napthe').val(),
        link_hotro:         $('#seo-link_hotro').val(),
        link_congdong:      $('#seo-link_congdong').val(),
        link_huongdan:      $('#seo-link_huongdan').val(),
        link_huongdan_nap:  $('#seo-link_huongdan_nap').val(),
        link_datquyenvip:   $('#seo-link_datquyenvip').val(),
        link_auto:          $('#seo-link_auto').val(),
        bank_name:          $('#seo-bank_name').val(),
        bank_number:        $('#seo-bank_number').val(),
        bank_owner:         $('#seo-bank_owner').val(),
        bank_content:       $('#seo-bank_content').val(),
        momo_number:        $('#seo-momo_number').val(),
        momo_owner:         $('#seo-momo_owner').val(),
        keyapi:             $('#seo-keyapi').val(),
    }, function(r) {
        if (r.status) {
            $msg.addClass('text-success').html('<i class="fa fa-check"></i> ' + r.msg);
        } else {
            $msg.addClass('text-danger').html('<i class="fa fa-times"></i> ' + r.msg);
        }
        $btn.prop('disabled', false);
        setTimeout(() => $msg.html(''), 3000);
    }, 'json');
}
</script>
