<?php include_once "../View/head.php" ?>
<?php require_once "../Model/exchange_data.php" ?>

<div class="d-flex flex-column container justify-content-center my-5">
    <h4 class="form-label text-center">Exchange Calculator</h4>

    <form class="card p-3 my-4" id="ex-form" method="post">
        <div class="row">
            <div class="col-12 mt-2">
                <label class="form-label" for="amount">Amount</label>
                <input class="form-control" form="ex-form" type="number" id="amount" name="amount" placeholder="Amount"
                       required>
            </div>
            <div class="col-12 mt-4">
                <label class="form-label" for="from-select">From Currency</label>
                <select name="from" class="form-select" form="ex-form" id="from-select" required>
                    <option disabled selected>Choose</option>
                    <?php foreach ($rates as $key => $value): ?>
                        <option value="<?= $key ?>"><?= $key ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 mt-4">
                <label class="form-label" for="to-select">To Currency</label>
                <select name="to" class="form-select" form="ex-form" id="to-select" required>
                    <option disabled selected>Choose</option>
                    <?php foreach ($rates as $key => $value): ?>
                        <option value="<?= $key ?>"><?= $key ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 mt-4 d-flex justify-content-center">
                <button class="btn btn-primary" value="calc" form="ex-form" name="ex-calc-form">Calculate</button>
            </div>
        </div>
    </form>
    <?php include_once "../Controller/exchange_cal.php" ?>
</div>

<?php include_once "../View/footer.php" ?>
