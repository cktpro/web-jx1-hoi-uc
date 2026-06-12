<?php

class HomeController extends Controller {
    public function index(): void {
        $db = db_blog();
        $post = new Post($db);
        $config = (new SiteConfig(db_portal()))->getBlog($db);

        $slidesStmt = $db->query('SELECT * FROM blog_slide LIMIT 1');
        $slides = $slidesStmt->fetch() ?: [];
        $slidesBottomStmt = $db->query('SELECT * FROM blog_slide_duoi LIMIT 1');
        $slidesBottom = $slidesBottomStmt->fetch() ?: [];

        $news     = $post->getByCategory(5, 20);
        $events   = $post->getByCategory(4, 20);
        $guides   = $post->getByCategory(1, 20);
        $features = $post->getByCategory(2, 20);

        $this->view('layouts/main', [
            'config'       => $config,
            'slides'       => $slides,
            'slidesBottom' => $slidesBottom,
            'news'         => $news,
            'events'       => $events,
            'guides'       => $guides,
            'features'     => $features,
            'content_view' => 'home/index',
        ]);
    }

    public function search(): void {
        $keyword = trim($_GET['keyword'] ?? '');
        $db = db_blog();
        $results = $keyword ? (new Post($db))->search($keyword) : [];
        $config = (new SiteConfig(db_portal()))->getBlog($db);
        $this->view('layouts/main', [
            'config'       => $config,
            'keyword'      => $keyword,
            'results'      => $results,
            'content_view' => 'home/search',
        ]);
    }
}
