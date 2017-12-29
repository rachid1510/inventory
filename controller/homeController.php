<?php
session_start();
require ("model/Model.php");

class homeController
{
    public function  actionIndex(){
        if (!isset($_SESSION["login"])) {
            header("Location:login.php?error=e");
        }

        require 'view/home.php';
    }

}