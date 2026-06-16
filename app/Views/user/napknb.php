<div class="u-card">
    <div class="u-card-header"><i class="fa fa-plus-circle mr-2"></i>Nạp KNB</div>
    <div class="u-card-body p-0">
        <ul class="nav nav-tabs px-3 pt-2" id="napTabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab-bank">
                    <i class="fa fa-university mr-1"></i> Ngân hàng
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab-momo">
                    <i class="fa fa-mobile mr-1"></i> Momo
                </a>
            </li>
        </ul>

        <div class="tab-content p-4">

            <!-- Tab ngân hàng -->
            <div class="tab-pane fade show active" id="tab-bank">
                <div class="row justify-content-center">
                    <div class="col-md-7">
                        <div style="background:#f8f9fd;border:1px solid #e0e4ef;border-radius:8px;padding:24px;text-align:center;">
                            <i class="fa fa-university fa-3x mb-3" style="color:#c8922a;"></i>
                            <?php if (!empty($config['bank_name'])): ?>
                            <table class="table table-borderless mb-0" style="font-size:14px;">
                                <tr>
                                    <td class="text-muted text-right" style="width:45%;">Ngân hàng</td>
                                    <td class="text-left font-weight-bold"><?= htmlspecialchars($config['bank_name']) ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted text-right">Số tài khoản</td>
                                    <td class="text-left font-weight-bold" style="font-size:18px;color:#c8922a;">
                                        <?= htmlspecialchars($config['bank_number']) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted text-right">Chủ tài khoản</td>
                                    <td class="text-left font-weight-bold"><?= htmlspecialchars($config['bank_owner']) ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted text-right">Nội dung CK</td>
                                    <td class="text-left text-danger font-weight-bold"><?= htmlspecialchars($config['bank_content']) ?></td>
                                </tr>
                            </table>
                            <?php else: ?>
                            <p class="text-muted">Chưa cấu hình thông tin ngân hàng.</p>
                            <?php endif; ?>
                        </div>
                        <div class="mt-3" style="background:#fff8e1;border:1px solid #f0d9a0;border-radius:8px;padding:14px;font-size:13px;color:#7a5c1a;">
                            <i class="fa fa-exclamation-triangle mr-1"></i>
                            Sau khi chuyển khoản, vui lòng liên hệ admin để được cộng KNB thủ công.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Momo -->
            <div class="tab-pane fade" id="tab-momo">
                <div class="row justify-content-center">
                    <div class="col-md-7">
                        <div style="background:#f8f9fd;border:1px solid #e0e4ef;border-radius:8px;padding:24px;text-align:center;">
                            <i class="fa fa-mobile fa-3x mb-3" style="color:#ae2070;"></i>
                            <?php if (!empty($config['momo_number'])): ?>
                            <table class="table table-borderless mb-0" style="font-size:14px;">
                                <tr>
                                    <td class="text-muted text-right" style="width:45%;">Số Momo</td>
                                    <td class="text-left font-weight-bold" style="font-size:18px;color:#ae2070;">
                                        <?= htmlspecialchars($config['momo_number']) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted text-right">Tên tài khoản</td>
                                    <td class="text-left font-weight-bold"><?= htmlspecialchars($config['momo_owner']) ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted text-right">Nội dung</td>
                                    <td class="text-left text-danger font-weight-bold"><?= htmlspecialchars($config['bank_content']) ?></td>
                                </tr>
                            </table>
                            <?php else: ?>
                            <p class="text-muted">Chưa cấu hình thông tin Momo.</p>
                            <?php endif; ?>
                        </div>
                        <div class="mt-3" style="background:#fff8e1;border:1px solid #f0d9a0;border-radius:8px;padding:14px;font-size:13px;color:#7a5c1a;">
                            <i class="fa fa-exclamation-triangle mr-1"></i>
                            Sau khi chuyển khoản, vui lòng liên hệ admin để được cộng KNB thủ công.
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

