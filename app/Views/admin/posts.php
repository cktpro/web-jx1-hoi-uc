<div class="alert alert-info mb-3" style="font-size:13px;">
    <i class="fa fa-info-circle mr-1"></i>
    <strong>Tính năng nổi bật (<i class="fa fa-star text-warning"></i>):</strong>
    Bài viết được đánh dấu ⭐ sẽ hiển thị trong khung <strong>"Tính Năng Mới Cập Nhật"</strong> ở sidebar và trang chủ mobile.
    Click vào nút ⭐ để bật/tắt — không giới hạn số lượng.
</div>

<div class="card">
    <div class="card-header">
        <span><i class="fa fa-newspaper-o text-success"></i> Danh sách bài viết</span>
        <a href="/admin/posts/add" class="btn btn-success btn-sm">
            <i class="fa fa-plus"></i> Thêm bài mới
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>Tiêu đề</th>
                    <th style="width:120px;">Ngày đăng</th>
                    <th style="width:60px;" title="Tính năng nổi bật"><i class="fa fa-star text-warning"></i></th>
                    <th style="width:100px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($posts)): ?>
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Chưa có bài viết nào.</td>
                </tr>
                <?php else: ?>
                <?php foreach ($posts as $post): ?>
                <?php $isFeatured = in_array($post['ID'], $featured ?? []); ?>
                <tr>
                    <td class="text-muted"><?= $post['ID'] ?></td>
                    <td>
                        <a href="<?= post_url($post) ?>" target="_blank">
                            <?= htmlspecialchars($post['Title']) ?>
                        </a>
                    </td>
                    <td class="text-muted"><?= date('d/m/Y', strtotime($post['DateTime'])) ?></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-featured <?= $isFeatured ? 'btn-warning' : 'btn-outline-secondary' ?>"
                                data-id="<?= $post['ID'] ?>"
                                title="<?= $isFeatured ? 'Bỏ nổi bật' : 'Đánh dấu nổi bật' ?>">
                            <i class="fa fa-star"></i>
                        </button>
                    </td>
                    <td class="text-nowrap">
                        <a href="/admin/posts/edit/<?= $post['ID'] ?>"
                           class="btn btn-outline-warning btn-sm" title="Sửa">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a href="/admin/posts/delete/<?= $post['ID'] ?>"
                           onclick="return confirm('Xóa bài viết này?')"
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

<script>
document.querySelectorAll('.btn-featured').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var id = this.dataset.id;
        var self = this;
        $.post('/admin/ajax/posts/featured', { id: id }, function(r) {
            if (r.status) {
                if (r.active) {
                    self.classList.remove('btn-outline-secondary');
                    self.classList.add('btn-warning');
                    self.title = 'Bỏ nổi bật';
                } else {
                    self.classList.remove('btn-warning');
                    self.classList.add('btn-outline-secondary');
                    self.title = 'Đánh dấu nổi bật';
                }
            }
        }, 'json');
    });
});
</script>
