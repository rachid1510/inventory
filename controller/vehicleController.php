<?php

require ("model/Model.php");
class vehicleController
{
    //
    public function actionIndex()
    {
        /*
         * var $condition string concat searsh's conditions
         */
        $condition='';
        /*
         * arry vehicles list off véhicles
         */
        $vehicles=array();
        /*
         * instance
         */
        $vehicles = Model::create('Vehicle');
        $costumer = Model::create('Costumer');
        /*
         * search form
         */
        if(!empty($_POST["client"]))
        {
           $condition= "c.id='".$_POST["client"]."'";
        }
        if(!empty($_POST["matricule_searsh"]))
        {
            if($condition=='')
            {
                $condition= "v.id='".$_POST["matricule_searsh"]."'";
            }else{
                $condition .= " AND v.id='".$_POST["matricule_searsh"]."'";
            }
        }
        $costumers=$costumer->find("Costumers",array("fields"=>"*"));
        if($condition!=''){
            $vehicles=$vehicles->findFromRelation( "costumers c,vehicles v","v.costumer_id=c.id AND $condition" ,array("fields"=>"v.*,c.name"));

        }else{
            $vehicles=$vehicles->findFromRelation( "costumers c,vehicles v","v.costumer_id=c.id" ,array("fields"=>"v.*,c.name"));

        }
         require 'view/vehicles/index.php';

    }
    public function actionAdd()
    {
        $result = array();

        $vehicle = Model::create('Vehicle');
        $matricule=(isset($_POST["vehicle_imei"])) ? $_POST["vehicle_imei"] :'';
        $model=(isset($_POST["vehicle_model"])) ? $_POST["vehicle_model"]:'';
        $client=(isset($_POST["costumer_id"])) ? $_POST["costumer_id"] :'';

        $data = array("imei" => $matricule, "model" => $model,"costumer_id"=>$client);

        $vec =$vehicle->save($data);
        if($vec>0)
        {
            $result=array("msg"=>"OK");
        }else{
            $result=array("msg"=>"ERROR");
        }

      echo json_encode($result);
      die();

    }
}
