<?php

require ("model/Model.php");
class costumerController
{
    //

    public function actionIndex()
    {

        $customers = array();
        $customers = Model::create('Costumer');
        // ,"groupBy"=>"i.id"
        //"costumers c,vehicles v,installations i", "v.costumer_id=c.id and i.vehicle-id= v.id", array("fields" => "c.*")
        if(!empty($_POST["costumer_name"]) OR !empty($_POST["costumer_tel"]))
        {
            $customers=$customers->findFromRelation( "costumers c","c.name='".$_POST["costumer_name"]. "' AND c.phone_number='".$_POST["costumer_tel"]."'" ,array("fields"=>"c.*"));

        }
        else {
            $customers = $customers->find();
        }
        require 'view/costumers/index.php';


    }
//    public function actionSearch()
//    {
//        echo "test";
//        $customers = array();
//        $customers = Model::create('Costumer');
//        $customers->find();
//
//
//
//
//
//    }
}
