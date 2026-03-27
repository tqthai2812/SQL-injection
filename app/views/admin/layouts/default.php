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
  <link href="/css/style.css" rel="stylesheet">

  <?= $this->section("page_specific_css") ?>
</head>

<body>
  <!-- Modal Xác nhận đăng xuất -->
  <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="logoutModalLabel">Xác nhận đăng xuất</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Bạn có chắc chắn muốn đăng xuất không?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <button type="button" class="btn btn-danger" id="confirmLogout">Đăng xuất</button>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row d-flex" style="height: 100vh;">
      <!-- Sidebar cố định -->
      <div class="col-2 bg-danger text-white p-3 d-flex flex-column justify-content-between" style="position: fixed; left: 0; top: 0; height: 100vh; width: 16.666%;">
        <div>
          <div class="text-center">
            <img src="../../../img/logo.png" class="img-fluid w-75 mt-3" alt="Logo">
            <p class="fs-4 mt-3">Hello, admin</p>
          </div>
          <ul class="list-unstyled fs-5 mx-3">
            <li><a class="text-decoration-none text-white d-block py-2" href="#"><i class="fa-solid fa-house"></i> DashBoard</a></li>
            <li><a class="text-decoration-none text-white d-block py-2" href="/admin/products"><i class="fa-solid fa-table-list"></i> Products</a></li>
            <li><a class="text-decoration-none text-white d-block py-2" href="/admin/user"><i class="fa-solid fa-users"></i> Customers</a></li>
            <li><a class="text-decoration-none text-white d-block py-2" href="/admin/brands"><i class="fa-solid fa-list"></i> Brands</a></li>
          </ul>
        </div>

        <!-- Nút Đăng xuất -->
        <div class="text-center mb-3">
          <button class="btn btn-light text-danger fw-bold w-75" data-bs-toggle="modal" data-bs-target="#logoutModal">
            <i class="fa-solid fa-right-from-bracket"></i>
            Logout
          </button>
          <form id="logout-form" class="d-none" action="/logout" method="POST"></form>
        </div>
        <script>
          document.getElementById('confirmLogout').addEventListener('click', function() {
            document.getElementById('logout-form').submit(); // Gửi form đăng xuất
          });
        </script>

      </div>

      <!-- Nội dung có thể cuộn -->
      <div class="col-10 p-3" style="margin-left: 16.666%; overflow-y: auto;">
        <?= $this->section("page") ?>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <?= $this->section("page_specific_js") ?>
</body>

</html>
