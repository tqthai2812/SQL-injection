<?php $this->layout("layouts/default", ["title" => "Lab Thực Nghiệm SQL Injection - " . APPNAME]) ?>

<?php $this->start("page_specific_css") ?>
<style>
    .error-msg {
        color: #d8000c;
        background-color: #ffd2d2;
        padding: 15px;
        border: 1px solid #d8000c;
        border-radius: 5px;
        margin-top: 20px;
        font-family: monospace;
        word-break: break-all;
    }

    .product-details {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
</style>
<?php $this->stop() ?>

<?php $this->start("page") ?>
<div id="wp-content" class="bg-body-tertiary pb-5" style="margin-top: 57px;">
    <div class="container pt-4">
        <h2 class="mb-4 text-danger">Trang Kiểm Thử Lỗ Hổng (Lab)</h2>

        <?php if ($sql_error): ?>
            <div class="error-msg">
                <strong>Lỗi Truy Vấn (Database Error):</strong> <br>
                <?= $sql_error ?>
            </div>
        <?php elseif ($product): ?>
            <div class="product-details row">
                <div class="col-md-4 text-center">
                    <img src="<?= $this->e($product['image']) ?>" alt="<?= $this->e($product['name']) ?>" class="img-fluid rounded">
                </div>
                <div class="col-md-8">
                    <h3 class="text-primary"><?= $this->e($product['name']) ?> - <?= $this->e($product['storage']) ?></h3>
                    <h4 class="text-danger fw-bold"><?= number_format($product['price'], 0, ',', '.') ?> ₫</h4>
                    <ul class="mt-3 list-group list-group-flush">
                        <li class="list-group-item"><strong>Màu sắc:</strong> <?= $this->e($product['color']) ?></li>
                        <li class="list-group-item"><strong>Chip xử lý:</strong> <?= $this->e($product['processor']) ?></li>
                        <li class="list-group-item"><strong>Xuất xứ:</strong> <?= $this->e($product['origin']) ?></li>
                        <li class="list-group-item"><strong>Bảo hành:</strong> <?= $this->e($product['warranty']) ?></li>
                    </ul>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">Không tìm thấy sản phẩm nào khớp với ID.</div>
        <?php endif; ?>

    </div>
</div>
<?php $this->stop() ?>