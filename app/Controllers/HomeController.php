<?php

class HomeController extends Controller {
    public function index(): void {
        $db     = db_portal();
        $post   = new Post($db);
        $config = siteconfig_load();

        $news     = $post->getByCategory('tin-tuc', 20);
        $events   = $post->getByCategory('su-kien', 20);
        $guides   = $post->getByCategory('cam-nang', 20);
        $features = $post->findByIds(featured_load());

        $this->view('layouts/main', [
            'config'       => $config,
            'slides'       => [],
            'slidesBottom' => [],
            'news'         => $news,
            'events'       => $events,
            'guides'       => $guides,
            'features'     => $features,
            'content_view' => 'home/index',
        ]);
    }

    public function trackDownload(): void {
        $cfg = siteconfig_load();
        $cfg['download_count'] = (int)($cfg['download_count'] ?? 0) + 1;
        siteconfig_save($cfg);
        $this->json(['ok' => true]);
    }

    public function search(): void {
        $keyword = trim($_GET['keyword'] ?? '');
        $db      = db_portal();
        $results = $keyword ? (new Post($db))->search($keyword) : [];
        $config  = siteconfig_load();
        $this->view('layouts/main', [
            'config'       => $config,
            'slides'       => [],
            'slidesBottom' => [],
            'keyword'      => $keyword,
            'results'      => $results,
            'content_view' => 'home/search',
        ]);
    }
}
