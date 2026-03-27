<?php $this->layout("layouts/default", ["title" => APPNAME]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<?php $this->stop() ?>

<?php $this->start("page") ?>

<div class="wp-content" style="margin-top: 100px;">
    <div class="main_content mx-auto" style="width: 76%;">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="/product-list">Điện thoại</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $this->e($brandName) ?></li>
                    </ol>
                </nav>
                <h1><?= $this->e($brandName) ?></h1>
                <div class="row g-4 mt-4">
                    <div class="col-md-3">
                        <h3>Bộ lọc tìm kiếm</h3>
                        <?php
                        $selected_price = $_GET['price_range'] ?? '';
                        $filteredPhones = $phones;
                        if ($selected_price) {
                            $filteredPhones = array_filter($phones, function ($phone) use ($selected_price) {
                                $price = $phone->price;
                                switch ($selected_price) {
                                    case 'under-5m':
                                        return $price < 5000000;
                                    case '5m-10m':
                                        return $price >= 5000000 && $price <= 10000000;
                                    case '10m-15m':
                                        return $price > 10000000 && $price <= 15000000;
                                    case 'above-15m':
                                        return $price > 15000000;
                                    default:
                                        return true;
                                }
                            });
                        }
                        ?>
                        <form method="GET" action="" id="searchForm">
                            <input type="hidden" name="search" value="<?= $this->e($brandName) ?>">
                            <div class="accordion" id="accordionPanelsStayOpenExample">
                                <!-- MỨC GIÁ -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#priceFilter" aria-expanded="true" aria-controls="priceFilter">
                                            Mức giá
                                        </button>
                                    </h2>
                                    <div id="priceFilter" class="accordion-collapse collapse show">
                                        <div class="accordion-body">
                                            <ul>
                                                <li>
                                                    <div>
                                                        <input type="radio" id="price-0" name="price_range" value="" <?= $selected_price == '' ? 'checked' : '' ?> onchange="document.getElementById('searchForm').submit();">
                                                        <label for="price-0"> Tất cả</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div>
                                                        <input type="radio" id="price-1" name="price_range" value="under-5m" <?= $selected_price == 'under-5m' ? 'checked' : '' ?> onchange="document.getElementById('searchForm').submit();">
                                                        <label for="price-1"> Dưới 5 triệu</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div>
                                                        <input type="radio" id="price-2" name="price_range" value="5m-10m" <?= $selected_price == '5m-10m' ? 'checked' : '' ?> onchange="document.getElementById('searchForm').submit();">
                                                        <label for="price-2"> 5 triệu - 10 triệu</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div>
                                                        <input type="radio" id="price-3" name="price_range" value="10m-15m" <?= $selected_price == '10m-15m' ? 'checked' : '' ?> onchange="document.getElementById('searchForm').submit();">
                                                        <label for="price-3"> 10 triệu - 15 triệu</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div>
                                                        <input type="radio" id="price-4" name="price_range" value="above-15m" <?= $selected_price == 'above-15m' ? 'checked' : '' ?> onchange="document.getElementById('searchForm').submit();">
                                                        <label for="price-4"> Trên 15 triệu</label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-9">
                        <div class="row g-1">
                            <?php if (!empty($filteredPhones)) : ?>
                                <?php foreach ($filteredPhones as $phone) : ?>
                                    <?php
                                    $originalPrice = $phone->price;
                                    $discountedPrice = $phone->price * (1 - $phone->discount_percent / 100);
                                    $discounted_price = $originalPrice - $discountedPrice;
                                    ?>
                                    <div class="col-lg-3">
                                        <a href="<?= '/product/' . $this->e($phone->id) ?>" class="col-hover card text-decoration-none pt-5 px-2 border-0" style="overflow: hidden;">
                                            <img src="<?= $this->e($phone->image) ?>" class="card-img-top object-fit-contain" alt="<?= $this->e($phone->image) ?>" style="height: 250px;">
                                            <div class="card-body mt-4">
                                                <p class="card-text mb-0 text-secondary text-decoration-line-through fs-6">
                                                    <?= number_format($this->e($phone->price), 0, ',', '.') ?> đ
                                                </p>
                                                <p class="card-text mb-0 fw-medium fs-5">
                                                    <?= number_format($this->e($discountedPrice), 0, ',', '.') ?> đ
                                                </p>
                                                <p class="card-text mb-0 fs-6 text-success fw-medium">
                                                    Giảm <?= number_format($this->e($discounted_price), 0, ',', '.') ?> đ
                                                </p>
                                                <h5 class="card-title mt-4"><?= $this->e($phone->name) ?> <?= $this->e($phone->storage) ?></h5>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach ?>
                            <?php else : ?>
                                <p>&nbsp;</p>
                                <div class="alert alert-light" role="alert">
                                    Không có sản phẩm nào thuộc thương hiệu này.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>
<?php $this->stop() ?>