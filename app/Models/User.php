<?php

class User extends Model {
    // Tìm user trong bảng LoginTables (MySQL thay SQL Server)
    public function findByUsername(string $username): ?array {
        return $this->queryOne(
            'SELECT * FROM LoginTables WHERE LoginName = ?',
            [$username]
        );
    }

    public function findPortalUser(string $username): ?array {
        return $this->queryOne(
            'SELECT * FROM gc_user WHERE user = ? LIMIT 1',
            [$username]
        );
    }

    public function createPortalUser(string $username, string $passHash): bool {
        return $this->execute(
            'INSERT INTO gc_user (user, pass) VALUES (?, ?)',
            [$username, $passHash]
        );
    }

    public function updatePassword(string $username, string $newPassHash): bool {
        return $this->execute(
            'UPDATE LoginTables SET Password = ? WHERE LoginName = ?',
            [$newPassHash, $username]
        );
    }

    public function updatePortalPassword(string $username, string $newPassHash): bool {
        return $this->execute(
            'UPDATE gc_user SET pass = ? WHERE user = ?',
            [$newPassHash, $username]
        );
    }

    public function getInfo(string $username): ?array {
        return $this->queryOne(
            'SELECT * FROM gc_user WHERE user = ? LIMIT 1',
            [$username]
        );
    }

    public function getAll(int $limit = 10, int $offset = 0, string $search = ''): array {
        if ($search) {
            return $this->query(
                'SELECT * FROM gc_user WHERE user LIKE ? LIMIT ? OFFSET ?',
                ["%$search%", $limit, $offset]
            );
        }
        return $this->query(
            'SELECT * FROM gc_user LIMIT ? OFFSET ?',
            [$limit, $offset]
        );
    }

    public function count(string $search = ''): int {
        $row = $search
            ? $this->queryOne('SELECT COUNT(*) as c FROM gc_user WHERE user LIKE ?', ["%$search%"])
            : $this->queryOne('SELECT COUNT(*) as c FROM gc_user');
        return (int)($row['c'] ?? 0);
    }
}
