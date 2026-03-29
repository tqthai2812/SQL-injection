<?php $this->layout("layouts/default", ["title" => APPNAME]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<?php $this->stop() ?>

<?php $this->start("page") ?>
<div id="wp-content" class="bg-body-tertiary pb-5" style="margin-top: 57px;">
  <div class="bg-header-content pt-4">

    <div id="carouselheader" class="carousel slide mx-auto mb-3" style="width: 85%;">
      <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="3000">
          <a href="#" class="d-flex justify-content-between">
            <img src="../img/bg-img-1.png" class="d-block w-100" alt="...">
          </a>
        </div>
        <div class="carousel-item" data-bs-interval="3000">
          <a href="#" class="d-flex justify-content-between">
            <img src="../img/bg-img-2.png" class="d-block w-100" alt="...">
          </a>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselheader" data-bs-slide="prev">
        <span class="fa-solid fa-chevron-left" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselheader" data-bs-slide="next">
        <span class="fa-solid fa-chevron-right" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    <div id="carouselExampleIndicators" class="carousel slide mx-auto d-md-block d-none" style="width: 85%;" data-bs-ride="carousel">
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
  <div class="bg-body-tertiary">
    <div class="display-5 fw-semibold mb-2 mx-auto mt-4" style="width: 85%;">Giảm Giá Sốc</div>
    <div class="slider-container mx-auto mt-4 bg-white border-0 rounded" style="width: 85%; overflow: hidden;">
      <div class="swiper-container">
        <div class="swiper-wrapper">
          <?php if (!empty($discountedPhones)) : ?>
            <?php foreach ($discountedPhones as $phone) : ?>
              <?php
              $original_price = $phone['price'];
              $discount_amount = $original_price * ($phone['discount_percent'] / 100);
              $discounted_price = $original_price - $discount_amount;
              ?>
              <div class="swiper-slide">
                <a href="<?= '/lab-sqli?id=' . $this->e($phone['id']) ?>" class="col-hover card text-decoration-none pt-5 px-2 border-0" style="overflow: hidden;">
                  <img src="<?= htmlspecialchars($phone['image']) ?>" class="card-img-top object-fit-contain" alt="<?= htmlspecialchars($phone['name']) ?>" style="height: 250px;">
                  <div class="card-body mt-4">
                    <p class="card-text mb-0 text-secondary text-decoration-line-through fs-6">
                      <?= number_format($original_price, 0, ',', '.') ?> đ
                    </p>
                    <p class="card-text mb-0 fw-medium fs-5 text-danger">
                      <?= number_format($discounted_price, 0, ',', '.') ?> đ
                    </p>
                    <p class="card-text mb-0 fs-6 text-success fw-medium">
                      Giảm <?= number_format($discount_amount, 0, ',', '.') ?> đ
                    </p>
                    <h5 class="card-title mt-4"><?= htmlspecialchars($phone['name']) ?></h5>
                  </div>
                </a>
              </div>
            <?php endforeach; ?>
          <?php else : ?>
            <p class="text-center">Không có sản phẩm nào đang giảm giá.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="d-grid col-3 mx-auto my-2" style="height: 40px; width: 200px;">
      <a href="/product-list" role="button" class="btn btn-dark">Xem tất cả</a>
    </div>
    <div class="mx-auto mt-4 bg-white p-0" style="width: 85%;">
      <a href="">
        <img src="../img/thoithuongdocdao.png" alt="" class="border rounded" style="width: 100%;">
      </a>
    </div>

    <div class="display-5 fw-semibold mb-2 mx-auto mt-4" style="width: 85%;">Sản Phẩm Mới</div>
    <div class="slider-container mx-auto mt-4 bg-white border-0 rounded" style="width: 85%; overflow: hidden;">
      <div class="swiper-container">
        <div class="swiper-wrapper">
          <?php if (!empty($newPhones)) : ?>
            <?php foreach ($newPhones as $phone) : ?>
              <?php
              $original_price = $phone['price'];
              $discount_amount = $original_price * ($phone['discount_percent'] / 100);
              $discounted_price = $original_price - $discount_amount;
              ?>
              <div class="swiper-slide">
                <a href="<?= '/lab-sqli2?id=' . $this->e($phone['id']) ?>" class="col-hover card text-decoration-none pt-5 px-2 border-0" style="overflow: hidden;">
                  <img src="<?= htmlspecialchars($phone['image']) ?>" class="card-img-top object-fit-contain" alt="<?= htmlspecialchars($phone['name']) ?>" style="height: 250px;">
                  <div class="card-body mt-4">
                    <p class="card-text mb-0 text-secondary text-decoration-line-through fs-6">
                      <?= number_format($original_price, 0, ',', '.') ?> đ
                    </p>
                    <p class="card-text mb-0 fw-medium fs-5 ">
                      <?= number_format($discounted_price, 0, ',', '.') ?> đ
                    </p>
                    <p class="card-text mb-0 fs-6 text-success fw-bold">
                      Giảm <?= number_format($discount_amount, 0, ',', '.') ?> đ
                    </p>
                    <h5 class="card-title mt-4 text-dark fw-bold"><?= htmlspecialchars($phone['name']) ?></h5>
                  </div>
                </a>
              </div>
            <?php endforeach; ?>
          <?php else : ?>
            <p class="text-center">Không có sản phẩm.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="d-grid col-3 mx-auto my-2" style="height: 40px; width: 200px;">
      <a href="/product-list" role="button" class="btn btn-dark">Xem tất cả</a>
    </div>
    <div class="display-5 fw-semibold mb-2 mx-auto mt-4" style="width: 85%;">Sự Kiện</div>
    <div class="mx-auto mt-4 bg-white p-0" style="width: 85%;">
      <a href="">
        <img src="../img/thangcuanang.png" alt="" class="border rounded" style="width: 100%;">
      </a>
    </div>
  </div>
</div>


<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>
<script>
  var swiper = new Swiper('.swiper-container', {
    slidesPerView: 5,
    spaceBetween: 20,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev'
    },
    breakpoints: {
      320: {
        slidesPerView: 1
      },
      768: {
        slidesPerView: 2
      },
      1024: {
        slidesPerView: 5
      }
    },
    on: {
      slideChange: function() {
        document.querySelectorAll('.swiper-slide').forEach((slide, index) => {
          if (index >= swiper.activeIndex && index < swiper.activeIndex + swiper.params.slidesPerView) {
            slide.querySelector('.product-name').style.display = 'block';
          } else {
            slide.querySelector('.product-name').style.display = 'none';
          }
        });
      }
    }
  });
  swiper.emit('slideChange');
</script>
<?php $this->stop() ?>