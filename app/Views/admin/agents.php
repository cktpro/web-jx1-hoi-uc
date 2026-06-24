<?php $totalPages = $limit > 0 ? ceil($total / $limit) : 1; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0"><i class="fa fa-users mr-2 text-success"></i>Quản lý đại lý</h5>
    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalCreate">
        <i class="fa fa-plus mr-1"></i>Tạo tài khoản đại lý
    </button>
</div>

<!-- Search -->
<form method="get" action="/admin/agents" class="mb-3">
    <div class="input-group" style="max-width:320px;">
        <input type="text" name="q" class="form-control form-control-sm" placeholder="Tìm tên tài khoản..." value="<?= htmlspecialchars($search) ?>">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary btn-sm" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>

<div class="card">
    <div class="card-header">
        <span><i class="fa fa-list mr-1"></i>Danh sách đại lý (<?= number_format($total) ?>)</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên tài khoản</th>
                        <th>SĐT</th>
                        <th>Loại</th>
                        <th>KNB</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($agents)): ?>
                    <tr><td colspan="6" class="text-center text-muted py-4">Không có đại lý nào</td></tr>
                <?php else: ?>
                    <?php foreach ($agents as $i => $ag): ?>
                    <tr>
                        <td class="text-muted"><?= ($page - 1) * $limit + $i + 1 ?></td>
                        <td><strong><?= htmlspecialchars($ag['LoginName']) ?></strong></td>
                        <td><?= htmlspecialchars($ag['Phone'] ?? '—') ?></td>
                        <td>
                            <?php if ((int)$ag['ActiveRoleID'] === 3): ?>
                                <span class="badge badge-warning">Đại lý tổng</span>
                            <?php else: ?>
                                <span class="badge badge-info">Đại lý</span>
                            <?php endif; ?>
                        </td>
                        <td><strong class="text-success"><?= number_format((int)$ag['KCoin']) ?></strong></td>
                        <td>
                            <button class="btn btn-warning btn-sm btn-setrole mr-1"
                                data-username="<?= htmlspecialchars($ag['LoginName']) ?>"
                                data-role="<?= (int)$ag['ActiveRoleID'] ?>">
                                <i class="fa fa-shield mr-1"></i>Quyền
                            </button>
                            <button class="btn btn-primary btn-sm btn-topup mr-1"
                                data-username="<?= htmlspecialchars($ag['LoginName']) ?>"
                                data-kcoin="<?= (int)$ag['KCoin'] ?>">
                                <i class="fa fa-plus-circle mr-1"></i>Nạp KNB
                            </button>
                            <button class="btn btn-danger btn-sm btn-delete"
                                data-username="<?= htmlspecialchars($ag['LoginName']) ?>">
                                <i class="fa fa-trash"></i>
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

<!-- Pagination -->
<?php if ($totalPages > 1): ?>
<nav>
    <ul class="pagination pagination-sm">
        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
        <li class="page-item <?= $p === $page ? 'active' : '' ?>">
            <a class="page-link" href="?page=<?= $p ?><?= $search ? '&q=' . urlencode($search) : '' ?>"><?= $p ?></a>
        </li>
        <?php endfor; ?>
    </ul>
</nav>
<?php endif; ?>

<!-- Modal: Tạo tài khoản -->
<div class="modal fade" id="modalCreate" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="fa fa-user-plus mr-2"></i>Tạo tài khoản đại lý</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="createAlert" class="alert d-none"></div>
                <div class="form-group">
                    <label>Tên tài khoản <span class="text-danger">*</span></label>
                    <input type="text" id="createUsername" class="form-control form-control-sm" placeholder="Nhập tên tài khoản">
                </div>
                <div class="form-group">
                    <label>Mật khẩu <span class="text-danger">*</span></label>
                    <input type="password" id="createPassword" class="form-control form-control-sm" placeholder="Tối thiểu 6 ký tự">
                </div>
                <div class="form-group">
                    <label>Số điện thoại</label>
                    <input type="text" id="createPhone" class="form-control form-control-sm" placeholder="Nhập SĐT (tuỳ chọn)">
                </div>
                <div class="form-group">
                    <label>Loại đại lý <span class="text-danger">*</span></label>
                    <select id="createRole" class="form-control form-control-sm">
                        <option value="1">Đại lý</option>
                        <option value="3">Đại lý tổng</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-dismiss="modal">Huỷ</button>
                <button class="btn btn-success btn-sm" id="btnCreate">
                    <i class="fa fa-check mr-1"></i>Tạo tài khoản
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Sửa quyền -->
<div class="modal fade" id="modalSetRole" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="fa fa-shield mr-2"></i>Sửa quyền đại lý</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="roleAlert" class="alert d-none"></div>
                <div class="form-group">
                    <label>Tài khoản</label>
                    <input type="text" id="roleUsername" class="form-control form-control-sm" readonly>
                </div>
                <div class="form-group">
                    <label>Quyền mới <span class="text-danger">*</span></label>
                    <select id="roleSelect" class="form-control form-control-sm">
                        <option value="1">Đại lý</option>
                        <option value="3">Đại lý tổng</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-dismiss="modal">Huỷ</button>
                <button class="btn btn-warning btn-sm" id="btnSetRole">
                    <i class="fa fa-check mr-1"></i>Cập nhật
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Nạp KNB -->
<div class="modal fade" id="modalTopup" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="fa fa-plus-circle mr-2"></i>Nạp KNB cho đại lý</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="topupAlert" class="alert d-none"></div>
                <div class="form-group">
                    <label>Tài khoản</label>
                    <input type="text" id="topupUsername" class="form-control form-control-sm" readonly>
                </div>
                <div class="form-group">
                    <label>Số dư hiện tại</label>
                    <input type="text" id="topupCurrent" class="form-control form-control-sm" readonly>
                </div>
                <div class="form-group">
                    <label>Số KNB cần nạp <span class="text-danger">*</span></label>
                    <input type="number" id="topupAmount" class="form-control form-control-sm" placeholder="Nhập số KNB" min="1">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-dismiss="modal">Huỷ</button>
                <button class="btn btn-primary btn-sm" id="btnTopup">
                    <i class="fa fa-check mr-1"></i>Xác nhận nạp
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$(function(){
    // Mở modal nạp KNB
    $('.btn-topup').on('click', function(){
        $('#topupUsername').val($(this).data('username'));
        $('#topupCurrent').val(Number($(this).data('kcoin')).toLocaleString('vi-VN') + ' KNB');
        $('#topupAmount').val('');
        $('#topupAlert').addClass('d-none').text('');
        $('#modalTopup').modal('show');
    });

    // Tạo tài khoản
    $('#btnCreate').on('click', function(){
        var btn = $(this).prop('disabled', true);
        $.post('/admin/ajax/agents/create', {
            username: $('#createUsername').val(),
            password: $('#createPassword').val(),
            phone:    $('#createPhone').val(),
            role:     $('#createRole').val()
        }, function(r){
            var el = $('#createAlert').removeClass('d-none alert-danger alert-success');
            el.addClass(r.status ? 'alert-success' : 'alert-danger').text(r.msg);
            if (r.status) {
                setTimeout(function(){ location.reload(); }, 1200);
            }
        }, 'json').always(function(){ btn.prop('disabled', false); });
    });

    // Sửa quyền
    $('.btn-setrole').on('click', function(){
        $('#roleUsername').val($(this).data('username'));
        $('#roleSelect').val($(this).data('role'));
        $('#roleAlert').addClass('d-none').text('');
        $('#modalSetRole').modal('show');
    });

    $('#btnSetRole').on('click', function(){
        var btn = $(this).prop('disabled', true);
        $.post('/admin/ajax/agents/set-role', {
            username: $('#roleUsername').val(),
            role:     $('#roleSelect').val()
        }, function(r){
            var el = $('#roleAlert').removeClass('d-none alert-danger alert-success');
            el.addClass(r.status ? 'alert-success' : 'alert-danger').text(r.msg);
            if (r.status) setTimeout(function(){ location.reload(); }, 1000);
        }, 'json').always(function(){ btn.prop('disabled', false); });
    });

    // Xoá đại lý
    $('.btn-delete').on('click', function(){
        var username = $(this).data('username');
        if (!confirm('Xác nhận xoá đại lý "' + username + '"? Hành động này không thể hoàn tác.')) return;
        $.post('/admin/ajax/agents/delete', { username: username }, function(r){
            if (r.status) {
                location.reload();
            } else {
                alert(r.msg);
            }
        }, 'json');
    });

    // Nạp KNB
    $('#btnTopup').on('click', function(){
        var btn = $(this).prop('disabled', true);
        $.post('/admin/ajax/agents/topup', {
            username: $('#topupUsername').val(),
            amount:   $('#topupAmount').val()
        }, function(r){
            var el = $('#topupAlert').removeClass('d-none alert-danger alert-success');
            el.addClass(r.status ? 'alert-success' : 'alert-danger').text(r.msg);
            if (r.status) {
                setTimeout(function(){ location.reload(); }, 1200);
            }
        }, 'json').always(function(){ btn.prop('disabled', false); });
    });
});
</script>
