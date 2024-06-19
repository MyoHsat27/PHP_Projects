<?php include_once "../View/head.php" ?>

<div class="d-flex flex-column container justify-content-center my-5">
    <h4 class="form-label text-center">Area Calculator</h4>

    <?php include_once "../Controller/area_cal.php" ?>
    <form class="card p-3 my-4" action="area.php" method="post" id="areaForm">
        <div class="row">
            <div class="col-12 mt-2">
                <label for="width" class="form-label">Width</label>
                <input id="width" class="form-control" form="areaForm" type="number" name="width" placeholder="Width"
                       required>
            </div>
            <div class="col-12 mt-4">
                <label for="height" class="form-label">Height</label>
                <input id="height" class="form-control" form="areaForm" type="number" name="height" placeholder="Height"
                       required>
            </div>
            <div class="col-12 mt-4 d-flex justify-content-center">
                <button class="btn btn-primary" form="areaForm" value="calc" name="area_calc_form">Calculate</button>
            </div>
        </div>
    </form>
    <?php $folderName = "area_records";
    if (is_dir($folderName)) :
        $records = array_filter(scandir("area_records"), fn($r) => $r != "." && $r != "..");
        if (count($records)) :
            ?>
            <table class="table table-bordered ">
                <thead>
                <tr>
                    <th class="text-center">Width</th>
                    <th class="text-center">Height</th>
                    <th class="text-center">Area</th>
                    <th class="text-center">Control</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($records as $record):
                    $currentFile = $folderName . "/" . $record;
                    $currentFileStream = fopen($currentFile, "r");
                    $rawData = fread($currentFileStream, filesize($currentFile));
                    $data = json_decode($rawData, true);
                    ?>
                    <tr>
                        <td class="text-center"><?= $data['width'] ?></td>
                        <td class="text-center"><?= $data['height'] ?></td>
                        <td class="text-center"><?= $data['area'] ?></td>
                        <td class="text-center">
                            <a onclick="return confirm('Are you sure?')" class="btn btn-outline-danger btn-sm"
                               href="../Controller/del-area-record.php?name=<?= $currentFile ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endif; ?>
</div>


<?php include_once "../View/footer.php" ?>
