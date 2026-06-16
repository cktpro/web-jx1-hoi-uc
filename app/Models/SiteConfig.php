<?php

// Configs: ID, StartKM, EndKM, NormalRate, KMRate (cấu hình event/tỉ lệ nạp)
class SiteConfig extends Model {
    private static ?array $cache = null;

    public function get(): array {
        if (self::$cache !== null) return self::$cache;
        self::$cache = $this->queryOne('SELECT TOP 1 * FROM Configs ORDER BY ID DESC') ?? [];
        return self::$cache;
    }

    // Giữ tương thích với controller cũ — cùng 1 DB nên bỏ tham số $db
    public function getBlog(PDO $db): array {
        return $this->get();
    }
}
