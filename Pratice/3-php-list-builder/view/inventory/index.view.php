<?php require_once ViewDir."/template/header.php"; ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="border p-4 rounded mt-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="">Inventory List</h4>
                    <a class="btn btn-outline-primary" href="<?= route("inventory-create") ?>">Create</a>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                      <div>Total List : <?= $lists["total"] ?> </div>
                    <form action="<?= route('inventory') ?>" class="d-flex justify-content-end" method="get">
                        <div class="d-flex input-group w-75">
                            <input type="text" class="form-control" value="<?php if(isset($_GET['q'])) : ?><?= sanitize($_GET['q'],true) ?><?php endif;; ?>" name="q" placeholder="Search">
                          <?php if(!empty($_GET['q'])) : ?>
                            <a href="<?= route('inventory') ?>" class="btn btn-outline-danger">x</a>
                          <?php endif; ?>
                            <button class="btn  btn-primary">Search</button>
                        </div>
                    </form>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Item Name</th>
                        <th class="text-end">Price</th>
                        <th class="text-end">Stock</th>
                        <th class="text-center">Controls</th>
                        <th class="text-center">Created At</th>
                    </tr>
                    <tbody>
                    <?php foreach($lists['data'] as $list ) : ?>
                        <tr>
                            <td class="text-center"><?= $list['id'] ?></td>
                            <td class="text-center"><?= $list['name'] ?></td>
                            <td class="text-end"><?= $list['price'] ?></td>
                            <td class="text-end"><?= $list['stock'] ?></td>
                            <td class="text-center">
                                <a href="<?= route("inventory-edit", ['id' => $list['id']]) ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="<?= route('inventory-delete') ?>" class="d-inline-block" method="post">
                                    <input type="hidden" name="_method" value="delete">
                                    <input type="hidden" name="id" value="<?= $list['id'] ?>">
                                    <button onclick="return confirm('Are you to Delete?')"  class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                            <td class=" text-center">
                                <p class="small m-0"><?= showDateTime($list['created_at']) ?></p>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td class="text-center" colspan="2">Total</td>
                        <td class="text-end"><?= getTotal($lists['data']); ?></td>
                      <td class="text-end"><?= getTotal($lists['data']); ?></td>
                        <td colspan="3"></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
  <?= paginator($lists['links']) ?>
</div>


<?php require_once ViewDir."/template/footer.php"; ?>
