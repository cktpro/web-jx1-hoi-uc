<?php

class Payment extends Model {
    public function logCard(string $username, string $seri, string $pin, string $type, int $price): bool {
        $user = $this->queryOne('SELECT ID FROM LoginTables WHERE LoginName = ?', [$username]);
        return $this->execute(
            "INSERT INTO history_gamebank
                (datetime, cardserial, cardpin, cardtype, price, coins, msg, status, UserID, accountname)
             VALUES (GETDATE(), ?, ?, ?, ?, 0, N'Đang xử lý', 0, ?, ?)",
            [$seri, $pin, $type, $price, $user['ID'] ?? 0, $username]
        );
    }

    public function getHistory(string $username, int $limit = 50): array {
        return $this->query(
            "SELECT * FROM RechageLogs
             WHERE UserName = ?
             ORDER BY ID DESC
             OFFSET 0 ROWS FETCH NEXT $limit ROWS ONLY",
            [$username]
        );
    }

    public function addPoints(string $username, int $amount, string $admin): bool {
        $user   = $this->queryOne('SELECT ID FROM LoginTables WHERE LoginName = ?', [$username]);
        $userId = $user['ID'] ?? 0;
        $coin   = $this->queryOne('SELECT KCoin FROM KTCoins WHERE UserName = ?', [$username]);
        $before = (int)($coin['KCoin'] ?? 0);
        $after  = $before + $amount;

        $ok1 = $this->execute(
            "INSERT INTO RechageLogs
                (UserID, UserName, CoinValue, BeforeCoin, AfterCoin, RechaheDate, RechaheType, ActionBy, Status)
             VALUES (?, ?, ?, ?, ?, GETDATE(), N'MANUAL', ?, 1)",
            [$userId, $username, $amount, $before, $after, $admin]
        );

        if ($coin) {
            $ok2 = $this->execute(
                'UPDATE KTCoins SET KCoin = KCoin + ?, UpdateTime = GETDATE() WHERE UserName = ?',
                [$amount, $username]
            );
        } else {
            $ok2 = $this->execute(
                'INSERT INTO KTCoins (UserName, KCoin, UpdateTime) VALUES (?, ?, GETDATE())',
                [$username, $amount]
            );
        }

        return $ok1 && $ok2;
    }

    public function getRevenue(): int {
        $row = $this->queryOne('SELECT SUM(CoinValue) AS total FROM RechageLogs WHERE Status = 1');
        return (int)($row['total'] ?? 0);
    }

    public function getAllLogs(int $limit = 20, int $offset = 0): array {
        return $this->query(
            "SELECT r.*, l.FullName FROM RechageLogs r
             LEFT JOIN LoginTables l ON l.LoginName = r.UserName
             ORDER BY r.ID DESC
             OFFSET $offset ROWS FETCH NEXT $limit ROWS ONLY"
        );
    }
}
