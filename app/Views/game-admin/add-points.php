<?php if ($success): ?>
<div class="alert alert-success">Cộng điểm thành công!</div>
<?php endif; ?>
<div class="widget-box">
    <div class="widget-title"><h5>Cộng điểm nạp thủ công</h5></div>
    <div class="widget-content">
        <form method="post" action="/game-admin/add-points">
            <div class="form-group">
                <label>Tài khoản</label>
                <input type="text" name="user" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Số điểm</label>
                <input type="number" name="diem" class="form-control" value="0" required>
            </div>
            <button type="submit" class="btn btn-success">Cộng điểm</button>
        </form>
    </div>
</div>
