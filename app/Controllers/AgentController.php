<?php

class AgentController extends Controller {
    public function loginForm(): void {
        if (!empty($_SESSION['agent'])) {
            $this->redirect('/dai-ly');
        }
        $this->view('agent/login', ['config' => siteconfig_load()]);
    }

    public function loginAjax(): void {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (!$username || !$password) {
            $this->json(['status' => false, 'msg' => 'Vui lòng nhập đầy đủ thông tin']);
        }

        $db      = db_portal();
        $account = (new User($db))->findByUsername($username);

        if (!$account) {
            $this->json(['status' => false, 'msg' => 'Tài khoản không tồn tại']);
        }
        $roleId = (int)($account['ActiveRoleID'] ?? 0);
        if (!in_array($roleId, [1, 3])) {
            $this->json(['status' => false, 'msg' => 'Tài khoản không có quyền đại lý']);
        }
        if ($account['Password'] !== strtoupper(md5($password))) {
            $this->json(['status' => false, 'msg' => 'Mật khẩu không chính xác']);
        }

        $_SESSION['agent']      = $account['LoginName'];
        $_SESSION['agent_role'] = $roleId;
        $this->json(['status' => true]);
    }

    public function logout(): void {
        unset($_SESSION['agent'], $_SESSION['agent_role']);
        $this->redirect('/dai-ly/login');
    }

    public function users(): void {
        $this->authAgent();
        $agentName   = $_SESSION['agent'];
        $isSuperAgent = $this->isSuperAgent();
        $page        = max(1, (int)($_GET['page'] ?? 1));
        $limit       = 20;
        $offset      = ($page - 1) * $limit;

        $days        = max(0, (int)($_GET['days'] ?? 0));
        $from        = $_GET['from'] ?? '';
        $to          = $_GET['to'] ?? '';
        $agentFilter = $isSuperAgent ? trim($_GET['agent'] ?? '') : $agentName;
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $from)) $from = '';
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $to))   $to   = '';
        if ($from && $to) $days = 0;

        $userModel = new User(db_portal());
        $logs      = $userModel->getAgentLogs($agentFilter, $limit, $offset, $days, $from, $to);
        $total     = $userModel->countAgentLogs($agentFilter, $days, $from, $to);
        $totalKnb  = $userModel->sumAgentLogs($agentFilter, $days, $from, $to);
        $user      = $userModel->findByUsername($agentName);
        $agentList = $isSuperAgent ? $userModel->getAllAgents() : [];

        $this->view('layouts/agent', [
            'config'       => siteconfig_load(),
            'user'         => $user,
            'content_view' => 'agent/users',
            'logs'         => $logs,
            'total'        => $total,
            'page'         => $page,
            'limit'        => $limit,
            'days'         => $days,
            'from'         => $from,
            'to'           => $to,
            'totalKnb'     => $totalKnb,
            'agentFilter'  => $agentFilter,
            'agentList'    => $agentList,
            'isSuperAgent' => $isSuperAgent,
        ]);
    }

    public function agents(): void {
        $this->authSuperAgent();
        $agentName = $_SESSION['agent'];
        $page      = max(1, (int)($_GET['page'] ?? 1));
        $limit     = 20;
        $offset    = ($page - 1) * $limit;

        $days = max(0, (int)($_GET['days'] ?? 0));
        $from = $_GET['from'] ?? '';
        $to   = $_GET['to'] ?? '';
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $from)) $from = '';
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $to))   $to   = '';
        if ($from && $to) $days = 0;

        $userModel  = new User(db_portal());
        $user       = $userModel->findByUsername($agentName);
        $list       = $userModel->getAllAgents();
        $logs       = $userModel->getAgentTransferLogs($agentName, $limit, $offset, $days, $from, $to);
        $total      = $userModel->countAgentTransferLogs($agentName, $days, $from, $to);
        $totalKnb   = $userModel->sumAgentTransferLogs($agentName, $days, $from, $to);

        $this->view('layouts/agent', [
            'config'       => siteconfig_load(),
            'user'         => $user,
            'content_view' => 'agent/agents',
            'list'         => $list,
            'logs'         => $logs,
            'total'        => $total,
            'totalKnb'     => $totalKnb,
            'page'         => $page,
            'limit'        => $limit,
            'days'         => $days,
            'from'         => $from,
            'to'           => $to,
            'isSuperAgent' => true,
        ]);
    }

    public function napKnbAgentAjax(): void {
        $this->authSuperAgent();
        $agentName = $_SESSION['agent'];
        $username  = trim($_POST['username'] ?? '');
        $amount    = (int)($_POST['amount'] ?? 0);

        if (!$username || $amount <= 0) {
            $this->json(['status' => false, 'msg' => 'Vui lòng nhập đầy đủ thông tin']);
        }
        if (strtolower($username) === strtolower($agentName)) {
            $this->json(['status' => false, 'msg' => 'Không thể nạp KNB cho chính mình']);
        }

        $userModel = new User(db_portal());
        $account   = $userModel->findByUsername($username);

        if (!$account) {
            $this->json(['status' => false, 'msg' => 'Tài khoản không tồn tại']);
        }
        if ((int)($account['ActiveRoleID'] ?? 0) !== 1) {
            $this->json(['status' => false, 'msg' => 'Tài khoản này không phải đại lý']);
        }

        $superKnb = $userModel->getKCoin($agentName);
        if ($superKnb < $amount) {
            $this->json(['status' => false, 'msg' => "Số dư KNB không đủ (hiện có: $superKnb KNB)"]);
        }

        $userId     = (int)$account['ID'];
        $userBefore = $userModel->getKCoin($username);
        $userAfter  = $userBefore + $amount;

        try {
            $userModel->updateCoins($agentName, -$amount);
            $userModel->updateCoins($username, $amount);
            $userModel->logAgentTransfer($userId, $username, $amount, $userBefore, $userAfter, $agentName);
            $this->json([
                'status' => true,
                'msg'    => "Đã nạp $amount KNB cho đại lý $username. Số dư còn: " . ($superKnb - $amount) . " KNB",
            ]);
        } catch (\Throwable $e) {
            $this->json(['status' => false, 'msg' => 'Lỗi hệ thống: ' . $e->getMessage()]);
        }
    }

    public function napKnbAjax(): void {
        $this->authAgent();
        $agentName = $_SESSION['agent'];
        $username  = trim($_POST['username'] ?? '');
        $amount    = (int)($_POST['amount'] ?? 0);

        if (!$username || $amount <= 0) {
            $this->json(['status' => false, 'msg' => 'Vui lòng nhập đầy đủ thông tin']);
        }

        $db        = db_portal();
        $userModel = new User($db);

        if (strtolower($username) === strtolower($agentName)) {
            $this->json(['status' => false, 'msg' => 'Không thể nạp KNB cho chính tài khoản đại lý']);
        }

        $account = $userModel->findByUsername($username);
        if (!$account) {
            $this->json(['status' => false, 'msg' => 'Tài khoản không tồn tại']);
        }

        $agentKnb = $userModel->getKCoin($agentName);
        if ($agentKnb < $amount) {
            $this->json(['status' => false, 'msg' => "Số dư KNB không đủ (hiện có: $agentKnb KNB)"]);
        }

        $userId     = (int)$account['ID'];
        $userBefore = $userModel->getKCoin($username);
        $userAfter  = $userBefore + $amount;

        try {
            $userModel->updateCoins($agentName, -$amount);
            $userModel->updateCoins($username, $amount);
            $userModel->logRecharge($userId, $username, $amount, $userBefore, $userAfter, $agentName);

            $this->json([
                'status' => true,
                'msg'    => "Đã nạp $amount KNB vào tài khoản $username. Số dư đại lý còn: " . ($agentKnb - $amount) . " KNB",
            ]);
        } catch (\Throwable $e) {
            $this->json(['status' => false, 'msg' => 'Lỗi hệ thống: ' . $e->getMessage()]);
        }
    }

    public function changePasswordAjax(): void {
        $this->authAgent();
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (!$username || !$password) {
            $this->json(['status' => false, 'msg' => 'Vui lòng nhập đầy đủ thông tin']);
        }
        if (strlen($password) < 6) {
            $this->json(['status' => false, 'msg' => 'Mật khẩu phải từ 6 ký tự']);
        }

        $userModel = new User(db_portal());
        if (!$userModel->findByUsername($username)) {
            $this->json(['status' => false, 'msg' => 'Tài khoản không tồn tại']);
        }

        $userModel->updatePassword($username, $password);
        $this->json(['status' => true, 'msg' => "Đã đổi mật khẩu tài khoản $username"]);
    }

    public function checkUserAjax(): void {
        $this->authAgent();
        $username = trim($_POST['username'] ?? '');
        if (!$username) {
            $this->json(['status' => false, 'msg' => 'Vui lòng nhập tên tài khoản']);
        }
        $account = (new User(db_portal()))->findByUsername($username);
        if (!$account) {
            $this->json(['status' => false, 'msg' => 'Tài khoản không tồn tại']);
        }
        $this->json([
            'status' => true,
            'phone'  => $account['Phone'] ?? '',
        ]);
    }

    public function changePhoneAjax(): void {
        $this->authAgent();
        $username = trim($_POST['username'] ?? '');
        $phone    = trim($_POST['phone'] ?? '');

        if (!$username || !$phone) {
            $this->json(['status' => false, 'msg' => 'Vui lòng nhập đầy đủ thông tin']);
        }

        $userModel = new User(db_portal());
        if (!$userModel->findByUsername($username)) {
            $this->json(['status' => false, 'msg' => 'Tài khoản không tồn tại']);
        }

        $userModel->updatePhone($username, $phone);
        $this->json(['status' => true, 'msg' => "Đã cập nhật SĐT tài khoản $username"]);
    }

    public function profileForm(): void {
        $this->authAgent();
        $user = (new User(db_portal()))->findByUsername($_SESSION['agent']);
        $this->view('layouts/agent', [
            'config'       => siteconfig_load(),
            'user'         => $user,
            'content_view' => 'agent/profile',
        ]);
    }

    public function profileUpdateAjax(): void {
        $this->authAgent();
        $phone = trim($_POST['phone'] ?? '');
        if (!$phone) {
            $this->json(['status' => false, 'msg' => 'Vui lòng nhập số điện thoại']);
        }
        (new User(db_portal()))->updatePhone($_SESSION['agent'], $phone);
        $this->json(['status' => true, 'msg' => 'Đã cập nhật thông tin']);
    }

    public function ownPasswordAjax(): void {
        $this->authAgent();
        $current = trim($_POST['current_password'] ?? '');
        $new     = trim($_POST['new_password'] ?? '');
        $confirm = trim($_POST['confirm_password'] ?? '');

        if (!$current || !$new || !$confirm) {
            $this->json(['status' => false, 'msg' => 'Vui lòng nhập đầy đủ thông tin']);
        }
        if ($new !== $confirm) {
            $this->json(['status' => false, 'msg' => 'Mật khẩu xác nhận không khớp']);
        }
        if (strlen($new) < 6) {
            $this->json(['status' => false, 'msg' => 'Mật khẩu mới phải từ 6 ký tự']);
        }

        $userModel = new User(db_portal());
        $account   = $userModel->findByUsername($_SESSION['agent']);
        if ($account['Password'] !== $current) {
            $this->json(['status' => false, 'msg' => 'Mật khẩu hiện tại không đúng']);
        }

        $userModel->updatePassword($_SESSION['agent'], $new);
        $this->json(['status' => true, 'msg' => 'Đổi mật khẩu thành công']);
    }

    public function index(): void {
        $this->authAgent();
        $userModel  = new User(db_portal());
        $user       = $userModel->findByUsername($_SESSION['agent']);
        $totalUsers = $userModel->count();
        $config     = siteconfig_load();

        $this->view('layouts/agent', [
            'config'       => $config,
            'user'         => $user,
            'content_view' => 'agent/dashboard',
            'totalUsers'   => $totalUsers,
            'downloadCount' => (int)($config['download_count'] ?? 0),
        ]);
    }
}
