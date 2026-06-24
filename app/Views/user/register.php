<!DOCTYPE html>
<html lang="vi">
<?php
$logo           = $config['logo_Img']        ?? '/assets/imgs/logo.webp';
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng ký | <?= htmlspecialchars($config['title'] ?? APP_NAME) ?></title>
    <meta name="robots" content="noindex, nofollow">
    <meta name="keywords" content="<?= htmlspecialchars($config['keywords'] ?? '') ?>">
    <meta name="description" content="<?= htmlspecialchars($config['descr'] ?? '') ?>">
    <meta property="og:title" content="<?= htmlspecialchars($config['title'] ?? APP_NAME) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($config['descr'] ?? '') ?>">
    <meta property="og:image" content="<?= htmlspecialchars($config['og_image'] ?? '') ?>">
    <link rel="shortcut icon" href="<?= htmlspecialchars($config['favicon'] ?? '/favicon.ico') ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="/assets/css/signin.css" rel="stylesheet">
    <script src="/assets/js/jquery-4.0.0.min.js"></script>
</head>
<body class="text-center">
<form method="post" onsubmit="ajaxRegister(); return false;" class="form-signin">
    <div class="bg-light border rounded p-4 m-3">
        <div class="avatar">
            <img src="<?= htmlspecialchars($logo) ?>" alt="Logo">
        </div>
        <h1 class="h3 m-3 font-weight-normal">Đăng ký tài khoản</h1>

        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-user"></i></div>
            </div>
            <input type="text" id="username" name="username" class="form-control"
                   placeholder="Tên đăng nhập (tối thiểu 6 ký tự)">
        </div>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-lock"></i></div>
            </div>
            <input type="password" id="password" name="password" class="form-control"
                   placeholder="Mật khẩu (tối thiểu 6 ký tự)">
        </div>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-lock"></i></div>
            </div>
            <input type="password" id="confirm" name="confirm" class="form-control"
                   placeholder="Xác nhận mật khẩu">
        </div>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-phone"></i></div>
            </div>
            <input type="text" id="phone" name="phone" class="form-control"
                   placeholder="Số điện thoại (không bắt buộc)">
        </div>

        <div id="msg" class="mb-2" style="min-height:20px;font-size:14px;"></div>

        <button class="btn btn-lg btn-success btn-block mt-1" type="submit">Đăng ký</button>
        <div class="mt-3">
            <a href="/user/login">Đã có tài khoản? Đăng nhập</a>
        </div>
    </div>
</form>
<script>
function ajaxRegister() {
    var username = $('#username').val().trim();
    var password = $('#password').val().trim();
    var confirm  = $('#confirm').val().trim();
    var phone    = $('#phone').val().trim();
    var $msg     = $('#msg');

    $msg.removeClass('text-danger text-success').html('');

    $.post('/user/ajax/register', {username, password, confirm, phone}, function(r) {
        if (r.status) {
            $msg.addClass('text-success').html(r.msg);
            setTimeout(() => window.location.href = '/user/login', 1500);
        } else {
            $msg.addClass('text-danger').html(r.msg);
        }
    }, 'json');
}
</script>
</body>
</html>
