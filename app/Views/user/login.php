<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập | <?= htmlspecialchars($config['title'] ?? APP_NAME) ?></title>
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
<form method="post" onsubmit="ajaxLogin(); return false;" class="form-signin">
    <div class="bg-light border rounded p-4 m-3">
        <div class="avatar">
            <img src="/assets/img/logo.png" alt="Logo">
        </div>
        <h1 class="h3 m-3 font-weight-normal">Đăng nhập</h1>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-user"></i></div>
            </div>
            <input type="text" id="username" name="username" class="form-control" placeholder="Tên đăng nhập">
        </div>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-lock"></i></div>
            </div>
            <input type="password" id="password" name="password" class="form-control" placeholder="Mật khẩu">
        </div>
        <span id="msg"></span>
        <button class="btn btn-lg btn-info btn-block mt-2" type="submit">Đăng nhập</button>
        <div class="mt-3">
            <a href="/user/register">Chưa có tài khoản? Đăng ký ngay</a>
        </div>
    </div>
</form>
<script>
function ajaxLogin() {
    var username = $('#username').val();
    var password = $('#password').val();
    if (!username) { $('#msg').addClass('text-danger').html('Vui lòng nhập tên đăng nhập'); return; }
    if (!password) { $('#msg').addClass('text-danger').html('Vui lòng nhập mật khẩu'); return; }
    $.post('/user/ajax/login', {username, password}, function(r) {
        if (r.status) {
            $('#msg').removeClass('text-danger').addClass('text-success').html('Đăng nhập thành công!');
            setTimeout(() => window.location.href = '/user', 1000);
        } else {
            $('#msg').addClass('text-danger').html(r.msg);
        }
    }, 'json');
}
</script>
</body>
</html>
