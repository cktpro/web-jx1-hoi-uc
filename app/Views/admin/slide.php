<?php $saved = isset($_GET['saved']); ?>

<?php if ($saved): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fa fa-check-circle mr-2"></i> Lưu slide thành công!
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
<?php endif; ?>

<style>
.slide-item { border: 1px solid #e9ecef; border-radius: 4px; padding: 16px; margin-bottom: 16px; background: #fafafa; }
.slide-item .preview { width: 100%; height: 120px; object-fit: cover; border-radius: 4px; border: 1px solid #dee2e6; background: #f0f0f0; display: block; margin-top: 8px; }
.slide-item .no-preview { width: 100%; height: 120px; display: flex; align-items: center; justify-content: center; background: #f0f0f0; border-radius: 4px; border: 1px dashed #ccc; color: #aaa; font-size: 13px; margin-top: 8px; }
.slide-number { font-weight: 700; color: #495057; font-size: 13px; margin-bottom: 10px; }
</style>

<form method="post" action="/admin/slide">
<div class="row">
    <!-- Slide PC -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <span><i class="fa fa-desktop text-primary"></i> Slide PC (4 ảnh)</span>
            </div>
            <div class="card-body">
                <?php for ($i = 1; $i <= 4; $i++):
                    $img  = $slide["slide_img$i"]  ?? '';
                    $link = $slide["slide_link$i"] ?? '';
                ?>
                <div class="slide-item">
                    <div class="slide-number"><i class="fa fa-image text-muted mr-1"></i> Slide <?= $i ?></div>
                    <div class="form-group mb-2">
                        <label class="text-muted" style="font-size:12px;">URL Ảnh</label>
                        <div class="input-group">
                            <input type="text" name="slide_img<?= $i ?>" id="pc_img_<?= $i ?>"
                                   class="form-control form-control-sm"
                                   value="<?= htmlspecialchars($img) ?>"
                                   placeholder="https://..."
                                   onchange="previewImg(this, 'pc_prev_<?= $i ?>')">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary btn-sm"
                                        onclick="document.getElementById('pc_img_<?= $i ?>').select()">
                                    <i class="fa fa-paste"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label class="text-muted" style="font-size:12px;">Link khi click</label>
                        <input type="text" name="slide_link<?= $i ?>" class="form-control form-control-sm"
                               value="<?= htmlspecialchars($link) ?>" placeholder="https://...">
                    </div>
                    <?php if ($img): ?>
                    <img id="pc_prev_<?= $i ?>" src="<?= htmlspecialchars($img) ?>"
                         class="preview" alt="Slide <?= $i ?>"
                         onerror="this.style.display='none';document.getElementById('pc_no_<?= $i ?>').style.display='flex'">
                    <div id="pc_no_<?= $i ?>" class="no-preview" style="display:none;">Ảnh không load được</div>
                    <?php else: ?>
                    <img id="pc_prev_<?= $i ?>" class="preview" style="display:none;" alt="">
                    <div id="pc_no_<?= $i ?>" class="no-preview"><i class="fa fa-picture-o mr-2"></i>Chưa có ảnh</div>
                    <?php endif; ?>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>

    <!-- Slide Mobile -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <span><i class="fa fa-mobile text-success"></i> Slide Mobile (5 ảnh)</span>
            </div>
            <div class="card-body">
                <?php
                $mobileFields = [
                    'slide_duoi_img'  => 'Slide 1',
                    'slide_duoi_img1' => 'Slide 2',
                    'slide_duoi_img2' => 'Slide 3',
                    'slide_duoi_img3' => 'Slide 4',
                    'slide_duoi_img4' => 'Slide 5',
                ];
                $idx = 1;
                foreach ($mobileFields as $field => $label):
                    $img = $duoi[$field] ?? '';
                ?>
                <div class="slide-item">
                    <div class="slide-number"><i class="fa fa-image text-muted mr-1"></i> <?= $label ?></div>
                    <div class="form-group mb-2">
                        <label class="text-muted" style="font-size:12px;">URL Ảnh</label>
                        <div class="input-group">
                            <input type="text" name="<?= $field ?>" id="mb_img_<?= $idx ?>"
                                   class="form-control form-control-sm"
                                   value="<?= htmlspecialchars($img) ?>"
                                   placeholder="https://..."
                                   onchange="previewImg(this, 'mb_prev_<?= $idx ?>')">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary btn-sm"
                                        onclick="document.getElementById('mb_img_<?= $idx ?>').select()">
                                    <i class="fa fa-paste"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php if ($img): ?>
                    <img id="mb_prev_<?= $idx ?>" src="<?= htmlspecialchars($img) ?>"
                         class="preview" alt="<?= $label ?>"
                         onerror="this.style.display='none';document.getElementById('mb_no_<?= $idx ?>').style.display='flex'">
                    <div id="mb_no_<?= $idx ?>" class="no-preview" style="display:none;">Ảnh không load được</div>
                    <?php else: ?>
                    <img id="mb_prev_<?= $idx ?>" class="preview" style="display:none;" alt="">
                    <div id="mb_no_<?= $idx ?>" class="no-preview"><i class="fa fa-picture-o mr-2"></i>Chưa có ảnh</div>
                    <?php endif; ?>
                </div>
                <?php $idx++; endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div class="d-flex mb-4">
    <button type="submit" class="btn btn-primary mr-2">
        <i class="fa fa-save"></i> Lưu tất cả slide
    </button>
    <a href="/" target="_blank" class="btn btn-outline-secondary">
        <i class="fa fa-eye"></i> Xem trang chủ
    </a>
</div>
</form>

<script>
function previewImg(input, previewId) {
    var url   = input.value.trim();
    var prev  = document.getElementById(previewId);
    // tìm div no-preview kế bên
    var noId  = previewId.replace('prev', 'no');
    var noPrev = document.getElementById(noId);
    if (url) {
        prev.src = url;
        prev.style.display = 'block';
        if (noPrev) noPrev.style.display = 'none';
        prev.onerror = function() {
            prev.style.display = 'none';
            if (noPrev) noPrev.style.display = 'flex';
        };
    } else {
        prev.style.display = 'none';
        if (noPrev) noPrev.style.display = 'flex';
    }
}
// Live preview khi gõ URL (debounce)
document.querySelectorAll('input[id^="pc_img_"], input[id^="mb_img_"]').forEach(function(el) {
    var timer;
    el.addEventListener('input', function() {
        clearTimeout(timer);
        var self = this;
        timer = setTimeout(function() {
            var prevId = self.id.replace('pc_img_', 'pc_prev_').replace('mb_img_', 'mb_prev_');
            previewImg(self, prevId);
        }, 600);
    });
});
</script>
