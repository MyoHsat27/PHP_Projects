<?php require_once ViewDir."/template/header.php"; ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="border p-4 rounded mt-5">
                <h3 class="mb-4">Update List</h3>
                <form action="<?= route("list-update") ?>" method="post">
                  <input type="hidden" name="_method" value="put">
                    <input type="hidden" name="id" value="<?= $list['id'] ?>">
                    <div class="mb-3">
                        <label for="name-input" class="form-label">Name</label>
                        <input type="text" name="name" value="<?= $list['name'] ?>" class="form-control" id="name-input" required>
                    </div>
                    <div class="mb-3">
                        <label for="money-input" class="form-label">Money</label>
                        <input type="number" name="money" value="<?= $list['money'] ?>" class="form-control" id="money-input" required>
                    </div>
                    <button class="btn btn-outline-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once ViewDir."/template/footer.php"; ?>
