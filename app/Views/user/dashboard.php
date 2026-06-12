<div class="row">
    <div class="col-md-4">
        <div class="card text-center mb-3">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($user['user'] ?? '') ?></h5>
                <p class="card-text">XU: <strong><?= number_format($user['xu'] ?? 0) ?></strong></p>
                <p class="card-text">GEM: <strong><?= number_format($user['gem'] ?? 0) ?></strong></p>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="list-group">
            <a href="/user/payment/card" class="list-group-item list-group-item-action"><i class="fa fa-credit-card"></i> Nạp thẻ cào</a>
            <a href="/user/payment/bank" class="list-group-item list-group-item-action"><i class="fa fa-bank"></i> Nạp ngân hàng</a>
            <a href="/user/exchange" class="list-group-item list-group-item-action"><i class="fa fa-exchange"></i> Đổi xu lấy item</a>
            <a href="/user/change-password" class="list-group-item list-group-item-action"><i class="fa fa-key"></i> Đổi mật khẩu</a>
            <a href="/user/payment/history" class="list-group-item list-group-item-action"><i class="fa fa-history"></i> Lịch sử nạp</a>
        </div>
    </div>
</div>
