<?php $this->layout("layouts/default", ["title" => APPNAME]) ?>
<?php $this->start("page") ?>

<div class="container-fluid py-5">
    <div class="card card-custom">
        <div class="card-header bg-white border-0 py-4">
            <h2 class="card-title text-center mb-0 text-danger">
                <i class="bi bi-phone me-2"></i>Sửa Sản Phẩm
            </h2>
        </div>

        <div class="card-body pt-0">
            <form action="<?= '/admin/' . $this->e($data['id']) ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                <!-- Main Content -->
                <div class="row g-3">
                    <!-- Left Column -->
                    <div class="col-lg-6">
                        <!-- Product Name -->
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control form-control-custom <?= isset($errors['name']) ? ' is-invalid' : '' ?>" name="name"
                                        placeholder="Tên điện thoại" value="<?= isset($data['name']) ? $this->e($data['name']) : '' ?>" required>
                                    <label>Tên Điện Thoại</label>
                                    <?php if (isset($errors['name'])) : ?>
                                        <span class="invalid-feedback">
                                            <strong><?= $this->e($errors['name']) ?></strong>
                                        </span>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>

                        <!-- Brand & Warranty -->
                        <div class="row mt-3 g-3">
                            <div class="col-md-6 mt-0">
                                <div class="form-floating">
                                    <select class="form-select form-control-custom <?= isset($errors['brand_id']) ? ' is-invalid' : '' ?>" name="brand_id">
                                        <?php foreach ($brands as $brand): ?>
                                            <option value="<?= $brand['id'] ?>" <?= isset($data['brand_id']) && $data['brand_id'] == $brand['id'] ? 'selected' : '' ?>><?= $brand['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>Thương Hiệu</label>
                                    <?php if (isset($errors['brand_id'])) : ?>
                                        <span class="invalid-feedback">
                                            <strong><?= $this->e($errors['brand_id']) ?></strong>
                                        </span>
                                    <?php endif ?>
                                </div>
                            </div>

                            <div class="col-md-6 mt-0">
                                <div class="form-floating">
                                    <input type="text" class="form-control form-control-custom <?= isset($errors['warranty']) ? ' is-invalid' : '' ?>" name="warranty"
                                        value="<?= isset($data['warranty']) ? $this->e($data['warranty']) : '' ?>" placeholder="Bảo hành">
                                    <label>Bảo Hành</label>
                                    <?php if (isset($errors['warranty'])) : ?>
                                        <span class="invalid-feedback">
                                            <strong><?= $this->e($errors['warranty']) ?></strong>
                                        </span>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>

                        <!-- Price & Discount -->
                        <div class="row mt-3 g-3">
                            <div class="col-md-6 mt-0">
                                <div class="form-floating">
                                    <input type="number" class="form-control form-control-custom <?= isset($errors['price']) ? ' is-invalid' : '' ?>" name="price"
                                        value="<?= isset($data['price']) ? $this->e($data['price']) : '' ?>" placeholder="Giá" required>
                                    <label>Giá (VNĐ)</label>
                                    <?php if (isset($errors['price'])) : ?>
                                        <span class="invalid-feedback">
                                            <strong><?= $this->e($errors['price']) ?></strong>
                                        </span>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="col-md-6 mt-0">
                                <div class="form-floating">
                                    <input type="number" class="form-control form-control-custom <?= isset($errors['discount_percent']) ? ' is-invalid' : '' ?>"
                                        value="<?= isset($data['discount_percent']) ? $this->e($data['discount_percent']) : '' ?>" name="discount_percent" placeholder="Giảm giá" min="0" max="100">
                                    <label>Giảm Giá (%)</label>
                                    <?php if (isset($errors['discount_percent'])) : ?>
                                        <span class="invalid-feedback">
                                            <strong><?= $this->e($errors['discount_percent']) ?></strong>
                                        </span>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>

                        <!-- Image -->
                        <div class="row g-3 mt-0">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="file" class="form-control <?= isset($errors['image']) ? ' is-invalid' : '' ?>" name="image" id="imageInput" accept="image/*"
                                        onchange="previewImage(event)">
                                    <label>Hình Ảnh</label>
                                    <input type="hidden" name="existing_image" value="<?= $this->e($data['image']) ?>">
                                </div>
                                <img id="preview" class="preview-image mt-3" style="display: none; border: 2px dashed #dee2e6; border-radius: 0.5rem; max-width: 300px;">
                                <?php if (isset($data['image'])) : ?>
                                    <div class="mt-3">
                                        <label>Hình Ảnh Hiện Tại</label>
                                    </div>
                                    <div class="mt-3">
                                        <img src="<?= $this->e($data['image']) ?>" class="img-fluid" style="border: 2px dashed #dee2e6; border-radius: 0.5rem; max-width: 300px;">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-lg-6">
                        <div class="row g-3">
                            <!-- Processor -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control form-control-custom <?= isset($errors['processor']) ? ' is-invalid' : '' ?>" name="processor"
                                        value="<?= isset($data['processor']) ? $this->e($data['processor']) : '' ?>" placeholder="Chip xử lý">
                                    <label>Chip Xử Lý</label>
                                    <?php if (isset($errors['processor'])) : ?>
                                        <span class="invalid-feedback">
                                            <strong><?= $this->e($errors['processor']) ?></strong>
                                        </span>
                                    <?php endif ?>
                                </div>
                            </div>
                            <!-- Release Date & Origin -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control form-control-custom <?= isset($errors['release_date']) ? ' is-invalid' : '' ?>" name="release_date"
                                        value="<?= isset($data['release_date']) ? $this->e($data['release_date']) : '' ?>" required>
                                    <label>Ngày Ra Mắt</label>
                                    <?php if (isset($errors['release_date'])) : ?>
                                        <span class="invalid-feedback">
                                            <strong><?= $this->e($errors['release_date']) ?></strong>
                                        </span>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control form-control-custom <?= isset($errors['origin']) ? ' is-invalid' : '' ?>" name="origin"
                                        value="<?= isset($data['origin']) ? $this->e($data['origin']) : '' ?>" placeholder="Xuất xứ" required>
                                    <label>Xuất Xứ</label>
                                    <?php if (isset($errors['origin'])) : ?>
                                        <span class="invalid-feedback">
                                            <strong><?= $this->e($errors['origin']) ?></strong>
                                        </span>
                                    <?php endif ?>
                                </div>
                            </div>

                            <!-- Storage -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select form-control-custom <?= isset($errors['storage']) ? ' is-invalid' : '' ?>" name="storage">
                                        <option value="64GB" <?= isset($data['storage']) && $data['storage'] == '64GB' ? 'selected' : '' ?>>64GB</option>
                                        <option value="128GB" <?= isset($data['storage']) && $data['storage'] == '128GB' ? 'selected' : '' ?>>128GB</option>
                                        <option value="256GB" <?= isset($data['storage']) && $data['storage'] == '256GB' ? 'selected' : '' ?>>256GB</option>
                                        <option value="512GB" <?= isset($data['storage']) && $data['storage'] == '512GB' ? 'selected' : '' ?>>512GB</option>
                                        <option value="1TB" <?= isset($data['storage']) && $data['storage'] == '1TB' ? 'selected' : '' ?>>1TB</option>
                                    </select>
                                    <label>Bộ Nhớ</label>
                                    <?php if (isset($errors['storage'])) : ?>
                                        <span class="invalid-feedback">
                                            <strong><?= $this->e($errors['storage']) ?></strong>
                                        </span>
                                    <?php endif ?>
                                </div>
                            </div>

                            <!-- Color -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control form-control-custom <?= isset($errors['color']) ? ' is-invalid' : '' ?>" name="color"
                                        value="<?= isset($data['color']) ? $this->e($data['color']) : '' ?>" placeholder="Màu sắc">
                                    <label>Màu Sắc</label>
                                    <?php if (isset($errors['color'])) : ?>
                                        <span class="invalid-feedback">
                                            <strong><?= $this->e($errors['color']) ?></strong>
                                        </span>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control form-control-custom <?= isset($errors['resolution']) ? ' is-invalid' : '' ?>" name="resolution"
                                        value="<?= isset($data['resolution']) ? $this->e($data['resolution']) : '' ?>" placeholder="Độ phân giải màn hình" required>
                                    <label>Độ phân giải màn hình</label>
                                    <?php if (isset($errors['resolution'])) : ?>
                                        <span class="invalid-feedback">
                                            <strong><?= $this->e($errors['resolution']) ?></strong>
                                        </span>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" step="0.1" class="form-control form-control-custom <?= isset($errors['screen_size']) ? ' is-invalid' : '' ?>" name="screen_size"
                                        value="<?= isset($data['screen_size']) ? $this->e($data['screen_size']) : '' ?>" placeholder="Kích thước màn hình" required>
                                    <label>Kích thước màn hình (inch)</label>
                                    <?php if (isset($errors['screen_size'])) : ?>
                                        <span class="invalid-feedback">
                                            <strong><?= $this->e($errors['screen_size']) ?></strong>
                                        </span>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control form-control-custom <?= isset($errors['screen_technology']) ? ' is-invalid' : '' ?>" name="screen_technology"
                                        value="<?= isset($data['screen_technology']) ? $this->e($data['screen_technology']) : '' ?>" placeholder="Công nghệ màn hình" required>
                                    <label>Công nghệ màn hình</label>
                                    <?php if (isset($errors['screen_technology'])) : ?>
                                        <span class="invalid-feedback">
                                            <strong><?= $this->e($errors['screen_technology']) ?></strong>
                                        </span>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Control Buttons -->
                <div class="row mt-5">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-danger btn-lg px-5 me-3" name="submit">
                            <i class="bi bi-save2 me-2"></i>Cập Nhật
                        </button>
                        <a href="/admin/products" class="btn btn-outline-secondary btn-lg px-5">
                            <i class="bi bi-arrow-left me-2"></i>Quay lại
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->stop() ?>
<?php $this->start("page_specific_js") ?>
<script>
    function previewImage(event) {
        const preview = document.getElementById('preview');
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.style.display = 'block';
                preview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }
</script>
<?php $this->stop() ?>