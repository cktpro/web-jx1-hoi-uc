<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login – JX1 Game</title>
    <link rel="stylesheet" href="/assets/admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/admin/font-awesome/css/font-awesome.min.css">
    <style>
        * { box-sizing: border-box; }
        body {
            background: linear-gradient(135deg, #1a2735 0%, #2f4050 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        .login-card {
            background: #fff;
            border-radius: 6px;
            box-shadow: 0 8px 32px rgba(0,0,0,.35);
            width: 100%;
            max-width: 380px;
            overflow: hidden;
        }
        .login-header {
            background: #19aa8d;
            padding: 28px 30px 22px;
            text-align: center;
        }
        .login-header h1 {
            margin: 0;
            font-size: 26px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 1px;
        }
        .login-header p {
            margin: 4px 0 0;
            color: rgba(255,255,255,.75);
            font-size: 13px;
        }
        .login-body { padding: 28px 30px 30px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { font-size: 12px; color: #888; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 6px; display: block; }
        .input-icon { position: relative; }
        .input-icon i {
            position: absolute;
            left: 12px; top: 50%;
            transform: translateY(-50%);
            color: #ccc;
            font-size: 14px;
        }
        .input-icon input {
            padding-left: 36px;
            height: 40px;
            border-radius: 3px;
            border: 1px solid #e0e0e0;
            width: 100%;
            font-size: 14px;
            transition: border-color .2s;
        }
        .input-icon input:focus {
            outline: none;
            border-color: #19aa8d;
            box-shadow: 0 0 0 2px rgba(25,170,141,.15);
        }
        .btn-login {
            width: 100%;
            height: 42px;
            background: #19aa8d;
            color: #fff;
            border: none;
            border-radius: 3px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s;
            margin-top: 8px;
        }
        .btn-login:hover { background: #148f76; }
        .btn-login i { margin-right: 6px; }
        #msg { margin-bottom: 12px; }
        .alert { padding: 10px 14px; border-radius: 3px; font-size: 13px; }
        .alert-danger { background: #fde8e8; color: #c0392b; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
<div class="login-card">
    <div class="login-header">
        <h1>JX1 Admin</h1>
        <p>Quản trị hệ thống game portal</p>
    </div>
    <div class="login-body">
        <div id="msg"></div>
        <div class="form-group">
            <label><i class="fa fa-user"></i> Tài khoản</label>
            <div class="input-icon">
                <i class="fa fa-user"></i>
                <input type="text" id="username" placeholder="Nhập tên đăng nhập" autocomplete="username">
            </div>
        </div>
        <div class="form-group">
            <label><i class="fa fa-lock"></i> Mật khẩu</label>
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input type="password" id="password" placeholder="Nhập mật khẩu" autocomplete="current-password">
            </div>
        </div>
        <button class="btn-login" onclick="doLogin()" id="loginBtn">
            <i class="fa fa-sign-in"></i> Đăng nhập
        </button>
    </div>
</div>

<script src="/assets/admin/js/jquery-2.1.1.js"></script>
<script>
$(function() {
    $('#password').on('keypress', function(e) {
        if (e.which === 13) doLogin();
    });
});
function doLogin() {
    var btn = $('#loginBtn');
    btn.html('<i class="fa fa-spinner fa-spin"></i> Đang đăng nhập...').prop('disabled', true);
    $.post('/admin/ajax/login', {
        username: $('#username').val(),
        password: $('#password').val(),
    }, function(r) {
        if (r.code === 0) {
            window.location.href = r.msg;
        } else {
            $('#msg').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + r.msg + '</div>');
            btn.html('<i class="fa fa-sign-in"></i> Đăng nhập').prop('disabled', false);
        }
    }, 'json').fail(function() {
        $('#msg').html('<div class="alert alert-danger">Lỗi kết nối, vui lòng thử lại.</div>');
        btn.html('<i class="fa fa-sign-in"></i> Đăng nhập').prop('disabled', false);
    });
}
</script>
</body>
</html>
