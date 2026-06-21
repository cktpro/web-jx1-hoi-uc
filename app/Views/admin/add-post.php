<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <span><i class="fa fa-pencil-square-o text-success"></i> Thêm bài viết mới</span>
            </div>
            <div class="card-body">
                <form method="post" action="/admin/posts/add">
                    <div class="form-group">
                        <label for="postCategory">Danh mục <span class="text-danger">*</span></label>
                        <select name="postCategory" id="postCategory" class="form-control" required>
                            <option value="">-- Chọn danh mục --</option>
                            <option value="tin-tuc">Tin tức</option>
                            <option value="su-kien">Sự kiện</option>
                            <option value="cam-nang">Cẩm nang</option>
                            <option value="tinh-nang">Tính năng mới cập nhật</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="postTitle">Tiêu đề <span class="text-danger">*</span></label>
                        <input type="text" name="postTitle" id="postTitle" class="form-control"
                               placeholder="Nhập tiêu đề bài viết..." oninput="autoSlug()" required>
                    </div>
                    <div class="form-group">
                        <label for="postSlug">Slug URL</label>
                        <div class="input-group">
                            <input type="text" name="postSlug" id="postSlug" class="form-control"
                                   placeholder="tu-dong-tao-tu-tieu-de">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary btn-sm" type="button"
                                        onclick="autoSlug()" title="Tạo lại từ tiêu đề">
                                    <i class="fa fa-refresh"></i>
                                </button>
                            </div>
                        </div>
                        <small class="text-muted">URL: <span id="slug-preview">/slug.html</span></small>
                    </div>
                    <div class="form-group">
                        <label for="postCont">Nội dung</label>
                        <textarea name="postCont" id="postCont" placeholder="Nội dung bài viết..."></textarea>
                    </div>
                    <div class="d-flex">
                        <button type="submit" class="btn btn-success mr-2" onclick="tinymce.triggerSave()">
                            <i class="fa fa-save"></i> Đăng bài
                        </button>
                        <a href="/admin/posts" class="btn btn-outline-secondary">
                            <i class="fa fa-arrow-left"></i> Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.tiny.cloud/1/mmrg5bvj98v0ftxqz9i5mjnkkohbp8nhjlj02grpxawn4ugg/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
<script>
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
    var slug = toSlug(document.getElementById('postTitle').value);
    document.getElementById('postSlug').value = slug;
    document.getElementById('slug-preview').textContent = '/' + slug + '.html';
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('postSlug').addEventListener('input', function() {
        document.getElementById('slug-preview').textContent = '/' + this.value + '.html';
    });
});

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
