<?php require_once "template/header.php"; ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="border p-4 rounded mt-5">
                <h3 class="mb-4">Update List</h3>
                <?php
                if ($_SERVER['REQUEST_METHOD'] === "GET") {
                    $id = $_GET['id'];
                    $sql = "SELECT * FROM my WHERE id=$id";
                    $query = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($query);
                }
                ?>
                <form action="list_update_info.php"  method="post">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <div class="mb-3">
                        <label for="name-input" class="form-label">Name</label>
                        <input type="text" name="name" value="<?= $row['name'] ?>" class="form-control" id="name-input" required>
                    </div>
                    <div class="mb-3">
                        <label for="money-input" class="form-label">Money</label>
                        <input type="number" name="money" value="<?= $row['money'] ?>" class="form-control" id="money-input" required>
                    </div>
                    <button class="btn btn-outline-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once "template/footer.php"; ?>
