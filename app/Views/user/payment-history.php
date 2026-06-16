<div class="u-card">
    <div class="u-card-header"><i class="fa fa-history mr-2"></i>Lịch sử nạp KNB</div>
    <div class="u-card-body p-0">
        <?php if (empty($logs)): ?>
        <div class="text-center text-muted py-5">
            <i class="fa fa-inbox fa-2x mb-2 d-block"></i>
            Chưa có giao dịch nào.
        </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table mb-0" style="font-size:13px;">
                <thead style="background:#f8f9fd;border-bottom:1px solid #e0e4ef;">
                    <tr>
                        <th style="padding:12px 16px;color:#999;font-weight:600;font-size:11px;text-transform:uppercase;">#</th>
                        <th style="padding:12px 16px;color:#999;font-weight:600;font-size:11px;text-transform:uppercase;">Số KNB</th>
                        <th style="padding:12px 16px;color:#999;font-weight:600;font-size:11px;text-transform:uppercase;">Trước</th>
                        <th style="padding:12px 16px;color:#999;font-weight:600;font-size:11px;text-transform:uppercase;">Sau</th>
                        <th style="padding:12px 16px;color:#999;font-weight:600;font-size:11px;text-transform:uppercase;">Loại</th>
                        <th style="padding:12px 16px;color:#999;font-weight:600;font-size:11px;text-transform:uppercase;">Thời gian</th>
                        <th style="padding:12px 16px;color:#999;font-weight:600;font-size:11px;text-transform:uppercase;">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log): ?>
                    <tr style="border-bottom:1px solid #f0f2f8;">
                        <td style="padding:11px 16px;color:#aaa;"><?= $log['ID'] ?></td>
                        <td style="padding:11px 16px;font-weight:700;color:#c8922a;">
                            +<?= number_format($log['CoinValue']) ?>
                        </td>
                        <td style="padding:11px 16px;color:#888;"><?= number_format($log['BeforeCoin'] ?? 0) ?></td>
                        <td style="padding:11px 16px;color:#888;"><?= number_format($log['AfterCoin'] ?? 0) ?></td>
                        <td style="padding:11px 16px;">
                            <span style="background:#eef4ff;color:#2255aa;border-radius:4px;padding:2px 8px;font-size:11px;font-weight:600;">
                                <?= htmlspecialchars($log['RechaheType'] ?? '') ?>
                            </span>
                        </td>
                        <td style="padding:11px 16px;color:#888;">
                            <?= $log['RechaheDate'] ? date('d/m/Y H:i', strtotime($log['RechaheDate'])) : '—' ?>
                        </td>
                        <td style="padding:11px 16px;">
                            <?php if ($log['Status'] == 1): ?>
                            <span style="color:#2d7a4f;font-weight:600;"><i class="fa fa-check-circle mr-1"></i>Thành công</span>
                            <?php else: ?>
                            <span style="color:#c0392b;"><i class="fa fa-clock-o mr-1"></i>Chờ duyệt</span>
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
