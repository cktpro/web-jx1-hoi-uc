<?php

class Post extends Model {
    public function getRecent(int $limit = 20, int $offset = 0): array {
        return $this->query(
            'SELECT * FROM blog_posts_seo ORDER BY postID DESC LIMIT ? OFFSET ?',
            [$limit, $offset]
        );
    }

    public function getByCategory(int $catId, int $limit = 20, int $offset = 0): array {
        return $this->query(
            'SELECT p.* FROM blog_posts_seo p
             JOIN blog_post_cats pc ON p.postID = pc.postID
             WHERE pc.catID = ?
             ORDER BY p.postID DESC LIMIT ? OFFSET ?',
            [$catId, $limit, $offset]
        );
    }

    public function countByCategory(int $catId): int {
        $row = $this->queryOne(
            'SELECT COUNT(*) as c FROM blog_post_cats WHERE catID = ?',
            [$catId]
        );
        return (int)($row['c'] ?? 0);
    }

    public function findBySlug(string $slug): ?array {
        return $this->queryOne(
            'SELECT * FROM blog_posts_seo WHERE postSlug = ?',
            [$slug]
        );
    }

    public function findById(int $id): ?array {
        return $this->queryOne(
            'SELECT * FROM blog_posts_seo WHERE postID = ?',
            [$id]
        );
    }

    public function getCategories(int $postId): array {
        return $this->query(
            'SELECT c.catTitle, c.catSlug FROM blog_cats c
             JOIN blog_post_cats pc ON c.catID = pc.catID
             WHERE pc.postID = ?',
            [$postId]
        );
    }

    public function create(array $data): bool {
        return $this->execute(
            'INSERT INTO blog_posts_seo (postTitle, postSlug, postCont, postDesc, postImage, postDate, postTags)
             VALUES (?, ?, ?, ?, ?, NOW(), ?)',
            [$data['title'], $data['slug'], $data['content'], $data['desc'], $data['image'], $data['tags']]
        );
    }

    public function update(int $id, array $data): bool {
        return $this->execute(
            'UPDATE blog_posts_seo SET postTitle=?, postSlug=?, postCont=?, postDesc=?, postImage=?, postTags=?
             WHERE postID=?',
            [$data['title'], $data['slug'], $data['content'], $data['desc'], $data['image'], $data['tags'], $id]
        );
    }

    public function delete(int $id): bool {
        return $this->execute('DELETE FROM blog_posts_seo WHERE postID = ?', [$id]);
    }

    public function search(string $keyword, int $limit = 20): array {
        return $this->query(
            'SELECT * FROM blog_posts_seo WHERE postTitle LIKE ? OR postCont LIKE ? LIMIT ?',
            ["%$keyword%", "%$keyword%", $limit]
        );
    }
}
