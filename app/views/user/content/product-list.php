<?php $this->layout("layouts/default", ["title" => APPNAME]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<?php $this->stop() ?>

<?php $this->start("page") ?>

<div class="wp-content" style=" margin-top: 100px;">
    <div class="main_content mx-auto" style="width: 76%;">
        <div class="row">
            <div class="col-md-9">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home">Trang chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Điện thoại</li>
                    </ol>
                </nav>
                <p>&nbsp;</p>
                <h1>Điện thoại</h1>
            </div>
            <div class="col-md-3">
                <img src="../img/banner_product.png" alt="/product-list" class="img-fluid" style="object-fit: cover;">
            </div>
        </div>
        <div class="row mt-4">
            <div class="col">
                <div id="carouselExampleIndicators" class="carousel slide mx-auto d-md-block d-none" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active" data-bs-interval="3000">
                            <div class="row">
                                <a href="#" class="col-md w-100"><img src="../img/silde_5.png" class="border-0 border rounded w-100" style="height: 220px;" alt="..."></a>
                                <a href="#" class="col-md w-100"><img src="../img/silde_6.png" class="border-0 border rounded w-100" style="height: 220px;" alt="..."></a>
                            </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="3000">
                            <div class="row">
                                <a href="#" class="col-md w-100"><img src="../img/silde_3.png" class="border-0 border rounded w-100" style="height: 220px;" alt="..."></a>
                                <a href="#" class="col-md w-100"><img src="../img/silde_4.png" class="border-0 border rounded w-100" style="height: 220px;" alt="..."></a>
                            </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="3000">
                            <div class="row">
                                <a href="#" class="col-md w-100"><img src="../img/silde_1.png" class="border-0 border rounded w-100" style="height: 220px;" alt="..."></a>
                                <a href="#" class="col-md w-100"><img src="../img/silde_2.png" class="border-0 border rounded w-100" style="height: 220px;" alt="..."></a>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="fa-solid fa-chevron-left" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="fa-solid fa-chevron-right" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="container">
                <div class="row g-3">
                    <?php foreach ($brands as $brand): ?>
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-3">
                            <a href="/product-list/<?= $this->e($brand['name']) ?>" class="text-decoration-none">
                                <div class="d-flex align-items-center brand-card border border-2 rounded p-2">
                                    <?php if (!empty($brand['image'])): ?>
                                        <img src="<?= $this->e($brand['image']) ?>" alt="<?= $this->e($brand['name']) ?>" class="me-2" style="width: 40px; height: 40px; object-fit: contain;">
                                    <?php endif; ?>
                                    <?= $this->e($brand['name']) ?>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-3">
                <h3>Bộ lọc tìm kiếm</h3>
                <?php
                $selected_price = $_GET['price_range'] ?? '';
                $selected_storage = $_GET['storage'] ?? '';
                ?>
                <form method="GET" action="/search" id="searchForm">
                    <!-- fix search -->
                    <input type="hidden" name="search" value="<?= isset($_GET['search']) ? $this->e($_GET['search']) : '' ?>"> 
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

                        <!-- DUNG LƯỢNG ROM -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#romFilter" aria-expanded="true" aria-controls="romFilter">
                                    Dung lượng ROM
                                </button>
                            </h2>
                            <div id="romFilter" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <ul>
                                        <li>
                                            <div>
                                                <input type="radio" id="rom-0" name="storage" value="" <?= $selected_storage == '' ? 'checked' : '' ?> onchange="document.getElementById('searchForm').submit();">
                                                <label for="rom-0"> Tất cả</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div>
                                                <input type="radio" id="rom-1" name="storage" value="128GB" <?= $selected_storage == '128GB' ? 'checked' : '' ?> onchange="document.getElementById('searchForm').submit();">
                                                <label for="rom-1"> ≤128 GB</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div>
                                                <input type="radio" id="rom-2" name="storage" value="256GB" <?= $selected_storage == '256GB' ? 'checked' : '' ?> onchange="document.getElementById('searchForm').submit();">
                                                <label for="rom-2"> 256GB</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div>
                                                <input type="radio" id="rom-3" name="storage" value="512GB" <?= $selected_storage == '512GB' ? 'checked' : '' ?> onchange="document.getElementById('searchForm').submit();">
                                                <label for="rom-3"> 512GB</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div>
                                                <input type="radio" id="rom-4" name="storage" value="1TB" <?= $selected_storage == '1TB' ? 'checked' : '' ?> onchange="document.getElementById('searchForm').submit();">
                                                <label for="rom-4"> 1TB</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-9" id="chaylaiday">
                <?php if (!empty($search)) : ?>
                    <p>Kết quả tìm kiếm cho: <strong><?= $this->e($search) ?></strong></p>
                <?php endif; ?>
                <div class="row g-1">
                    <?php if (!empty($phones)) : ?>
                        <?php foreach ($phones as $phone) : ?>
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
                            <?= $this->e($error) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>
<?php $this->stop() ?>
