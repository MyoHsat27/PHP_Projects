<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?= url("bootstrap/css/bootstrap.min.css") ?>">
    <link rel="stylesheet" href="<?= url("bootstrap-icons/font/bootstrap-icons.css") ?>">
    <link rel="stylesheet" href="<?= url("assets/css/login.css") ?>">
</head>
<body>
<?php
if (isset($_SESSION['formInvalid'])) {
    echo "<div class='invalid-form'>".$_SESSION['formInvalid']."</div>";
    unset($_SESSION['formInvalid']);
}

if (isset($_SESSION['login']) && $_SESSION['login']) {
    redirect(route("shop"));
}

?>

<div class="d-flex flex-column align-items-center">
    <a href="<?= route('shop') ?>" class="without-login">Continue
        Without
        Login</a>
    <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true">
        <div class="login">
            <form class="form" action="<?= route("user-login") ?>" method="post">
                <label for="chk" aria-hidden="true">Log in</label>
                <div class="input-container">
                    <input class="input" name="loginEmail" placeholder="Enter Email or Username"
                           value="<?php echo $_SESSION['loginEmail'] ?? '';
                           unset($_SESSION['loginEmail']) ?>">
                    <?php if (isset($_SESSION['notExist'])) {
                        echo "<span style='font-size: 13px; color: #fa3e3e;'>* ".$_SESSION['notExist']."</span>";
                        unset($_SESSION['notExist']);
                    } ?>
                </div>
                <div class="input-container">
                    <input class="input" type="password" name="loginPass" placeholder="Password"
                           value="<?php echo $_SESSION['loginPass'] ?? '';
                           unset($_SESSION['loginPass']) ?>">
                    <?php if (isset($_SESSION['incorrectPass'])) {
                        echo "<span style='font-size: 13px; color: #fa3e3e;'>* ".$_SESSION['incorrectPass']."</span>";
                        unset($_SESSION['incorrectPass']);
                    } ?>
                </div>
                <button>Log in</button>
            </form>
        </div>
        <div class="register">
            <form class="form" action="<?= route("user-signup") ?>" method="post">
                <label for="chk" aria-hidden="true">Sign Up</label>
                <div class="input-container">
                    <input class="input" name="signEmail" placeholder="Email"
                           value="<?php echo $_SESSION['signEmail'] ?? '';
                           unset($_SESSION['signEmail']) ?>" required>
                    <?php if (isset($_SESSION['emailExist'])) {
                        echo "<span class='text-danger' style='font-size: 13px'>* ".$_SESSION['emailExist']."</span>";
                        unset($_SESSION['emailExist']);
                    } ?>
                    <?php if (isset($_SESSION['emailInvalid'])) {
                        echo "<span class='text-danger' style='font-size: 13px'>* ".$_SESSION['emailInvalid']."</span>";
                        unset($_SESSION['emailInvalid']);
                    } ?>
                </div>
                <div class="input-container">
                    <input class="input" type="password" name="signPass" placeholder="Password"
                           value="<?php echo $_SESSION['signPass'] ?? '';
                           unset($_SESSION['signPass']) ?>" required>
                    <?php if (isset($_SESSION['emailInvalid'])) {
                        echo "<span class='text-danger' style='font-size: 13px'>* ".$_SESSION['emailInvalid']."</span>";
                        unset($_SESSION['emailInvalid']);
                    } ?>
                    <?php if (isset($_SESSION['passInvalid'])) {
                        echo "<span class='text-danger' style='font-size: 13px'>* ".$_SESSION['passInvalid']."</span>";
                        unset($_SESSION['passInvalid']);
                    } ?>
                </div>
                <div class="input-container">
                    <input class="input" type="text" name="signUser" placeholder="Username"
                           value="<?php echo $_SESSION['signUser'] ?? '';
                           unset($_SESSION['signUser']) ?>" required>
                    <?php if (isset($_SESSION['userExist'])) {
                        echo "<span class='text-danger' style='font-size: 13px'>* ".$_SESSION['userExist']."</span>";
                        unset($_SESSION['userExist']);
                    }
                    ?>
                    <?php if (isset($_SESSION['userInvalid'])) {
                        echo "<span class='text-danger' style='font-size: 13px'>* ".$_SESSION['userInvalid']."</span>";
                        unset($_SESSION['userInvalid']);
                    } ?>
                </div>
                <button>Sign Up</button>
            </form>
        </div>
    </div>
</div>
</body>
<script src="<?= url('bootstrap/js/bootstrap.bundle.js') ?>"></script>
</html>