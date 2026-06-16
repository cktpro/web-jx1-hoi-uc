<?php
$pages    = (int)ceil($total / $limit);
$dayOpts  = [0 => 'Tất cả', 7 => '7 ngày', 30 => '30 ngày', 90 => '90 ngày'];
$hasRange = $from && $to;
$agentKnb = (int)($user['KCoin'] ?? 0);
?>

<!-- Thống kê -->
<div class="row mb-4">
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

<!-- Các thao tác -->
<div class="row mb-4">

    <!-- Nạp KNB -->
    <div class="col-md-4 mb-3">
        <div class="u-card h-100">
            <div class="u-card-header"><i class="fa fa-plus-circle mr-2"></i>Nạp KNB</div>
            <div class="u-card-body">
                <div id="msg-knb"></div>
                <div class="form-group">
                    <label>Tên tài khoản</label>
                    <input type="text" id="knb-username" class="form-control" placeholder="Nhập tên tài khoản">
                </div>
                <div class="form-group">
                    <label>Số KNB</label>
                    <input type="number" id="knb-amount" class="form-control" placeholder="Nhập số KNB" min="1">
                </div>
                <button class="btn btn-primary-agent btn-block" onclick="doNapKnb()">
                    <i class="fa fa-paper-plane mr-1"></i> Nạp KNB
                </button>
            </div>
        </div>
    </div>

    <!-- Đổi mật khẩu -->
    <div class="col-md-4 mb-3">
        <div class="u-card h-100">
            <div class="u-card-header"><i class="fa fa-key mr-2"></i>Đổi mật khẩu người dùng</div>
            <div class="u-card-body">
                <div id="msg-pass"></div>
                <div class="form-group">
                    <label>Tên tài khoản</label>
                    <input type="text" id="pass-username" class="form-control" placeholder="Nhập tên tài khoản">
                </div>
                <div class="form-group">
                    <label>Mật khẩu mới</label>
                    <input type="text" id="pass-new" class="form-control" placeholder="Tối thiểu 6 ký tự">
                </div>
                <button class="btn btn-primary-agent btn-block" onclick="doChangePass()">
                    <i class="fa fa-save mr-1"></i> Đổi mật khẩu
                </button>
            </div>
        </div>
    </div>

    <!-- Đổi SĐT -->
    <div class="col-md-4 mb-3">
        <div class="u-card h-100">
            <div class="u-card-header"><i class="fa fa-phone mr-2"></i>Đổi số điện thoại</div>
            <div class="u-card-body">
                <div id="msg-sdt"></div>
                <div class="form-group">
                    <label>Tên tài khoản</label>
                    <div class="input-group">
                        <input type="text" id="sdt-username" class="form-control" placeholder="Nhập tên tài khoản">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" onclick="checkUser()">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="sdt-current" style="display:none;" class="mb-3">
                    <div style="background:#f8f9fd;border:1px solid #e0e4ef;border-radius:6px;padding:10px 14px;font-size:13px;">
                        <span class="text-muted">SĐT hiện tại:</span>
                        <strong id="sdt-current-val" class="ml-2" style="color:#2255cc;"></strong>
                    </div>
                </div>
                <div class="form-group">
                    <label>Số điện thoại mới</label>
                    <input type="text" id="sdt-phone" class="form-control" placeholder="Nhập số điện thoại mới" disabled>
                </div>
                <button id="btn-sdt" class="btn btn-primary-agent btn-block" onclick="doChangeSdt()" disabled>
                    <i class="fa fa-save mr-1"></i> Cập nhật SĐT
                </button>
            </div>
        </div>
    </div>

</div>

<!-- Bộ lọc -->
<div class="u-card mb-3">
    <div class="u-card-body py-2">
        <form method="get" class="d-flex align-items-center flex-wrap" style="gap:8px;">
            <?php if (!empty($isSuperAgent)): ?>
            <select name="agent" class="form-control form-control-sm" style="width:170px;" onchange="this.form.submit()">
                <option value="">-- Tất cả đại lý --</option>
                <?php foreach ($agentList as $a): ?>
                    <option value="<?= htmlspecialchars($a['LoginName']) ?>"
                        <?= $agentFilter === $a['LoginName'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($a['LoginName']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php endif; ?>

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
                <?php if ($hasRange || $days > 0 || $agentFilter): ?>
                    <a href="/dai-ly/users" class="btn btn-sm btn-outline-danger">
                        <i class="fa fa-times"></i>
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<!-- Lịch sử nạp -->
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
                        <?php if (!empty($isSuperAgent)): ?><th>Đại lý</th><?php endif; ?>
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
                        <?php if (!empty($isSuperAgent)): ?>
                        <td style="color:#b8860b;font-size:12px;"><?= htmlspecialchars($log['ActionBy'] ?? '—') ?></td>
                        <?php endif; ?>
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
<nav class="mt-3">
    <ul class="pagination pagination-sm justify-content-center">
        <?php for ($i = 1; $i <= $pages; $i++): ?>
            <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                <a class="page-link" href="?days=<?= $days ?>&from=<?= urlencode($from) ?>&to=<?= urlencode($to) ?>&page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>
<?php endif; ?>

<script>
function showMsg(id, status, msg) {
    var cls = status ? 'u-alert-success' : 'u-alert-danger';
    var ico = status ? 'fa-check' : 'fa-times';
    var $el = $('#' + id);
    $el.html('<div class="u-alert ' + cls + '"><i class="fa ' + ico + ' mr-1"></i>' + msg + '</div>');
    clearTimeout($el.data('t'));
    $el.data('t', setTimeout(function() { $el.html(''); }, 6000));
}

function ajaxPost(url, data, onDone) {
    $.ajax({
        url: url, type: 'POST', data: data, dataType: 'json',
        success: function(r) { onDone(r); },
        error: function(xhr) {
            var msg = 'Lỗi kết nối';
            try { var r = JSON.parse(xhr.responseText); msg = r.msg || msg; } catch(e) {}
            onDone({ status: false, msg: msg });
        }
    });
}

function doNapKnb() {
    var u = $('#knb-username').val().trim();
    var a = parseInt($('#knb-amount').val(), 10);
    if (!u || !a || a <= 0) { showMsg('msg-knb', false, 'Vui lòng nhập đầy đủ thông tin'); return; }
    ajaxPost('/dai-ly/ajax/nap-knb', { username: u, amount: a }, function(r) {
        showMsg('msg-knb', r.status, r.msg);
        if (r.status) {
            $('#knb-username, #knb-amount').val('');
            setTimeout(function() { location.reload(); }, 1500);
        }
    });
}

function doChangePass() {
    var u = $('#pass-username').val().trim();
    var p = $('#pass-new').val().trim();
    if (!u || !p) { showMsg('msg-pass', false, 'Vui lòng nhập đầy đủ thông tin'); return; }
    ajaxPost('/dai-ly/ajax/doi-mat-khau', { username: u, password: p }, function(r) {
        showMsg('msg-pass', r.status, r.msg);
        if (r.status) { $('#pass-username, #pass-new').val(''); }
    });
}

function checkUser() {
    var u = $('#sdt-username').val().trim();
    if (!u) { showMsg('msg-sdt', false, 'Vui lòng nhập tên tài khoản'); return; }
    ajaxPost('/dai-ly/ajax/check-user', { username: u }, function(r) {
        if (r.status) {
            $('#sdt-current-val').text(r.phone || '(chưa có)');
            $('#sdt-current').show();
            $('#sdt-phone').prop('disabled', false).focus();
            $('#btn-sdt').prop('disabled', false);
            $('#msg-sdt').html('');
        } else {
            $('#sdt-current').hide();
            $('#sdt-phone').prop('disabled', true).val('');
            $('#btn-sdt').prop('disabled', true);
            showMsg('msg-sdt', false, r.msg);
        }
    });
}

function doChangeSdt() {
    var u = $('#sdt-username').val().trim();
    var p = $('#sdt-phone').val().trim();
    if (!u || !p) { showMsg('msg-sdt', false, 'Vui lòng nhập đầy đủ thông tin'); return; }
    ajaxPost('/dai-ly/ajax/doi-sdt', { username: u, phone: p }, function(r) {
        showMsg('msg-sdt', r.status, r.msg);
        if (r.status) {
            $('#sdt-current-val').text(p);
            $('#sdt-phone').val('');
        }
    });
}

$('#sdt-username').on('keydown', function(e) { if (e.key === 'Enter') checkUser(); });
</script>
