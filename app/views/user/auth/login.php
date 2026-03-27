<?php $this->layout("layouts/default", ["title" => APPNAME]) ?>

<?php $this->start("page") ?>
<div class="container py-5" style="margin-top: 57px;">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/home">Trang chủ</a></li>
      <li class="breadcrumb-item active" aria-current="page">Đăng nhập</li>
    </ol>
  </nav>
  <div class="row border rounded-5 p-3 bg-white shadow box-area">
    <div class="col">
      <!-- FLASH SUCCESS MESSAGE -->
      <?php if (isset($_SESSION['success_Mess'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= $this->e($_SESSION['success_Mess']); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success_Mess']); ?>
      <?php endif; ?>

      <!-- FLASH ERROR MESSAGE -->
      <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <ul class="mb-0">
            <?php foreach ($_SESSION['errors'] as $error): ?>
              <li><?= $this->e($error) ?></li>
            <?php endforeach; ?>
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['errors']); ?>
      <?php endif; ?>

      <div class="row">
        <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box">
          <div class="featured-image mb-3">
            <img src="../img/login-logout.png" class="img-fluid" style="width: 250px;">
          </div>
          <div class="d-flex justify-content-center align-items-center flex-column left-text">
            <p class="text-white fs-2" style="font-weight: 600;">Be Verified</p>
            <small class="text-white text-wrap text-center" style="width: 17rem;">Đăng nhập để trải nghiệm tốt hơn.</small>
          </div>
        </div>
        <div class="col-md-6 right-box">
          <div class="row align-items-center">
            <div class="header-text mb-4">
              <h2>Xin Chào</h2>
              <p>Chúng tôi rất vui khi có bạn trở lại.</p>
            </div>
            <form action="/login" method="post">
              <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
              <div class="input-group mb-3">
                <input id="email" type="email" class="form-control form-control-lg bg-light fs-6 <?= isset($errors['email']) ? 'is-invalid' : '' ?>" name="email" value="<?= isset($old['email']) ? $this->e($old['email']) : '' ?>" required autofocus placeholder="Email">
                <?php if (isset($errors['email'])) : ?>
                  <span class="invalid-feedback">
                    <strong><?= $this->e($errors['email']) ?></strong>
                  </span>
                <?php endif ?>
              </div>
              <div class="input-group mb-1">
                <input id="password" type="password" class="form-control form-control-lg bg-light fs-6 <?= isset($errors['password']) ? 'is-invalid' : '' ?>" name="password" required placeholder="Mật khẩu">
                <?php if (isset($errors['password'])) : ?>
                  <span class="invalid-feedback">
                    <strong><?= $this->e($errors['password']) ?></strong>
                  </span>
                <?php endif ?>
              </div>
              <div class="input-group mb-3 d-flex justify-content-between">
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="formCheck">
                  <label for="formCheck" class="form-check-label text-secondary"><small>Ghi nhớ tôi</small></label>
                </div>
                <div class="forgot">
                  <small><a href="#">Quên mật khẩu?</a></small>
                </div>
              </div>
              <div class="input-group mb-3">
                <button class="btn btn-lg w-100 fs-6 text-white" style="background: #CC2125;">Đăng nhập</button>
              </div>
              <div class="row">
                <small>Bạn chưa có tài khoản?<a href="/register">Đăng ký ngay</a></small>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->stop() ?>