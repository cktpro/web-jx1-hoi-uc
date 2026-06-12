<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <span><i class="fa fa-pencil-square-o text-warning"></i> Sửa bài viết</span>
            </div>
            <div class="card-body">
                <form method="post" action="/admin/posts/edit/<?= $post['postID'] ?>">
                    <div class="form-group">
                        <label for="postTitle">Tiêu đề <span class="text-danger">*</span></label>
                        <input type="text" name="postTitle" id="postTitle" class="form-control"
                               value="<?= htmlspecialchars($post['postTitle']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="postImage">Ảnh đại diện (URL)</label>
                        <input type="text" name="postImage" id="postImage" class="form-control"
                               value="<?= htmlspecialchars($post['postImage'] ?? '') ?>">
                        <?php if (!empty($post['postImage'])): ?>
                        <img src="<?= htmlspecialchars($post['postImage']) ?>" alt="preview"
                             class="mt-2 rounded" style="max-height:120px;max-width:100%;object-fit:cover;">
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="postDesc">Mô tả ngắn</label>
                        <textarea name="postDesc" id="postDesc" class="form-control" rows="3"><?= htmlspecialchars($post['postDesc'] ?? '') ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="postCont">Nội dung</label>
                        <textarea name="postCont" id="postCont"><?= htmlspecialchars($post['postCont'] ?? '') ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="postTags">Tags</label>
                        <input type="text" name="postTags" id="postTags" class="form-control"
                               value="<?= htmlspecialchars($post['postTags'] ?? '') ?>">
                    </div>
                    <div class="d-flex">
                        <button type="submit" class="btn btn-warning mr-2" onclick="tinymce.triggerSave()">
                            <i class="fa fa-save"></i> Lưu thay đổi
                        </button>
                        <a href="/admin/posts" class="btn btn-outline-secondary">
                            <i class="fa fa-arrow-left"></i> Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <span><i class="fa fa-list-ul text-primary"></i> Danh mục</span>
            </div>
            <div class="card-body">
                <?php foreach ($cats as $cat): ?>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox"
                           name="cats[]" value="<?= $cat['catID'] ?>"
                           id="cat<?= $cat['catID'] ?>"
                           <?= in_array($cat['catID'], $postCatIds) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="cat<?= $cat['catID'] ?>">
                        <?= htmlspecialchars($cat['catTitle']) ?>
                    </label>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <span><i class="fa fa-info-circle text-muted"></i> Thông tin</span>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <tr>
                        <td class="text-muted pl-3" style="border-top:none;width:40%;">ID</td>
                        <td style="border-top:none;"><?= $post['postID'] ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted pl-3">Ngày đăng</td>
                        <td><?= date('d/m/Y H:i', strtotime($post['postDate'])) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted pl-3">Slug</td>
                        <td style="word-break:break-all;font-size:12px;"><?= htmlspecialchars($post['postSlug']) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted pl-3">Xem trước</td>
                        <td>
                            <a href="/<?= htmlspecialchars($post['postSlug']) ?>.html" target="_blank" class="btn btn-outline-secondary btn-sm">
                                <i class="fa fa-external-link"></i> Xem
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.tiny.cloud/1/mmrg5bvj98v0ftxqz9i5mjnkkohbp8nhjlj02grpxawn4ugg/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
<script>
tinymce.init({
    selector: '#postCont',
    height: 520,
    menubar: true,
    plugins: 'advlist autolink lists link image charmap anchor searchreplace visualblocks code fullscreen insertdatetime media table wordcount',
    toolbar:
        'undo redo | blocks | bold italic underline strikethrough | ' +
        'forecolor backcolor | alignleft aligncenter alignright alignjustify | ' +
        'bullist numlist outdent indent | link image media table | ' +
        'code fullscreen',
    content_style: 'body { font-family: Arial, sans-serif; font-size: 14px; line-height: 1.6; padding: 8px; }',
    image_advtab: true,
    relative_urls: false,
    remove_script_host: false,
    promotion: false,
    branding: false,
    setup: function(editor) {
        editor.on('change input', function() { editor.save(); });
    }
});
</script>
