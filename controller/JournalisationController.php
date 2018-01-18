<?php
/**
 * Created by PhpStorm.
 * User: post2
 * Date: 18/01/2018
 * Time: 17:53
 */
require ("model/Model.php");
include ("config/config.php");

class JournalisationController
{
    public function actionIndex()
    {

        require 'view/journalisation/index.php';

    }
}