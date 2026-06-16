<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập Đại lý | <?= htmlspecialchars($config['title'] ?? APP_NAME) ?></title>
    <link rel="shortcut icon" href="/favicon.ico">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="/assets/js/jquery-4.0.0.min.js"></script>
    <style>
        body { background: #f4f6fb; font-family: 'Segoe UI', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-box { background: #fff; border: 1px solid #e0e4ef; border-radius: 10px; padding: 36px 32px; width: 100%; max-width: 400px; box-shadow: 0 4px 20px rgba(0,0,0,.07); }
        .login-logo { text-align: center; margin-bottom: 24px; }
        .login-logo .badge-agent { display: inline-block; background: linear-gradient(135deg, #2255cc, #1a3fa0); color: #fff; border-radius: 6px; padding: 4px 12px; font-size: 11px; font-weight: 700; letter-spacing: 1px; margin-bottom: 8px; }
        .login-logo h4 { font-weight: 700; color: #222; margin: 0; }
        .login-logo p { color: #999; font-size: 13px; margin: 4px 0 0; }
        .form-control { border: 1px solid #d0d5e8; border-radius: 6px; font-size: 14px; height: 42px; }
        .form-control:focus { border-color: #2255cc; box-shadow: 0 0 0 2px rgba(34,85,204,.12); }
        label { font-size: 13px; color: #555; }
        .btn-agent { background: linear-gradient(135deg, #2255cc, #1a3fa0); color: #fff; border: none; border-radius: 6px; font-weight: 600; height: 42px; font-size: 14px; }
        .btn-agent:hover { background: linear-gradient(135deg, #2d63e0, #2255cc); color: #fff; }
        .msg { font-size: 13px; min-height: 20px; margin-bottom: 8px; }
        .back-link { text-align: center; margin-top: 16px; font-size: 13px; }
        .back-link a { color: #2255cc; text-decoration: none; }
    </style>
</head>
<body>
<div class="login-box">
    <div class="login-logo">
        <div class="badge-agent">ĐẠI LÝ</div>
        <h4><?= htmlspecialchars($config['title'] ?? APP_NAME) ?></h4>
        <p>Đăng nhập tài khoản đại lý</p>
    </div>

    <div id="msg" class="msg"></div>

    <div class="form-group">
        <label>Tên đăng nhập</label>
        <input type="text" id="username" class="form-control" placeholder="Nhập tên tài khoản">
    </div>
    <div class="form-group">
        <label>Mật khẩu</label>
        <input type="password" id="password" class="form-control" placeholder="Nhập mật khẩu">
    </div>
    <button class="btn btn-agent btn-block" onclick="doLogin()">
        <i class="fa fa-sign-in mr-1"></i> Đăng nhập
    </button>

    <div class="back-link">
        <a href="/"><i class="fa fa-home mr-1"></i>Về trang chủ</a>
    </div>
</div>

<script>
function doLogin() {
    var u = $('#username').val().trim();
    var p = $('#password').val().trim();
    var $msg = $('#msg');
    if (!u || !p) { $msg.html('<span style="color:#c0392b;">Vui lòng nhập đầy đủ thông tin.</span>'); return; }
    $.post('/dai-ly/ajax/login', { username: u, password: p }, function(r) {
        if (r.status) {
            $msg.html('<span style="color:#2d7a4f;"><i class="fa fa-check mr-1"></i>Đăng nhập thành công!</span>');
            setTimeout(() => window.location.href = '/dai-ly', 1000);
        } else {
            $msg.html('<span style="color:#c0392b;"><i class="fa fa-times mr-1"></i>' + r.msg + '</span>');
        }
    }, 'json');
}
$('#password').on('keydown', function(e) { if (e.key === 'Enter') doLogin(); });
</script>
</body>
</html>
