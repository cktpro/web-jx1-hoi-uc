<?php

class User extends Model {
    private function baseSelect(): string {
        return 'SELECT l.*, ISNULL(k.KCoin, 0) AS KCoin
                FROM LoginTables l
                LEFT JOIN KTCoins k ON k.UserName = l.LoginName';
    }

    public function findByUsername(string $username): ?array {
        return $this->queryOne(
            $this->baseSelect() . ' WHERE l.LoginName = ?',
            [$username]
        );
    }

    public function findById(int $id): ?array {
        return $this->queryOne(
            $this->baseSelect() . ' WHERE l.ID = ?',
            [$id]
        );
    }

    public function getInfo(string $username): ?array {
        return $this->findByUsername($username);
    }

    public function updatePassword(string $username, string $newPassHash): bool {
        return $this->execute(
            'UPDATE LoginTables SET Password = ? WHERE LoginName = ?',
            [$newPassHash, $username]
        );
    }

    public function updatePhone(string $username, string $phone): bool {
        return $this->execute(
            'UPDATE LoginTables SET Phone = ? WHERE LoginName = ?',
            [$phone, $username]
        );
    }

    public function getAll(int $limit = 10, int $offset = 0, string $search = ''): array {
        $base = $this->baseSelect();
        if ($search) {
            return $this->query(
                "$base WHERE l.LoginName LIKE ?
                 ORDER BY l.ID DESC
                 OFFSET $offset ROWS FETCH NEXT $limit ROWS ONLY",
                ["%$search%"]
            );
        }
        return $this->query(
            "$base ORDER BY l.ID DESC
             OFFSET $offset ROWS FETCH NEXT $limit ROWS ONLY"
        );
    }

    public function count(string $search = ''): int {
        $row = $search
            ? $this->queryOne('SELECT COUNT(*) AS c FROM LoginTables WHERE LoginName LIKE ?', ["%$search%"])
            : $this->queryOne('SELECT COUNT(*) AS c FROM LoginTables');
        return (int)($row['c'] ?? 0);
    }

    public function usernameExists(string $username): bool {
        $row = $this->queryOne('SELECT ID FROM LoginTables WHERE LoginName = ?', [$username]);
        return $row !== null;
    }

    public function create(string $username, string $passHash, string $phone = ''): bool {
        return $this->execute(
            'INSERT INTO LoginTables (LoginName, Password, Phone, Status) VALUES (?, ?, ?, 1)',
            [$username, $passHash, $phone]
        );
    }

    public function updateCoins(string $username, int $delta): bool {
        $exists = $this->queryOne('SELECT ID FROM KTCoins WHERE UserName = ?', [$username]);
        if ($exists) {
            return $this->execute(
                'UPDATE KTCoins SET KCoin = KCoin + ?, UpdateTime = GETDATE() WHERE UserName = ?',
                [$delta, $username]
            );
        }
        $user   = $this->queryOne('SELECT ID FROM LoginTables WHERE LoginName = ?', [$username]);
        $userId = (int)($user['ID'] ?? 0);
        return $this->execute(
            'INSERT INTO KTCoins (UserID, UserName, KCoin, UpdateTime) VALUES (?, ?, ?, GETDATE())',
            [$userId, $username, $delta]
        );
    }

    public function getKCoin(string $username): int {
        $row = $this->queryOne('SELECT ISNULL(KCoin, 0) AS KCoin FROM KTCoins WHERE UserName = ?', [$username]);
        return (int)($row['KCoin'] ?? 0);
    }

    public function getAgentLogs(string $agentName, int $limit, int $offset, int $days = 0, string $from = '', string $to = ''): array {
        [$where, $params] = $this->buildAgentLogWhere($agentName, $days, $from, $to);
        return $this->query(
            "SELECT * FROM RechageLogs WHERE $where
             ORDER BY ID DESC
             OFFSET $offset ROWS FETCH NEXT $limit ROWS ONLY",
            $params
        );
    }

    public function countAgentLogs(string $agentName, int $days = 0, string $from = '', string $to = ''): int {
        [$where, $params] = $this->buildAgentLogWhere($agentName, $days, $from, $to);
        $row = $this->queryOne("SELECT COUNT(*) AS c FROM RechageLogs WHERE $where", $params);
        return (int)($row['c'] ?? 0);
    }

    public function sumAgentLogs(string $agentName, int $days = 0, string $from = '', string $to = ''): int {
        [$where, $params] = $this->buildAgentLogWhere($agentName, $days, $from, $to);
        $row = $this->queryOne("SELECT ISNULL(SUM(CoinValue), 0) AS s FROM RechageLogs WHERE $where", $params);
        return (int)($row['s'] ?? 0);
    }

    private function buildAgentLogWhere(string $agentName, int $days, string $from, string $to): array {
        if ($agentName === '') {
            $where  = '1=1';
            $params = [];
        } else {
            $where  = 'ActionBy = ?';
            $params = [$agentName];
        }
        if ($from && $to) {
            $where   .= ' AND CAST(RechageDate AS DATE) BETWEEN ? AND ?';
            $params[] = $from;
            $params[] = $to;
        } elseif ($days > 0) {
            $where .= " AND RechageDate >= DATEADD(DAY, -$days, GETDATE())";
        }
        return [$where, $params];
    }

    public function getAllAgents(): array {
        return $this->query(
            $this->baseSelect() . ' WHERE l.ActiveRoleID = 1 ORDER BY l.ID DESC'
        );
    }

    public function logRecharge(int $userId, string $username, int $amount, int $before, int $after, string $actionBy): bool {
        return $this->execute(
            "INSERT INTO RechageLogs (UserID, UserName, CoinValue, BeforeCoin, AfterCoin, RechageType, RechageDate, Status, ActionBy)
             VALUES (?, ?, ?, ?, ?, N'DAI_LY', GETDATE(), 1, ?)",
            [$userId, $username, $amount, $before, $after, $actionBy]
        );
    }

    public function logAgentTransfer(int $userId, string $username, int $amount, int $before, int $after, string $actionBy): bool {
        return $this->execute(
            "INSERT INTO RechageLogs (UserID, UserName, CoinValue, BeforeCoin, AfterCoin, RechageType, RechageDate, Status, ActionBy)
             VALUES (?, ?, ?, ?, ?, N'TONG_TO_AGENT', GETDATE(), 1, ?)",
            [$userId, $username, $amount, $before, $after, $actionBy]
        );
    }

    public function getAgentTransferLogs(string $agentName, int $limit, int $offset, int $days = 0, string $from = '', string $to = ''): array {
        [$timeWhere, $params] = $this->buildTimeWhere($days, $from, $to);
        array_unshift($params, $agentName);
        return $this->query(
            "SELECT * FROM RechageLogs
             WHERE ActionBy = ? AND RechageType = 'TONG_TO_AGENT' $timeWhere
             ORDER BY ID DESC
             OFFSET $offset ROWS FETCH NEXT $limit ROWS ONLY",
            $params
        );
    }

    public function countAgentTransferLogs(string $agentName, int $days = 0, string $from = '', string $to = ''): int {
        [$timeWhere, $params] = $this->buildTimeWhere($days, $from, $to);
        array_unshift($params, $agentName);
        $row = $this->queryOne(
            "SELECT COUNT(*) AS c FROM RechageLogs
             WHERE ActionBy = ? AND RechageType = 'TONG_TO_AGENT' $timeWhere",
            $params
        );
        return (int)($row['c'] ?? 0);
    }

    public function sumAgentTransferLogs(string $agentName, int $days = 0, string $from = '', string $to = ''): int {
        [$timeWhere, $params] = $this->buildTimeWhere($days, $from, $to);
        array_unshift($params, $agentName);
        $row = $this->queryOne(
            "SELECT ISNULL(SUM(CoinValue), 0) AS s FROM RechageLogs
             WHERE ActionBy = ? AND RechageType = 'TONG_TO_AGENT' $timeWhere",
            $params
        );
        return (int)($row['s'] ?? 0);
    }

    private function buildTimeWhere(int $days, string $from, string $to): array {
        if ($from && $to) {
            return [' AND CAST(RechageDate AS DATE) BETWEEN ? AND ?', [$from, $to]];
        }
        if ($days > 0) {
            return [" AND RechageDate >= DATEADD(DAY, -$days, GETDATE())", []];
        }
        return ['', []];
    }
}
