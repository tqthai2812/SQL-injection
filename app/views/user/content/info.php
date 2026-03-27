<?php $this->layout("layouts/default", ["title" => APPNAME]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<style>
    .profile-card {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #f2f2f2;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 30px;
        font-weight: bold;
        color: #333;
    }
</style>
<?php $this->stop() ?>
<?php $this->start("page") ?>
<div class="container py-5 mt-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/home">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tài khoản</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-3">
            <div class="profile-card text-center p-3">
                <div class="d-flex">
                    <div class="avatar"><i class="fa-solid fa-user-tie"></i></div>
                    <div class="ms-3 text-start">
                        <h5 class="mt-2"><?= htmlspecialchars($user->name) ?></h5>
                        <p class="text-muted"><?= htmlspecialchars($user->email) ?></p>
                    </div>
                </div>
                <ul class="list-group mt-3 text-start">
                    <li class="list-group-item"><i class="fa-solid fa-box"></i> Đơn hàng của tôi</li>
                    <li class="list-group-item"><i class="fa-regular fa-heart"></i> Khách hàng thân thiết</li>
                    <li class="list-group-item"><i class="fa-solid fa-location-dot"></i> Số địa chỉ nhận hàng</li>
                    <li class="list-group-item text-danger">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <a class="text-danger" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng Xuất</a>
                        <form id="logout-form" class="d-none" action="/logout" method="POST">
                    </li>
                </ul>
            </div>

        </div>
        <div class="col-md-9">
            <h4>Thông tin cá nhân</h4>
            <div class="profile-card p-4">

                <div class="mx-auto w-50 text-center">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <div class="avatar"><i class="fa-solid fa-user-tie"></i></div>
                    </div>
                    <div class="d-flex justify-content-between border-bottom p-3">
                        <div>Họ và tên:</div>
                        <div><?= htmlspecialchars($user->name) ?></div>
                    </div>
                    <div class="d-flex justify-content-between border-bottom p-3">
                        <div>Email:</div>
                        <div><?= htmlspecialchars($user->email) ?></div>
                    </div>
                    <div class="d-flex justify-content-between border-bottom p-3">
                        <div>Ngày tham gia:</div>
                        <div><?= htmlspecialchars($user->created_at) ?></div>
                    </div>
                    <a href="#" class="btn btn-danger mt-5">Chỉnh sửa thông tin</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>
<?php $this->stop() ?>