<?php
/**
 * Created by PhpStorm.
 * User: poste1
 * Date: 18/12/2017
 * Time: 12:32
 */
session_start();

if (isset($_SESSION["login"])) {
    include "layouts/header.php";
    include "layouts/footer.php";
}
else
    header("Location:login.php?error=e");

