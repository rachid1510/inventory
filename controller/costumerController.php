<?php

require ("model/Model.php");
class costumerController
{
    //

    public function actionIndex($page=null)
    {

        $customers = array();
        $customers = Model::create('Costumer');
        /*
         * var condition string
         */
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
            $customers=$customers->findFromRelation( "costumers c",$condition ,array("fields"=>"c.*","limit"=>$start_from.','.$limit));

        }
        else {

            $customers = $customers->find();
        }
        session_start();

        if (isset($_SESSION["login"])) {
            require 'view/costumers/index.php';
        }
        else
            header("Location:login.php?error=e");


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
        /*
         * instance costumer
         */
        $costumer=Model::create('Costumer');
        $data=array("name"=>$name,"phone_number"=>$phone,"type"=>$type,"city"=>$city,"departement"=>$departement,"adress"=>$adress);

        if($costumer->save($data)>0)
        {
            $result = array("msg"=>"OK");

        }
        else{
            $result = array("msg"=>"ERRORR");
        }
        header('content-type:application/json');
        echo json_encode($result);
        die();

    }
}
