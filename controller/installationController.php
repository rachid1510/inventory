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
        //$movement=new Move;ment();
        $installation = Model::create('Installation');
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
        $data = array("status" => $status, "personal_id" => $_POST["personal_id"],"vehicle_id"=>$_POST["vehicle_id"],"user_id"=>1,"installed_at"=>$_POST["date_installation"]);
        /*
         * call function to save installation and get lastinsert id in var $installation_id
         */
        $installation_id = $installation->save($data);
         /*
          * check if saved
          */
        if ($installation_id > 0) {
            /*
             * instance object detail_installation
             */
            $detail_installation=Model::create('DetailsInstallations');
            /*
             * check if is not costumer's product (card and box)
             */
            if(!isset($_POST["gps_client_check"]) && !isset($_POST["sim_client_check"])) {
                /*
                 * prepare data to insert box data  in detail_installation table
                 */
                $databoitier = array("product_id" => $_POST["boitier"], "installation_id" => $installation_id);
                /*
                 *  prepare data to insert card data  in detail_installation table
                */
                $datasim = array("product_id" => $_POST["sim"], "installation_id" => $installation_id);
                /*
                 * call function to save box in  detail_installation
                 */
                $detail_installation->save($databoitier);
                /*
                 * call function to save card in  detail_installation
                 */
                $detail_installation->save($datasim);

            }
               /*
                 * check if is not costumer's product (box)
              */
            elseif (isset($_POST["gps_client_check"]))
            {
                /*
                 * installation is change of the card
                 */
                 $datasim = array("product_id" => $_POST["sim"], "installation_id" => $installation_id);
                 /*
                  * save detail installation
                  */
                $detail_installation->save($datasim);
                //update observation installation table
            }else{
                //change of the box
                /*
                 * installation is change of the box
                 */
                $databoitier = array("product_id" => $_POST["boitier"], "installation_id" => $installation_id);
                  /*
                  * save detail installation
                  */
                $detail_installation->save($databoitier);
            }
            $result['msg'] = 'OK';

        } else {
            $result['msg'] = 'error';
        }
        //header('content-type:application/json');
        return $result;
        die();
    }

}
