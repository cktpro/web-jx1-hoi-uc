<div class="row mb-3">
    <div class="col-sm-6 col-lg-4 mb-3">
        <div class="stat-box">
            <div class="stat-icon" style="background:rgba(212,168,67,.15);color:#d4a843;">
                <i class="fa fa-user"></i>
            </div>
            <div>
                <div class="stat-val"><?= htmlspecialchars($user['LoginName'] ?? '') ?></div>
                <div class="stat-lbl">Tên tài khoản</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-4 mb-3">
        <div class="stat-box">
            <div class="stat-icon" style="background:rgba(255,193,7,.15);color:#ffc107;">
                <i class="fa fa-circle"></i>
            </div>
            <div>
                <div class="stat-val"><?= number_format($user['KCoin'] ?? 0) ?></div>
                <div class="stat-lbl">KNB</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-4 mb-3">
        <div class="stat-box">
            <div class="stat-icon" style="background:rgba(40,167,69,.15);color:#28a745;">
                <i class="fa fa-gamepad"></i>
            </div>
            <div>
                <div class="stat-val"><?= htmlspecialchars($user['ActiveRoleName'] ?? 'Chưa có') ?></div>
                <div class="stat-lbl">Nhân vật đang chọn</div>
            </div>
        </div>
    </div>
</div>

<div class="u-card">
    <div class="u-card-header"><i class="fa fa-bolt mr-2"></i>Thao tác nhanh</div>
    <div class="u-card-body">
        <div class="action-grid">
            <a href="/user/payment/napknb" class="action-item">
                <i class="fa fa-plus-circle"></i>
                <span>Nạp KNB</span>
            </a>
            <a href="/user/giftcode" class="action-item">
                <i class="fa fa-gift"></i>
                <span>Gift code</span>
            </a>
            <a href="/user/payment/history" class="action-item">
                <i class="fa fa-history"></i>
                <span>Lịch sử nạp</span>
            </a>
            <a href="/user/change-password" class="action-item">
                <i class="fa fa-key"></i>
                <span>Đổi mật khẩu</span>
            </a>
        </div>
    </div>
</div>
