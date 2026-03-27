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
    <h2 class="text-center animate__animated animate__bounce">Product</h2>
    <div class="row">
        <div class="col-md-6 offset-md-3 text-center">
            <p class="animate__animated animate__fadeInLeft">View all product here.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?php if (isset($_SESSION['success_Mess'])): ?>
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['success_Mess']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['success_Mess']); ?>
            <?php endif; ?>
            <!-- FLASH MESSAGES -->

            <a href="/admin/create" class="btn btn-success mb-3">
                <i class="fas fa-plus-circle"></i> Add New Phone
            </a>

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
                        <th scope="col">Model</th>
                        <th scope="col">Price</th>
                        <th scope="col">Date Created</th>
                        <th scope="col">Chipset</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($smartphones as $smartphone) : ?>
                        <tr>
                            <td><?= $this->e($smartphone->name) ?></td>
                            <td><?= number_format($smartphone->price, 0, ',', '.') ?></td>
                            <td><?= $this->e(date("d-m-Y", strtotime($smartphone->created_at))) ?></td>
                            <td><?= $this->e($smartphone->processor) ?></td>
                            <td class="d-flex justify-content-center">
                                <a href="<?= '/admin/edit/' . $this->e($smartphone->id) ?>" class="btn btn-xs btn-warning">
                                    <i alt="Edit" class="fa fa-pencil"></i> Edit
                                </a>
                                <form class="ms-1" action="<?= '/admin/delete/' . $this->e($smartphone->id) ?>" method="POST">
                                    <button type="submit" class="btn btn-xs btn-danger" name="delete-phone">
                                        <i alt="Delete" class="fa fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <!-- Table Ends Here -->
        </div>
    </div>
    <div id="delete-confirm" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="lead">Are you sure you want to delete this smartphone?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Cancel</button>
                    <button type="button" class="btn btn-danger" id="delete">Delete</button>
                </div>
            </div>
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

        // Xử lý nút xóa
        const deleteButtons = document.querySelectorAll('button[name="delete-phone"]');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = button.closest('form');
                const nameTd = button.closest('tr').querySelector('td:first-child');
                if (nameTd) {
                    document.querySelector('.modal-body p').textContent =
                        `Do you want to delete "${nameTd.textContent}"?`;
                }
                const submitForm = function() {
                    form.submit();
                };
                document.getElementById('delete').addEventListener('click', submitForm, {
                    once: true
                });

                const modalEl = document.getElementById('delete-confirm');
                modalEl.addEventListener('hidden.bs.modal', function() {
                    document.getElementById('delete').removeEventListener('click', submitForm);
                });

                const confirmModal = new bootstrap.Modal(modalEl, {
                    backdrop: 'static',
                    keyboard: false
                });
                confirmModal.show();
            });
        });
    });
</script>
<?php $this->stop() ?>