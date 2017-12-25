<?php

require ("model/Model.php");
class installationController
{
    //
    public function actionIndex($page=null)
    {

        $installations=array();
        $installation = Model::create('Installation');
        $product = Model::create('Product');
        /*
         * pagination
         */


        $limit = 20;

        if(isset($_POST["pagination"]) and !empty($_POST["pagination"])) {
           $limit = $_POST["pagination"];
        }

            $start_from = 0;
            $p = 1;
            if ($page != null) {
                $p = $page;
            }
            $start_from = ($p - 1) * $limit;

        /*
         * declarr list of $costumers and $boitiers and $cartes
         */
        $costumers=array();
        $boitiers=array();
        $cartes=array();
        /*
         * instance objects of costumer, vehicle and product
         */
        $costumer = Model::create('Costumer');
        $vehicle = Model::create('Vehicle');
        $personal = Model::create('Personal');

         /*
         * get list of costumers ,vehicles,boitiers,cartes
         */
        $personals=$personal->find();
        $costumers=$costumer->find("Costumers",array("fields"=>"*"));
        $vehicles=$vehicle->find("Vehicles",array("fields"=>"*"));
        $boitiers=$product->findFromRelation("products p,movements m",'p.movement_id=m.id and m.category_id=1',array("fields"=>"p.*"));
        $cartes=$product->findFromRelation("products p,movements m",'p.movement_id=m.id and m.category_id=2',array("fields"=>"p.*"));
       /*
        * require view index
        */
        $condition="";
        if(!empty($_POST["installed_at"]))
        {
            $condition= "i.installed_at like '%".$_POST["installed_at"]. "%'";

        }
        if(!empty($_POST["client"]))
        {
            if($condition=='')
            {
                $condition= "c.id='".$_POST["client"]."'";
            }else{
                $condition .= " AND c.id='".$_POST["client"]."'";
            }
        }
        if(!empty($_POST["matricule"]))
        {
            if($condition=='')
            {
                $condition= "v.id='".$_POST["matricule"]."'";
            }else{
                $condition .= " AND v.id='".$_POST["matricule"]."'";
            }
        }


        if($condition !='')

        {
            $p=1;
            $start_from = ($p-1) * $limit;
            $all_installations=$installation->findFromRelation( "installations i,costumers c,vehicles v,personals p"," i.vehicle_id=v.id  and i.personal_id=p.id and v.costumer_id=c.id AND ".$condition ,array("fields"=>"i.*,v.imei,c.name,CONCAT( p.first_name,' ', p.last_name) AS personnal_name"));
            $installations=$installation->findFromRelation( "installations i,costumers c,vehicles v,personals p"," i.vehicle_id=v.id  and i.personal_id=p.id and v.costumer_id=c.id AND ".$condition ,array("fields"=>"i.*,v.imei,c.name,CONCAT( p.first_name,' ', p.last_name) AS personnal_name","limit"=>$start_from.','.$limit,"orderBy"=>"i.id desc"));

        }
        else {
            $all_installations=$installation->findFromRelation( "installations i,costumers c,vehicles v,personals p"," i.vehicle_id=v.id  and i.personal_id=p.id and v.costumer_id=c.id ",array("fields"=>"i.*,v.imei,c.name,CONCAT( p.first_name,' ', p.last_name) AS personnal_name"));
            $installations=$installation->findFromRelation( "installations i,costumers c,vehicles v,personals p"," i.vehicle_id=v.id  and i.personal_id=p.id and v.costumer_id=c.id" ,array("fields"=>"i.*,v.imei,c.name,CONCAT( p.first_name,' ', p.last_name) AS personnal_name","limit"=>$start_from.','.$limit,"orderBy"=>"i.id desc"));

            //$installations = $installation->find();
        }
//
        $html='';

        foreach ($installations as $installation){
            $boitier=$this->getProductByTypeInstallation($installation['id'],1,$product);
            $sim=$this->getProductByTypeInstallation($installation['id'],2,$product);
            $status= ($installation['status']=='In_progress')? '<span style="padding: 0px !important;" class="alert alert-warning">En cours</span>':'<span style="padding: 0px !important;" class="alert alert-success">Terminé</span>';

            $html.='<tr> <td class="text-center">'. $installation["installed_at"].'</td>';
            $html.='<td class="text-center">'.$installation['personnal_name'].'</td>';
            $html.='<td class="text-center">' .$installation['name'].' </td>';
            $html.='<td class="text-center">' .$installation['imei'].'</td>';
            $html.='<td class="text-center">'. $sim.'</td>';
            $html.='<td class="text-center">'. $boitier.'</td>';
            $html.='<td class="text-center">'.$status.'</td>';
            $html.='<td class="text-center">'. $installation['observation'].'</td>';


             $html.=($installation['status']=='In_progress')? '<td class="text-center"> <div class="btn-group"><a   onclick="javascript:update_function('. $installation["id"].')"   class="btn btn-info btn-xs" title="Edit" data-toggle="tooltip"><span class="glyphicon glyphicon-edit"></span></a></div>':'<td></td>';
            $html.='</tr>';

        }

        $total_records = count($all_installations);
        $total_pages = ceil($total_records / $limit);
        require 'view/installations/index.php';

    }


   public  function getProductByTypeInstallation($installation_id,$category,$product)
   {
       $products=array();
       $products=$product->findFromRelation( "details_installations di,products p,movements m","p.movement_id=m.id and di.product_id=p.id and di.installation_id=$installation_id and m.category_id=$category" ,array("fields"=>"p.*"));
       if(count($products)>0){
           if($category==1){
               return $products[0]["imei_product"];
           }
           else{
               return $products[0]["label"];
           }

       }
       else{
           $products=$product->findFromRelation( "costumer_products cp","cp.installation_id=$installation_id" ,array("fields"=>"cp.*"));
           if(!empty($products[0]["imei_product"])){
               $data='<span style="padding: 3px !important;" class="alert alert-danger">'.$products[0]["imei_product"].'</span>';

           }
           else{
               $data='-------';

           }
          return $data;
       }


   }

    /*
     * action add insert into table movements
     */
    public function actionAdd()
    {

        $result = array();
        $error=array();
        $inventory_personal_data=array();
        $personal_id=$_POST["personal_id"];
        $selected_vehicle=$_POST["selected_vehicle"];
        $date_installation=$_POST["date_installation"];
       /* $box=(isset($_POST["selected_box"]))? $_POST["selected_box"] :'';
        $card=(isset($_POST["selected_card"]))? $_POST["selected_card"] :'';*/
        $box=$_POST["selected_box"];
        $card=$_POST["selected_card"];
        /*
        * set default value off installation's status
        */
        $status="In_progress";
        $completd=true;
       /*
        * validation
        */
        if(!$this->validation($date_installation)){
            $result = 'Veuillez selectionner une date';
            $this->__message($result);
        }
        if(!$this->validation($personal_id)){
            $result = 'Veuillez selectionner un installateur';
            $this->__message($result);
        }
        if(!$this->validation($selected_vehicle)){
            //$result = 'Veuillez selectionner un matricule';
            $completd=false;
           // $this->__message($result);
        }

        if(!isset($_POST["gps_client_check"])){
        if(!$this->validation($box)){
            $result = 'Veuillez selectionner un boitier';
            $this->__message($result);
        }
       }
        if(!isset($_POST["sim_client_check"])){
            if(!$this->validation($card)){
                $result = 'Veuillez selectionner une carte SIM';
                $this->__message($result);
            }
        }
        /*
         * instances
         */
        $installation = Model::create('Installation');
        $detail_installation=Model::create('DetailsInstallation');
        $inventory_personl=Model::create('InventoryPersonal');
        $product=Model::create('Product');
        $CostumerProduct=Model::create('CostumerProduct');

        /*
         * check if installation in progress is checked and change default value if checked
         */
//        if(isset($_POST["status"])){
//            $status="Completed";
//        }
        if($completd)
        {
            $status="Completed";
        }

        /*
         * prepare data to insert in installation table
         */
        $data = array("status" => $status, "personal_id" => $personal_id,"vehicle_id"=>$selected_vehicle,"user_id"=>3,"installed_at"=>$date_installation);
        /*
         * call function to save installation and get lastinsert id in var $installation_id
         */
        $installation_id = $installation->save($data);
         /*
          * check if saved
          */
        if ($installation_id > 0) {
            /*
             * check if is not costumer's product (card and box)
             */
            if(!isset($_POST["gps_client_check"]) && !isset($_POST["sim_client_check"]) && $card !='' && $box !='') {
                /*
                 * prepare data to insert box data  in detail_installation table
                 */
                $databoitier = array("product_id" => $box, "installation_id" => $installation_id);
                /*
                 *  prepare data to insert card data  in detail_installation table
                */
                $datasim = array("product_id" => $card, "installation_id" => $installation_id);
                /*
                 * call function to save box in  detail_installation
                 */
                $detail_installation->save($databoitier);
                /*
                 * call function to save card in  detail_installation
                 */
                $detail_installation->save($datasim);
                /*
                 * check if installation is completed
                 */
                //if($status=="Completed") {
                    /*
                    * get inventory personl ids
                    */
                    $inventory_personal_data = $inventory_personl->find(array('conditions' => 'product_id in(' . $card . ',' . $box . ') and personal_id=' . $personal_id));
                    // var_dump($inventory_personal_data);
                    foreach ($inventory_personal_data as $inventory_perso) {
                        $data_inventory_perso = array("id" => $inventory_perso['id'], "status" => '0');
                        $data_product = array("id" => $inventory_perso['product_id'], "status" => '0');
                        /*
                         * update status of product on product's table and personal's inventory
                         */
                        if($inventory_personl->save($data_inventory_perso)>0 and $product->save($data_product)>0){
                            $result = 'OK';
                        }
                        else{
                            $result ='L\'installation a été ajouter sans avoir mettre le stock';
                        }
                    }
                //}
            }
               /*
                 * check if is not costumer's product (box)
              */
          if (isset($_POST["gps_client_check"]))
            {
                if($card !='') {
                    $imei_product_costumer=$_POST['imei_product_costumer'];
                    $provider_product_costumer=$_POST['provider_product_costumer'];
                    /*
                     * installation is change of the card
                     */
                    $datasim = array("product_id" => $card, "installation_id" => $installation_id);
                    /*
                     * save detail installation
                     */
                    $detail_installation->save($datasim);
                    /*
                    * check if installation is completed
                    */
                    //if ($status == "Completed") {
                        /*
                         * get inventory personl id
                         */
                        $inventory_personal_data = $inventory_personl->find(array('conditions' => 'product_id =' . $card . ' and personal_id=' . $personal_id));
                        $data_inventory_perso = array("id" => $inventory_personal_data[0]['id'], "status" => '0');
                        $data_product = array("id" => $inventory_personal_data[0]['product_id'], "status" => '0');
                        /*
                            * update status of product on product's table and personal's inventory
                            */
                    if($inventory_personl->save($data_inventory_perso)>0 and $product->save($data_product)>0){
                        $result = 'OK';
                    }
                    else{
                        $result ='L\'installation a été ajouter sans avoir mettre le stock';
                    }

                   // }

                    $costumer_products = array('imei_product'=>$imei_product_costumer,'provider'=>$provider_product_costumer,'installation_id'=>$installation_id);
                    //$product->find(array('conditions' => 'product_id =' . $card . ' and personal_id=' . $personal_id));
                   if($CostumerProduct->save($costumer_products)>0){
                       $result = 'OK';
                   }

                }
                else{
                    $result = 'Veuillez selectionner une carte SIM';
                }
            }
          if(isset($_POST["sim_client_check"])){
              if($box !=''){
                  $gsm_product_costumer=$_POST['gsm_product_costumer'];
                  $operateur_product_costumer=$_POST['operateur_product_costumer'];
                //change of the box
                /*
                 * installation is change of the box
                 */
                $databoitier =  array("product_id" => $box, "installation_id" => $installation_id);
                  /*
                  * save detail installation
                  */
                $detail_installation->save($databoitier);
                 /*
                 * check if installation is completed
                 */
              // if($status=="Completed") {
                  /*
                  * get inventory personl id
                  */
                  $inventory_personal_data = $inventory_personl->find(array('conditions' => 'product_id =' . $box . ' and personal_id=' . $personal_id));
                  $data_inventory_perso = array("id" => $inventory_personal_data[0]['id'], "status" => '0');
                  $data_product = array("id" => $inventory_personal_data[0]['product_id'], "status" => '0');
                  /*
                      * update status of product on product's table and personal's inventory
                      */
                  if($inventory_personl->save($data_inventory_perso)>0 and $product->save($data_product)>0){
                      $result = 'OK';
                  }
                  else{
                      $result ='L\'installation a été ajouter sans avoir mettre le stock';
                  }
                  $costumer_products = array('imei_product'=>$gsm_product_costumer,'provider'=>$operateur_product_costumer,'installation_id'=>$installation_id);
                  //$product->find(array('conditions' => 'product_id =' . $card . ' and personal_id=' . $personal_id));
                  $CostumerProduct->save($costumer_products);
                  if($CostumerProduct->save($costumer_products)>0){
                      $result = 'OK';
                  }
              //}
            }
             else
              {
                  $result ='Veuillez selectionner un boitier';
              }
         }


        } else {
            $result = 'error';
        }
       $this->__message($result);
    }
    /*/*
        * function edit
        */
    public function actionEdit(){
        require 'view/installations/update.php';
       /* $installations=array();
        $installation_id=$_POST['id'];
        $installation = Model::create('Installation');
        $installations=$installation->findFromRelation( "installations i,details_installations di,products p,movements m","p.movement_id=m.id and di.product_id=p.id and i.id=$installation_id" ,array("fields"=>"i.*,p.*"));

        $installations=$installation->find(array("fields"=>"*","conditions"=>"id=".$_POST['id']));//  find("movements",array("fields"=>"*"));
       // $moves=array("order_ref"=>$installations[0]["order_ref"],"plan"=>$installations[0]["plan"]);
        header('content-type:application/json');
        echo json_encode($installations);
        die();*/
    }
    function changerFormatDate($datetime)
    {
        $datetime=  $datetime;
        //$date_tab= explode(' ', $datetime);
        $date_fr = explode('/', $datetime);
        $date_fin= $date_fr[2] . '-' . $date_fr[1] . '-' . $date_fr[0];
        return $date_fin;

    }
    public function  validation($input,$ruls='required')
    {
        $result=true;
        if($ruls=='required'){
            if($input=='' || $input==0)
            {
                $result=false;
            }
        }
        return $result;
    }
   public function __message($result)
   {

       echo json_encode(array('msg' => $result));
       die();
   }
}
