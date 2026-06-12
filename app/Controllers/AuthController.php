<?php

class AuthController extends Controller {
    public function loginForm(): void {
        if (!empty($_SESSION['username'])) {
            $this->redirect('/user');
        }
        $config = (new SiteConfig(db_portal()))->get();
        $this->view('user/login', ['config' => $config]);
    }

    public function loginAjax(): void {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (!$username || !$password) {
            $this->json(['status' => false, 'msg' => 'Vui lòng nhập đầy đủ thông tin']);
        }

        $passHash = strtoupper(md5($password));
        $db = db_portal();
        $userModel = new User($db);

        // Kiểm tra trong LoginTables (MySQL thay SQL Server)
        $account = $userModel->findByUsername($username);

        if (!$account) {
            $this->json(['status' => false, 'msg' => 'Tài khoản không tồn tại']);
        }
        if ($account['Password'] !== $passHash) {
            $this->json(['status' => false, 'msg' => 'Mật khẩu không chính xác']);
        }

        // Tạo portal user nếu chưa có
        $portalUser = $userModel->findPortalUser($username);
        if (!$portalUser) {
            $userModel->createPortalUser($username, $passHash);
        }

        $_SESSION['username'] = $account['LoginName'];
        $this->json(['status' => true]);
    }

    public function logout(): void {
        session_destroy();
        $this->redirect('/user/login');
    }
}
