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
