<div class="row justify-content-start">
    <div class="col-md-6">
        <div class="u-card">
            <div class="u-card-header"><i class="fa fa-key mr-2"></i>Đổi mật khẩu</div>
            <div class="u-card-body">
                <div id="msg"></div>
                <div class="form-group">
                    <label>Mật khẩu hiện tại</label>
                    <input type="password" id="oldpassword" class="form-control" placeholder="Nhập mật khẩu hiện tại">
                </div>
                <div class="form-group">
                    <label>Mật khẩu mới</label>
                    <input type="password" id="newpassword" class="form-control" placeholder="Tối thiểu 6 ký tự">
                </div>
                <div class="form-group">
                    <label>Xác nhận mật khẩu mới</label>
                    <input type="password" id="renewpassword" class="form-control" placeholder="Nhập lại mật khẩu mới">
                </div>
                <button class="btn btn-gold" onclick="doChange()">
                    <i class="fa fa-save mr-1"></i> Lưu thay đổi
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function doChange() {
    var old = $('#oldpassword').val();
    var np  = $('#newpassword').val();
    var rnp = $('#renewpassword').val();
    if (!old || !np || !rnp) {
        $('#msg').html('<div class="u-alert u-alert-danger">Vui lòng điền đầy đủ thông tin.</div>');
        return;
    }
    $.post('/user/ajax/change-password', {
        oldpassword: old, newpassword: np, renewpassword: rnp
    }, function(r) {
        if (r.status) {
            $('#msg').html('<div class="u-alert u-alert-success">' + r.msg + '</div>');
            setTimeout(() => window.location.href = '/user/login', 2000);
        } else {
            $('#msg').html('<div class="u-alert u-alert-danger">' + r.msg + '</div>');
        }
    }, 'json');
}
</script>
