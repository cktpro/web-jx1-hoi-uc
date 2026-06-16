<?php

class PostController extends Controller {
    public function show(string $slug): void {
        $db   = db_portal();
        $post = (new Post($db))->findBySlug($slug);

        if (!$post) {
            http_response_code(404);
            $this->view('layouts/404');
            return;
        }

        $config  = siteconfig_load();
        $related = (new Post($db))->getByCategory($post['Catagory'], 4);

        $this->view('layouts/post', [
            'config'       => $config,
            'post'         => $post,
            'categories'   => [],
            'related'      => $related,
            'content_view' => 'post/view',
        ]);
    }

    public function category(): void {
        $slug   = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $db     = db_portal();
        $page   = max(1, (int)($_GET['p'] ?? 1));
        $limit  = 20;
        $offset = ($page - 1) * $limit;

        $postModel = new Post($db);
        $posts     = $postModel->getByCategory($slug, $limit, $offset);
        $total     = $postModel->countByCategory($slug);
        $config    = siteconfig_load();

        $this->view('layouts/category', [
            'config'       => $config,
            'category'     => ['catSlug' => $slug, 'catTitle' => $slug],
            'allCats'      => [],
            'posts'        => $posts,
            'total'        => $total,
            'page'         => $page,
            'limit'        => $limit,
            'content_view' => 'post/category',
        ]);
    }

    public function tag(string $tag): void {
        $db     = db_portal();
        $posts  = (new Post($db))->search($tag);
        $config = (new SiteConfig($db))->get();
        $this->view('layouts/main', [
            'config'       => $config,
            'tag'          => $tag,
            'posts'        => $posts,
            'content_view' => 'post/tag',
        ]);
    }
}
