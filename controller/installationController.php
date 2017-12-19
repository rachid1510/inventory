<?php

require ("model/Model.php");
class installationController
{
    //
    public function actionIndex()
    {

        $installations=array();
        $installation = Model::create('Installation');
        $product = Model::create('Product');


       // $installations = $installation->find();


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
            $installations=$installation->findFromRelation( "installations i,costumers c,vehicles v,personals p"," i.vehicle_id=v.id  and i.personal_id=p.id and v.costumer_id=c.id AND ".$condition ,array("fields"=>"i.*,v.imei,c.name,CONCAT( p.first_name,' ', p.last_name) AS personnal_name"));

        }
        else {
            $installations=$installation->findFromRelation( "installations i,costumers c,vehicles v,personals p"," i.vehicle_id=v.id  and i.personal_id=p.id and v.costumer_id=c.id ",array("fields"=>"i.*,v.imei,c.name,CONCAT( p.first_name,' ', p.last_name) AS personnal_name"));

            //$installations = $installation->find();
        }
//        if(!empty($_POST["installed_at"]) OR !empty($_POST["client"]) OR !empty($_POST["matricule"]))
//        {
//            $installations=$installation->findFromRelation( "installations i,costumers c,vehicles v,personals p"," i.vehicle_id=v.id  and i.personal_id=p.id and v.costumer_id=c.id and i.installed_at='".$_POST["installed_at"]."'  and c.id='".$_POST["client"]."' and v.id='".$_POST["matricule"]."' ",array("fields"=>"i.*,v.imei,c.name,CONCAT( p.first_name,' ', p.last_name) AS personnal_name"));
//
//
//        }
//        else {
//            $installations=$installation->findFromRelation( "installations i,costumers c,vehicles v,personals p","i.vehicle_id=v.id and i.personal_id=p.id and v.costumer_id=c.id" ,array("fields"=>"i.*,v.imei,c.name,CONCAT( p.first_name,' ', p.last_name) AS personnal_name"));
//            //var_dump($installations);
//
//        }
        $html='';

        foreach ($installations as $installation){
            $boitier=$this->getProductByTypeInstallation($installation['id'],1,$product);
            $sim=$this->getProductByTypeInstallation($installation['id'],2,$product);


            $html.='<tr> <td class="text-center">'. $installation["installed_at"].'</td>';
            $html.='<td class="text-center">'.$installation['personnal_name'].'</td>';
            $html.='<td class="text-center">' .$installation['name'].' </td>';
            $html.='<td class="text-center">' .$installation['imei'].'</td>';
            $html.='<td class="text-center">'. $sim.'</td>';
            $html.='<td class="text-center">'. $boitier.'</td>';
            $html.='<td class="text-center">'. $installation['observation'].'</td>';
             $html.='<td class="text-center"> <div class="btn-group"><a onclick="javascript:update_function('. $installation["id"].')"   class="btn btn-info btn-xs" title="Edit" data-toggle="tooltip"><span class="glyphicon glyphicon-edit"></span></a></div></td>';
            $html.='</tr>';

        }
        require 'view/installations/index.php';

    }


   public  function getProductByTypeInstallation($installation_id,$category,$product)
   {

       $product=$product->findFromRelation( "details_installations di,products p,movements m","p.movement_id=m.id and di.product_id=p.id and di.installation_id=$installation_id and m.category_id=$category" ,array("fields"=>"p.*"));
       if(count($product)>0){
           return $product[0]["imei_product"];
       }


   }

    /*
     * action add insert into table movements
     */
    public function actionAdd()
    {
        $result = array();
        $error=array();
        $personal_id=$_POST["personal_id"];
        $selected_vehicle=$_POST["selected_vehicle"];
        $date_installation=$_POST["date_installation"];
        $box=$_POST["selected_box"];
        $card=$_POST["selected_card"];
        /*
         * instances
         */
        $installation = Model::create('Installation');
        $detail_installation=Model::create('DetailsInstallation');
        $inventory_personl=Model::create('InventoryPersonal');
        $product=Model::create('Product');
        /*
         * set default value off installation's status
         */
        $status="Completed";
        /*
         * check if installation in progress is checked and change default value if checked
         */
        if(!isset($_POST["status"])){
            $status="In_progress";
        }
        /*
         * prepare data to insert in installation table
         */
        $data = array("status" => $status, "personal_id" => $personal_id,"vehicle_id"=>$selected_vehicle,"user_id"=>1,"installed_at"=>$date_installation);
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
            if(!isset($_POST["gps_client_check"]) && !isset($_POST["sim_client_check"])) {
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
                if($status=="Completed") {
                    /*
                    * get inventory personl ids
                    */
                    $inventory_personal_data[] = $inventory_personl->find(array('conditions' => 'product_id in(' . $card . ',' . $box . ') and personal_id=' . $personal_id));
                    // var_dump($inventory_personal_data);
                    foreach ($inventory_personal_data as $inventory_perso) {
                        $data_inventory_perso = array("id" => $inventory_perso['id'], "status" => '0');
                        $data_product = array("id" => $inventory_perso['product_id'], "status" => '0');
                        /*
                         * update status of product on product's table and personal's inventory
                         */
                        $inventory_personl->save($data_inventory_perso);
                        $product->save($data_product);
                    }
                }
            }
               /*
                 * check if is not costumer's product (box)
              */
          elseif (isset($_POST["gps_client_check"]) && $_POST["gps_client_check"] )
            {
                /*
                 * installation is change of the card
                 */
                 $datasim = array("product_id" => $_POST["sim"], "installation_id" => $installation_id);
                 /*
                  * save detail installation
                  */
                $detail_installation->save($datasim);
                /*
                * check if installation is completed
                */
                if($status=="Completed") {
                    /*
                     * get inventory personl id
                     */
                    $inventory_personal_data[] = $inventory_personl->find(array('conditions' => 'product_id =' . $card . ' and personal_id=' . $personal_id));
                    $data_inventory_perso = array("id" => $inventory_personal_data[0]['id'], "status" => '0');
                    $data_product = array("id" => $inventory_personal_data[0]['product_id'], "status" => '0');
                    /*
                        * update status of product on product's table and personal's inventory
                        */
                    $inventory_personl->save($data_inventory_perso);
                    $product->save($data_product);
                }

            }
          elseif(isset($_POST["sim_client_check"]) && $_POST["sim_client_check"]){
                //change of the box
                /*
                 * installation is change of the box
                 */
                $databoitier =  array("product_id" => $_POST["boitier"], "installation_id" => $installation_id);
                  /*
                  * save detail installation
                  */
                $detail_installation->save($databoitier);
                 /*
                 * check if installation is completed
                 */
              if($status=="Completed") {
                  /*
                  * get inventory personl id
                  */
                  $inventory_personal_data[] = $inventory_personl->find(array('conditions' => 'product_id =' . $box . ' and personal_id=' . $personal_id));
                  $data_inventory_perso = array("id" => $inventory_personal_data[0]['id'], "status" => '0');
                  $data_product = array("id" => $inventory_personal_data[0]['product_id'], "status" => '0');
                  /*
                      * update status of product on product's table and personal's inventory
                      */
                  $inventory_personl->save($data_inventory_perso);
                  $product->save($data_product);
              }
            }
            $result = array('msg' => 'OK');

        } else {
            $result = array('msg' => 'error');
        }
        header('content-type:application/json');
        echo json_encode($result);
        die();
    }
    /*/*
        * function edit
        */
   /* public function actionEdit(){
        $installation = Model::create('Installation');
        $installations=$installation->findFromRelation("installations i,details_installation di"," di.installation_id=di.id and i.id=".$_POST['id'],array("fields"=>"i.*"));//  find("movements",array("fields"=>"*"));
        $moves=array("order_ref"=>$installations[0]["order_ref"],"plan"=>$installations[0]["plan"]);
        header('content-type:application/json');
        echo json_encode($moves);
        die();
    }*/

}
