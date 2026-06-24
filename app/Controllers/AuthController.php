<?php

class AuthController extends Controller {
    public function loginForm(): void {
        if (!empty($_SESSION['username'])) {
            $this->redirect('/user');
        }
        $this->view('user/login', ['config' => siteconfig_load()]);
    }

    public function loginAjax(): void {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (!$username || !$password) {
            $this->json(['status' => false, 'msg' => 'Vui lòng nhập đầy đủ thông tin']);
        }

        $passHash = strtoupper(md5($password));
        $account  = (new User(db_portal()))->findByUsername($username);

        if (!$account) {
            $this->json(['status' => false, 'msg' => 'Tài khoản không tồn tại']);
        }
        if ($account['Password'] !== $passHash) {
            $this->json(['status' => false, 'msg' => 'Mật khẩu không chính xác']);
        }

        $_SESSION['username'] = $account['LoginName'];
        $this->json(['status' => true]);
    }

    public function registerForm(): void {
        if (!empty($_SESSION['username'])) {
            $this->redirect('/user');
        }
        $this->view('user/register', ['config' => siteconfig_load()]);
    }

    public function registerAjax(): void {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirm  = trim($_POST['confirm'] ?? '');
        $phone    = trim($_POST['phone'] ?? '');


        if (!$username || !$password) {
            $this->json(['status' => false, 'msg' => 'Vui lòng nhập đầy đủ thông tin']);
        }
        if (strlen($username) < 6) {
            $this->json(['status' => false, 'msg' => 'Tên đăng nhập phải từ 6 ký tự']);
        }
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            $this->json(['status' => false, 'msg' => 'Tên đăng nhập chỉ chứa chữ cái, số và dấu _']);
        }
        if (strlen($password) < 6) {
            $this->json(['status' => false, 'msg' => 'Mật khẩu phải từ 6 ký tự']);
        }
        if ($password !== $confirm) {
            $this->json(['status' => false, 'msg' => 'Mật khẩu xác nhận không khớp']);
        }

        $userModel = new User(db_portal());
        if ($userModel->usernameExists($username)) {
            $this->json(['status' => false, 'msg' => 'Tên đăng nhập đã tồn tại']);
        }

        $userModel->create($username, strtoupper(md5($password))) ;
        $this->json(['status' => true, 'msg' => 'Đăng ký thành công!']);
    }

    public function logout(): void {
        session_destroy();
        $this->redirect('/user/login');
    }
}
