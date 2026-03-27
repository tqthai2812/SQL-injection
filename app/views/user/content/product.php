<?php $this->layout("layouts/default", ["title" => APPNAME]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<style>
    .option-item input:checked+span {
        border-color: #007bff !important;
        background-color: #e7f1ff;
        font-weight: bold;
    }

    .option-item input:checked+span::after {
        content: "✓";
        color: #ff0000;
        font-weight: bold;
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
    }

    .option-item span {
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        padding-right: 35px !important;
    }

    .option-item:hover span {
        border-color: #007bff !important;
    }
</style>
<?php $this->stop() ?>

<?php $this->start("page") ?>

<div class="wp-content" style=" margin-top: 100px;">

    <div class="main_content mx-auto" style="width: 76%;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="/product-list">Điện Thoại</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $this->e($phone->name) ?></li>
            </ol>
        </nav>
        <?php if (!empty($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success_message']; ?>
            </div>
            <?php unset($_SESSION['success_message']);
            ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error_message']; ?>
            </div>
            <?php unset($_SESSION['error_message']);
            ?>
        <?php endif; ?>
        <div class="product-details row">
            <div class="col-md bg-white border rounded" id="product-image">
                <img class="w-100 object-fit-contain" alt="<?= $this->e($phone->name) ?>"
                    src="../<?= $this->e($phone->image) ?>" style="height: 336px;">
            </div>
            <div class="col-md ps-md-5">
                <div class="d-flex flex-column justify-content-between h-100">
                    <div>
                        <h1 id="product-name"><?= $this->e($phone->name) ?></h1>
                        <div class="d-flex">
                            <p class="fs-2 text-danger"><?= number_format((float)str_replace('.', '', $discountedPrice), 0, ',', '.') ?> đ
                                <?php if ($phone->discount_percent > 0): ?>
                            <p class="ms-3 mt-3 text-decoration-line-through"><?= $originalPrice ?> đ</p>
                        <?php endif; ?>
                        </div>
                        <div>
                            <form method="get">
                                <!-- Phần chọn dung lượng -->
                                <div class="mb-4 container">
                                    <label class="fw-bold mb-2">Chọn dung lượng:</label>
                                    <div class="options-container d-flex gap-3 row">
                                        <?php foreach ($storages as $storage): ?>
                                            <label class="option-item position-relative col-4">
                                                <input
                                                    type="radio"
                                                    name="storage"
                                                    value="<?= $this->e($storage) ?>"
                                                    <?= $storage === $selectedStorage ? 'checked' : '' ?>
                                                    onchange="this.form.submit()"
                                                    class="visually-hidden">
                                                <span class="d-block px-4 py-2 border rounded">
                                                    <?= $this->e($storage) ?>
                                                </span>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- Phần chọn màu sắc -->
                                <div class="mb-4 container">
                                    <label class="fw-bold mb-2">Chọn màu sắc:</label>
                                    <div class="options-container d-flex gap-3 row">
                                        <?php foreach ($colors as $color): ?>
                                            <label class="option-item position-relative col-4">
                                                <input type="radio"
                                                    name="color"
                                                    value="<?= $this->e($color) ?>"
                                                    <?= $color === $selectedColor ? 'checked' : '' ?>
                                                    onchange="this.form.submit()"
                                                    class="visually-hidden">
                                                <span class="d-block px-4 py-2 border rounded">
                                                    <?= $this->e($color) ?>
                                                </span>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <form method="post" action="/cart/add">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                        <input type="hidden" name="product_id" value="<?= $this->e($phone->id) ?>">
                        <input type="hidden" name="product_price" value="<?= $this->e($discountedPrice) ?>">
                        <input type="hidden" name="product_color" value="<?= $selectedColor ?>">
                        <input type="hidden" name="product_storage" value="<?= $selectedStorage ?>">
                        <div class="row g-3 mt-md-0 mt-1 ms-1 ms-md-0 d-flex justify-content-between">
                            <button type="submit" class="col-md-7 col bg-danger text-white fw-semibold border-0 rounded py-md-2 text-center">
                                Mua Ngay
                            </button>
                            <button type="submit" class="col-md-4 col text-danger border rounded border-danger text-center w-md-75 d-block pt-2 pb-2">
                                <i class="fa-solid fa-cart-shopping"></i> Thêm giỏ hàng
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-3 row">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                        data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane"
                        aria-selected="true">Thông Số Kĩ Thuật</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                        data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane"
                        aria-selected="false">Thông Tin Sản Phẩm</button>
                </li>
            </ul>
            <div class="tab-content border border-top-0 bg-white px-5 pt-3" id="myTabContent">
                <div class="tab-pane fade show active mx-0" id="home-tab-pane" role="tabpanel"
                    aria-labelledby="home-tab" tabindex="0">
                    <p class="fw-semibold">Màn Hình</p>
                    <table class="table table-striped table-bordered rounded overflow-hidden">
                        <tr>
                            <th scope="row" class="align-middle w-25">Kích thước mà hình</th>
                            <td><?= $this->e($phone->screen_size) ?></td>
                        </tr>
                        <tr>
                            <th scope="row" class="align-middle w-25">Công nghệ màn hình</th>
                            <td><?= $this->e($phone->screen_technology) ?></td>
                        </tr>
                        <tr>
                            <th scope="row" class="align-middle w-25">Độ phân giải</th>
                            <td><?= $this->e($phone->resolution) ?></td>
                        </tr>
                    </table>
                    <p class="fw-semibold">Bộ xử lí</p>
                    <table class="table table-striped table-bordered rounded overflow-hidden">
                        <tr>
                            <th scope="row" class="align-middle w-25">Chip xử lí</th>
                            <td>
                                <?= $this->e($phone->processor) ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                    tabindex="0">
                    <table class="table table-striped table-bordered rounded overflow-hidden">
                        <tr>
                            <th scope="row" class="align-middle w-25">Xuất xứ</th>
                            <td>
                                <?= $this->e($phone->origin) ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="align-middle w-25">Thương hiệu</th>
                            <td>
                                <?= $this->e($brandName) ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="align-middle w-25">Bảo hành</th>
                            <td>
                                <?= $this->e($phone->warranty) ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="align-middle w-25">Thời điểm ra mắt</th>
                            <td>
                                <?= $this->e($phone->release_date) ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>
<?php $this->stop() ?>
