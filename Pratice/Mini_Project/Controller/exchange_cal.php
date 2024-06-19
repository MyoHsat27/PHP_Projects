<?php
if (isset($_POST['ex-calc-form'])):
    $amount = $_POST['amount'];
    $from = str_replace(",", "", $rates[$_POST['from']]);
    $to = str_replace(",", "", $rates[$_POST['to']]);
    ?>
    <table class="table table-bordered ">
        <thead>
        <tr>
            <th class="text-center" colspan="2">Rate</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="text-center"><?= $_POST['amount'] . " " . $_POST['from'] ?></td>
            <td class="text-center"><?= exchange($amount, $from, $to) ?></td>
        </tr>
        </tbody>
    </table>
<?php endif; ?>


