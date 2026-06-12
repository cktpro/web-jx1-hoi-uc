<?php

class UserController extends Controller {
    public function index(): void {
        $this->authUser();
        $db = db_portal();
        $user = (new User($db))->getInfo($_SESSION['username']);
        $config = (new SiteConfig($db))->get();
        $this->view('layouts/user', [
            'config'       => $config,
            'user'         => $user,
            'content_view' => 'user/dashboard',
        ]);
    }

    public function changePasswordForm(): void {
        $this->authUser();
        $config = (new SiteConfig(db_portal()))->get();
        $this->view('layouts/user', [
            'config'       => $config,
            'content_view' => 'user/change-password',
        ]);
    }

    public function changePasswordAjax(): void {
        $this->authUser();
        $username   = $_SESSION['username'];
        $oldPass    = strtoupper(md5($_POST['oldpassword'] ?? ''));
        $newPass    = strtoupper(md5($_POST['newpassword'] ?? ''));
        $confirmPass = strtoupper(md5($_POST['renewpassword'] ?? ''));

        if (!$_POST['oldpassword'] || !$_POST['newpassword'] || !$_POST['renewpassword']) {
            $this->json(['status' => 0, 'msg' => 'Không được bỏ trống các trường']);
        }
        if ($newPass !== $confirmPass) {
            $this->json(['status' => 0, 'msg' => 'Mật khẩu mới và xác nhận không trùng khớp']);
        }

        $db = db_portal();
        $userModel = new User($db);
        $account = $userModel->findByUsername($username);

        if (!$account || $account['Password'] !== $oldPass) {
            $this->json(['status' => 0, 'msg' => 'Mật khẩu cũ không chính xác']);
        }

        $userModel->updatePassword($username, $newPass);
        $userModel->updatePortalPassword($username, $newPass);
        session_destroy();
        $this->json(['status' => 1, 'msg' => 'Đổi mật khẩu thành công, vui lòng đăng nhập lại']);
    }

    public function giftcode(): void {
        $this->authUser();
        $config = (new SiteConfig(db_portal()))->get();
        $this->view('layouts/user', [
            'config'       => $config,
            'content_view' => 'user/giftcode',
        ]);
    }

    public function exchange(): void {
        $this->authUser();
        $db = db_portal();
        $user = (new User($db))->getInfo($_SESSION['username']);
        $shop = $db->query('SELECT * FROM gc_shop')->fetchAll();
        $config = (new SiteConfig($db))->get();
        $this->view('layouts/user', [
            'config'       => $config,
            'user'         => $user,
            'shop'         => $shop,
            'content_view' => 'user/exchange',
        ]);
    }

    public function exchangeAjax(): void {
        $this->authUser();
        $username = $_SESSION['username'];
        $shopId   = (int)($_POST['xu'] ?? 0);
        $db = db_portal();

        $item = $db->prepare('SELECT * FROM gc_shop WHERE id = ? LIMIT 1');
        $item->execute([$shopId]);
        $shopItem = $item->fetch();

        $userInfo = (new User($db))->getInfo($username);

        if (!$shopItem || $userInfo['xu'] < $shopItem['xu']) {
            $this->json(['status' => false, 'msg' => 'Không đủ XU để đổi']);
        }

        $db->prepare('UPDATE gc_user SET xu = xu - ? WHERE user = ?')
           ->execute([$shopItem['xu'], $username]);
        $db->prepare("INSERT INTO gc_logxu (user, xutru, createTime) VALUES (?, ?, NOW())")
           ->execute([$username, $shopItem['xu']]);

        // Cộng token vào KTCoins (MySQL)
        $coins = $db->prepare('SELECT * FROM KTCoins WHERE UserName = ? LIMIT 1');
        $coins->execute([$username]);
        $coinRow = $coins->fetch();
        if ($coinRow) {
            $db->prepare('UPDATE KTCoins SET KCoin = KCoin + ? WHERE UserName = ?')
               ->execute([$shopItem['data'], $username]);
        } else {
            $db->prepare('INSERT INTO KTCoins (UserName, KCoin, UpdateTime) VALUES (?, ?, NOW())')
               ->execute([$username, $shopItem['data']]);
        }

        $this->json(['status' => true, 'msg' => 'Đổi xu thành công']);
    }
}
