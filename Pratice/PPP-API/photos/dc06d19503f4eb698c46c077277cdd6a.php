<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
<nav class="border-bottom">
    <div class="d-flex justify-content-evenly my-3">
        <a  class="nav-link p-2 m-2"  href="../View/index.php">Home</a>
        <a  class="nav-link p-2 m-2"  href="../View/area.php">Area</a>
        <a  class="nav-link p-2 m-2"  href="../View/exchange.php">Exchange</a>
    </div>
</nav>

<div class="d-flex flex-column container justify-content-center my-5">
    <h4 class="form-label text-center">Exchange Calculator</h4>

    <form class="card p-3 mb-4" id="ex-form"  method="post">
        <div class="row">
            <div class="col">
                <label class="form-label" for="amount">Amount</label>
                <input class="form-control" form="ex-form" type="number" id="amount" name="amount" placeholder="Amount" required>
            </div>
            <div class="col">
                <label class="form-label" for="from-select">From Currency</label>
                <select name="from" class="form-select"  form="ex-form" id="from-select" required>
                    <option disabled selected>Choose</option>
                                            <option value="USD">USD</option>
                                            <option value="KWD">KWD</option>
                                            <option value="RUB">RUB</option>
                                            <option value="INR">INR</option>
                                            <option value="BND">BND</option>
                                            <option value="EUR">EUR</option>
                                            <option value="ZAR">ZAR</option>
                                            <option value="NPR">NPR</option>
                                            <option value="CNY">CNY</option>
                                            <option value="CHF">CHF</option>
                                            <option value="THB">THB</option>
                                            <option value="PKR">PKR</option>
                                            <option value="KES">KES</option>
                                            <option value="EGP">EGP</option>
                                            <option value="BDT">BDT</option>
                                            <option value="SAR">SAR</option>
                                            <option value="LAK">LAK</option>
                                            <option value="IDR">IDR</option>
                                            <option value="KHR">KHR</option>
                                            <option value="SGD">SGD</option>
                                            <option value="LKR">LKR</option>
                                            <option value="NZD">NZD</option>
                                            <option value="CZK">CZK</option>
                                            <option value="JPY">JPY</option>
                                            <option value="KRW">KRW</option>
                                            <option value="VND">VND</option>
                                            <option value="PHP">PHP</option>
                                            <option value="HKD">HKD</option>
                                            <option value="BRL">BRL</option>
                                            <option value="RSD">RSD</option>
                                            <option value="MYR">MYR</option>
                                            <option value="GBP">GBP</option>
                                            <option value="CAD">CAD</option>
                                            <option value="SEK">SEK</option>
                                            <option value="NOK">NOK</option>
                                            <option value="ILS">ILS</option>
                                            <option value="DKK">DKK</option>
                                            <option value="AUD">AUD</option>
                                    </select>
            </div>
            <div class="col">
                <label class="form-label" for="to-select">To Currency</label>
                <select name="to" class="form-select"  form="ex-form" id="to-select" required>
                    <option disabled selected>Choose</option>
                                            <option value="USD">USD</option>
                                            <option value="KWD">KWD</option>
                                            <option value="RUB">RUB</option>
                                            <option value="INR">INR</option>
                                            <option value="BND">BND</option>
                                            <option value="EUR">EUR</option>
                                            <option value="ZAR">ZAR</option>
                                            <option value="NPR">NPR</option>
                                            <option value="CNY">CNY</option>
                                            <option value="CHF">CHF</option>
                                            <option value="THB">THB</option>
                                            <option value="PKR">PKR</option>
                                            <option value="KES">KES</option>
                                            <option value="EGP">EGP</option>
                                            <option value="BDT">BDT</option>
                                            <option value="SAR">SAR</option>
                                            <option value="LAK">LAK</option>
                                            <option value="IDR">IDR</option>
                                            <option value="KHR">KHR</option>
                                            <option value="SGD">SGD</option>
                                            <option value="LKR">LKR</option>
                                            <option value="NZD">NZD</option>
                                            <option value="CZK">CZK</option>
                                            <option value="JPY">JPY</option>
                                            <option value="KRW">KRW</option>
                                            <option value="VND">VND</option>
                                            <option value="PHP">PHP</option>
                                            <option value="HKD">HKD</option>
                                            <option value="BRL">BRL</option>
                                            <option value="RSD">RSD</option>
                                            <option value="MYR">MYR</option>
                                            <option value="GBP">GBP</option>
                                            <option value="CAD">CAD</option>
                                            <option value="SEK">SEK</option>
                                            <option value="NOK">NOK</option>
                                            <option value="ILS">ILS</option>
                                            <option value="DKK">DKK</option>
                                            <option value="AUD">AUD</option>
                                    </select>
            </div>
            <div class="col d-flex justify-content-center">
                <button class="btn btn-primary" value="calc"  form="ex-form" name="ex-calc-form">Calculate</button>
            </div>
        </div>
    </form>


    



</div>




</body>
<script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</html>