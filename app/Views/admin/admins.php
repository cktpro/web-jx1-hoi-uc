<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0"><i class="fa fa-user-secret mr-2 text-secondary"></i>Quản lý admin</h5>
    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalCreate">
        <i class="fa fa-plus mr-1"></i>Thêm admin
    </button>
</div>

<div class="card">
    <div class="card-header">
        <span><i class="fa fa-list mr-1"></i>Danh sách admin (<?= count($admins) ?>)</span>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên tài khoản</th>
                    <th>Quyền</th>
                    <th>Ngày tạo</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($admins)): ?>
                <tr><td colspan="4" class="text-center text-muted py-4">Không có admin nào</td></tr>
            <?php else: ?>
                <?php foreach ($admins as $i => $adm): ?>
                <?php $isSelf = $adm['LoginName'] === ($_SESSION['blog_admin'] ?? ''); ?>
                <tr>
                    <td class="text-muted"><?= $i + 1 ?></td>
                    <td>
                        <strong><?= htmlspecialchars($adm['LoginName']) ?></strong>
                        <?php if ($isSelf): ?>
                            <span class="badge badge-secondary ml-1">Bạn</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ((int)($adm['Premission'] ?? 1) === 1): ?>
                            <span class="badge badge-danger">Full quyền</span>
                        <?php else: ?>
                            <span class="badge badge-info">Quản lý tin tức</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-muted small">
                        <?php
                            $ca = $adm['RegTime'];
                            if ($ca instanceof \DateTime) $ca = $ca->format('Y-m-d H:i:s');
                            echo $ca ? date('d/m/Y H:i', strtotime($ca)) : '—';
                        ?>
                    </td>
                    <td>
                        <?php if (!$isSelf && (int)($adm['Premission'] ?? 1) !== 1): ?>
                        <button class="btn btn-danger btn-sm btn-delete"
                            data-username="<?= htmlspecialchars($adm['LoginName']) ?>">
                            <i class="fa fa-trash"></i> Xoá
                        </button>
                        <?php else: ?>
                        <span class="text-muted small">—</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Thêm admin -->
<div class="modal fade" id="modalCreate" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="fa fa-user-plus mr-2"></i>Thêm admin quản lý tin tức</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="createAlert" class="alert d-none"></div>
                <div class="alert alert-info py-2 small">
                    <i class="fa fa-info-circle mr-1"></i>Admin được tạo qua đây chỉ có quyền <strong>quản lý tin tức</strong>.
                </div>
                <div class="form-group">
                    <label>Tên tài khoản <span class="text-danger">*</span></label>
                    <input type="text" id="createUsername" class="form-control form-control-sm" placeholder="Nhập tên đăng nhập">
                </div>
                <div class="form-group">
                    <label>Mật khẩu <span class="text-danger">*</span></label>
                    <input type="password" id="createPassword" class="form-control form-control-sm" placeholder="Tối thiểu 6 ký tự">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-dismiss="modal">Huỷ</button>
                <button class="btn btn-success btn-sm" id="btnCreate">
                    <i class="fa fa-check mr-1"></i>Tạo admin
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$(function(){
    $('#btnCreate').on('click', function(){
        var btn = $(this).prop('disabled', true);
        $.post('/admin/ajax/admins/create', {
            username: $('#createUsername').val(),
            password: $('#createPassword').val()
        }, function(r){
            var el = $('#createAlert').removeClass('d-none alert-danger alert-success');
            el.addClass(r.status ? 'alert-success' : 'alert-danger').text(r.msg);
            if (r.status) setTimeout(function(){ location.reload(); }, 1000);
        }, 'json').always(function(){ btn.prop('disabled', false); });
    });

    $('.btn-delete').on('click', function(){
        var username = $(this).data('username');
        if (!confirm('Xác nhận xoá admin "' + username + '"?')) return;
        $.post('/admin/ajax/admins/delete', { username: username }, function(r){
            if (r.status) {
                location.reload();
            } else {
                alert(r.msg);
            }
        }, 'json');
    });
});
</script>
