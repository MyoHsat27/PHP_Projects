<?php require_once ViewDir."/admin/header.php"?>

<!--Navbar Start-->
<div class="container-fluid navbar ps-0">
    <div class="px-4 py-2 d-flex justify-content-between align-items-center w-100">
        <div class="fs-4 fw-semibold">Location</div>
        <div class="d-flex justify-content-between align-items-center">
            <form class="input-group me-3 mb-0 search-input" method="get">
                <button class="input-group-text" id="search-icon"><i class="bi bi-search"></i></button>
                <input name="q" type="text" class="form-control" placeholder="Search" aria-label="Username" aria-describedby="search-icon" value="<?= !empty($_GET) ? $_GET['q'] : '' ?>">
                <?php if (!empty($_GET)) : ?>
                    <a class="search-remove btn" href="<?= route('admin/location') ?>"><i class="bi bi-x-lg"></i></a>
                <?php endif; ?>
            </form>
            <a href="<?= route('admin/location-create') ?>" class="create-btn d-flex
            align-items-center justify-content-center"><i class="bi bi-plus-square"></i><span>Create</span></a>
        </div>
    </div>
</div>
<!--Navbar End-->
<?php require_once ViewDir."/admin/session_message.php"?>
<!--Fetching Products Data-->
<?php
require_once ModelDir."/Location.php";
$location = new Location();
if (isset($_GET['q'])) {
    $states = $location->getAllStates($_GET['q']);
} else {
    $states = $location->getAllStates();
}
?>

<!--Table Start-->
<div class="container-fluid px-5 mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card px-3 py-2 border-0 shadow-sm">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>STATE ID</th>
                        <th>STATE NAME</th>
                        <th>TOWNS</th>
                        <th>STATE STATUS</th>
                        <th>LAST UPDATED</th>
                        <th>CONTROL</th>
                    </tr>
                    </thead>

                    <tbody>
                       <?php foreach ($states as $state) : ?>
                           <tr>
                               <td><?= $state->id ?></td>
                               <td><?= $state->name ?></td>
                               <td><?= $state->town_count ?></td>
                               <td class="status-container"><?= $state->active_state ? "<i class='bi bi-check-circle active-check'></i>" : "<i class='bi bi-dash-circle inactive-check'></i>" ?></td>
                               <td><?= $state->created_at ?></td>
                               <td class="control-container">
                                   <div class="detail-control-btn">
                                       <a href="<?= route('admin/location-detail', ["id"=> $state->id]) ?>"><i class="bi bi-file-earmark-text"></i></a>
                                   </div>
                                   <div class="edit-control-btn">
                                       <a href="<?= route('admin/location-edit', ["id"=> $state->id]) ?>"><i class="bi bi-pencil"></i></a>
                                   </div>
                                   <form action="<?= route('admin/discount-delete') ?>" method="post">
                                       <button class="delete-control-btn btn" onclick="return confirm('Are you sure you want to delete this category?')"><i class="bi bi-trash3"></i></button>
                                       <input type="hidden" name="_method" value="delete">
                                       <input type="hidden" name="id" value="<?= $state->id ?>">
                                   </form>
                               </td>
                           </tr>
                       <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--Table Emd-->

<?php require_once ViewDir."/admin/footer.php"?>
