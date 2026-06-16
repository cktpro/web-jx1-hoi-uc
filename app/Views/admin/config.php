<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fa fa-cogs text-primary"></i> Cấu hình trang chủ</span>
                <div>
                    <span id="save-msg" class="mr-2" style="font-size:13px;"></span>
                    <button type="button" class="btn btn-primary btn-sm" onclick="saveConfig()">
                        <i class="fa fa-save"></i> Lưu
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label><i class="fa fa-download text-success mr-1"></i> Link tải game PC</label>
                    <input type="url" id="cfg-taigame" class="form-control"
                           value="<?= htmlspecialchars($cfg['taigame'] ?? '') ?>"
                           placeholder="https://...">
                </div>
                <div class="form-group">
                    <label><i class="fa fa-mobile text-info mr-1"></i> Link tải game iOS / Mini Client</label>
                    <input type="url" id="cfg-taigameios" class="form-control"
                           value="<?= htmlspecialchars($cfg['taigameios'] ?? '') ?>"
                           placeholder="https://...">
                </div>
                <hr>
                <div class="form-group">
                    <label><i class="fa fa-user-plus text-warning mr-1"></i> Link đăng ký tài khoản</label>
                    <input type="url" id="cfg-link_dangky" class="form-control"
                           value="<?= htmlspecialchars($cfg['link_dangky'] ?? '') ?>"
                           placeholder="https://...">
                </div>
                <div class="form-group">
                    <label><i class="fa fa-facebook-square text-primary mr-1"></i> Link hỗ trợ / Fanpage</label>
                    <input type="url" id="cfg-link_hotro" class="form-control"
                           value="<?= htmlspecialchars($cfg['link_hotro'] ?? '') ?>"
                           placeholder="https://...">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <span><i class="fa fa-info-circle text-muted"></i> Hướng dẫn</span>
            </div>
            <div class="card-body" style="font-size:13px;color:#555;line-height:1.8;">
                <p><strong>Tên trang</strong> — hiển thị trên tab trình duyệt và trang đăng nhập.</p>
                <p><strong>Link tải game PC</strong> — gắn vào nút "Tải game" ở sidebar và trang chủ.</p>
                <p><strong>Link tải iOS / Mini</strong> — gắn vào nút mini client.</p>
                <p><strong>Link đăng ký</strong> — nút đăng ký tài khoản ở sidebar.</p>
                <p><strong>Link hỗ trợ / Fanpage</strong> — icon hỗ trợ và khung Facebook sidebar phải.</p>
            </div>
        </div>
    </div>
</div>

<script>
function saveConfig() {
    var $btn = $('button[onclick="saveConfig()"]');
    var $msg = $('#save-msg');

    $btn.prop('disabled', true);
    $msg.removeClass('text-success text-danger').html('<i class="fa fa-spinner fa-spin"></i> Đang lưu...');

    $.post('/admin/ajax/config/save', {
        taigame:      $('#cfg-taigame').val(),
        taigameios:   $('#cfg-taigameios').val(),
        link_dangky:  $('#cfg-link_dangky').val(),
        link_hotro:   $('#cfg-link_hotro').val(),
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
