<?php $this->layout("layouts/default", ["title" => APPNAME]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<style>
    table#phones {
        border-radius: 10px;
        overflow: hidden;
    }

    table#phones tbody tr:hover {
        background-color: #f8f9fa;
    }

    table#phones th,
    table#phones td {
        vertical-align: middle;
        text-align: center;
    }

    td:last-child {
        white-space: nowrap;
    }

    /* Căn chỉnh dropdown Show Entries */
    #entries-per-page {
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
        margin-left: 5px;
    }

    /* Căn chỉnh ô tìm kiếm */
    #custom-search {
        width: 200px;
    }
    div.dt-search {
        display: none;
    }
</style>

<?php $this->stop() ?>

<?php $this->start("page") ?>
<div class="container">

    <!-- SECTION HEADING -->
    <h2 class="text-center animate__animated animate__bounce">Account</h2>
    <div class="row">
        <div class="col-md-6 offset-md-3 text-center">
            <p class="animate__animated animate__fadeInLeft">View your all account here.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <!-- FLASH MESSAGES -->
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <label class="me-2">Show</label>
                    <select id="entries-per-page" class="">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <label class="ms-2">entries</label>
                </div>
                <div>
                    <input type="text" id="custom-search" class="form-control form-control-sm" placeholder="Search...">
                </div>
            </div>

            <!-- Table Starts Here -->
            <table id="phones" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Created Day</th>
                        <th scope="col">Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?= $this->e($user->id) ?></td>
                            <td><?= $this->e($user->name) ?></td>
                            <td><?= $this->e($user->email) ?></td>
                            <td><?= $this->e(date("d-m-Y", strtotime($user->created_at))) ?></td>
                            <td><?= $this->e($user->role) ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <!-- Table Ends Here -->
        </div>
    </div>

</div>
<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let table = new DataTable("#phones", {
            responsive: true,
            pagingType: "simple_numbers",
            lengthChange: false, // Ẩn dropdown mặc định của DataTables
            searching: true // Tắt thanh tìm kiếm mặc định
        });

        // Thay đổi số dòng hiển thị
        document.getElementById("entries-per-page").addEventListener("change", function() {
            table.page.len(this.value).draw();
        });

        // Tìm kiếm theo từ khóa nhập vào
        document.getElementById("custom-search").addEventListener("keyup", function() {
            table.search(this.value).draw();
        });
  
    });
</script>
<?php $this->stop() ?>