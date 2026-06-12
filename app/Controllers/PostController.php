<?php

class PostController extends Controller {
    public function show(string $slug): void {
        $db = db_blog();
        $post = (new Post($db))->findBySlug($slug);
        if (!$post) {
            http_response_code(404);
            $this->view('layouts/404');
            return;
        }
        $categories = (new Post($db))->getCategories($post['postID']);
        $config     = (new SiteConfig(db_portal()))->getBlog($db);
        // Bài liên quan: cùng danh mục, ưu tiên cùng cat
        $stmt = $db->prepare(
            'SELECT p.postID, p.postTitle, p.postSlug, p.postDate, p.postImage
             FROM blog_posts_seo p
             JOIN blog_post_cats pc ON p.postID = pc.postID
             WHERE pc.catID IN (
                 SELECT catID FROM blog_post_cats WHERE postID = ?
             ) AND p.postID != ?
             GROUP BY p.postID
             ORDER BY p.postID DESC LIMIT 4'
        );
        $stmt->execute([$post['postID'], $post['postID']]);
        $related = $stmt->fetchAll();
        // fallback nếu không đủ 4 bài cùng cat
        if (count($related) < 4) {
            $exclude = array_merge([$post['postID']], array_column($related, 'postID') ?: [0]);
            $in      = implode(',', array_fill(0, count($exclude), '?'));
            $extra   = $db->prepare(
                "SELECT postTitle, postSlug, postDate, postImage FROM blog_posts_seo
                 WHERE postID NOT IN ($in) ORDER BY postID DESC LIMIT " . (4 - count($related))
            );
            $extra->execute($exclude);
            $related = array_merge($related, $extra->fetchAll());
        }
        $this->view('layouts/post', [
            'config'       => $config,
            'post'         => $post,
            'categories'   => $categories,
            'related'      => $related,
            'content_view' => 'post/view',
        ]);
    }

    public function category(): void {
        $slug = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $db   = db_blog();
        $cat  = $db->prepare('SELECT * FROM blog_cats WHERE catSlug = ?');
        $cat->execute([$slug]);
        $category = $cat->fetch();
        if (!$category) {
            http_response_code(404);
            $this->view('layouts/404');
            return;
        }
        $page      = max(1, (int)($_GET['p'] ?? 1));
        $limit     = 20;
        $offset    = ($page - 1) * $limit;
        $postModel = new Post($db);
        $posts     = $postModel->getByCategory($category['catID'], $limit, $offset);
        $total     = $postModel->countByCategory($category['catID']);
        $config    = (new SiteConfig(db_portal()))->getBlog($db);
        $allCats   = $db->query('SELECT catID, catTitle, catSlug FROM blog_cats ORDER BY catID ASC')->fetchAll();
        $this->view('layouts/category', [
            'config'       => $config,
            'category'     => $category,
            'allCats'      => $allCats,
            'posts'        => $posts,
            'total'        => $total,
            'page'         => $page,
            'limit'        => $limit,
            'content_view' => 'post/category',
        ]);
    }

    public function tag(string $tag): void {
        $db = db_blog();
        $page = max(1, (int)($_GET['p'] ?? 1));
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $posts = (new Post($db))->search($tag, $limit);
        $config = (new SiteConfig(db_portal()))->getBlog($db);
        $this->view('layouts/main', [
            'config'       => $config,
            'tag'          => $tag,
            'posts'        => $posts,
            'content_view' => 'post/tag',
        ]);
    }
}
