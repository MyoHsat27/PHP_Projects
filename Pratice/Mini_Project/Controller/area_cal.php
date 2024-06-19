
<?php if (isset($_POST['area_calc_form'])):
    $width = $_POST['width'];
    $height = $_POST['height'];
    $area = area($width, $height);
    $folderName = "area_records";
    $json = json_encode(["width" => $width, "height" => $height, "area" => $area]);

    if (!is_dir($folderName)) {
        mkdir($folderName);
    }

    $fileName = $folderName . "/record" . uniqid() . ".json";
    $fileString = fopen($fileName, 'w');
    fwrite($fileString, $json);
    fclose($fileString);
    ?>
<?php endif; ?>

