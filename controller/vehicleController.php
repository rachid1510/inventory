<?php

require ("model/Model.php");
class vehicleController
{
    //
    public function actionIndex()
    {
        $vehicles=array();
        $vehicles = Model::create('Vehicle');
        $vehicles=$vehicles->findFromRelation( "costumers c,vehicles v","v.costumer_id=c.id" ,array("fields"=>"v.*,c.name"));
        require 'view/vehicles/index.php';

    }
    public function actionAdd()
    {
//        $result = array();
//        //$movement=new Move;ment();
//        $vehicle=array();
//        $vehicle = Model::create('Vehicle');
//        $matricule=$_POST["vehicle_imei"];
//        $model=$_POST["vehicle_model"];
//        $client=$_POST["costumer_id"];
//
//        $data = array("status" => $matricule, "personal_id" => $model,"vehicle_id"=>$client);
//
//        $vec =$vehicle->save();



    }
}
