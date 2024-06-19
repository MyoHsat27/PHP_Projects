<?php
require_once ModelDir."/Auth.php";

if (checkLogin()) {
    $auth = new Auth();
    $userInfo = $auth->getUserInfo($_SESSION['user_id']);
}
