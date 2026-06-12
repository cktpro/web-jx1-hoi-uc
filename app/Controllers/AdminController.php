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
        $db = db_blog();
        $user = $db->prepare('SELECT * FROM blog_users WHERE userLogin = ? LIMIT 1');
        $user->execute([$username]);
        $row = $user->fetch();
        if (!$row || !password_verify($password, $row['userPass'])) {
            $this->json(['code' => 1, 'msg' => 'Sai tên đăng nhập hoặc mật khẩu']);
        }
        $_SESSION['blog_admin'] = $row['userLogin'];
        $this->json(['code' => 0, 'msg' => '/admin']);
    }

    public function logout(): void {
        unset($_SESSION['blog_admin']);
        $this->redirect('/admin/login');
    }

    public function index(): void {
        $this->authAdmin();
        $db = db_blog();
        $totalPosts      = $db->query('SELECT COUNT(*) FROM blog_posts_seo')->fetchColumn();
        $totalCats       = $db->query('SELECT COUNT(*) FROM blog_cats')->fetchColumn();
        $totalActivities = $db->query('SELECT COUNT(*) FROM blog_hoatdong')->fetchColumn();
        $this->view('layouts/admin', [
            'totalPosts'      => $totalPosts,
            'totalCats'       => $totalCats,
            'totalActivities' => $totalActivities,
            'content_view'    => 'admin/dashboard',
        ]);
    }

    public function posts(): void {
        $this->authAdmin();
        $db = db_blog();
        $page = max(1, (int)($_GET['p'] ?? 1));
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $posts = (new Post($db))->getRecent($limit, $offset);
        $this->view('layouts/admin', [
            'posts'        => $posts,
            'page'         => $page,
            'content_view' => 'admin/posts',
        ]);
    }

    public function addPostForm(): void {
        $this->authAdmin();
        $db = db_blog();
        $cats = $db->query('SELECT * FROM blog_cats')->fetchAll();
        $this->view('layouts/admin', [
            'cats'         => $cats,
            'content_view' => 'admin/add-post',
        ]);
    }

    public function addPost(): void {
        $this->authAdmin();
        $db = db_blog();
        $slug = url_slug($_POST['postTitle'] ?? '');
        (new Post($db))->create([
            'title'   => $_POST['postTitle'] ?? '',
            'slug'    => $slug,
            'content' => $_POST['postCont'] ?? '',
            'desc'    => $_POST['postDesc'] ?? '',
            'image'   => $_POST['postImage'] ?? '',
            'tags'    => $_POST['postTags'] ?? '',
        ]);
        $postId = $db->lastInsertId();
        if (!empty($_POST['cats'])) {
            foreach ((array)$_POST['cats'] as $catId) {
                $db->prepare('INSERT INTO blog_post_cats (postID, catID) VALUES (?, ?)')->execute([$postId, $catId]);
            }
        }
        $this->redirect('/admin/posts');
    }

    public function editPostForm(int $id): void {
        $this->authAdmin();
        $db   = db_blog();
        $post = (new Post($db))->findById($id);
        if (!$post) { $this->redirect('/admin/posts'); }
        $cats        = $db->query('SELECT * FROM blog_cats')->fetchAll();
        $postCatIds  = array_column(
            $db->prepare('SELECT catID FROM blog_post_cats WHERE postID=?')->execute([$id]) ? [] : [],
            'catID'
        );
        $stmt = $db->prepare('SELECT catID FROM blog_post_cats WHERE postID=?');
        $stmt->execute([$id]);
        $postCatIds = array_column($stmt->fetchAll(), 'catID');
        $this->view('layouts/admin', [
            'post'       => $post,
            'cats'       => $cats,
            'postCatIds' => $postCatIds,
            'content_view' => 'admin/edit-post',
        ]);
    }

    public function editPost(int $id): void {
        $this->authAdmin();
        $db   = db_blog();
        $slug = url_slug($_POST['postTitle'] ?? '');
        (new Post($db))->update($id, [
            'title'   => $_POST['postTitle'] ?? '',
            'slug'    => $slug,
            'content' => $_POST['postCont'] ?? '',
            'desc'    => $_POST['postDesc'] ?? '',
            'image'   => $_POST['postImage'] ?? '',
            'tags'    => $_POST['postTags'] ?? '',
        ]);
        $db->prepare('DELETE FROM blog_post_cats WHERE postID=?')->execute([$id]);
        if (!empty($_POST['cats'])) {
            foreach ((array)$_POST['cats'] as $catId) {
                $db->prepare('INSERT INTO blog_post_cats (postID, catID) VALUES (?, ?)')->execute([$id, $catId]);
            }
        }
        $this->redirect('/admin/posts');
    }

    public function deletePost(int $id): void {
        $this->authAdmin();
        (new Post(db_blog()))->delete($id);
        $this->redirect('/admin/posts');
    }

    public function slide(): void {
        $this->authAdmin();
        $db    = db_blog();
        $slide = $db->query('SELECT * FROM blog_slide LIMIT 1')->fetch() ?: [];
        $duoi  = $db->query('SELECT * FROM blog_slide_duoi LIMIT 1')->fetch() ?: [];
        $this->view('layouts/admin', [
            'slide'        => $slide,
            'duoi'         => $duoi,
            'content_view' => 'admin/slide',
        ]);
    }

    public function slideSave(): void {
        $this->authAdmin();
        $db = db_blog();

        // Slide PC
        $slideData = [];
        for ($i = 1; $i <= 4; $i++) {
            $slideData["slide_img$i"]  = trim($_POST["slide_img$i"]  ?? '');
            $slideData["slide_link$i"] = trim($_POST["slide_link$i"] ?? '');
        }
        $slideCount = $db->query('SELECT COUNT(*) FROM blog_slide')->fetchColumn();
        if ($slideCount > 0) {
            $sets = implode(', ', array_map(fn($k) => "$k=?", array_keys($slideData)));
            $db->prepare("UPDATE blog_slide SET $sets LIMIT 1")->execute(array_values($slideData));
        } else {
            $cols = implode(', ', array_keys($slideData));
            $phs  = implode(', ', array_fill(0, count($slideData), '?'));
            $db->prepare("INSERT INTO blog_slide ($cols) VALUES ($phs)")->execute(array_values($slideData));
        }

        // Slide mobile
        $duoiData = [];
        for ($i = 0; $i <= 4; $i++) {
            $key = $i === 0 ? 'slide_duoi_img' : "slide_duoi_img$i";
            $duoiData[$key] = trim($_POST[$key] ?? '');
        }
        $duoiCount = $db->query('SELECT COUNT(*) FROM blog_slide_duoi')->fetchColumn();
        if ($duoiCount > 0) {
            $sets = implode(', ', array_map(fn($k) => "$k=?", array_keys($duoiData)));
            $db->prepare("UPDATE blog_slide_duoi SET $sets LIMIT 1")->execute(array_values($duoiData));
        } else {
            $cols = implode(', ', array_keys($duoiData));
            $phs  = implode(', ', array_fill(0, count($duoiData), '?'));
            $db->prepare("INSERT INTO blog_slide_duoi ($cols) VALUES ($phs)")->execute(array_values($duoiData));
        }

        $this->redirect('/admin/slide?saved=1');
    }

    public function seo(): void {
        $this->authAdmin();
        $db  = db_blog();
        $cfg = $db->query('SELECT * FROM blog_cauhinh LIMIT 1')->fetch();
        $this->view('layouts/admin', [
            'cfg'          => $cfg,
            'content_view' => 'admin/seo',
        ]);
    }

    public function seoSave(): void {
        $this->authAdmin();
        $db = db_blog();
        $fields = ['title','descr','keywords','og_image','taigame','taigameios',
                   'link_dangky','link_napthe','link_hotro','link_congdong',
                   'link_huongdan','link_huongdan_nap','link_datquyenvip',
                   'link_auto','phone','tips'];
        $sets  = implode(', ', array_map(fn($f) => "$f = ?", $fields));
        $vals  = array_map(fn($f) => trim($_POST[$f] ?? ''), $fields);
        $count = $db->query('SELECT COUNT(*) FROM blog_cauhinh')->fetchColumn();
        if ($count > 0) {
            $db->prepare("UPDATE blog_cauhinh SET $sets LIMIT 1")->execute($vals);
        } else {
            $cols = implode(', ', $fields);
            $phs  = implode(', ', array_fill(0, count($fields), '?'));
            $db->prepare("INSERT INTO blog_cauhinh ($cols) VALUES ($phs)")->execute($vals);
        }
        $this->redirect('/admin/seo?saved=1');
    }

    public function hoatdong(): void {
        $this->authAdmin();
        $db = db_blog();
        $list = $db->query('SELECT * FROM blog_hoatdong ORDER BY sapxep ASC')->fetchAll();
        $this->view('layouts/admin', [
            'list'         => $list,
            'content_view' => 'admin/hoatdong',
        ]);
    }

    public function hoatdongSave(): void {
        $this->authAdmin();
        $db = db_blog();
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            $_POST['ten'] ?? '',
            isset($_POST['t2']) ? 1 : 0,
            isset($_POST['t3']) ? 1 : 0,
            isset($_POST['t4']) ? 1 : 0,
            isset($_POST['t5']) ? 1 : 0,
            isset($_POST['t6']) ? 1 : 0,
            isset($_POST['t7']) ? 1 : 0,
            isset($_POST['cn']) ? 1 : 0,
            $_POST['thoigian'] ?? 'UPDATE',
            (int)($_POST['sapxep'] ?? 0),
        ];
        if ($id > 0) {
            $db->prepare('UPDATE blog_hoatdong SET ten=?,t2=?,t3=?,t4=?,t5=?,t6=?,t7=?,cn=?,thoigian=?,sapxep=? WHERE id=?')
               ->execute([...$data, $id]);
        } else {
            $db->prepare('INSERT INTO blog_hoatdong (ten,t2,t3,t4,t5,t6,t7,cn,thoigian,sapxep) VALUES (?,?,?,?,?,?,?,?,?,?)')
               ->execute($data);
        }
        $this->redirect('/admin/hoatdong');
    }

    public function hoatdongDelete(int $id): void {
        $this->authAdmin();
        db_blog()->prepare('DELETE FROM blog_hoatdong WHERE id=?')->execute([$id]);
        $this->redirect('/admin/hoatdong');
    }
}
