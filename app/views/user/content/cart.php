<?php $this->layout("layouts/default", ["title" => APPNAME]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<style>
    .cart-container {
        margin: 100px;
        text-align: center;
    }

    .cart-image {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 0 auto 20px;
    }

    .btn-buy {
        background-color: red;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
        display: inline-block;
    }

    .btn-buy:hover {
        background-color: white;
        color: red;
        border: 1px solid black;
    }

    @media (max-width: 768px) {
        .cart-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .cart-image {
            order: -1;
        }
    }
</style>
<?php $this->stop() ?>

<?php $this->start("page") ?>
<div id="wp-content" class="bg-body-tertiary pb-5" style="margin-top: 57px;">
    <div class="container pt-4">
        <?php if (!empty($cartItems)): ?>
            <div class="row d-flex justify-content-center align-content-center">
                <div class="col-lg-8 mb-2">
                    <div class="d-grid gap-2 gap-lg-3" style="border-radius: 12px;">
                        <div
                            class="d-flex w-100 justify-content-between bg-white px-4 py-2 py-lg-3 rounded-lg border border-2 border-black rounded-4 mb-2">
                            <div class="d-flex gap-2 gap-lg-3" style="height: 24px;">
                                <!-- <div class="d-flex justify-content-center" style="width: 24px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="customCheckbox">
                                    </div>
                                </div> -->
                                <!-- <span class="d-flex align-items-center justify-content-center text-dark fw-medium"> -->
                                    <h3>Giỏ Hàng</h3>
                                <!-- </span> -->
                            </div>
                            <form action="/cart/clear" method="post">
                                <button class="d-flex align-items-center justify-content-center btn btn-light"
                                    title="Xoá sản phẩm đã chọn">
                                    <i class="fa-solid fa-trash fs-5"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php foreach ($cartItems as $item): ?>
                        <div class="gy-4 bg-white rounded-lg border border-2 border-black rounded-4 mb-2">
                            <div class="d-grid w-100 gap-3 p-2 py-lg-3">
                                <div class="d-flex gap-3">
                                    <div class="d-flex gap-2 gx-lg-3">
                                        <!-- <div class="d-flex w-25 justify-content-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="customCheckbox">
                                            </div>
                                        </div> -->
                                        <div class="d-flex align-items-center justify-content-center rounded-2 border border-1 border-secondary p-2 p-lg-3"
                                            style="width: 64px; height: 64px;">
                                            <img src="../<?= $this->e($item['image']) ?>" alt="<?= $this->e($item['name']) ?>"
                                                style="width: 50px; height: auto;">
                                        </div>
                                    </div>
                                    <div class="d-flex w-100 justify-content-end flex-column flex-md-row gap-lg-4">
                                        <div class="d-grid w-100 align-content-center gap-1">
                                            <div class="d-flex justify-content-between w-100 gap-3 gap-lg-1 text-truncate">
                                                <span title="<?= $this->e($item['name']) ?>"
                                                    class="d-inline-block text-dark fw-medium text-truncate">
                                                    <?= $this->e($item['name']) ?>
                                                    <?= $this->e($item['storage']) ?>
                                                    <?= $this->e($item['color']) ?>
                                                </span>
                                                <div class="d-md-none d-block">
                                                    <form action="/cart/remove" method="post">
                                                        <input type="hidden" name="product_id" value="<?= $this->e($item['product_id']) ?>">
                                                        <input type="hidden" name="product_color" value="<?= $this->e($item['color']) ?>">
                                                        <input type="hidden" name="product_storage" value="<?= $this->e($item['storage']) ?>">
                                                        <button type="submit" class="d-flex align-items-center justify-content-center btn btn-light" title="Xoá sản phẩm đã chọn">
                                                            <i class="fa-solid fa-trash fs-5"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="d-flex mt-1 mt-lg-0">
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column flex-md-row gap-lg-5">
                                            <div class="d-flex flex-column flex-md-row gap-md-4">
                                                <div
                                                    class="d-flex gap-1 mt-1 mt-md-0 flex-md-column align-items-md-end justify-content-md-center">
                                                    <span
                                                        class="text-danger fw-semibold d-lg-flex justify-content-center"><?= number_format($item['price'], 0, ',', '.') ?>&nbsp;₫</span>
                                                </div>
                                                <div class="mt-2 mt-md-0 d-md-flex align-items-md-center" style="width: 100px;">
                                                    <form action="/cart/update" method="post" class="input-group input-group-sm">
                                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                                                        <input type="hidden" name="cart_item_id" value="<?= $this->e($item['id']) ?>">

                                                        <button class="btn btn-outline-secondary" type="submit" name="action" value="decrease"
                                                            <?= $item['quantity'] <= 1 ? 'disabled' : '' ?>>-</button>

                                                        <input type="number" name="quantity" class="form-control text-center"
                                                            value="<?= $this->e($item['quantity']) ?>" min="1" readonly style="max-width: 50px;">

                                                        <button class="btn btn-outline-secondary" type="submit" name="action" value="increase">+</button>
                                                    </form>
                                                </div>
                                                <div class="d-none d-md-flex align-items-center">
                                                    <form action="/cart/remove" method="post">
                                                        <input type="hidden" name="product_id" value="<?= $this->e($item['product_id']) ?>">
                                                        <input type="hidden" name="product_color" value="<?= $this->e($item['color']) ?>">
                                                        <input type="hidden" name="product_storage" value="<?= $this->e($item['storage']) ?>">
                                                        <button type="submit" class="d-flex align-items-center justify-content-center btn btn-light" title="Xoá sản phẩm đã chọn">
                                                            <i class="fa-solid fa-trash fs-5"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="col-lg-4 mg-top-15 pd-right-0">
                    <div class="bg-white sidebar-checkout">
                        <div class="sidebar-order-wrap">
                            <div class="order_title">
                                <h4>Thông tin đơn hàng</h4>
                            </div>
                            <div class="order_total">
                                <p>
                                    Tổng tiền:
                                    <span class="total-price"><?= number_format($cart['total_price'], 0, ',', '.') ?>&nbsp;₫</span>
                                </p>
                            </div>
                            <div class="order_text">
                                <p></p>
                            </div>
                            <div class="order_action">
                                <button class="btncart-checkout text-center" name="checkout" type="submit">Xác nhận đơn</button>
                                <p class="link-continue text-center">
                                    <a href="/product-list">
                                        <i class="fa-solid fa-reply"></i>
                                        Tiếp tục mua hàng
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <div class="container d-flex justify-content-center align-items-center" style="margin-top: 57px;">
                <div class="cart-container row flex-column-reverse flex-md-row align-items-center">
                    <div class="col-md-6 text-center">
                        <img src="../img/empty_cart.png" alt="Giỏ hàng trống" class="cart-image">
                    </div>
                    <div class="col-md-6 text-center text-md-start">
                        <p class="cart-title mb-2">Chưa có sản phẩm nào trong giỏ hàng</p>
                        <p class="cart-text mb-4">Cùng mua sắm hàng ngàn sản phẩm tại Shop nhé!</p>
                        <a href="/product-list" class="btn-buy">Mua hàng</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>
<?php $this->stop() ?>