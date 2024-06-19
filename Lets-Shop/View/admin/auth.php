<?php
if (checkAdminLogin()) {

} else {
    redirect(route("login"));
}