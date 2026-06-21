<div class="row">
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-success mr-3"><i class="fa fa-newspaper-o"></i></div>
                <div>
                    <div class="stat-value"><?= number_format($totalPosts) ?></div>
                    <div class="stat-label">Tổng bài viết</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-warning mr-3"><i class="fa fa-calendar-check-o"></i></div>
                <div>
                    <div class="stat-value"><?= number_format($totalActivities ?? 0) ?></div>
                    <div class="stat-label">Hoạt động ngày</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-primary mr-3"><i class="fa fa-users"></i></div>
                <div>
                    <div class="stat-value"><?= number_format($totalUsers ?? 0) ?></div>
                    <div class="stat-label">Tổng user đăng ký</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-danger mr-3"><i class="fa fa-download"></i></div>
                <div>
                    <div class="stat-value"><?= number_format($downloadCount ?? 0) ?></div>
                    <div class="stat-label">Lượt tải game</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <span><i class="fa fa-bolt text-warning"></i> Truy cập nhanh</span>
            </div>
            <div class="card-body">
                <a href="/admin/posts" class="btn btn-outline-secondary btn-sm mr-2 mb-2">
                    <i class="fa fa-newspaper-o"></i> Quản lý bài viết
                </a>
                <a href="/admin/posts/add" class="btn btn-success btn-sm mr-2 mb-2">
                    <i class="fa fa-plus"></i> Thêm bài viết
                </a>
                <a href="/admin/hoatdong" class="btn btn-warning btn-sm mb-2">
                    <i class="fa fa-calendar"></i> Hoạt động ngày
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <span><i class="fa fa-info-circle text-primary"></i> Thông tin hệ thống</span>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <tr><td class="text-muted pl-3" style="width:40%;border-top:none;">PHP</td><td style="border-top:none;"><?= phpversion() ?></td></tr>
                    <tr><td class="text-muted pl-3">Timezone</td><td><?= date_default_timezone_get() ?></td></tr>
                    <tr><td class="text-muted pl-3">Thời gian</td><td><?= date('d/m/Y H:i:s') ?></td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
