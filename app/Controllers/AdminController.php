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

        if (!$row || $row['Password'] !== $password) {
            $this->json(['code' => 1, 'msg' => 'Sai tên đăng nhập hoặc mật khẩu']);
        }

        $_SESSION['blog_admin'] = $row['LoginName'];
        $this->json(['code' => 0, 'msg' => '/admin']);
    }

    public function logout(): void {
        unset($_SESSION['blog_admin']);
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
        $this->authAdmin();
        $this->view('layouts/admin', [
            'cfg'          => siteconfig_load(),
            'content_view' => 'admin/config',
        ]);
    }

    public function configSaveAjax(): void {
        $this->authAdmin();
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
        $this->authAdmin();
        $this->view('layouts/admin', [
            'cfg'          => siteconfig_load(),
            'content_view' => 'admin/seo',
        ]);
    }

    public function seoSaveAjax(): void {
        $this->authAdmin();
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
        $this->authAdmin();
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
}
