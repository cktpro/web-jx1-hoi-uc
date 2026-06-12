<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <span><i class="fa fa-calendar-check-o text-success"></i> Danh sách hoạt động ngày</span>
                <button class="btn btn-success btn-sm" onclick="resetForm()">
                    <i class="fa fa-plus"></i> Thêm mới
                </button>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width:40px;">#</th>
                            <th>Tên hoạt động</th>
                            <th class="text-center" style="width:34px;">T2</th>
                            <th class="text-center" style="width:34px;">T3</th>
                            <th class="text-center" style="width:34px;">T4</th>
                            <th class="text-center" style="width:34px;">T5</th>
                            <th class="text-center" style="width:34px;">T6</th>
                            <th class="text-center" style="width:34px;">T7</th>
                            <th class="text-center" style="width:34px;">CN</th>
                            <th style="width:90px;">Giờ</th>
                            <th style="width:40px;">STT</th>
                            <th style="width:80px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($list)): ?>
                        <tr>
                            <td colspan="12" class="text-center text-muted py-4">Chưa có hoạt động nào.</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($list as $item): ?>
                        <tr>
                            <td class="text-muted"><?= $item['id'] ?></td>
                            <td class="font-weight-bold"><?= htmlspecialchars($item['ten']) ?></td>
                            <?php foreach (['t2','t3','t4','t5','t6','t7','cn'] as $d): ?>
                            <td class="text-center">
                                <?php if ($item[$d]): ?>
                                    <i class="fa fa-check text-success"></i>
                                <?php else: ?>
                                    <span class="text-muted">–</span>
                                <?php endif; ?>
                            </td>
                            <?php endforeach; ?>
                            <td class="text-muted"><?= htmlspecialchars($item['thoigian']) ?></td>
                            <td class="text-muted"><?= $item['sapxep'] ?></td>
                            <td>
                                <button class="btn btn-outline-warning btn-sm"
                                        onclick="editRow(<?= htmlspecialchars(json_encode($item)) ?>)"
                                        title="Sửa">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <a href="/admin/hoatdong/delete/<?= $item['id'] ?>"
                                   onclick="return confirm('Xóa hoạt động này?')"
                                   class="btn btn-outline-danger btn-sm" title="Xóa">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <span id="form-title"><i class="fa fa-plus-circle text-success"></i> Thêm hoạt động</span>
            </div>
            <div class="card-body">
                <form method="post" action="/admin/hoatdong/save">
                    <input type="hidden" name="id" id="f-id" value="0">
                    <div class="form-group">
                        <label for="f-ten">Tên hoạt động <span class="text-danger">*</span></label>
                        <input type="text" name="ten" id="f-ten" class="form-control"
                               placeholder="VD: Đua ngựa hoàng kim..." required>
                    </div>
                    <div class="form-group">
                        <label>Ngày diễn ra</label>
                        <div class="d-flex flex-wrap" style="gap:6px;">
                            <?php foreach (['t2'=>'T2','t3'=>'T3','t4'=>'T4','t5'=>'T5','t6'=>'T6','t7'=>'T7','cn'=>'CN'] as $key => $label): ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input day-check" type="checkbox"
                                       name="<?= $key ?>" id="f-<?= $key ?>" value="1">
                                <label class="form-check-label" for="f-<?= $key ?>"><?= $label ?></label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="f-thoigian">Thời gian</label>
                        <input type="text" name="thoigian" id="f-thoigian" class="form-control"
                               value="UPDATE" placeholder="VD: 20:00 – 21:00">
                    </div>
                    <div class="form-group">
                        <label for="f-sapxep">Thứ tự hiển thị</label>
                        <input type="number" name="sapxep" id="f-sapxep" class="form-control" value="0" min="0">
                    </div>
                    <div class="d-flex">
                        <button type="submit" class="btn btn-success mr-2">
                            <i class="fa fa-save"></i> Lưu
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                            <i class="fa fa-refresh"></i> Làm mới
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function editRow(item) {
    document.getElementById('form-title').innerHTML = '<i class="fa fa-pencil text-warning"></i> Sửa hoạt động';
    document.getElementById('f-id').value      = item.id;
    document.getElementById('f-ten').value     = item.ten;
    document.getElementById('f-thoigian').value = item.thoigian;
    document.getElementById('f-sapxep').value  = item.sapxep;
    ['t2','t3','t4','t5','t6','t7','cn'].forEach(function(d) {
        document.getElementById('f-' + d).checked = (item[d] == 1);
    });
    document.querySelector('.col-md-4 .card').scrollIntoView({ behavior: 'smooth', block: 'start' });
}
function resetForm() {
    document.getElementById('form-title').innerHTML = '<i class="fa fa-plus-circle text-success"></i> Thêm hoạt động';
    document.getElementById('f-id').value       = 0;
    document.getElementById('f-ten').value      = '';
    document.getElementById('f-thoigian').value = 'UPDATE';
    document.getElementById('f-sapxep').value   = 0;
    document.querySelectorAll('.day-check').forEach(function(c) { c.checked = false; });
}
</script>
