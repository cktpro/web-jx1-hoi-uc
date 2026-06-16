<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fa fa-pencil-square-o text-warning"></i> Sửa bài viết</span>
                <div>
                    <span id="save-msg" class="mr-2" style="font-size:13px;"></span>
                    <button type="button" class="btn btn-warning btn-sm" onclick="savePost()">
                        <i class="fa fa-save"></i> Lưu thay đổi
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Danh mục <span class="text-danger">*</span></label>
                    <select id="postCategory" class="form-control">
                        <option value="tin-tuc"   <?= ($post['Catagory'] ?? '') === 'tin-tuc'   ? 'selected' : '' ?>>Tin tức</option>
                        <option value="su-kien"   <?= ($post['Catagory'] ?? '') === 'su-kien'   ? 'selected' : '' ?>>Sự kiện</option>
                        <option value="cam-nang"  <?= ($post['Catagory'] ?? '') === 'cam-nang'  ? 'selected' : '' ?>>Cẩm nang</option>
                        <option value="tinh-nang" <?= ($post['Catagory'] ?? '') === 'tinh-nang' ? 'selected' : '' ?>>Tính năng mới cập nhật</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tiêu đề <span class="text-danger">*</span></label>
                    <input type="text" id="postTitle" class="form-control"
                           value="<?= htmlspecialchars($post['Title']) ?>"
                           oninput="autoSlug()">
                </div>
                <div class="form-group">
                    <label>Slug URL</label>
                    <div class="input-group">
                        <input type="text" id="postSlug" class="form-control"
                               value="<?= htmlspecialchars($post['Slug'] ?? '') ?>"
                               placeholder="tu-dong-tao-tu-tieu-de">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary btn-sm" type="button"
                                    onclick="autoSlug()" title="Tạo lại từ tiêu đề">
                                <i class="fa fa-refresh"></i>
                            </button>
                        </div>
                    </div>
                    <small class="text-muted">URL: <span id="slug-preview">/<?= htmlspecialchars($post['Slug'] ?? '') ?>.html</span></small>
                </div>
                <div class="form-group">
                    <label>Nội dung</label>
                    <textarea id="postCont"><?= htmlspecialchars($post['Context'] ?? '') ?></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <span><i class="fa fa-info-circle text-muted"></i> Thông tin</span>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <tr>
                        <td class="text-muted pl-3" style="border-top:none;width:40%;">ID</td>
                        <td style="border-top:none;"><?= $post['ID'] ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted pl-3">Ngày đăng</td>
                        <td><?= date('d/m/Y H:i', strtotime($post['DateTime'])) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted pl-3">Xem trước</td>
                        <td>
                            <a id="preview-link" href="/<?= htmlspecialchars($post['Slug'] ?? '') ?>.html"
                               target="_blank" class="btn btn-outline-secondary btn-sm">
                                <i class="fa fa-external-link"></i> Xem
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body text-center">
                <a href="/admin/posts" class="btn btn-outline-secondary btn-block">
                    <i class="fa fa-arrow-left"></i> Quay lại danh sách
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.tiny.cloud/1/mmrg5bvj98v0ftxqz9i5mjnkkohbp8nhjlj02grpxawn4ugg/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
<script src="/assets/js/jquery-4.0.0.min.js"></script>
<script>
tinymce.init({
    selector: '#postCont',
    height: 480,
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

function toSlug(str) {
    var map = {
        'á':'a','à':'a','ả':'a','ã':'a','ạ':'a','ă':'a','ắ':'a','ằ':'a','ẳ':'a','ẵ':'a','ặ':'a',
        'â':'a','ấ':'a','ầ':'a','ẩ':'a','ẫ':'a','ậ':'a','đ':'d',
        'é':'e','è':'e','ẻ':'e','ẽ':'e','ẹ':'e','ê':'e','ế':'e','ề':'e','ể':'e','ễ':'e','ệ':'e',
        'í':'i','ì':'i','ỉ':'i','ĩ':'i','ị':'i',
        'ó':'o','ò':'o','ỏ':'o','õ':'o','ọ':'o','ô':'o','ố':'o','ồ':'o','ổ':'o','ỗ':'o','ộ':'o',
        'ơ':'o','ớ':'o','ờ':'o','ở':'o','ỡ':'o','ợ':'o',
        'ú':'u','ù':'u','ủ':'u','ũ':'u','ụ':'u','ư':'u','ứ':'u','ừ':'u','ử':'u','ữ':'u','ự':'u',
        'ý':'y','ỳ':'y','ỷ':'y','ỹ':'y','ỵ':'y',
    };
    str = str.toLowerCase();
    str = str.replace(/./g, function(c) { return map[c] || c; });
    str = str.replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
    return str || 'n-a';
}

function autoSlug() {
    var title = document.getElementById('postTitle').value;
    var slug  = toSlug(title);
    document.getElementById('postSlug').value = slug;
    updateSlugPreview(slug);
}

document.getElementById('postSlug').addEventListener('input', function() {
    updateSlugPreview(this.value);
});

function updateSlugPreview(slug) {
    document.getElementById('slug-preview').textContent = '/' + slug + '.html';
    document.getElementById('preview-link').href = '/' + slug + '.html';
}

function savePost() {
    tinymce.triggerSave();
    var $btn = $('button[onclick="savePost()"]');
    var $msg = $('#save-msg');

    $btn.prop('disabled', true);
    $msg.removeClass('text-success text-danger').html('<i class="fa fa-spinner fa-spin"></i> Đang lưu...');

    $.post('/admin/ajax/posts/edit/<?= $post['ID'] ?>', {
        postCategory: $('#postCategory').val(),
        postTitle:    $('#postTitle').val(),
        postSlug:     $('#postSlug').val(),
        postCont:     $('#postCont').val(),
    }, function(r) {
        if (r.status) {
            $msg.addClass('text-success').html('<i class="fa fa-check"></i> ' + r.msg);
        } else {
            $msg.addClass('text-danger').html('<i class="fa fa-times"></i> ' + r.msg);
        }
        $btn.prop('disabled', false);
        setTimeout(() => $msg.html(''), 3000);
    }, 'json');
}
</script>
