<?php
$pages    = (int)ceil($total / $limit);
$dayOpts  = [0 => 'Tất cả', 7 => '7 ngày', 30 => '30 ngày', 90 => '90 ngày'];
$hasRange = $from && $to;
$agentKnb = (int)($user['KCoin'] ?? 0);
?>

<div class="row mb-3">
    <div class="col-6">
        <div class="stat-box">
            <div class="stat-icon" style="background:#eef2ff;">
                <i class="fa fa-wallet" style="color:#2255cc;"></i>
            </div>
            <div>
                <div class="stat-val" style="color:#2255cc;"><?= number_format($agentKnb) ?></div>
                <div class="stat-lbl">KNB hiện có</div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="stat-box">
            <div class="stat-icon" style="background:#eafaf0;">
                <i class="fa fa-arrow-up" style="color:#2d7a4f;"></i>
            </div>
            <div>
                <div class="stat-val" style="color:#2d7a4f;"><?= number_format($totalKnb) ?></div>
                <div class="stat-lbl">KNB đã nạp<?= $hasRange ? " ($from → $to)" : ($days > 0 ? " ($days ngày)" : '') ?></div>
            </div>
        </div>
    </div>
</div>

<div class="u-card mb-3">
    <div class="u-card-body py-2">
        <form method="get" class="d-flex align-items-center flex-wrap" style="gap:8px;">
            <span style="font-size:13px;color:#555;white-space:nowrap;">Lọc nhanh:</span>
            <?php foreach ($dayOpts as $val => $label): ?>
                <button type="submit" name="days" value="<?= $val ?>"
                    class="btn btn-sm <?= !$hasRange && $days === $val ? 'btn-primary-agent' : 'btn-outline-secondary' ?>">
                    <?= $label ?>
                </button>
            <?php endforeach; ?>

            <div class="d-flex align-items-center ml-3" style="gap:6px;flex-wrap:wrap;">
                <span style="font-size:13px;color:#555;white-space:nowrap;">Từ ngày:</span>
                <input type="date" name="from" value="<?= htmlspecialchars($from) ?>"
                    class="form-control form-control-sm" style="width:140px;">
                <span style="font-size:13px;color:#555;">đến</span>
                <input type="date" name="to" value="<?= htmlspecialchars($to) ?>"
                    class="form-control form-control-sm" style="width:140px;">
                <button type="submit" class="btn btn-sm <?= $hasRange ? 'btn-primary-agent' : 'btn-outline-secondary' ?>">
                    <i class="fa fa-search mr-1"></i>Lọc
                </button>
                <?php if ($hasRange): ?>
                    <a href="/dai-ly/history" class="btn btn-sm btn-outline-danger">
                        <i class="fa fa-times"></i>
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<div class="u-card">
    <div class="u-card-header">
        <i class="fa fa-history mr-2"></i>Lịch sử nạp KNB
        <?php if ($hasRange): ?>
            <span style="font-size:12px;color:#2255cc;font-weight:400;margin-left:6px;"><?= htmlspecialchars($from) ?> → <?= htmlspecialchars($to) ?></span>
        <?php elseif ($days > 0): ?>
            <span style="font-size:12px;color:#2255cc;font-weight:400;margin-left:6px;"><?= $days ?> ngày gần nhất</span>
        <?php endif; ?>
        <span class="float-right" style="font-size:12px;color:#999;font-weight:400;">Tổng: <?= number_format($total) ?> giao dịch</span>
    </div>
    <div class="u-card-body p-0">
        <?php if (empty($logs)): ?>
            <div class="text-center text-muted py-5">Chưa có lịch sử nạp nào.</div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-sm mb-0" style="font-size:13px;">
                <thead style="background:#f8f9fd;">
                    <tr>
                        <th class="px-3">ID</th>
                        <th>Tài khoản</th>
                        <th class="text-right">Số KNB</th>
                        <th class="text-right">Trước</th>
                        <th class="text-right">Sau</th>
                        <th>Loại</th>
                        <th>Thời gian</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td class="px-3 text-muted"><?= $log['ID'] ?></td>
                        <td><strong><?= htmlspecialchars($log['UserName'] ?? '') ?></strong></td>
                        <td class="text-right" style="color:#2d7a4f;font-weight:600;">+<?= number_format((int)$log['CoinValue']) ?></td>
                        <td class="text-right text-muted"><?= number_format((int)$log['BeforeCoin']) ?></td>
                        <td class="text-right"><?= number_format((int)$log['AfterCoin']) ?></td>
                        <td><span style="background:#eef2ff;color:#2255cc;border-radius:4px;padding:2px 7px;font-size:11px;"><?= htmlspecialchars($log['RechageType'] ?? '') ?></span></td>
                        <td class="text-muted"><?= htmlspecialchars($log['RechageDate'] ?? '') ?></td>
                        <td>
                            <?php if ((int)($log['Status'] ?? 0) === 1): ?>
                                <span style="color:#2d7a4f;"><i class="fa fa-check-circle"></i> Thành công</span>
                            <?php else: ?>
                                <span style="color:#c0392b;"><i class="fa fa-times-circle"></i> Thất bại</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php if ($pages > 1): ?>
<nav>
    <ul class="pagination pagination-sm justify-content-center">
        <?php for ($i = 1; $i <= $pages; $i++): ?>
            <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                <a class="page-link" href="?days=<?= $days ?>&from=<?= urlencode($from) ?>&to=<?= urlencode($to) ?>&page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>
<?php endif; ?>
