<?php
if (checkCustomerLogin()) {

} else {
    redirect(route("login"));
    die();
}