<?php $this->layout("layouts/default", ["title" => APPNAME]) ?>
<?php $this->start("page") ?>
<div class="container-fluid py-5">
  <div class="card card-custom">
    <div class="card-header bg-white border-0 py-4">
      <h2 class="card-title text-center mb-0 text-danger">
        <i class="bi bi-phone me-2"></i>Chỉnh sửa thương hiệu
      </h2>
    </div>
    <div class="card-body pt-0">
      <form action="/admin/brands/update/<?= $data['id'] ?>" method="POST" enctype="multipart/form-data">
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
                    placeholder="Tên thương hiệu" value="<?= isset($data['name']) ? $this->e($data['name']) : '' ?>" required>
                  <label>Tên thương hiệu</label>
                  <?php if (isset($errors['name'])) : ?>
                    <span class="invalid-feedback">
                      <strong><?= $this->e($errors['name']) ?></strong>
                    </span>
                  <?php endif ?>
                </div>
              </div>
            </div>
            <!-- img -->
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
        </div>
        <div class="row mt-5">
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-danger btn-lg px-5 me-3" name="submit">
              <i class="bi bi-save2 me-2"></i>Lưu lại
            </button>
            <a href="/admin/brands" class="btn btn-outline-secondary btn-lg px-5">
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