<?php

// SQL Server — dùng sqlsrv PDO driver (cần php_pdo_sqlsrv.dll trong XAMPP)
function db_portal(): PDO {
    static $pdo;
    if (!$pdo) {
        $dsn = sprintf(
            'sqlsrv:Server=%s,%s;Database=%s;TrustServerCertificate=1',
            $_ENV['DB_HOST'],
            $_ENV['DB_PORT'] ?? 1433,
            $_ENV['DB_NAME']
        );
        $pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }
    return $pdo;
}

function db_blog(): PDO {
    return db_portal();
}
