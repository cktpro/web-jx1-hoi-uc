<?php
$pages   = (int)ceil($total / $limit);
$dayOpts = [0 => 'Tất cả', 7 => '7 ngày', 30 => '30 ngày', 90 => '90 ngày'];
$hasRange = $from && $to;
$superKnb = (int)($user['KCoin'] ?? 0);
?>

<!-- Thống kê -->
<div class="row mb-4">
    <div class="col-6">
        <div class="stat-box">
            <div class="stat-icon" style="background:rgba(184,134,11,.12);">
                <i class="fa fa-briefcase" style="color:#b8860b;"></i>
            </div>
            <div>
                <div class="stat-val" style="color:#b8860b;"><?= number_format($superKnb) ?></div>
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
                <div class="stat-lbl">KNB đã nạp cho đại lý<?= $hasRange ? " ($from → $to)" : ($days > 0 ? " ($days ngày)" : '') ?></div>
            </div>
        </div>
    </div>
</div>

<!-- Danh sách đại lý -->
<div class="u-card mb-4">
    <div class="u-card-header"><i class="fa fa-sitemap mr-2"></i>Danh sách đại lý</div>
    <div class="u-card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0" style="font-size:13px;">
                <thead style="background:#f4f6fb;">
                    <tr>
                        <th style="padding:10px 16px;font-weight:600;color:#555;">#</th>
                        <th style="padding:10px 16px;font-weight:600;color:#555;">Tên đăng nhập</th>
                        <th style="padding:10px 16px;font-weight:600;color:#555;">Số điện thoại</th>
                        <th style="padding:10px 16px;font-weight:600;color:#555;">KNB hiện có</th>
                        <th style="padding:10px 16px;font-weight:600;color:#555;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($list)): ?>
                    <tr><td colspan="5" class="text-center text-muted py-4">Chưa có đại lý nào</td></tr>
                <?php else: ?>
                    <?php foreach ($list as $i => $agent): ?>
                    <tr style="border-top:1px solid #f0f2f8;">
                        <td style="padding:10px 16px;color:#aaa;"><?= $i + 1 ?></td>
                        <td style="padding:10px 16px;font-weight:600;"><?= htmlspecialchars($agent['LoginName']) ?></td>
                        <td style="padding:10px 16px;"><?= htmlspecialchars($agent['Phone'] ?? '—') ?></td>
                        <td style="padding:10px 16px;color:#e0a800;font-weight:700;"><?= number_format($agent['KCoin'] ?? 0) ?></td>
                        <td style="padding:10px 16px;">
                            <button class="btn btn-sm btn-outline-primary mr-1"
                                data-name="<?= htmlspecialchars($agent['LoginName']) ?>"
                                onclick="openNap(this.dataset.name)">
                                <i class="fa fa-plus-circle mr-1"></i>Nạp KNB
                            </button>
                            <button class="btn btn-sm btn-outline-secondary"
                                data-name="<?= htmlspecialchars($agent['LoginName']) ?>"
                                onclick="openReset(this.dataset.name)">
                                <i class="fa fa-key mr-1"></i>Đặt lại mật khẩu
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bộ lọc lịch sử -->
<div class="u-card mb-3">
    <div class="u-card-body py-2">
        <form method="get" class="d-flex align-items-center flex-wrap" style="gap:8px;">
            <span style="font-size:13px;color:#555;white-space:nowrap;">Lọc lịch sử:</span>
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
                <?php if ($hasRange || $days > 0): ?>
                    <a href="/dai-ly/agents" class="btn btn-sm btn-outline-danger">
                        <i class="fa fa-times"></i>
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<!-- Lịch sử nạp cho đại lý -->
<div class="u-card">
    <div class="u-card-header">
        <i class="fa fa-history mr-2"></i>Lịch sử nạp KNB cho đại lý
        <?php if ($hasRange): ?>
            <span style="font-size:12px;color:#b8860b;font-weight:400;margin-left:6px;"><?= htmlspecialchars($from) ?> → <?= htmlspecialchars($to) ?></span>
        <?php elseif ($days > 0): ?>
            <span style="font-size:12px;color:#b8860b;font-weight:400;margin-left:6px;"><?= $days ?> ngày gần nhất</span>
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
                        <th>Đại lý nhận</th>
                        <th class="text-right">Số KNB</th>
                        <th class="text-right">Trước</th>
                        <th class="text-right">Sau</th>
                        <th>Thời gian</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td class="px-3 text-muted"><?= $log['ID'] ?></td>
                        <td><strong style="color:#b8860b;"><?= htmlspecialchars($log['UserName'] ?? '') ?></strong></td>
                        <td class="text-right" style="color:#2d7a4f;font-weight:600;">+<?= number_format((int)$log['CoinValue']) ?></td>
                        <td class="text-right text-muted"><?= number_format((int)$log['BeforeCoin']) ?></td>
                        <td class="text-right"><?= number_format((int)$log['AfterCoin']) ?></td>
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

        <?php if ($pages > 1): ?>
        <div class="d-flex justify-content-center align-items-center py-3" style="gap:4px;">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>&days=<?= $days ?>&from=<?= urlencode($from) ?>&to=<?= urlencode($to) ?>"
                    class="btn btn-sm btn-outline-secondary"><i class="fa fa-chevron-left"></i></a>
            <?php endif; ?>
            <?php for ($p = max(1, $page - 2); $p <= min($pages, $page + 2); $p++): ?>
                <a href="?page=<?= $p ?>&days=<?= $days ?>&from=<?= urlencode($from) ?>&to=<?= urlencode($to) ?>"
                    class="btn btn-sm <?= $p === $page ? 'btn-primary-agent' : 'btn-outline-secondary' ?>">
                    <?= $p ?>
                </a>
            <?php endfor; ?>
            <?php if ($page < $pages): ?>
                <a href="?page=<?= $page + 1 ?>&days=<?= $days ?>&from=<?= urlencode($from) ?>&to=<?= urlencode($to) ?>"
                    class="btn btn-sm btn-outline-secondary"><i class="fa fa-chevron-right"></i></a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Modal nạp KNB cho đại lý -->
<div class="modal fade" id="modalNap" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background:#b8860b;color:#fff;padding:12px 16px;">
                <h6 class="modal-title mb-0"><i class="fa fa-plus-circle mr-2"></i>Nạp KNB cho đại lý</h6>
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:1;">&times;</button>
            </div>
            <div class="modal-body">
                <div id="nap-alert"></div>
                <div class="form-group">
                    <label>Tên đại lý</label>
                    <input type="text" class="form-control" id="nap-username" readonly style="background:#f4f6fb;">
                </div>
                <div class="form-group">
                    <label>Số KNB</label>
                    <input type="number" class="form-control" id="nap-amount" placeholder="Nhập số KNB" min="1">
                </div>
                <div style="font-size:12px;color:#999;">KNB hiện có: <strong style="color:#b8860b;"><?= number_format($superKnb) ?></strong></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm" style="background:#b8860b;color:#fff;" onclick="doNap()">
                    <i class="fa fa-check mr-1"></i>Xác nhận
                </button>
                <button class="btn btn-secondary btn-sm" data-dismiss="modal">Hủy</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal reset mật khẩu -->
<div class="modal fade" id="modalReset" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background:#6c757d;color:#fff;padding:12px 16px;">
                <h6 class="modal-title mb-0"><i class="fa fa-key mr-2"></i>Đặt lại mật khẩu đại lý</h6>
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:1;">&times;</button>
            </div>
            <div class="modal-body">
                <div id="reset-alert"></div>
                <div class="form-group">
                    <label>Tên đại lý</label>
                    <input type="text" class="form-control" id="reset-username" readonly style="background:#f4f6fb;">
                </div>
                <div class="form-group">
                    <label>Mật khẩu mới</label>
                    <input type="password" class="form-control" id="reset-password" placeholder="Tối thiểu 6 ký tự">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" onclick="doReset()"><i class="fa fa-check mr-1"></i>Xác nhận</button>
                <button class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Hủy</button>
            </div>
        </div>
    </div>
</div>

<script>
function showAlert(id, msg, ok) {
    $('#' + id).html('<div class="u-alert ' + (ok ? 'u-alert-success' : 'u-alert-danger') + ' mb-2">' + msg + '</div>');
}
function openNap(name) {
    $('#nap-username').val(name);
    $('#nap-amount').val('');
    $('#nap-alert').html('');
    $('#modalNap').modal('show');
}
function openReset(name) {
    $('#reset-username').val(name);
    $('#reset-password').val('');
    $('#reset-alert').html('');
    $('#modalReset').modal('show');
}
function doNap() {
    $.post('/dai-ly/ajax/nap-knb-agent', {
        username: $('#nap-username').val(),
        amount:   $('#nap-amount').val(),
    }, function(res) {
        showAlert('nap-alert', res.msg, res.status);
        if (res.status) setTimeout(() => location.reload(), 1200);
    }, 'json');
}
function doReset() {
    $.post('/dai-ly/ajax/doi-mat-khau', {
        username: $('#reset-username').val(),
        password: $('#reset-password').val(),
    }, function(res) {
        showAlert('reset-alert', res.msg, res.status);
        if (res.status) setTimeout(() => $('#modalReset').modal('hide'), 1000);
    }, 'json');
}
</script>
