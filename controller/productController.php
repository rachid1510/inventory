<?php

require ("model/Model.php");
class productController
{
    //
    
    public function actionBoitier($page=null)
    {

        $products=array();
        /*
         * pagination
         */
        $limit=20;
        $start_from=0;
        $p=1;
        if ($page != null) { $p  = $page; }
        $start_from = ($p-1) * $limit;

        $product = Model::create('Product');
        $all_products=$product->findFromRelation( "products p,movements m","p.movement_id=m.id " ,array("fields"=>"p.*,m.provider,m.date_arrived"));
        $products=$product->findFromRelation( "products p,movements m","p.movement_id=m.id " ,array("fields"=>"p.*,m.provider,m.date_arrived","limit"=>$start_from.','.$limit));
        $total_records = count($all_products);

       $total_pages = ceil($total_records / $limit);

        require 'view/products/boitier.php';

    }

     public function actionSim($page=null)
    {
        $products=array();
        /*
         * instance
         */
        $product = Model::create('Product');
        $personal = Model::create('Personal');



        /*
        * pagination
        */
        $limit=20;
        $start_from=0;
        $p=1;
        if ($page != null) { $p  = $page; }
        $start_from = ($p-1) * $limit;
        /*
        * get list data
        */
        $personals=$personal->find();
        $all_products=$product->findFromRelation( "products p,movements m","p.movement_id=m.id " ,array("fields"=>"p.*,m.provider,m.date_arrived"));
        $products=$product->findFromRelation( "products p,movements m","p.movement_id=m.id " ,array("fields"=>"p.*,m.provider,m.date_arrived","limit"=>$start_from.','.$limit));
        $total_records = count($all_products);
        $total_pages = ceil($total_records / $limit);
        require 'view/products/sim.php';
    }

}
