<?php

class UserController extends Controller {
    public function index(): void {
        $this->authUser();
        $user = (new User(db_portal()))->getInfo($_SESSION['username']);
        $this->view('layouts/user', [
            'config'       => siteconfig_load(),
            'user'         => $user,
            'content_view' => 'user/dashboard',
        ]);
    }

    public function changePasswordForm(): void {
        $this->authUser();
        $this->view('layouts/user', [
            'config'       => siteconfig_load(),
            'content_view' => 'user/change-password',
        ]);
    }

    public function changePasswordAjax(): void {
        $this->authUser();
        $username    = $_SESSION['username'];
        $oldPass     = trim($_POST['oldpassword'] ?? '');
        $newPass     = trim($_POST['newpassword'] ?? '');
        $confirmPass = trim($_POST['renewpassword'] ?? '');

        if (!$oldPass || !$newPass || !$confirmPass) {
            $this->json(['status' => 0, 'msg' => 'Không được bỏ trống các trường']);
        }
        if ($newPass !== $confirmPass) {
            $this->json(['status' => 0, 'msg' => 'Mật khẩu mới và xác nhận không trùng khớp']);
        }
        if (strlen($newPass) < 6) {
            $this->json(['status' => 0, 'msg' => 'Mật khẩu mới phải từ 6 ký tự']);
        }

        $userModel = new User(db_portal());
        $account   = $userModel->findByUsername($username);

        if (!$account || $account['Password'] !== $oldPass) {
            $this->json(['status' => 0, 'msg' => 'Mật khẩu cũ không chính xác']);
        }

        $userModel->updatePassword($username, $newPass);
        session_destroy();
        $this->json(['status' => 1, 'msg' => 'Đổi mật khẩu thành công, vui lòng đăng nhập lại']);
    }

    public function giftcode(): void {
        $this->authUser();
        $this->view('layouts/user', [
            'config'       => siteconfig_load(),
            'content_view' => 'user/giftcode',
        ]);
    }

    public function exchange(): void {
        $this->authUser();
        $user = (new User(db_portal()))->getInfo($_SESSION['username']);
        $this->view('layouts/user', [
            'config'       => siteconfig_load(),
            'user'         => $user,
            'shop'         => [],
            'content_view' => 'user/exchange',
        ]);
    }

    public function exchangeAjax(): void {
        $this->authUser();
        $this->json(['status' => false, 'msg' => 'Tính năng đang cập nhật']);
    }
}
