<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $this->e($title) ?></title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://kit.fontawesome.com/950843fd38.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <link href="/css/main.css?v=<?php echo time(); ?>" rel="stylesheet">

    <?= $this->section("page_specific_css") ?>
</head>

<body>
    <div id="header" class="bg-danger py-2" style="position: fixed; top: 0px; right: 0px; left: 0px; z-index: 1000;">
        <div id="header-main" class="row mx-auto" style="width: 85%;">
            <div id="logo" class="col-2 d-flex justify-content-center align-items-center">
                <a href="/">
                    <img src="../img/logoheader.png" alt="" class="object-fit-cover" style="width: 170px;">
                </a>
            </div>
            <div id="search" class="col-7 d-flex justify-content-between row">
                <div class="ms-4 col-3 border border-0 text-white rounded-pill bg-dark bg-opacity-50 dropdown d-flex align-items-center" style="width: 142px;">
                    <div class="dropdown-toggle d-flex align-items-center">
                        <i class="fa-solid fa-indent d-flex justify-content-center align-items-center me-3"></i>
                        <p class="m-0 d-flex justify-content-center align-items-center">Danh Mục</p>
                    </div>
                    <ul class="dropdown-menu" style="min-width: 200px;">
                        <?php if (!empty($_SESSION['brands'])): ?>
                            <?php foreach ($_SESSION['brands'] as $brand): ?>
                                <li>
                                    <a href="/product-list/<?= $this->e($brand['name']) ?>" class="text-decoration-none">
                                        <?php if (!empty($brand['image'])): ?>
                                            <img src="<?= $this->e($brand['image']) ?>" alt="<?= $this->e($brand['name']) ?>" class="me-2" style="width: 40px; height: 40px; object-fit: contain;">
                                        <?php endif; ?>
                                        <?= $this->e($brand['name']) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li><a class="dropdown-item py-2" href="#">No brands available</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <form id="search-form" class="border rounded-pill col-9 row border bg-body" action="/search" method="GET">
                    <input id="input_search" class="rounded-pill p-2 col-11 border border-0" type="text" name="search" placeholder="Nhập sản phẩm cần tìm" value="<?= isset($_GET['search']) ? $this->e($_GET['search']) : '' ?>" style="outline: none;">
                    <button class="col-1 m-0 border rounded-circle d-flex justify-content-center align-items-center border-0 fa-solid fa-magnifying-glass" type="submit"></button>
                </form>
            </div>
            <div id="icon-shop" class="col-3 d-flex justify-content-end">
                <?php if (!AUTHGUARD()->isUserLoggedIn()) : ?>
                    <a href="/login" class="p-2 px-3 me-2 fa-solid fa-user d-flex justify-content-center align-items-center border border-0 text-white rounded-circle bg-dark bg-opacity-50"></a>
                <?php else : ?>
                    <div class="nav-item dropstart">
                        <a class="p-2 px-3 me-2 fa-solid fa-user d-flex justify-content-center align-items-center border border-0 text-white rounded-circle bg-success nav-link h-100" href="#" role="button" data-bs-toggle="dropdown">
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="/user/info">
                                Thông tin tài khoản
                            </a>
                            <a class="dropdown-item" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Đăng xuất
                            </a>
                            <form id="logout-form" class="d-none" action="/logout" method="POST">
                            </form>
                        </div>
                    </div>
                <?php endif ?>
                <a href="/cart"
                    class="text-decoration-none icon-shop-index d-flex border border-0 text-white rounded-pill bg-dark justify-content-center"
                    style="width: 134px;"><i
                        class="fa-solid fa-cart-shopping d-flex justify-content-center align-items-center me-2"></i>
                    <p class="d-flex justify-content-center align-items-center m-0">Giỏ Hàng</p>
                </a>
            </div>
        </div>
    </div>

    <?= $this->section("page") ?>

    <div class="footer">
        <div class="container">
            <div class="d-flex row pt-4">
                <div class="d-flex flex-column col-lg-3 col-md-6 col-sm-12">
                    <h3>Giới Thiệu</h3>
                    <div class="container m-0 p-0">
                        <p>TQTshop chuyên cung cấp, order các loại điện thoại thông minh từ các hãng SamSung, Xiaoni, Opppo, Apple...</p>
                        <p>Địa chỉ: 180 Cao Lỗ, Phường 4, Quận 8, TP.Cần thơ</p>
                        <p>Điện thoại: 0363476805</p>
                        <p>Email: contact@gmail.com</p>
                    </div>
                </div>
                <div class="d-flex flex-column col-lg-3 col-md-6 col-sm-12">
                    <h3>Thông Tin</h3>
                    <ul class="list">
                        <li><a href="#">Về Chúng Tôi</a></li>
                        <li><a href="#">Chính Sách Bảo Mật</a></li>
                        <li><a href="#">Chính Sách Đổi Trả</a></li>
                        <li><a href="#">Chính Sách Vận Chuyển</a></li>
                    </ul>
                </div>
                <div class="d-flex flex-column col-lg-3 col-md-6 col-sm-12">
                    <h3>Chăm Sóc Khách Hàng</h3>
                    <ul class="list">
                        <li><a href="#">Hướng Dẫn Mua Hàng</a></li>
                        <li><a href="#">Hướng Dẫn Thanh Toán</a></li>
                        <li><a href="#">Hướng Dẫn Đổi Trả</a></li>
                        <li><a href="#">Hướng Dẫn Vận Chuyển</a></li>
                    </ul>
                </div>
                <div class="d-flex flex-column col-lg-3 col-md-6 col-sm-12">
                    <h3>Theo Dõi Chúng Tôi</h3>
                    <div class="social-links">
                        <a href="https://www.facebook.com/" class="social-icon facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.instagram.com/" class="social-icon instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.tiktok.com/" class="social-icon tiktok">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <a href="https://twitter.com/" class="social-icon twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.youtube.com/" class="social-icon youtube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <div class="bottom-bar d-flex justify-content-center">
            <p>© Bản quyền thuộc về TQTshop</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <?= $this->section("page_specific_js") ?>
</body>

</html>
