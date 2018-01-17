<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location:login.php");
}

include "layouts/header.php"; ?>


<!-- Left side column. contains the logo and sidebar -->


<!-- Content Wrapper. Contains page content -->


<section class="content">
    <p>404</p>
</section>
<?php
include "layouts/footer.php"; ?>