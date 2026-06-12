<?php

class Payment extends Model {
    public function logCard(string $user, string $seri, string $pin, string $type, int $value): bool {
        return $this->execute(
            'INSERT INTO gc_log (user, seri, pin, type, menhgia, createTime, date)
             VALUES (?, ?, ?, ?, ?, NOW(), CURDATE())',
            [$user, $seri, $pin, $type, $value]
        );
    }

    public function getHistory(string $user, int $limit = 20): array {
        return $this->query(
            'SELECT * FROM gc_log WHERE user = ? ORDER BY id DESC LIMIT ?',
            [$user, $limit]
        );
    }

    public function addPoints(string $user, int $amount, string $admin): bool {
        $ok1 = $this->execute(
            'INSERT INTO gc_log (user, menhgia, pin, seri, createTime, date, status, gia)
             VALUES (?, ?, "MANUAL", "MANUAL", NOW(), CURDATE(), 1, 1)',
            [$user, $amount]
        );
        $ok2 = $this->execute(
            'INSERT INTO gc_logcongxu (admin, user, xucong, createTime) VALUES (?, ?, ?, NOW())',
            [$admin, $user, $amount]
        );
        return $ok1 && $ok2;
    }

    public function getTotalNap(string $user, string $fromDate): int {
        $row = $this->queryOne(
            'SELECT SUM(menhgia) as total FROM gc_log WHERE user = ? AND date >= ? AND status = 1',
            [$user, $fromDate]
        );
        return (int)($row['total'] ?? 0);
    }

    public function getRevenue(): int {
        $row = $this->queryOne(
            'SELECT SUM(menhgia) as total FROM gc_log WHERE gia = 0'
        );
        return (int)($row['total'] ?? 0);
    }
}
