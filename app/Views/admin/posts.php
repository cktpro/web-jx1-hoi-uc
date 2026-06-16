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
                    <th style="width:100px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($posts)): ?>
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">Chưa có bài viết nào.</td>
                </tr>
                <?php else: ?>
                <?php foreach ($posts as $post): ?>
                <tr>
                    <td class="text-muted"><?= $post['ID'] ?></td>
                    <td>
                        <a href="<?= post_url($post) ?>" target="_blank">
                            <?= htmlspecialchars($post['Title']) ?>
                        </a>
                    </td>
                    <td class="text-muted"><?= date('d/m/Y', strtotime($post['DateTime'])) ?></td>
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
