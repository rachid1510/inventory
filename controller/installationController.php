<?php

require ("model/Model.php");
class installationController
{
    //
    public function actionIndex()
    {
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
        $product = Model::create('Product');
         /*
         * get list of costumers ,vehicles,boitiers,cartes
         */
        $costumers=$costumer->find("Costumers",array("fields"=>"*"));
        $vehicles=$vehicle->find("Vehicles",array("fields"=>"*"));
        $boitiers=$product->findFromRelation("products p,movements m",'p.movement_id=m.id and m.category_id=1',array("fields"=>"p.*"));
        $cartes=$product->findFromRelation("products p,movements m",'p.movement_id=m.id and m.category_id=2',array("fields"=>"p.*"));
       /*
        * require view index
        */
        require 'view/installations/index.php';

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
       //header('content-type:application/json');

        echo json_encode($result,JSON_FORCE_OBJECT);
        die();
    }

}
