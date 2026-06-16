<?php

class Controller {
    protected function view(string $view, array $data = []): void {
        extract($data);
        $viewFile = APP_PATH . '/app/Views/' . $view . '.php';
        if (!file_exists($viewFile)) {
            throw new RuntimeException("View not found: $view");
        }
        include $viewFile;
    }

    protected function json(mixed $data, int $status = 200): void {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    protected function redirect(string $url): void {
        header("Location: $url");
        exit;
    }

    protected function authUser(): void {
        if (empty($_SESSION['username'])) {
            $this->redirect('/user/login');
        }
    }

    protected function authAdmin(): void {
        if (empty($_SESSION['blog_admin'])) {
            $this->redirect('/admin/login');
        }
    }

    protected function authAgent(): void {
        if (empty($_SESSION['agent'])) {
            $this->redirect('/dai-ly/login');
        }
    }

    protected function isSuperAgent(): bool {
        return (int)($_SESSION['agent_role'] ?? 0) === 3;
    }

    protected function authSuperAgent(): void {
        $this->authAgent();
        if (!$this->isSuperAgent()) {
            $this->redirect('/dai-ly');
        }
    }

    protected function authGameAdmin(): void {
        if (empty($_SESSION['useradmin']) || ($_SESSION['admin'] ?? '') !== '2205') {
            $this->redirect('/game-admin/login');
        }
    }
}
