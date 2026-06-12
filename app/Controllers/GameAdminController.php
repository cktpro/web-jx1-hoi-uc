<?php

class GameAdminController extends Controller {
    public function loginForm(): void {
        if (!empty($_SESSION['useradmin'])) {
            $this->redirect('/game-admin');
        }
        $this->view('game-admin/login');
    }

    public function loginAjax(): void {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $db = db_portal();
        $row = $db->prepare('SELECT * FROM gc_admin WHERE username = ? LIMIT 1');
        $row->execute([$username]);
        $admin = $row->fetch();
        if (!$admin || $admin['password'] !== md5($password)) {
            $this->json(['code' => 1, 'msg' => 'Sai tên đăng nhập hoặc mật khẩu']);
        }
        $_SESSION['useradmin'] = $admin['username'];
        $_SESSION['admin'] = '2205';
        $this->json(['code' => 0, 'msg' => '/game-admin']);
    }

    public function logout(): void {
        unset($_SESSION['useradmin'], $_SESSION['admin']);
        $this->redirect('/game-admin/login');
    }

    public function index(): void {
        $this->authGameAdmin();
        $db = db_portal();
        $totalUsers   = $db->query('SELECT COUNT(*) FROM gc_user')->fetchColumn();
        $totalServers = $db->query('SELECT COUNT(*) FROM gc_server')->fetchColumn();
        $revenue      = (new Payment($db))->getRevenue();
        $this->view('layouts/game-admin', [
            'totalUsers'   => $totalUsers,
            'totalServers' => $totalServers,
            'revenue'      => $revenue,
            'content_view' => 'game-admin/dashboard',
        ]);
    }

    public function users(): void {
        $this->authGameAdmin();
        $db = db_portal();
        $page   = max(1, (int)($_GET['p'] ?? 1));
        $limit  = (int)($_GET['limit'] ?? 10);
        $search = $_GET['search'] ?? '';
        $offset = ($page - 1) * $limit;
        $userModel = new User($db);
        $users = $userModel->getAll($limit, $offset, $search);
        $total = $userModel->count($search);
        $this->json(['users' => $users, 'total' => $total]);
    }

    public function addPoints(): void {
        $this->authGameAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user   = trim($_POST['user'] ?? '');
            $amount = (int)($_POST['diem'] ?? 0);
            if ($user && $amount) {
                (new Payment(db_portal()))->addPoints($user, $amount, $_SESSION['useradmin']);
                $this->view('layouts/game-admin', [
                    'success'      => true,
                    'content_view' => 'game-admin/add-points',
                ]);
                return;
            }
        }
        $this->view('layouts/game-admin', [
            'success'      => false,
            'content_view' => 'game-admin/add-points',
        ]);
    }

    public function resetPassword(): void {
        $this->authGameAdmin();
        $user    = trim($_POST['user'] ?? '');
        $newPass = strtoupper(md5($_POST['newpass'] ?? ''));
        if ($user && $_POST['newpass']) {
            $db = db_portal();
            (new User($db))->updatePassword($user, $newPass);
            (new User($db))->updatePortalPassword($user, $newPass);
            $this->json(['status' => true, 'msg' => 'Đặt lại mật khẩu thành công']);
        }
        $this->json(['status' => false, 'msg' => 'Thiếu thông tin']);
    }

    public function servers(): void {
        $this->authGameAdmin();
        $db = db_portal();
        $servers = $db->query('SELECT * FROM gc_server')->fetchAll();
        $this->view('layouts/game-admin', [
            'servers'      => $servers,
            'content_view' => 'game-admin/servers',
        ]);
    }

    public function paymentLogs(): void {
        $this->authGameAdmin();
        $db = db_portal();
        $page  = max(1, (int)($_GET['p'] ?? 1));
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $logs = $db->prepare('SELECT * FROM gc_log ORDER BY id DESC LIMIT ? OFFSET ?');
        $logs->execute([$limit, $offset]);
        $this->view('layouts/game-admin', [
            'logs'         => $logs->fetchAll(),
            'page'         => $page,
            'content_view' => 'game-admin/payment-logs',
        ]);
    }
}
