<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Game Admin Login</title>
    <link rel="stylesheet" href="/assets/admin/css/bootstrap.min.css">
    <script src="/assets/admin/js/jquery.min.js"></script>
</head>
<body>
<div class="container" style="max-width:400px;margin-top:100px;">
    <div class="panel panel-default">
        <div class="panel-heading"><h3>Game Admin Login</h3></div>
        <div class="panel-body">
            <div id="msg"></div>
            <div class="form-group">
                <input type="text" id="username" class="form-control" placeholder="Tài khoản">
            </div>
            <div class="form-group">
                <input type="password" id="password" class="form-control" placeholder="Mật khẩu">
            </div>
            <button class="btn btn-danger btn-block" onclick="doLogin()">Đăng nhập</button>
        </div>
    </div>
</div>
<script>
function doLogin() {
    $.post('/game-admin/ajax/login', {
        username: $('#username').val(),
        password: $('#password').val(),
    }, function(r) {
        if (r.code === 0) { window.location.href = r.msg; }
        else { $('#msg').html('<div class="alert alert-danger">' + r.msg + '</div>'); }
    }, 'json');
}
</script>
</body>
</html>
