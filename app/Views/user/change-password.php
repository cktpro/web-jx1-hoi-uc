<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h5>Đổi mật khẩu</h5></div>
            <div class="card-body">
                <div id="msg"></div>
                <div class="form-group">
                    <label>Mật khẩu cũ</label>
                    <input type="password" id="oldpassword" class="form-control">
                </div>
                <div class="form-group">
                    <label>Mật khẩu mới</label>
                    <input type="password" id="newpassword" class="form-control">
                </div>
                <div class="form-group">
                    <label>Xác nhận mật khẩu mới</label>
                    <input type="password" id="renewpassword" class="form-control">
                </div>
                <button class="btn btn-primary" onclick="doChange()">Đổi mật khẩu</button>
            </div>
        </div>
    </div>
</div>
<script>
function doChange() {
    $.post('/user/ajax/change-password', {
        oldpassword: $('#oldpassword').val(),
        newpassword: $('#newpassword').val(),
        renewpassword: $('#renewpassword').val(),
    }, function(r) {
        if (r.status) {
            $('#msg').html('<div class="alert alert-success">' + r.msg + '</div>');
            setTimeout(() => window.location.href = '/user/login', 2000);
        } else {
            $('#msg').html('<div class="alert alert-danger">' + r.msg + '</div>');
        }
    }, 'json');
}
</script>
