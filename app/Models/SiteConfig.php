<?php

class SiteConfig extends Model {
    private static ?array $cache = null;

    public function get(): array {
        if (self::$cache) return self::$cache;
        self::$cache = $this->queryOne('SELECT * FROM gc_info WHERE id = 1') ?? [];
        return self::$cache;
    }

    // Blog config
    public static ?array $blogCache = null;

    public function getBlog(PDO $blogDb): array {
        if (self::$blogCache) return self::$blogCache;
        $stmt = $blogDb->prepare('SELECT * FROM blog_cauhinh LIMIT 1');
        $stmt->execute();
        self::$blogCache = $stmt->fetch() ?? [];
        return self::$blogCache;
    }
}
