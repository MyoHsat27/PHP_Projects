<?php require_once "template/header.php"; ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="border p-4 rounded mt-5">
                <h3 class="mb-4">Create List</h3>
                <?php
                    if ($_SERVER['REQUEST_METHOD'] === "POST") {
                        $name = $_POST['name'];
                        $money = $_POST['money'];
                        $sql = "INSERT INTO my (name, money) VALUES ('$name', $money)";
                        if (mysqli_query($conn, $sql)) {
                            $_SESSION['status'] = [ 'message' => "List Created"];
                        } else {
                            echo alert("Fail", "danger");
                        }
                    }
                ?>
                <form action=""  method="post">
                    <div class="mb-3">
                        <label for="name-input" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name-input" required>
                    </div>
                    <div class="mb-3">
                        <label for="money-input" class="form-label">Money</label>
                        <input type="number" name="money" class="form-control" id="money-input" required>
                    </div>
                    <?php if (!empty($_SESSION['status'])) : ?>
                        <?php echo alert($_SESSION['status']['message']); $_SESSION['status'] = []; ?>
                    <?php endif; ?>
                    <button class="btn btn-outline-primary" >Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once "template/footer.php"; ?>
