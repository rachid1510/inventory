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
        if(!empty($_POST["installed_at"]) OR !empty($_POST["client"]) OR !empty($_POST["matricule"]))
        {
            $installations=$installation->findFromRelation( "installations i,costumers c,vehicles v,personals p"," i.vehicle_id=v.id and i.installed_at='".$_POST["installed_at"]."' and i.personal_id=p.id and v.costumer_id=c.id and c.id='".$_POST["client"]."' and v.id='".$_POST["matricule"]."' ",array("fields"=>"i.*,v.imei,c.name,CONCAT( p.first_name,' ', p.last_name) AS personnal_name"));


        }
        else {
            $installations=$installation->findFromRelation( "installations i,costumers c,vehicles v,personals p","i.vehicle_id=v.id and i.personal_id=p.id and v.costumer_id=c.id" ,array("fields"=>"i.*,v.imei,c.name,CONCAT( p.first_name,' ', p.last_name) AS personnal_name"));
            //var_dump($installations);

        }
        $html='';

        foreach ($installations as $installation){
            $boitier=$this->getProductByTypeInstallation($installation['id'],1,$product);
            $sim=$this->getProductByTypeInstallation($installation['id'],2,$product);


            $html.='<tr> <td class="text-center">'. $installation["installed_at"].'</td>';
            $html.='<td class="text-center">'.$installation['personnal_name'].'</td>';
            $html.='<td class="text-center">' .$installation['name'].' </td>';
            $html.='<td class="text-center">' .$installation['imei'].'</td>';
            $html.='<td class="text-center">'. $installation['observation'].'</td>';
            $html.='<td class="text-center">'. $sim.'</td>';
            $html.='<td class="text-center">'. $boitier.'</td>';

            $html.='<td class="text-center"> <div class="btn-group"><a href="#" class="btn btn-info btn-xs" title="Edit" data-toggle="tooltip"><span class="glyphicon glyphicon-edit"></span></a></div></td></tr>';


        }
        require 'view/installations/index.php';

    }


   public  function getProductByTypeInstallation($installation_id,$category,$product)
   {

       $product=$product->findFromRelation( "details_installations di,products p,movements m","p.movement_id=m.id and di.product_id=p.id and di.installation_id=$installation_id and m.category_id=$category" ,array("fields"=>"p.*"));
       return $product[0]["imei_product"];

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
             * instance object detail_installation
             */
            $detail_installation=Model::create('DetailsInstallation');
            /*
             * check if is not costumer's product (card and box)
             */
            if(!isset($_POST["gps_client_check"]) && !isset($_POST["sim_client_check"])) {
                /*
                 * prepare data to insert box data  in detail_installation table
                 */
                $databoitier = array("product_id" => $_POST["selected_box"], "installation_id" => $installation_id);
                /*
                 *  prepare data to insert card data  in detail_installation table
                */
                $datasim = array("product_id" => $_POST["selected_card"], "installation_id" => $installation_id);
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
       header('content-type:application/json');
        return $result;
        die();
    }


}
