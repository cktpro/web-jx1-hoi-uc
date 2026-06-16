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
        $db       = db_portal();

        $stmt = $db->prepare('SELECT * FROM CsmLogins WHERE LoginName = ?');
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if (!$admin || $admin['Password'] !== $password) {
            $this->json(['code' => 1, 'msg' => 'Sai tên đăng nhập hoặc mật khẩu']);
        }

        $_SESSION['useradmin'] = $admin['LoginName'];
        $_SESSION['admin']     = '2205';
        $this->json(['code' => 0, 'msg' => '/game-admin']);
    }

    public function logout(): void {
        unset($_SESSION['useradmin'], $_SESSION['admin']);
        $this->redirect('/game-admin/login');
    }

    public function index(): void {
        $this->authGameAdmin();
        $db          = db_portal();
        $totalUsers  = $db->query('SELECT COUNT(*) AS c FROM LoginTables')->fetch()['c'] ?? 0;
        $totalServer = $db->query('SELECT COUNT(*) AS c FROM ServerLists')->fetch()['c'] ?? 0;
        $revenue     = (new Payment($db))->getRevenue();
        $this->view('layouts/game-admin', [
            'totalUsers'   => $totalUsers,
            'totalServers' => $totalServer,
            'revenue'      => $revenue,
            'content_view' => 'game-admin/dashboard',
        ]);
    }

    public function users(): void {
        $this->authGameAdmin();
        $page   = max(1, (int)($_GET['p'] ?? 1));
        $limit  = (int)($_GET['limit'] ?? 10);
        $search = $_GET['search'] ?? '';
        $offset = ($page - 1) * $limit;

        $userModel = new User(db_portal());
        $this->json([
            'users' => $userModel->getAll($limit, $offset, $search),
            'total' => $userModel->count($search),
        ]);
    }

    public function addPoints(): void {
        $this->authGameAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user   = trim($_POST['user'] ?? '');
            $amount = (int)($_POST['diem'] ?? 0);
            if ($user && $amount > 0) {
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
            (new User(db_portal()))->updatePassword($user, $newPass);
            $this->json(['status' => true, 'msg' => 'Đặt lại mật khẩu thành công']);
        }
        $this->json(['status' => false, 'msg' => 'Thiếu thông tin']);
    }

    public function servers(): void {
        $this->authGameAdmin();
        $servers = db_portal()->query('SELECT * FROM ServerLists ORDER BY nServerOrder ASC')->fetchAll();
        $this->view('layouts/game-admin', [
            'servers'      => $servers,
            'content_view' => 'game-admin/servers',
        ]);
    }

    public function paymentLogs(): void {
        $this->authGameAdmin();
        $page   = max(1, (int)($_GET['p'] ?? 1));
        $limit  = 20;
        $offset = ($page - 1) * $limit;
        $logs   = (new Payment(db_portal()))->getAllLogs($limit, $offset);
        $this->view('layouts/game-admin', [
            'logs'         => $logs,
            'page'         => $page,
            'content_view' => 'game-admin/payment-logs',
        ]);
    }
}
