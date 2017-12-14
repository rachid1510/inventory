<?php

require ("model/Model.php");
class productController
{
    //
    
    public function actionBoitier()
    {
        require 'view/products/boitier.php';

    }

     public function actionSim()
    {
        require 'view/products/sim.php';
    }
}
