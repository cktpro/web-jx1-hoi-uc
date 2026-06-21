<div class="row">
    <div class="col-md-6 mb-4">
        <div class="u-card">
            <div class="u-card-header"><i class="fa fa-id-card-o mr-2"></i>Thông tin cá nhân</div>
            <div class="u-card-body">
                <div id="info-alert"></div>
                <div class="form-group">
                    <label>Tên đăng nhập</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($user['LoginName'] ?? '') ?>" readonly style="background:#f4f6fb;">
                </div>
                <div class="form-group">
                    <label>Số điện thoại</label>
                    <input type="text" class="form-control" id="input-phone" value="<?= htmlspecialchars($user['Phone'] ?? '') ?>" placeholder="Nhập số điện thoại">
                </div>
                <button class="btn btn-primary-agent" onclick="saveInfo()">
                    <i class="fa fa-save mr-1"></i>Lưu thay đổi
                </button>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="u-card">
            <div class="u-card-header"><i class="fa fa-lock mr-2"></i>Đổi mật khẩu</div>
            <div class="u-card-body">
                <div id="pw-alert"></div>
                <div class="form-group">
                    <label>Mật khẩu hiện tại</label>
                    <input type="password" class="form-control" id="input-current" placeholder="Nhập mật khẩu hiện tại">
                </div>
                <div class="form-group">
                    <label>Mật khẩu mới</label>
                    <input type="password" class="form-control" id="input-new" placeholder="Tối thiểu 6 ký tự">
                </div>
                <div class="form-group">
                    <label>Xác nhận mật khẩu mới</label>
                    <input type="password" class="form-control" id="input-confirm" placeholder="Nhập lại mật khẩu mới">
                </div>
                <button class="btn btn-primary-agent" onclick="changePassword()">
                    <i class="fa fa-key mr-1"></i>Đổi mật khẩu
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function showAlert(id, msg, ok) {
    $('#' + id).html('<div class="u-alert ' + (ok ? 'u-alert-success' : 'u-alert-danger') + '">' + msg + '</div>');
}

function saveInfo() {
    var phone = $('#input-phone').val().trim();
    $.post('/dai-ly/ajax/cap-nhat-thong-tin', { phone: phone }, function(res) {
        showAlert('info-alert', res.msg, res.status);
    }, 'json');
}

function changePassword() {
    var data = {
        current_password: $('#input-current').val(),
        new_password:     $('#input-new').val(),
        confirm_password: $('#input-confirm').val(),
    };
    $.post('/dai-ly/ajax/doi-mat-khau-ca-nhan', data, function(res) {
        showAlert('pw-alert', res.msg, res.status);
        if (res.status) {
            $('#input-current, #input-new, #input-confirm').val('');
        }
    }, 'json');
}
</script>
