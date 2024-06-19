<?php require_once "template/header.php"; ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="border p-4 rounded mt-5">
                <?php
                    $sql = "SELECT * FROM my";
                    if (isset($_GET['q'])) {
                        $q = $_GET['q'];
                        $sql .= " WHERE name LIKE '%$q%'";
                    }
                    $query = mysqli_query($conn, $sql);

                    $totalSql = "SELECT sum(money) AS total FROM my";
                    if (isset($_GET['q'])) {
                        $q = $_GET['q'];
                        $totalSql .= " WHERE name LIKE '%$q%'";
                    }
                    $totalQuery = mysqli_query($conn, $totalSql);
                ?>
                <?php if (!empty($_SESSION['status'])) : ?>
                    <?php echo alert($_SESSION['status']['message']); $_SESSION['status'] = [];  ?>
                <?php endif; ?>

                <h4 class="">Lender List</h4>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>Total List : <?= $query->num_rows ?> </div>

                    <form action="" class="d-flex justify-content-end" method="get">
                        <div class="d-flex input-group w-75">
                            <input type="text" class="form-control" value="<?php if (isset($_GET['q'])) : ?><?= $_GET['q'] ?><?php endif; ?>" name="q" placeholder="Search">
                            <?php if (isset($_GET['q'])) : ?>
                                <a href="./list_index.php" class="btn btn-light">x</a>
                            <?php endif; ?>
                            <button class="btn  btn-primary">Search</button>
                        </div>
                    </form>
                </div>
                <table class="table table-bordered">
                    <tr >
                        <th class="text-center">No</th>
                        <th class="text-center">Name</th>
                        <th class="text-end">Money</th>
                        <th class="text-center">Controls</th>
                        <th class="text-center">Created At</th>
                    </tr>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($query)) : ?>
                        <tr>
                            <td class="text-center"><?= $row['id'] ?></td>
                            <td class="text-center"><?= $row['name'] ?></td>
                            <td class="text-end"><?= $row['money'] ?></td>
                            <td class="text-center">
                                <a href="./list_update.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="./list_delete.php" class="d-inline-block" method="post">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button onclick="return confirm('Are you to Delete?')"  class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                            <td class=" text-center">
                                <p class="small m-0"><?= showDateTime($row['created_at']) ?></p>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td class="text-center" colspan="2">Total</td>
                        <td  class="text-end"><?= mysqli_fetch_assoc($totalQuery)['total'] ?></td>
                        <td colspan="2"></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once "template/footer.php"; ?>
