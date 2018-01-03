<?php
session_start();
require ("model/Model.php");
include ("config/config.php");
class installationController
{
    //
    public function actionIndex($page=null)
    {
        /*
        * check session
        */


        if (!isset($_SESSION["login"])) {
            header("Location:login.php?error=e");
        }
        $installations=array();
        $installation = Model::create('Installation');
        $product = Model::create('Product');
        /*
         * pagination
         */

        $limit=20;
        if(isset($_POST["pagination"]) and !empty($_POST["pagination"]) and is_numeric($_POST["pagination"])) {
            $limit = $_POST["pagination"];
        }
        $start_from=0;
        $p=1;
        if ($page != null && is_numeric($page)) { $p  = $page; }
        $start_from = ($p-1) * $limit;

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
            $installations=$installation->findFromRelation( "installations i,costumers c,vehicles v,personals p"," i.vehicle_id=v.id    and i.personal_id=p.id and v.costumer_id=c.id" ,array("fields"=>"i.*,v.imei,c.name,CONCAT( p.first_name,' ', p.last_name) AS personnal_name","limit"=>$start_from.','.$limit,"orderBy"=>"i.id desc"));

        }

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

            $html.= (!empty($installation['observation']))?'<td class="text-center">'.$installation['observation'].'</td>':'<td class="text-center">----</td>';
            if($_SESSION['fonction']=='admin' || $_SESSION['fonction']=='technique'){
                $html.='<td class="text-center"><a   onclick="javascript:update_function('. $installation["id"].')"   class="btn btn-secondary btn-xs" title="Edit" data-toggle="tooltip"><span class="glyphicon glyphicon-cog"></span></a></td>';
            }
            else {
                $html.='<td></td>';
            }


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

    public function validation_data($personal_id,$selected_vehicle,$date_installation,$box,$card,$box_costumer,$card_costumer,$new_vehicle,$displaynewvehicle,$product,$action)
    {

        $errors=array();
        if (!$this->validation($date_installation)) {

            $errors[]="Date d'installation ne peut pas etre vide<br>";
        }
        if (empty($personal_id)) {

            $errors[]="Veuillez selctionnez un installateur<br>";
        }

        if ($displaynewvehicle) {
            if (empty($new_vehicle)) {

                $errors[]="Veuillez saissir un matricule<br>";
            }
        }
        else{
            if (!$this->validation($selected_vehicle)) {

                $errors[]="Veuillez selctionnez un véhcule ou couhcer nouveau véhicle<br>";
            }
        }

        if (!isset($_POST["gps_client_check"])) {
            if (!$this->validation($box)) {

                $errors[]="Veuillez selctionnez un boitier<br>";
            }
            else {
                if($action=='add') {
                    if ($this->checkProductByInstallation($box, $product)) {
                        $errors[] = "Le boitier est dèjà installé<br>";
                    }
                }
            }
        }
        else{
            if(empty($box_costumer))
            {

                $errors[]="Veuillez saisir un boitier client<br>";
            }
        }
        if (!isset($_POST["sim_client_check"])) {
            if (!$this->validation($card)) {

                $errors[]="Veuillez selctionnez une carte<br>";
            }
            else {
                if($action=='add') {
                    if ($this->checkProductByInstallation($card, $product)) {
                        $errors[] = "la carte est dèjà installée<br>";
                    }
                }
            }
        }
        else{
            if(empty($card_costumer))
            {

                $errors[]="Veuillez saisir la carte client<br>";
            }
        }

  return $errors;
    }

    public function insertInstallation($personal_id,$selected_vehicle,$date_installation,$new_vehicle,$costumer_id,$observation,$installation)
    {

        $status="Completed";

        if (!empty($new_vehicle)) {
                $vehicle = Model::create('Vehicle');
                $data = array("imei" => $new_vehicle, "costumer_id" => $costumer_id, "user_id" => $_SESSION['user_id']);
                $vec = $vehicle->save($data);
                if ($vec > 0) {
                    $selected_vehicle = $vec;
                }

            }
        /*
        * prepare data to insert in installation table
         */
        $data = array("status" => $status, "personal_id" => $personal_id, "vehicle_id" => $selected_vehicle, "user_id" => $_SESSION['user_id'], "installed_at" => $date_installation,"observation"=>$observation);
        /*
         * call function to save installation and get lastinsert id in var $installation_id
         */
        $installation_id = $installation->save($data);
        return $installation_id;

    }
    /*
     * action add insert into table movements
     */
    public function actionAdd()
    {
        /*
             * instances
         */
        $installation = Model::create('Installation');
        $detail_installation = Model::create('DetailsInstallation');
        $inventory_personl = Model::create('InventoryPersonal');
        $product = Model::create('Product');
        $CostumerProduct = Model::create('CostumerProduct');

        $personal_id=(isset($_POST["personal_id"]))? $_POST["personal_id"]:'';
        $selected_vehicle=(isset($_POST["selected_vehicle"]))? $_POST["selected_vehicle"]:'';
        $date_installation=(isset($_POST["date_installation"]))? $_POST["date_installation"]:'';
        $box=(isset($_POST["selected_box"]))? $_POST["selected_box"]:'' ;
        $card=(isset($_POST["selected_card"]))? $_POST["selected_card"]:'';
        $box_costumer=(isset($_POST["imei_product_costumer"]))? $_POST["imei_product_costumer"]:'';
        $card_costumer=(isset($_POST["gsm_product_costumer"]))? $_POST["gsm_product_costumer"]:'';
        $new_vehicle=(isset($_POST["newvehicle"]))? $_POST["newvehicle"]:'';
        $costumer_id=(isset($_POST["selected_costmer"]))? $_POST["selected_costmer"]:'' ;
        $displaynewvehicle=(isset($_POST['displaynewvehicle']))? true:false;
        $observation=(isset($_POST["observation"]))? $_POST["observation"]:'';
        /*
         * arrays
         */
        $result = "";
        $errors=array();
        $inventory_personal_data=array();
        $installation_id=0;
        $errors=$this->validation_data($personal_id,$selected_vehicle,$date_installation,$box,$card,$box_costumer,$card_costumer,$new_vehicle,$displaynewvehicle,$product,'add');

         if(count($errors)==0) {
            $installation_id = $this->insertInstallation($personal_id,$selected_vehicle,$date_installation,$new_vehicle,$costumer_id,$observation,$installation);

           if ($installation_id > 0) {
                if (!isset($_POST["gps_client_check"]) && !isset($_POST["sim_client_check"]) && $card != '' && $box != '') {

                    if ($this->insertCard($card, $product, $installation_id, $personal_id, $detail_installation, $inventory_personl, $CostumerProduct)) {
                        $result = 'OK';
                    }

                    if ($this->insertBox($box, $product, $installation_id, $personal_id, $detail_installation, $inventory_personl, $CostumerProduct)) {
                        $result = 'OK';
                    }

                }elseif (isset($_POST["gps_client_check"])) {

                    if ($this->insertCard($card, $product, $installation_id, $personal_id, $detail_installation, $inventory_personl, $CostumerProduct)) {
                        $result = 'OK';
                    } else {
                        $result = 'Erreur au niveau d\'insertion de la carte sim';
                    }


                }elseif (isset($_POST["sim_client_check"])) {

                    if ($this->insertBox($box, $product, $installation_id, $personal_id, $detail_installation, $inventory_personl, $CostumerProduct)) {
                        $result = 'OK';
                    } else {
                        $result = 'Erreur au niveau d\'insertion de boitier';
                    }


                }
            }
            else {
                $result = 'L\'installation n\'est pas crée';
            }
             $this->__message($result);
            }
            else{
                echo json_encode(array("msg"=>$errors));
            }

    }

    /*
     * insert sim
     */
     public function insertCard($card,$product,$installation_id,$personal_id,$detail_installation,$inventory_personl,$CostumerProduct)
     {
         $result=true;

         /*
          * installation is change of the card
          */
         $datasim = array("product_id" => $card, "installation_id" => $installation_id);
         /*
          * save detail installation
          */
         if($detail_installation->save($datasim)==0){
             $result=false;
           }
         /*
         * get inventory personl id
         */
         $inventory_personal_data = $inventory_personl->find(array('conditions' => 'product_id =' . $card . ' and personal_id=' . $personal_id));
         $data_inventory_perso = array("id" => $inventory_personal_data[0]['id'], "status" => '0');
         $data_product = array("id" => $inventory_personal_data[0]['product_id'], "status" => '0');
         /*
         * update status of product on product's table and personal's inventory
         */
         if($result) {
             if ($inventory_personl->save($data_inventory_perso)==0 or $product->save($data_product)== 0) {
                 $result = false;
             }
         }

         /*
          * data product's costumer
          */
         if(isset($_POST['imei_product_costumer']) and !empty($_POST['imei_product_costumer'])) {
             $imei_product_costumer = $_POST['imei_product_costumer'];
             $provider_product_costumer = $_POST['provider_product_costumer'];
             $costumer_products = array('imei_product' => $imei_product_costumer, 'provider' => $provider_product_costumer, 'installation_id' => $installation_id);
             if ($result) {
                 if ($CostumerProduct->save($costumer_products) == 0) {
                     $result = false;
                 }
             }
         }
         return $result;
     }
     /*
      * insert box
      */
     public function insertBox($box,$product,$installation_id,$personal_id,$detail_installation,$inventory_personl,$CostumerProduct)
     {
         $result=true;

         //change of the box
         /*
          * installation is change of the box
          */
         $databoitier = array("product_id" => $box, "installation_id" => $installation_id);
         /*
         * save detail installation
         */
         if($detail_installation->save($databoitier)==0)
         {
             $result=false;
         }

         $inventory_personal_data = $inventory_personl->find(array('conditions' => 'product_id =' . $box . ' and personal_id=' . $personal_id));
         $data_inventory_perso = array("id" => $inventory_personal_data[0]['id'], "status" => '0');
         $data_product = array("id" => $inventory_personal_data[0]['product_id'], "status" => '0');
         /*
             * update status of product on product's table and personal's inventory
             */
         if($result==true) {
             if ($inventory_personl->save($data_inventory_perso) == 0 or $product->save($data_product) == 0) {
                 $result = false;
             }
         }
         if(isset($_POST['gsm_product_costumer']) and !empty($_POST['gsm_product_costumer'])) {
             $gsm_product_costumer = $_POST['gsm_product_costumer'];
             $operateur_product_costumer = $_POST['operateur_product_costumer'];
             $costumer_products = array('imei_product' => $gsm_product_costumer, 'provider' => $operateur_product_costumer, 'installation_id' => $installation_id);
             if ($result == true) {
                 if ($CostumerProduct->save($costumer_products)== 0) {
                     $result = false;
                 }
             }
         }
         return $result;
     }

     /*/*
        * function edit
        */
    public function actionEdit(){
        //require 'view/installations/update.php';
        $installations=array();
        $installation_id=$_POST['id'];
        $installation = Model::create('Installation');
        $installations=$installation->findFromRelation( "installations i,details_installations di,products p,movements m,vehicles v","v.id=i.vehicle_id and p.movement_id=m.id and di.product_id=p.id and i.id=di.installation_id and i.id=$installation_id" ,array("fields"=>"i.*,i.id as installation_id,p.*,p.id as id_product,m.category_id as category,v.costumer_id as costumer"));


        echo json_encode($installations);

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
    /*
     * function update installation
     */
    public  function actionUpdate()
    {
        /*
             * instances
         */
        $installation = Model::create('Installation');
        $detail_installation = Model::create('DetailsInstallation');
        $inventory_personl = Model::create('InventoryPersonal');
        $product = Model::create('Product');
        $CostumerProduct = Model::create('CostumerProduct');
        /*
         * binding data
         */
        $personal_id=(isset($_POST["personal_id"]))? $_POST["personal_id"]:'';
        $selected_vehicle=(isset($_POST["selected_vehicle"]))? $_POST["selected_vehicle"]:'';
        $date_installation=(isset($_POST["date_installation"]))? $_POST["date_installation"]:'';
        $box=(isset($_POST["selected_box"]))? $_POST["selected_box"]:'' ;
        $card=(isset($_POST["selected_card"]))? $_POST["selected_card"]:'';
        $box_costumer=(isset($_POST["imei_product_costumer"]))? $_POST["imei_product_costumer"]:'';
        $card_costumer=(isset($_POST["gsm_product_costumer"]))? $_POST["gsm_product_costumer"]:'';
        $new_vehicle=(isset($_POST["newvehicle"]))? $_POST["newvehicle"]:'';
        $costumer_id=(isset($_POST["selected_costmer"]))? $_POST["selected_costmer"]:'' ;
        $displaynewvehicle=(isset($_POST['displaynewvehicle']))? true:false;
        $id_installation_old= $_POST['id_installation'];
        $id_sim_old=$_POST['id_sim_old'];
        $id_box_old=$_POST['id_box_old'];
        $status="Completed";
        $observation="Reconfiguration";
        $errors=array();
        $errors=$this->validation_data($personal_id,$selected_vehicle,$date_installation,$box,$card,$box_costumer,$card_costumer,$new_vehicle,$displaynewvehicle,$product,'update');
        if(count($errors)==0) {
            if (($id_sim_old != $card) or ($id_box_old != $box)) {
                $installation_id = $this->insertInstallation($personal_id, $selected_vehicle, $date_installation, $new_vehicle, $costumer_id, $observation, $installation);
                if ($installation_id > 0) {
                    if (!isset($_POST["gps_client_check"]) && !isset($_POST["sim_client_check"]) && $card != '' && $box != '') {
                        if ($id_sim_old != $card and $card != '') {
                            if ($this->insertCard($card, $product, $installation_id, $personal_id, $detail_installation, $inventory_personl, $CostumerProduct)) {
                                $result = 'OK';
                                if ($id_sim_old > 0) {
                                    if (!$this->blockedProduct($id_sim_old, $product)) {
                                        $result = 'Erreur';
                                    }
                                }
                            } else {
                                $result = 'Erreur au niveau d\'insertion de la carte sim';
                            }
                        }
                        if ($id_box_old != $box and $box != '') {
                            if ($this->insertBox($box, $product, $installation_id, $personal_id, $detail_installation, $inventory_personl, $CostumerProduct)) {
                                $result = 'OK';
                                if ($id_box_old > 0) {
                                    if (!$this->blockedProduct($id_box_old, $product)) {
                                        $result = 'Erreur';
                                    }
                                }
                            } else {
                                $result = 'Erreur au niveau d\'insertion de la carte sim';
                            }
                        }
                    } elseif (isset($_POST["gps_client_check"])) {
                        if ($id_sim_old != $card and $card != '') {
                            if ($this->insertCard($card, $product, $installation_id, $personal_id, $detail_installation, $inventory_personl, $CostumerProduct)) {
                                $result = 'OK';
                                if ($id_sim_old > 0) {
                                    if (!$this->blockedProduct($id_sim_old, $product)) {
                                        $result = 'Erreur';
                                    }
                                }
                            } else {
                                $result = 'Erreur au niveau d\'insertion de la carte sim';
                            }
                        }
                        if ($id_box_old > 0) {
                            if (!$this->blockedProduct($id_box_old, $product)) {
                                $result = 'Erreur';
                            }
                        }
                    } elseif (isset($_POST["sim_client_check"])) {

                        if ($id_box_old != $box and $box != '') {
                            if ($this->insertBox($box, $product, $installation_id, $personal_id, $detail_installation, $inventory_personl, $CostumerProduct)) {
                                $result = 'OK';
                                if ($id_box_old > 0) {
                                    if (!$this->blockedProduct($id_box_old, $product)) {
                                        $result = 'Erreur';
                                    }
                                }
                            } else {
                                $result = 'Erreur au niveau d\'insertion de la carte sim';
                            }
                        }
                        if ($id_sim_old > 0) {
                            if (!$this->blockedProduct($id_sim_old, $product)) {
                                $result = 'Erreur';
                            }
                        }
                    }
                } else {
                    $result = 'Erreur';
                }
            } else {
                $data = array("id" => $id_installation_old, "status" => $status, "personal_id" => $personal_id, "vehicle_id" => $selected_vehicle, "user_id" => $_SESSION['user_id'], "installed_at" => $date_installation);
                if ($installation->save($data)) {
                    $result = 'OK';
                }
            }

        }
        else{
            echo json_encode(array("msg"=>$errors));
        }

        $this->__message($result);
    }

    /**
     * @param $result
     */
    public function __message($result)
   {

       echo json_encode(array('msg' => $result));

   }

   public function checkProductByInstallation($id,$product)
   {
       $product_id=$id;
       $products=array();

       $products=$product->findFromRelation('products p,details_installations di',"p.id=$product_id and di.product_id=p.id",array("fields"=>"p.id"));
       if(count($products)>0)
       {
           return true;
       }
     return false;
   }

    public function blockedProduct($id,$product)
    {

        $product_id=$id;
        $products=array("id" => $product_id, "status" => '3');
        /*
        * save update product
        */
        if($product->save($products))
        {
            return true;
        }
        return false;
    }
}
