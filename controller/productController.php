<?php

require ("model/Model.php");
class productController
{
   /*
    * display list of box
    */
    public function actionBoitier($page=null)
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

        $personals=$personal->find();
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
            $all_products=$product->findFromRelation( "products p,movements m","p.movement_id=m.id and m.category_id=1 ".$condition ,array("fields"=>"p.*,m.provider,m.date_arrived"));
            $products=$product->findFromRelation( "products p,movements m","p.movement_id=m.id and m.category_id=1 ".$condition ,array("fields"=>"p.*,m.provider,m.date_arrived,m.order_ref","limit"=>$start_from.','.$limit));

           // $products=$product->findFromRelation( "products p,movements m","p.movement_id=m.id AND ".$condition ,array("fields"=>"p.*,m.provider,m.date_arrived"));

        }
        else{
            $all_products=$product->findFromRelation( "products p,movements m","p.movement_id=m.id and m.category_id=1",array("fields"=>"p.*,m.provider,m.date_arrived"));

            $products = $product->findFromRelation( "products p,movements m","p.movement_id=m.id and m.category_id=1 ",array("fields"=>"p.*,m.provider,m.date_arrived,m.order_ref","limit"=>$start_from.','.$limit));
        }

        $total_records = count($all_products);
        $total_pages = ceil($total_records / $limit);
        require 'view/products/boitier.php';

    }
  /*
   * acction display list of product with type 2 cards
   */
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

        if(!empty($_POST["state"]))
        {
            if($condition=='')
            {
                $condition= "p.state like '".$_POST["state"]. "'";
            }else{
                $condition .= " AND p.state like '".$_POST["state"]. "'";
            }
        }

        if(!empty($_POST["stock"]))
        {

            if($condition=='')
            {
                $condition= "p.status = '".$_POST["stock"]. "'";
            }else{
                $condition .= " AND p.status = '".$_POST["stock"]. "'";
            }
        }

        if($condition !='')
        {
            $all_products=$product->findFromRelation( "products p,movements m","p.movement_id=m.id and m.category_id=2 AND ".$condition ,array("fields"=>"p.*,m.provider,m.date_arrived"));
            $products=$product->findFromRelation( "products p,movements m","p.movement_id=m.id and m.category_id=2 AND ".$condition ,array("fields"=>"p.*,m.provider,m.date_arrived,m.order_ref","limit"=>$start_from.','.$limit));

           // $products=$product->findFromRelation( "products p,movements m","p.movement_id=m.id AND ".$condition ,array("fields"=>"p.*,m.provider,m.date_arrived"));

        }
        else{
            $all_products=$product->findFromRelation( "products p,movements m","p.movement_id=m.id and m.category_id=2" ,array("fields"=>"p.*,m.provider,m.date_arrived"));
            $products=$product->findFromRelation( "products p,movements m","p.movement_id=m.id and m.category_id=2" ,array("fields"=>"p.*,m.provider,m.date_arrived,m.order_ref","limit"=>$start_from.','.$limit));

            //$products = $product->findFromRelation( "products p,movements m","p.movement_id=m.id ",array("fields"=>"p.*,m.provider,m.date_arrived"));
        }
        $total_records = count($all_products);
        $total_pages = ceil($total_records / $limit);
        require 'view/products/sim.php';
    }
    /*
     *delevry product to personal
     */
   public function actionAffectation()
   {
       $products=explode(',',$_POST['products']);
       $personal_id=$_POST['personal_id'];
       $return=true;
       $result=array();
       /*
        * instanciation
        */
       $prod=Model::create("Product");
       $InventoryPersonal=Model::create("InventoryPersonal");
       /*
        * loop list of product checked to delevried
        */
       foreach ($products as $product)
       {
           /*
            * insert into table inventory_personal
            */
             $data=array("product_id"=>$product,"personal_id"=>$personal_id,"status"=>"1","user_id"=>3);
             if($InventoryPersonal->save($data)==0)
             {
                 $return=false;
                 break;
             }
             else{
                 /*
                 * update product status
                 */
                 $data_prod=array("id"=>$product,"status"=>"2");
                 if($prod->save($data_prod)==0){
                     $return=false;
                 }
             }

       }
       if($return==true)
           $result = array('msg' => 'OK');
          // echo json_encode(array("msg"=>"OK"));

       else
           $result = array('msg' => 'ERROR');

       //header('content-type:application/json');
       echo json_encode($result);
   }

    public function actionActivation()
    {
        $position=$_POST['position'];
        $nomber=$_POST['nomber'];
        $date_activation=$_POST['date_activation'];
        $return=true;
        $result=array();
        /*
         * instanciation
         */
        $prod=Model::create("Product");
        /*
         * get list of product to active
         */
        $products=$prod->findFromRelation( "products p,movements m","p.movement_id=m.id and m.category_id=2 and p.id>=$position" ,array("fields"=>"p.*","limit"=>$nomber));

        /*
         * loop list of product checked to delevried
         */
        foreach ($products as $product)
        {

                $data_prod=array("id"=>$product['id'],"state"=>'enabled','enabled_date'=>$date_activation);
                if($prod->save($data_prod)==0){
                    $return=false;
                }


        }
        if($return==true)
            $result = array('msg' => 'OK');

        else
            $result = array('msg' => 'ERROR');

        header('content-type:application/json');
        echo json_encode($result);
    }

}
