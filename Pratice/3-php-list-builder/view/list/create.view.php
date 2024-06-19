<?php require_once ViewDir."/template/header.php"; ?>


<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="border p-4 rounded mt-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="m-0">Create new list</h4>
                    <a class="btn btn-outline-primary" href="<?= route("list") ?>">All List</a>
                </div>

                <form action="<?= route('list-store') ?>"  method="post">
                    <div class="mb-3">
                        <label for="name-input" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name-input" required>
                    </div>
                    <div class="mb-3">
                        <label for="money-input" class="form-label">Money</label>
                        <input type="number" name="money" class="form-control" id="money-input" required>
                    </div>
                    <button class="btn btn-outline-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php require_once ViewDir."/template/footer.php"; ?>
