<?php
$string_data = file_get_contents("http://forex.cbm.gov.mm/api/latest");
$data = json_decode($string_data, true);
$rates = $data['rates'];

?>