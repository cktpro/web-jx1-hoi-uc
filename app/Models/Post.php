<?php

// NewsTables: ID, Catagory (varchar), Title, Context, DateTime
class Post extends Model {
    public function getRecent(int $limit = 20, int $offset = 0): array {
        return $this->query(
            "SELECT * FROM NewsTables
             ORDER BY ID DESC
             OFFSET $offset ROWS FETCH NEXT $limit ROWS ONLY"
        );
    }

    public function getByCategory(string $category, int $limit = 20, int $offset = 0): array {
        return $this->query(
            "SELECT * FROM NewsTables
             WHERE Catagory = ?
             ORDER BY ID DESC
             OFFSET $offset ROWS FETCH NEXT $limit ROWS ONLY",
            [$category]
        );
    }

    public function countByCategory(string $category): int {
        $row = $this->queryOne(
            'SELECT COUNT(*) AS c FROM NewsTables WHERE Catagory = ?',
            [$category]
        );
        return (int)($row['c'] ?? 0);
    }

    public function findById(int $id): ?array {
        return $this->queryOne('SELECT * FROM NewsTables WHERE ID = ?', [$id]);
    }

    public function findBySlug(string $slug): ?array {
        return $this->queryOne('SELECT * FROM NewsTables WHERE Slug = ?', [$slug]);
    }

    public function create(array $data): bool {
        $slug = $data['slug'] ?? url_slug($data['title'] ?? '');
        return $this->execute(
            'INSERT INTO NewsTables (Catagory, Title, Context, Slug, DateTime)
             VALUES (?, ?, ?, ?, GETDATE())',
            [$data['category'], $data['title'], $data['content'], $slug]
        );
    }

    public function getLastId(): int {
        $row = $this->queryOne('SELECT SCOPE_IDENTITY() AS id');
        return (int)($row['id'] ?? 0);
    }

    public function update(int $id, array $data): bool {
        $slug = $data['slug'] ?? url_slug($data['title'] ?? '');
        return $this->execute(
            'UPDATE NewsTables SET Catagory = ?, Title = ?, Context = ?, Slug = ? WHERE ID = ?',
            [$data['category'], $data['title'], $data['content'], $slug, $id]
        );
    }

    public function delete(int $id): bool {
        return $this->execute('DELETE FROM NewsTables WHERE ID = ?', [$id]);
    }

    public function findByIds(array $ids): array {
        if (empty($ids)) return [];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        return $this->query(
            "SELECT * FROM NewsTables WHERE ID IN ($placeholders) ORDER BY ID DESC",
            array_map('intval', $ids)
        );
    }

    public function search(string $keyword, int $limit = 20): array {
        return $this->query(
            "SELECT * FROM NewsTables
             WHERE Title LIKE ? OR Context LIKE ?
             ORDER BY ID DESC
             OFFSET 0 ROWS FETCH NEXT $limit ROWS ONLY",
            ["%$keyword%", "%$keyword%"]
        );
    }

    public function getCategories(): array {
        $rows = $this->query('SELECT DISTINCT Catagory FROM NewsTables ORDER BY Catagory');
        return array_column($rows, 'Catagory');
    }
}
