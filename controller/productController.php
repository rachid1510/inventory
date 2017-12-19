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

        $condition="";
        if(!empty($_POST["imei"]))
        {
            $condition= "p.imei_product like '%".$_POST["imei"]. "%'";
        }
        if(!empty($_POST["ref_order"]))
        {
            if($condition=='')
            {
                $condition= "m.order_ref like '%".$_POST["ref_order"]. "%'";
            }else{
                $condition .= " AND m.order_ref like '%".$_POST["ref_order"]. "%'";
            }
        }
        if(!empty($_POST["date_debut"]))
        {
            if($condition=='')
            {
                $condition= "m.date_arrived like '%".$_POST["date_debut"]. "%'";
            }else{
                $condition .= " AND m.date_arrived like '%".$_POST["date_debut"]. "%'";
            }
        }


        if($condition !='')
        {
            $products=$product->findFromRelation( "products p,movements m","p.movement_id=m.id AND ".$condition ,array("fields"=>"p.*,m.provider,m.date_arrived"));

        }
        else{
             echo "ok";
            $products = $product->findFromRelation( "products p,movements m","p.movement_id=m.id ",array("fields"=>"p.*,m.provider,m.date_arrived"));
        }
        require 'view/products/boitier.php';

    }

     public function actionSim($page=null)
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

        $condition="";
        if(!empty($_POST["imei"]))
        {
            $condition= "p.imei_product like '%".$_POST["imei"]. "%'";
        }
        if(!empty($_POST["ref_order"]))
        {
            if($condition=='')
            {
                $condition= "m.order_ref like '%".$_POST["ref_order"]. "%'";
            }else{
                $condition .= " AND m.order_ref like '%".$_POST["ref_order"]. "%'";
            }
        }
        if(!empty($_POST["date_debut"]))
        {
            if($condition=='')
            {
                $condition= "m.date_arrived like '%".$_POST["date_debut"]. "%'";
            }else{
                $condition .= " AND m.date_arrived like '%".$_POST["date_debut"]. "%'";
            }
        }


        if($condition !='')
        {
            $products=$product->findFromRelation( "products p,movements m","p.movement_id=m.id AND ".$condition ,array("fields"=>"p.*,m.provider,m.date_arrived"));

        }
        else{
            echo "ok";
            $products = $product->findFromRelation( "products p,movements m","p.movement_id=m.id ",array("fields"=>"p.*,m.provider,m.date_arrived"));
        }

        require 'view/products/sim.php';
    }

}
