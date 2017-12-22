<?php

require ("model/Model.php");
class costumerController
{
    //

    public function actionIndex()
    {

        $customers = array();
        $customers = Model::create('Costumer');
        /*
         * var condition string
         */
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
            }else{
                $condition .= " AND c.phone_number like '%".$_POST["costumer_tel"]. "%'";
            }
        }


        if($condition !='')
        {
            $customers=$customers->findFromRelation( "costumers c",$condition ,array("fields"=>"c.*"));

        }
        else {

            $customers = $customers->find();
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
