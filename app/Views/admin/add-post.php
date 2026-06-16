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
                               placeholder="Nhập tiêu đề bài viết..." required>
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
