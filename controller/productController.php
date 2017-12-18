<?php

require ("model/Model.php");
class productController
{
    //
    
    public function actionBoitier()
    {

        $products=array();
        $products = Model::create('Product');
        $products=$products->findFromRelation( "products p,movements m","p.movement_id=m.id " ,array("fields"=>"p.*,m.provider,m.date_arrived"));
        require 'view/products/boitier.php';

    }

     public function actionSim()
    {
        $products=array();
        $products = Model::create('Product');
        $products=$products->findFromRelation( "products p,movements m","p.movement_id=m.id " ,array("fields"=>"p.*,m.provider,m.date_arrived"));

        require 'view/products/sim.php';
    }

}
