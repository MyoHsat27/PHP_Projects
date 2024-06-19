<?php require_once ViewDir."/template/header.php"; ?>


<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="border p-4 rounded mt-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="m-0">Create new list</h4>
                    <a class="btn btn-outline-primary" href="<?= route("inventory") ?>">All List</a>
                </div>

                <form action="<?= route('inventory-store') ?>"  method="post">
                    <div class="mb-3">
                        <label for="name-input" class="form-label">Item Name</label>
                        <input type="text" name="name" class="form-control <?= hasError('name') ? 'is-invalid' : '' ?>" id="name-input" value="<?= old('name') ?>">
                      <?php if (hasError("name")) : ?>
                      <div class="invalid-feedback" id="name-input">
                        <?= getError("name") ?>
                      </div>
                      <?php endif; ?>
                    </div>
                  <div class="mb-3">
                    <label for="money-input" class="form-label">Price</label>
                    <input type="text" name="price" class="form-control <?= hasError('price') ? 'is-invalid' : '' ?>" id="money-input" value="<?= old('price') ?>">
                    <?php if (hasError("price")) : ?>
                      <div class="invalid-feedback" id="name-input">
                        <?= getError("price") ?>
                      </div>
                      <?php endif; ?>
                  </div>
                  <div class="mb-3">
                    <label for="money-input" class="form-label">Stock</label>
                    <input type="number" name="stock" class="form-control <?= hasError('stock') ? 'is-invalid' : '' ?>" id="money-input" value="<?= old('stock') ?>">
                    <?php if (hasError("stock")) : ?>
                      <div class="invalid-feedback" id="name-input">
                        <?= getError("stock") ?>
                      </div>
                      <?php endif; ?>
                  </div>
                    <button class="btn btn-outline-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php require_once ViewDir."/template/footer.php"; ?>
