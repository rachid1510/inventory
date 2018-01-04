<?php
session_start();
require ("model/Model.php");
class vehicleController
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
        /*
         * var $condition string concat searsh's conditions
         */
        $condition='';
        /*
         * arry vehicles list off véhicles
         */
        /*
         * pagination limit
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
        $vehicles=array();
        /*
         * instance
         */
        $vehicle = Model::create('Vehicle');
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
                $condition= "v.imei='".$_POST["matricule_searsh"]."'";
            }
            else{
                $condition .= " AND v.imei='".$_POST["matricule_searsh"]."'";
            }
        }
        $costumers = $costumer->find("Costumers",array("fields"=>"*"));
        if($condition!=''){
            $allvehicles=$vehicle->findFromRelation( "costumers c,vehicles v","v.costumer_id=c.id AND $condition" ,array("fields"=>"v.*,c.name"));

            $vehicles=$vehicle->findFromRelation( "costumers c,vehicles v","v.costumer_id=c.id AND $condition" ,array("fields"=>"v.*,c.name","limit"=>$start_from.','.$limit));

        }else{
            $allvehicles=$vehicle->findFromRelation( "costumers c,vehicles v","v.costumer_id=c.id" ,array("fields"=>"v.*,c.name"));

            $vehicles=$vehicle->findFromRelation( "costumers c,vehicles v","v.costumer_id=c.id" ,array("fields"=>"v.*,c.name","limit"=>$start_from.','.$limit));

        }
        $total_records = count($allvehicles);
        $total_pages = ceil($total_records / $limit);
        require 'view/vehicles/index.php';


    }
    public function actionAdd()
    {
        $result = array();

        $vehicle = Model::create('Vehicle');
        $matricule=(isset($_POST["vehicle_imei"])) ? $_POST["vehicle_imei"] :'';
        $model=(isset($_POST["vehicle_model"])) ? $_POST["vehicle_model"]:'';
        $client=(isset($_POST["costumer_id"])) ? $_POST["costumer_id"] :'';
        $marque=(isset($_POST["vehicle_marque"])) ? $_POST["vehicle_marque"] :'';
        $data = array("imei" => $matricule, "model" => $model,"marque" =>$marque,"costumer_id"=>$client,"user_id"=>$_SESSION['user_id']);

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

    public function actionGetVehicleByCostumer(){
        $vehicles = array();
        $costumer=$_POST['id'];
        //echo $personal;
        $vehicle = Model::create('Vehicle');
        $vehicles=$vehicle->findFromRelation("vehicles","costumer_id=$costumer",array("fields"=>"*"));
        echo json_encode($vehicles);
    }

    /*/*
     * function edit
     */
    public function actionEdit(){

        $vehicles=array();
        $vehicle_id=$_POST['id'];
        $vehicle = Model::create('Vehicle');
        $vehicles=$vehicle->findFromRelation("vehicles","id=$vehicle_id" ,array("fields"=>"*"));
        echo json_encode($vehicles);

    }

    public function actionUpdate()
    {
        $result = array();

        $vehicle = Model::create('Vehicle');
        $matricule=(isset($_POST["vehicle_imei"])) ? $_POST["vehicle_imei"] :'';
        $model=(isset($_POST["vehicle_model"])) ? $_POST["vehicle_model"]:'';
        $client=(isset($_POST["costumer_id"])) ? $_POST["costumer_id"] :'';
        $marque=(isset($_POST["vehicle_marque"])) ? $_POST["vehicle_marque"] :'';
        if(isset($_POST["id_vehicle"])) {
            $id = $_POST["id_vehicle"];
            $data = array("id"=>$id,"imei" => $matricule, "model" => $model, "marque" => $marque, "costumer_id" => $client,"user_id"=>$_SESSION['user_id']);
           if($vehicle->save($data))
             {
                $result = array("msg" => "OK");
            } else {
                $result = array("msg" => "ERROR");
            }
        }
        else{
            $result = array("msg" => "ERROR");
        }
        echo json_encode($result);
        die();

    }
}
