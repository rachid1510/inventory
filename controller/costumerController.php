<?php
session_start();
require ("model/Model.php");
class costumerController
{
    //

    public function actionIndex($page=null)
    {
        /*
         *
         */
        if (!isset($_SESSION["login"])) {
            header("Location:login.php?error=e");
        }
        $customers = array();
        $customer = Model::create('Costumer');
        /*
         * var condition string
         */
        /*
         * pagination
         */
        $limit = 20;

        if(isset($_POST["pagination"]) and !empty($_POST["pagination"]) and is_numeric($_POST["pagination"])) {
            $limit = $_POST["pagination"];
        }

        $start_from = 0;
        $p = 1;
        if ($page != null and is_numeric($page)) {
            $p = $page;
        }
        $start_from = ($p - 1) * $limit;

        $condition="";

        if(!empty($_POST["costumer_name"]))
        {
            $condition= "c.name like '%".$_POST["costumer_name"]. "%'";
        }
        if(!empty($_POST["costumer_tel"]))
        {
            if($condition=='')
            {
                $condition= "c.phone_number like '%".$_POST["costumer_tel"]. "%'";
            }
            else{
                $condition .= " AND c.phone_number like '%".$_POST["costumer_tel"]. "%'";
            }
        }


        if($condition !='')
        {
            $customers=$customer->findFromRelation( "costumers c",$condition ,array("fields"=>"c.*","limit"=>$start_from.','.$limit));

        }
        else {

            $customers = $customer->find();
        }
      if(isset($_POST['export'])) {
            $header = ['id', 'name', 'type', 'phone_number', 'city', 'departement', 'adress', 'user_id', 'created_at', 'updated_at'];
            $customer->export_excel($customers, $header, 'La liste des clients');
        }
         require 'view/costumers/index.php';

    }
    public function actionAdd()
    {
        $result = array();

        /*
         * bind data from post
         */
        $name=(isset($_POST["costumer_name"]))? $_POST["costumer_name"] : '';
        $phone=(isset($_POST["costumer_phone"]))? $_POST["costumer_phone"] :'';
        $city=(isset($_POST["costumer_city"]))? $_POST["costumer_city"]:'';
        $departement=(isset($_POST["costumer_departement"])) ? $_POST["costumer_departement"] :'';
        $adress=(isset($_POST["costumer_adress"])) ? $_POST["costumer_adress"] :'';
        $type=(isset($_POST["costumer_type"])) ? $_POST["costumer_type"] :'' ;
        $mail=(isset($_POST["costumer_mail"])) ? $_POST["costumer_mail"] :'' ;
        /*
         * instance costumer
         */
        $costumer=Model::create('Costumer');
        $data=array("name"=>$name,"phone_number"=>$phone,"mail"=>$mail,"type"=>$type,"city"=>$city,"departement"=>$departement,"adress"=>$adress,'user_id'=>$_SESSION['user_id']);

        if($costumer->save($data)>0)
        {
            $result = array("msg"=>"OK");

        }
        else{
            $result = array("msg"=>"ERRORR");
        }
        echo json_encode($result);
        die();

    }
  /*
   * get costumer product
   */
    public function actionGetProduct(){
        //require 'view/installations/update.php';
        $products=array();
        $costumerprod=Model::create('CostumerProduct');
        $installation_id=$_POST['id'];
        $products=$costumerprod->findFromRelation( "costumer_products c","c.installation_id=$installation_id" ,array("fields"=>"c.*"));
        echo json_encode($products);

    }

    /*/*
      * function edit
      */
    public function actionEdit(){

        $costumers=array();
        $costumer_id=$_POST['id'];
        $Costumer = Model::create('Costumer');
        $costumers=$Costumer->findFromRelation( "costumers c","c.id=$costumer_id" ,array("fields"=>"c.*"));
        echo json_encode($costumers);

    }

    public function actionUpdate()
    {
        $result = array();

        /*
         * bind data from post
         */
        $name=(isset($_POST["costumer_name"]))? $_POST["costumer_name"] : '';
        $phone=(isset($_POST["costumer_phone"]))? $_POST["costumer_phone"] :'';
        $city=(isset($_POST["costumer_city"]))? $_POST["costumer_city"]:'';
        $departement=(isset($_POST["costumer_departement"])) ? $_POST["costumer_departement"] :'';
        $adress=(isset($_POST["costumer_adress"])) ? $_POST["costumer_adress"] :'';
        $type=(isset($_POST["costumer_type"])) ? $_POST["costumer_type"] :'' ;
        $mail=(isset($_POST["costumer_mail"])) ? $_POST["costumer_mail"] :'' ;
        /*
         * instance costumer
         */
        $costumer=Model::create('Costumer');
        if(isset($_POST["id_costumer"])) {
            $id = $_POST["id_costumer"];
            $data = array("id"=> $id, "name" => $name, "phone_number" => $phone,"mail"=>$mail,"type" => $type, "city" => $city, "departement" => $departement, "adress" => $adress);

            if ($costumer->save($data)) {
                $result = array("msg" => "OK");

            } else {
                $result = array("msg" => "ERRORR");
            }
        }
        else{
            $result = array("msg" => "ERRORR");
        }

        echo json_encode($result);
        die();

    }
}
