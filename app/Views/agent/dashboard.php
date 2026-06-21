<div class="row mb-3">
    <div class="col-sm-6 col-lg-3 mb-3">
        <div class="stat-box">
            <div class="stat-icon" style="background:rgba(34,85,204,.1);color:#2255cc;">
                <i class="fa fa-user"></i>
            </div>
            <div>
                <div class="stat-val"><?= htmlspecialchars($user['LoginName'] ?? '') ?></div>
                <div class="stat-lbl">Tên tài khoản</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-3">
        <div class="stat-box">
            <div class="stat-icon" style="background:rgba(255,193,7,.15);color:#e0a800;">
                <i class="fa fa-circle"></i>
            </div>
            <div>
                <div class="stat-val"><?= number_format($user['KCoin'] ?? 0) ?></div>
                <div class="stat-lbl">KNB hiện có</div>
            </div>
        </div>
    </div>
</div>

<div class="u-card">
    <div class="u-card-header"><i class="fa fa-info-circle mr-2"></i>Thông tin tài khoản đại lý</div>
    <div class="u-card-body p-0">
        <table class="table mb-0" style="font-size:13px;">
            <tbody>
                <tr style="border-bottom:1px solid #f0f2f8;">
                    <td style="padding:12px 20px;color:#999;width:160px;">Tên đăng nhập</td>
                    <td style="padding:12px 20px;font-weight:600;"><?= htmlspecialchars($user['LoginName'] ?? '') ?></td>
                </tr>
                <tr style="border-bottom:1px solid #f0f2f8;">
                    <td style="padding:12px 20px;color:#999;">Số điện thoại</td>
                    <td style="padding:12px 20px;"><?= htmlspecialchars($user['Phone'] ?? '—') ?></td>
                </tr>
                <tr style="border-bottom:1px solid #f0f2f8;">
                    <td style="padding:12px 20px;color:#999;">Nhân vật</td>
                    <td style="padding:12px 20px;"><?= htmlspecialchars($user['ActiveRoleName'] ?? '—') ?></td>
                </tr>
                <tr style="border-bottom:1px solid #f0f2f8;">
                    <td style="padding:12px 20px;color:#999;">KNB hiện có</td>
                    <td style="padding:12px 20px;font-weight:700;color:#e0a800;"><?= number_format($user['KCoin'] ?? 0) ?></td>
                </tr>
                <tr>
                    <td style="padding:12px 20px;color:#999;">Trạng thái</td>
                    <td style="padding:12px 20px;">
                        <span style="background:#eafaf0;color:#2d7a4f;border-radius:4px;padding:2px 10px;font-size:11px;font-weight:700;">
                            <i class="fa fa-check-circle mr-1"></i>Hoạt động
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
