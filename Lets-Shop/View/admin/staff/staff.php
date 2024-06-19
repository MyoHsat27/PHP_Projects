<?php require_once ViewDir."/admin/header.php"?>

<div class="container-fluid navbar ps-0">
    <div class="px-4 py-2 d-flex justify-content-between align-items-center w-100">
        <div class="fs-4 fw-semibold">Staffs</div>
        <div class="d-flex justify-content-between align-items-center">
            <form class="input-group me-3 mb-0 search-input">
                <button class="input-group-text" id="search-icon"><i class="bi bi-search"></i></button>
                <input type="text" class="form-control" placeholder="Search" aria-label="Username" aria-describedby="search-icon">
            </form>
            <a href="<?= route('admin/staff-create') ?>" class="create-btn d-flex
            align-items-center justify-content-center"><i class="bi bi-plus-square"></i><span>Create</span></a>
        </div>
    </div>
</div>
<div class="container-fluid px-5 mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card px-3 py-2 border-0 shadow-sm">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>USERNAME</th>
                        <th>ROLE</th>
                        <th>EMAIL</th>
                        <th>PHONE NO</th>
                        <th>ADDRESS</th>
                        <th>JOINED AT</th>
                        <th>CONTROL</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>Mg Zaw</td>
                        <td>Delivery</td>
                        <td>mgzaw@gmail.com</td>
                        <td>09 883777736</td>
                        <td>Address </td>
                        <td>2000</td>
                        <td class="control-container">
                            <div class="detail-control-btn">
                                <a href=""><i class="bi bi-file-earmark-text"></i></a>
                            </div>
                            <div class="edit-control-btn">
                                <a href=""><i class="bi bi-pencil"></i></a>
                            </div>
                            <form action="" method="post">
                                <button class="delete-control-btn btn" onclick="return confirm('Are you sure you want to delete this category?')"><i class="bi bi-trash3"></i></button>
                                <input type="hidden" name="_method" value="delete">
                                <input type="hidden" name="id" value="">
                            </form>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>


        </div>
    </div>
</div>

<?php require_once ViewDir."/admin/footer.php"?>
