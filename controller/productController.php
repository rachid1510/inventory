<?php
require ("model/Model.php");
include ("config/config.php");
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
        $limit = 20;

        if(isset($_POST["pagination"]) and !empty($_POST["pagination"])) {
            $limit = $_POST["pagination"];
        }
        $start_from=0;
        $p=1;
        if ($page != null && is_numeric($page)) { $p  = $page; }
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

        if(!empty($_POST["state"]))
        {
            if($condition=='')
            {
                $condition= "p.state like '".$_POST["state"]. "'";
            }else{
                $condition .= " AND p.state like '".$_POST["state"]. "'";
            }
        }

        if(!empty($_POST["stock"]) and $_POST["stock"] !='')
        {


            if($condition=='')
            {
                $condition= "p.status = '".$_POST["stock"]. "'";
            }else{
                $condition .= " AND p.status = '".$_POST["stock"]. "'";
            }
        }
        if(!empty($_POST['personal_search']) and $_POST['personal_search'] !='')
        {
            if($condition=='')
            {
                $condition= "ip.personal_id =".$_POST['personal_search'];
            }else{
                $condition .= " AND ip.personal_id =".$_POST['personal_search'];
            }

        }


        if($condition !='')
        {
            $p=1;
            $start_from = ($p-1) * $limit;
            $all_products=$product->findFromRelation( "products p left join movements m on p.movement_id=m.id left join inventory_personals ip on ip.product_id=p.id and ip.status<>'3' left join details_installations di on di.product_id=p.id left join installations i on i.id=di.installation_id left join vehicles v on v.id=i.vehicle_id left join personals per on per.id=ip.personal_id","m.category_id=1 and $condition",array("fields"=>"p.*,m.provider,m.date_arrived,m.order_ref,v.imei as imei_vehicle,per.first_name,per.id as personal_id,(SELECT p2.label from products p2 join details_installations di2 on di2.product_id=p2.id where di2.product_id<>di.product_id and p2.id<>p.id and di2.installation_id=di.installation_id) as imei_product_inverse ,(SELECT cp.imei_product from costumer_products cp join installations i2 on i2.id=cp.installation_id where i2.id=i.id) as costumer_product"));
            $products = $product->findFromRelation( "products p left join movements m on p.movement_id=m.id left join inventory_personals ip on ip.product_id=p.id  and ip.status<>'3' left join details_installations di on di.product_id=p.id left join installations i on i.id=di.installation_id left join vehicles v on v.id=i.vehicle_id left join personals per on per.id=ip.personal_id ","m.category_id=1 and $condition",array("fields"=>"DISTINCT p.*,m.provider,m.date_arrived,m.order_ref,v.imei as imei_vehicle,per.first_name,per.id as personal_id,(SELECT p2.label from products p2 join details_installations di2 on di2.product_id=p2.id where di2.product_id<>di.product_id and p2.id<>p.id and di2.installation_id=di.installation_id) as imei_product_inverse ,(SELECT cp.imei_product from costumer_products cp join installations i2 on i2.id=cp.installation_id where i2.id=i.id) as costumer_product","limit"=>$start_from.','.$limit));

        }
        else{

            $all_products=$product->findFromRelation( "products p left join movements m on p.movement_id=m.id left join inventory_personals ip on ip.product_id=p.id and ip.status<>'3' left join details_installations di on di.product_id=p.id left join installations i on i.id=di.installation_id left join vehicles v on v.id=i.vehicle_id left join personals per on per.id=ip.personal_id","m.category_id=1",array("fields"=>"p.*,m.provider,m.date_arrived,m.order_ref,v.imei as imei_vehicle,per.first_name,per.id as personal_id,(SELECT p2.label from products p2 join details_installations di2 on di2.product_id=p2.id where di2.product_id<>di.product_id and p2.id<>p.id and di2.installation_id=di.installation_id) as imei_product_inverse ,(SELECT cp.imei_product from costumer_products cp join installations i2 on i2.id=cp.installation_id where i2.id=i.id) as costumer_product"));
            $products = $product->findFromRelation( "products p left join movements m on p.movement_id=m.id left join inventory_personals ip on ip.product_id=p.id and ip.status<>'3' left join details_installations di on di.product_id=p.id left join installations i on i.id=di.installation_id left join vehicles v on v.id=i.vehicle_id left join personals per on per.id=ip.personal_id","m.category_id=1",array("fields"=>"DISTINCT p.*,m.provider,m.date_arrived,m.order_ref,v.imei as imei_vehicle,per.first_name,per.id as personal_id,(SELECT p2.label from products p2 join details_installations di2 on di2.product_id=p2.id where di2.product_id<>di.product_id and p2.id<>p.id and di2.installation_id=di.installation_id) as imei_product_inverse ,(SELECT cp.imei_product from costumer_products cp join installations i2 on i2.id=cp.installation_id where i2.id=i.id) as costumer_product","limit"=>$start_from.','.$limit));


        }
        if(isset($_POST['export'])) {
            $labels=['IMEI', 'Modèle','Date d\'arrivée','Fournisseur','Ref commande', 'Etat de stock', 'Installateur','Matricule', 'SIM opentech', 'SIM Client'];
            $header = ['imei_product', 'model', 'date_arrived', 'provider','order_ref','status', 'first_name', 'imei_vehicle', 'imei_product_inverse', 'costumer_product'];
            $product->export_excel($all_products, $header,$labels, 'La liste des boitiers');
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

        /*
       * check session
       */
        if (!isset($_SESSION["login"])) {
            header("Location:http://".$_SERVER['HTTP_HOST']."/inventory/login.php");
        }

        $products=array();
        /*

         * instance
         */
        $product = Model::create('Product');
        $personal = Model::create('Personal');
        /*
        * pagination
        */

        $limit = 20;

        if(isset($_POST["pagination"]) and !empty($_POST["pagination"])) {
            $limit = $_POST["pagination"];
        }
        $start_from=0;
        $p=1;
        if ($page != null && is_numeric($page)) { $p  = $page; }
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
            //$ref_search=$_POST["ref_order"];

            if($condition=='')
            {
                $condition= "m.order_ref like '%".$_POST["ref_order"]. "%'";
            }else{
                $condition .= " AND m.order_ref like '%".$_POST["ref_order"]. "%'";
            }
        }
        if(!empty($_POST["date_activation"]))
        {
            if($condition=='')
            {
                $condition= "p.enabled_date like '%".$_POST["date_activation"]. "%'";
            }else{
                $condition .= " AND p.enabled_date like '%".$_POST["date_activation"]. "%'";
            }
        }
        if(!empty($_POST["date_arrived"]))
        {
            if($condition=='')
            {
                $condition= "m.date_arrived like '%".$_POST["date_arrived"]. "%'";
            }else{
                $condition .= " AND m.date_arrived like '%".$_POST["date_arrived"]. "%'";
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

        if(isset($_POST["stock"]) and (!empty($_POST["stock"]) || $_POST["stock"]!=''))
        {

            if($condition=='')
            {
                $condition= "p.status = '".$_POST["stock"]. "'";
            }else{
                $condition .= " AND p.status = '".$_POST["stock"]. "'";
            }
        }

        if(!empty($_POST['personal_search']) and $_POST['personal_search'] !='')
        {
            if($condition=='')
            {
                $condition= "ip.personal_id =".$_POST['personal_search'];
            }else{
                $condition .= " AND ip.personal_id =".$_POST['personal_search'];
            }

        }

        if($condition !='')
        {
            $p=1;
            $start_from = ($p-1) * $limit;
            $all_products=$product->findFromRelation( "products p left join movements m on p.movement_id=m.id left join inventory_personals ip on ip.product_id=p.id and  ip.status<>'3' left join details_installations di on di.product_id=p.id left join installations i on i.id=di.installation_id left join vehicles v on v.id=i.vehicle_id left join personals per on per.id=ip.personal_id","m.category_id=2 and $condition",array("fields"=>"p.*,m.provider,m.date_arrived,m.order_ref,v.imei as imei_vehicle,per.first_name,per.id as personal_id,(SELECT p2.imei_product from products p2 join details_installations di2 on di2.product_id=p2.id where di2.product_id<>di.product_id and p2.id<>p.id and di2.installation_id=di.installation_id) as imei_product_inverse ,(SELECT cp.imei_product from costumer_products cp join installations i2 on i2.id=cp.installation_id where i2.id=i.id) as costumer_product"));
            $products = $product->findFromRelation( "products p left join movements m on p.movement_id=m.id left join inventory_personals ip on ip.product_id=p.id  and ip.status<>'3' left join details_installations di on di.product_id=p.id left join installations i on i.id=di.installation_id left join vehicles v on v.id=i.vehicle_id left join personals per on per.id=ip.personal_id","m.category_id=2 and $condition",array("fields"=>"DISTINCT p.*,m.provider,m.date_arrived,m.order_ref,v.imei as imei_vehicle,per.first_name,per.id as personal_id,(SELECT p2.imei_product from products p2 join details_installations di2 on di2.product_id=p2.id where di2.product_id<>di.product_id and p2.id<>p.id and di2.installation_id=di.installation_id) as imei_product_inverse ,(SELECT cp.imei_product from costumer_products cp join installations i2 on i2.id=cp.installation_id where i2.id=i.id) as costumer_product","limit"=>$start_from.','.$limit));

        }
        else{
            $all_products=$product->findFromRelation( "products p left join movements m on p.movement_id=m.id left join inventory_personals ip on ip.product_id=p.id and ip.status<>'3' left join details_installations di on di.product_id=p.id left join installations i on i.id=di.installation_id left join vehicles v on v.id=i.vehicle_id left join personals per on per.id=ip.personal_id","m.category_id=2",array("fields"=>"p.*,m.provider,m.date_arrived,m.order_ref,v.imei as imei_vehicle,per.first_name,per.id as personal_id ,(SELECT p2.imei_product from products p2 join details_installations di2 on di2.product_id=p2.id where di2.product_id<>di.product_id and p2.id<>p.id and di2.installation_id=di.installation_id) as imei_product_inverse ,(SELECT cp.imei_product from costumer_products cp join installations i2 on i2.id=cp.installation_id where i2.id=i.id) as costumer_product"));
            $products = $product->findFromRelation( "products p left join movements m on p.movement_id=m.id left join inventory_personals ip on ip.product_id=p.id and ip.status<>'3' left join details_installations di on di.product_id=p.id left join installations i on i.id=di.installation_id left join vehicles v on v.id=i.vehicle_id left join personals per on per.id=ip.personal_id","m.category_id=2",array("fields"=>"DISTINCT p.*,m.provider,m.date_arrived,m.order_ref,v.imei as imei_vehicle,per.first_name,per.id as personal_id,(SELECT p2.imei_product from products p2 join details_installations di2 on di2.product_id=p2.id where di2.product_id<>di.product_id and p2.id<>p.id and di2.installation_id=di.installation_id) as imei_product_inverse ,(SELECT cp.imei_product from costumer_products cp join installations i2 on i2.id=cp.installation_id where i2.id=i.id) as costumer_product","limit"=>$start_from.','.$limit));
          }

        if(isset($_POST['export'])) {
            $labels=['SSID','Numèro', 'Plan','Date d\'arrivée','Fournisseur','Activer','Date d\'activation','Ref commande','Etat de stock', 'Installateur', 'Matricule', 'SIM opentech', 'SIM Client'];
            $header = ['imei_product','label', 'model', 'date_arrived', 'provider','state','enabled_date','order_ref', 'status','first_name', 'imei_vehicle', 'imei_product_inverse', 'costumer_product'];
            $product->export_excel($all_products, $header,$labels, 'La liste des boitiers');
        }
        $total_records = count($all_products);
        $total_pages = ceil($total_records / $limit);


         require 'view/products/sim.php';

    }
    /*
     *delevry product to personal
     */
   public function actionAffectationboitier()
   {

       $personal_id=$_POST['personal_id'];
       $return=true;
       $result=array();
       $products=array();
       $nombreaafecter=(isset($_POST['nombreaafecter']))? $_POST['nombreaafecter']:0;
       /*
        * instanciation
        */
       $prod=Model::create("Product");
       $InventoryPersonal=Model::create("InventoryPersonal");
       if($nombreaafecter>0){
       /*
         * get list of product to add to inventory personal
         */
       $products=$prod->findFromRelation( "products p,movements m","p.movement_id=m.id and m.category_id=1 and p.status ='1'" ,array("fields"=>"p.*","limit"=>$nombreaafecter,"orderBy"=>'id'));

           /*
                   * loop list of product checked to delevried
                   */
           foreach ($products as $product)
           {
               /*
                * insert into table inventory_personal
                */
               $data=array("product_id"=>$product['id'],"personal_id"=>$personal_id,"status"=>'1',"user_id"=>$_SESSION['user_id']);

               if($InventoryPersonal->save($data)==0)
               {
                   $return=false;
                   break;
               }
               else{
                   /*
                   * update product status
                   */
                   $data_prod=array("id"=>$product['id'],"status"=>"2");
                   if($prod->save($data_prod)==0){
                       $return=false;
                   }
               }

           }

       }else{
           $products=explode(',',$_POST['products']);

           /*
        * loop list of product checked to delevried
        */
           foreach ($products as $product)
           {
               /*
                * insert into table inventory_personal
                */
               $data=array("product_id"=>$product,"personal_id"=>$personal_id,"status"=>'1',"user_id"=>$_SESSION['user_id']);

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
       }


       if($return==true)
           $result = array('msg' => 'OK');
          // echo json_encode(array("msg"=>"OK"));

       else
           $result = array('msg' => 'ERROR');

       //header('content-type:application/json');
       echo json_encode($result);
   }


    /*
     *delevry product to personal
     */
    public function actionAffectationsim()
    {

        $personal_id=$_POST['personal_id'];
        $return=true;
        $result=array();
        $products=array();
        $nombreaafecter=(isset($_POST['nombreaafecter']))? $_POST['nombreaafecter']:0;
        /*
         * instanciation
         */
        $prod=Model::create("Product");
        $InventoryPersonal=Model::create("InventoryPersonal");
        if($nombreaafecter>0){
            /*
              * get list of product to add to inventory personal
              */
            $products=$prod->findFromRelation( "products p,movements m","p.movement_id=m.id and m.category_id=2 and p.status ='1'" ,array("fields"=>"p.*","limit"=>$nombreaafecter,"orderBy"=>'id'));

            /*
                    * loop list of product checked to delevried
                    */
            foreach ($products as $product)
            {
                /*
                 * insert into table inventory_personal
                 */
                $data=array("product_id"=>$product['id'],"personal_id"=>$personal_id,"status"=>'1',"user_id"=>$_SESSION['user_id']);

                if($InventoryPersonal->save($data)==0)
                {
                    $return=false;
                    break;
                }
                else{
                    /*
                    * update product status
                    */
                    $data_prod=array("id"=>$product['id'],"status"=>"2");
                    if($prod->save($data_prod)==0){
                        $return=false;
                    }
                }

            }

        }else{
            $products=explode(',',$_POST['products']);

            /*
         * loop list of product checked to delevried
         */
            foreach ($products as $product)
            {
                /*
                 * insert into table inventory_personal
                 */
                $data=array("product_id"=>$product,"personal_id"=>$personal_id,"status"=>'1',"user_id"=>$_SESSION['user_id']);

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
       //$position=$_POST['position'];
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
        $products=$prod->findFromRelation( "products p,movements m","p.movement_id=m.id and m.category_id=2 and p.state ='disabled'" ,array("fields"=>"p.*","limit"=>$nomber,"orderBy"=>'id'));

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
    /*
    *delevry product to personal
    */
    public function actionTransfer()
    {
        $products=explode(',',$_POST['products_transfer']);
        $personal_id=$_POST['personal_id_stock'];
        $personal_old=$_POST['enstockde'];
        $return=true;
        $inventory_per=array();
        $result=array();
        /*
         * instanciation
         */

        $InventoryPersonal=Model::create("InventoryPersonal");
        /*
         * loop list of product checked to delevried
         */
        foreach ($products as $product)
        {
            /*
             * get persoanl inventory
             */
            $inventory_per= $InventoryPersonal->findFromRelation("inventory_personals i","personal_id=$personal_old  and product_id=$product" ,array("fields"=>"i.*"));
             /*
             * update into table inventory_personal
             */
            $data=array("id"=>$inventory_per[0]['id'],"personal_id"=>$personal_id,"status"=>"1","user_id"=>3);
            if($InventoryPersonal->save($data)==0)
            {
                $return=false;
                break;
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

    /*
     * function returne to stock
     */
    public function actionReturntoopentech()
    {
        $result=array();
        $return=true;
        $products=array();
        $products=$_POST["product"];

         /*
        * instanciation
        */
            $prod=Model::create("Product");
            $inven_personal=Model::create("InventoryPersonal");

        /*
         * loop list of product checked to returne
         */
        foreach ($products as $product)
        {
            $this->actionDesaffectation($product,$inven_personal);
            $data_prod=array("id"=>$product,"status"=>'1');
            if($prod->save($data_prod)==0){
                $return=false;
            }


        }
        if($return==true)
            $result = array('msg' => 'OK');

        else
            $result = array('msg' => 'ERROR');


        echo json_encode($result);
    }
    /*
     * bloquer produit
     */
    public function actionBlockedProduct()
    {
        $result=array();
        $return=true;
        $products=array();
        $products=$_POST["product"];
        $prod=Model::create("Product");
        $inven_personal=Model::create("InventoryPersonal");
        /*
        * loop list of product checked to returne
        */
        foreach ($products as $product)
        {
            $this->actionDesaffectation($product,$inven_personal);
            $data_prod=array("id"=>$product,"status"=>'3');
            if($prod->save($data_prod)==0){
                $return=false;
            }


        }
        if($return==true)
            $result = array('msg' => 'OK');

        else
            $result = array('msg' => 'ERROR');


        echo json_encode($result);

    }

    public function actionDesaffectation($prodcut_id,$inven_personal)
    {
        $inventory_per=array();
        $inventory_per= $inven_personal->findFromRelation("inventory_personals i","product_id=$prodcut_id" ,array("fields"=>"i.*"));
        if(count($inventory_per)>0) {
            $inventory_per = array("id" => $inventory_per[0]['id'], "status" => '3');

            if ($inven_personal->save($inventory_per)) {
                return true;
            }
        }
  return false;

    }

    public function actionStockalert(){
        $category=$_POST['category'];
        $product = Model::create('Product');
        $products=array();
        $products=$product->findFromRelation("products p left join movements m on p.movement_id=m.id","p.status='1' and p.state='enabled' and m.category_id=$category",array("fields"=>"p.*"));
        echo json_encode(array("notification"=>count($products)));
    }
}
