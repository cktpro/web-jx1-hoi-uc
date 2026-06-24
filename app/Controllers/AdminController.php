<?php

class AdminController extends Controller {
    public function loginForm(): void {
        if (!empty($_SESSION['blog_admin'])) {
            $this->redirect('/admin');
        }
        $this->view('admin/login');
    }

    public function loginAjax(): void {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $db       = db_portal();

        $stmt = $db->prepare('SELECT * FROM CsmLogins WHERE LoginName = ?');
        $stmt->execute([$username]);
        $row = $stmt->fetch();

        if (!$row || $row['Password'] !== strtoupper(md5($password))) {
            $this->json(['code' => 1, 'msg' => 'Sai tên đăng nhập hoặc mật khẩu']);
        }

        $_SESSION['blog_admin']      = $row['LoginName'];
        $_SESSION['blog_admin_perm'] = (int)($row['Premission'] ?? 1);
        $this->json(['code' => 0, 'msg' => '/admin']);
    }

    public function logout(): void {
        unset($_SESSION['blog_admin'], $_SESSION['blog_admin_perm']);
        $this->redirect('/admin/login');
    }

    public function index(): void {
        $this->authAdmin();
        $db            = db_portal();
        $totalPosts    = $db->query('SELECT COUNT(*) AS c FROM NewsTables')->fetch()['c'] ?? 0;
        $totalUsers    = $db->query('SELECT COUNT(*) AS c FROM LoginTables')->fetch()['c'] ?? 0;
        $config        = siteconfig_load();
        $downloadCount = (int)($config['download_count'] ?? 0);
        $this->view('layouts/admin', [
            'totalPosts'      => $totalPosts,
            'totalCats'       => 0,
            'totalActivities' => 0,
            'totalUsers'      => $totalUsers,
            'downloadCount'   => $downloadCount,
            'content_view'    => 'admin/dashboard',
        ]);
    }

    public function posts(): void {
        $this->authAdmin();
        $page  = max(1, (int)($_GET['p'] ?? 1));
        $limit = 20;
        $posts = (new Post(db_portal()))->getRecent($limit, ($page - 1) * $limit);
        $this->view('layouts/admin', [
            'posts'        => $posts,
            'page'         => $page,
            'featured'     => featured_load(),
            'content_view' => 'admin/posts',
        ]);
    }

    public function featuredToggleAjax(): void {
        $this->authAdmin();
        $id  = (int)($_POST['id'] ?? 0);
        if (!$id) { $this->json(['status' => false]); return; }
        $ids = featured_load();
        if (in_array($id, $ids)) {
            $ids = array_filter($ids, fn($v) => $v !== $id);
        } else {
            $ids[] = $id;
        }
        featured_save($ids);
        $this->json(['status' => true, 'active' => in_array($id, featured_load())]);
    }

    public function addPostForm(): void {
        $this->authAdmin();
        $this->view('layouts/admin', ['content_view' => 'admin/add-post']);
    }

    public function addPost(): void {
        $this->authAdmin();
        (new Post(db_portal()))->create([
            'category' => trim($_POST['postCategory'] ?? ''),
            'title'    => trim($_POST['postTitle'] ?? ''),
            'content'  => $_POST['postCont'] ?? '',
            'slug'     => trim($_POST['postSlug'] ?? ''),
        ]);
        $this->redirect('/admin/posts');
    }

    public function editPostForm(int $id): void {
        $this->authAdmin();
        $post = (new Post(db_portal()))->findById($id);
        if (!$post) {
            $this->redirect('/admin/posts');
        }
        $this->view('layouts/admin', [
            'post'         => $post,
            'content_view' => 'admin/edit-post',
        ]);
    }

    public function editPost(int $id): void {
        $this->authAdmin();
        (new Post(db_portal()))->update($id, [
            'category' => trim($_POST['postCategory'] ?? ''),
            'title'    => trim($_POST['postTitle'] ?? ''),
            'content'  => $_POST['postCont'] ?? '',
            'slug'     => trim($_POST['postSlug'] ?? ''),
        ]);
        $this->redirect('/admin/posts');
    }

    public function checkSlugAjax(): void {
        $this->authAdmin();
        $slug      = trim($_POST['slug'] ?? '');
        $excludeId = (int)($_POST['exclude_id'] ?? 0);

        if (!$slug) {
            $this->json(['exists' => false]);
        }

        $exists = (new Post(db_portal()))->slugExists($slug, $excludeId);
        $this->json(['exists' => $exists]);
    }

    public function editPostAjax(int $id): void {
        $this->authAdmin();
        $title    = trim($_POST['postTitle'] ?? '');
        $category = trim($_POST['postCategory'] ?? '');
        $content  = $_POST['postCont'] ?? '';
        $slug     = trim($_POST['postSlug'] ?? '');

        if (!$title) {
            $this->json(['status' => false, 'msg' => 'Tiêu đề không được để trống']);
        }

        (new Post(db_portal()))->update($id, [
            'category' => $category,
            'title'    => $title,
            'content'  => $content,
            'slug'     => $slug,
        ]);

        $this->json(['status' => true, 'msg' => 'Đã lưu thành công']);
    }

    public function deletePost(int $id): void {
        $this->authAdmin();
        (new Post(db_portal()))->delete($id);
        $this->redirect('/admin/posts');
    }

    public function config(): void {
        $this->authFullAdmin();
        $this->view('layouts/admin', [
            'cfg'          => siteconfig_load(),
            'content_view' => 'admin/config',
        ]);
    }

    public function configSaveAjax(): void {
        $this->authFullAdmin();
        $current = siteconfig_load();
        $fields  = ['taigame', 'taigameios', 'link_dangky', 'link_hotro', 'img_maintenance', 'img_tongkim', 'link_tongkim'];
        foreach ($fields as $f) {
            if (isset($_POST[$f])) {
                $current[$f] = trim($_POST[$f]);
            }
        }
        siteconfig_save($current);
        $this->json(['status' => true, 'msg' => 'Đã lưu cấu hình']);
    }

    // Slide, SEO, hoạt động — chưa có bảng tương ứng trong SQL Server schema
    public function slide(): void {
        $this->authAdmin();
        $this->view('layouts/admin', [
            'slide'        => [],
            'duoi'         => [],
            'content_view' => 'admin/slide',
        ]);
    }

    public function slideSave(): void {
        $this->authAdmin();
        $this->redirect('/admin/slide?saved=1');
    }

    public function seo(): void {
        $this->authFullAdmin();
        $this->view('layouts/admin', [
            'cfg'          => siteconfig_load(),
            'content_view' => 'admin/seo',
        ]);
    }

    public function seoSaveAjax(): void {
        $this->authFullAdmin();
        $current = siteconfig_load();
        $fields  = ['title','descr','keywords','og_image','phone','tips',
                    'taigame','taigameios','link_dangky','link_napthe','link_hotro',
                    'link_congdong','link_huongdan','link_huongdan_nap','link_datquyenvip','link_auto',
                    'bank_name','bank_number','bank_owner','bank_content','momo_number','momo_owner','keyapi',
                    'download_count'];
        foreach ($fields as $f) {
            if (array_key_exists($f, $_POST)) {
                $current[$f] = trim($_POST[$f]);
            }
        }
        siteconfig_save($current);
        $this->json(['status' => true, 'msg' => 'Đã lưu cài đặt SEO']);
    }

    public function faviconUploadAjax(): void {
        $this->authFullAdmin();
        if (empty($_FILES['favicon']) || $_FILES['favicon']['error'] !== UPLOAD_ERR_OK) {
            $this->json(['status' => false, 'msg' => 'Không nhận được file']);
        }
        $file = $_FILES['favicon'];
        $allowed = ['image/x-icon', 'image/vnd.microsoft.icon', 'image/png', 'image/jpeg'];
        $mime    = mime_content_type($file['tmp_name']);
        if (!in_array($mime, $allowed)) {
            $this->json(['status' => false, 'msg' => 'Chỉ chấp nhận file .ico hoặc .png']);
        }
        if ($file['size'] > 512 * 1024) {
            $this->json(['status' => false, 'msg' => 'File không được vượt quá 512KB']);
        }
        $dest = APP_PATH . '/public/favicon.ico';
        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            $this->json(['status' => false, 'msg' => 'Lưu file thất bại, kiểm tra quyền ghi thư mục']);
        }
        $cfg = siteconfig_load();
        $cfg['favicon'] = '/favicon.ico';
        siteconfig_save($cfg);
        $this->json(['status' => true, 'msg' => 'Đã cập nhật favicon']);
    }

    public function hoatdong(): void {
        $this->authAdmin();
        $this->view('layouts/admin', [
            'list'         => hoatdong_load(),
            'content_view' => 'admin/hoatdong',
        ]);
    }

    public function hoatdongSave(): void {
        $this->authAdmin();
        $id   = (int)($_POST['id'] ?? -1);
        $days = ['t2','t3','t4','t5','t6','t7','cn'];
        $item = [
            'ten'     => trim($_POST['ten'] ?? ''),
            'thoigian'=> trim($_POST['thoigian'] ?? ''),
            'sapxep'  => (int)($_POST['sapxep'] ?? 0),
        ];
        foreach ($days as $d) {
            $item[$d] = isset($_POST[$d]) ? 1 : 0;
        }

        $list = hoatdong_load();
        if ($id >= 0 && array_key_exists($id, $list)) {
            $list[$id] = $item;
        } else {
            $list[] = $item;
        }
        usort($list, fn($a, $b) => $a['sapxep'] <=> $b['sapxep']);
        hoatdong_save($list);
        $this->redirect('/admin/hoatdong');
    }

    public function hoatdongDelete(int $id): void {
        $this->authAdmin();
        $list = hoatdong_load();
        array_splice($list, $id, 1);
        hoatdong_save($list);
        $this->redirect('/admin/hoatdong');
    }

    public function agents(): void {
        $this->authFullAdmin();
        $search = trim($_GET['q'] ?? '');
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $limit  = 20;
        $offset = ($page - 1) * $limit;

        $userModel = new User(db_portal());
        $agents    = $userModel->getAllAgentsAdmin($limit, $offset, $search);
        $total     = $userModel->countAgentsAdmin($search);

        $this->view('layouts/admin', [
            'agents'       => $agents,
            'total'        => $total,
            'page'         => $page,
            'limit'        => $limit,
            'search'       => $search,
            'content_view' => 'admin/agents',
        ]);
    }

    public function agentCreateAjax(): void {
        $this->authAdmin();
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $phone    = trim($_POST['phone'] ?? '');
        $roleId   = (int)($_POST['role'] ?? 1);

        if (!$username || !$password) {
            $this->json(['status' => false, 'msg' => 'Vui lòng nhập đầy đủ thông tin']);
        }
        if (strlen($password) < 6) {
            $this->json(['status' => false, 'msg' => 'Mật khẩu phải từ 6 ký tự']);
        }
        if (!in_array($roleId, [1, 3])) {
            $this->json(['status' => false, 'msg' => 'Loại đại lý không hợp lệ']);
        }

        $userModel = new User(db_portal());
        if ($userModel->usernameExists($username)) {
            $this->json(['status' => false, 'msg' => 'Tên tài khoản đã tồn tại']);
        }

        $userModel->createAgent($username, strtoupper(md5($password)), $phone, $roleId);
        $this->json(['status' => true, 'msg' => "Đã tạo tài khoản đại lý $username"]);
    }

    public function admins(): void {
        $this->authFullAdmin();
        $db    = db_portal();
        $admins = $db->query('SELECT * FROM CsmLogins ORDER BY ID DESC')->fetchAll();
        $this->view('layouts/admin', [
            'admins'       => $admins,
            'content_view' => 'admin/admins',
        ]);
    }

    public function adminCreateAjax(): void {
        $this->authFullAdmin();
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (!$username || !$password) {
            $this->json(['status' => false, 'msg' => 'Vui lòng nhập đầy đủ thông tin']);
        }
        if (strlen($password) < 6) {
            $this->json(['status' => false, 'msg' => 'Mật khẩu phải từ 6 ký tự']);
        }

        $db  = db_portal();
        $row = $db->prepare('SELECT ID FROM CsmLogins WHERE LoginName = ?');
        $row->execute([$username]);
        if ($row->fetch()) {
            $this->json(['status' => false, 'msg' => 'Tên tài khoản đã tồn tại']);
        }

        $stmt = $db->prepare('INSERT INTO CsmLogins (LoginName, Password, Premission, RegTime) VALUES (?, ?, ?, ?)');
        $stmt->execute([$username, strtoupper(md5($password)), 2, date('Y-m-d H:i:s')]);
        $this->json(['status' => true, 'msg' => "Đã tạo admin $username (quyền tin tức)"]);
    }

    public function adminDeleteAjax(): void {
        $this->authFullAdmin();
        $username = trim($_POST['username'] ?? '');

        if (!$username) {
            $this->json(['status' => false, 'msg' => 'Thiếu tên tài khoản']);
        }
        if ($username === ($_SESSION['blog_admin'] ?? '')) {
            $this->json(['status' => false, 'msg' => 'Không thể xoá tài khoản đang đăng nhập']);
        }

        $db   = db_portal();
        $stmt = $db->prepare('SELECT Premission FROM CsmLogins WHERE LoginName = ?');
        $stmt->execute([$username]);
        $target = $stmt->fetch();
        if (!$target) {
            $this->json(['status' => false, 'msg' => 'Tài khoản không tồn tại']);
        }
        if ((int)($target['Premission'] ?? 1) === 1) {
            $this->json(['status' => false, 'msg' => 'Không thể xoá admin full quyền']);
        }

        $db->prepare('DELETE FROM CsmLogins WHERE LoginName = ?')->execute([$username]);
        $this->json(['status' => true, 'msg' => "Đã xoá admin $username"]);
    }

    public function agentSetRoleAjax(): void {
        $this->authAdmin();
        $username = trim($_POST['username'] ?? '');
        $roleId   = (int)($_POST['role'] ?? 0);

        if (!$username || !in_array($roleId, [1, 3])) {
            $this->json(['status' => false, 'msg' => 'Dữ liệu không hợp lệ']);
        }

        $userModel = new User(db_portal());
        if (!$userModel->findByUsername($username)) {
            $this->json(['status' => false, 'msg' => 'Tài khoản không tồn tại']);
        }

        $userModel->setRole($username, $roleId);
        $label = $roleId === 3 ? 'Đại lý tổng' : 'Đại lý';
        $this->json(['status' => true, 'msg' => "Đã cập nhật quyền $username thành $label"]);
    }

    public function agentDeleteAjax(): void {
        $this->authAdmin();
        $username = trim($_POST['username'] ?? '');
        if (!$username) {
            $this->json(['status' => false, 'msg' => 'Thiếu tên tài khoản']);
        }
        $userModel = new User(db_portal());
        if (!$userModel->findByUsername($username)) {
            $this->json(['status' => false, 'msg' => 'Tài khoản không tồn tại']);
        }
        $userModel->deleteAgent($username);
        $this->json(['status' => true, 'msg' => "Đã xoá đại lý $username"]);
    }

    public function agentTopupAjax(): void {
        $this->authAdmin();
        $username = trim($_POST['username'] ?? '');
        $amount   = (int)($_POST['amount'] ?? 0);

        if (!$username || $amount <= 0) {
            $this->json(['status' => false, 'msg' => 'Vui lòng nhập đầy đủ thông tin']);
        }

        $userModel = new User(db_portal());
        $account   = $userModel->findByUsername($username);
        if (!$account) {
            $this->json(['status' => false, 'msg' => 'Tài khoản không tồn tại']);
        }
        if (!in_array((int)($account['ActiveRoleID'] ?? 0), [1, 3])) {
            $this->json(['status' => false, 'msg' => 'Tài khoản này không phải đại lý']);
        }

        $before = $userModel->getKCoin($username);
        $after  = $before + $amount;
        $userModel->updateCoins($username, $amount);
        $userModel->logAdminTopup((int)$account['ID'], $username, $amount, $before, $after, $_SESSION['blog_admin'] ?? 'admin');

        $this->json(['status' => true, 'msg' => "Đã nạp $amount KNB cho $username. Số dư: $after KNB"]);
    }
}
