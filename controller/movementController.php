<?php

class movementController
{
    public function __construct()
    {
        require_once "model/movement.php";
    }

    /*
     * action index display list off movements from database
     */
    public function actionIndex()
    {
        require 'view/movements/index.php';

    }

    /*
     * action add insert into table movements
     */
    public function actionAdd()
    {
        $result = array();
        $movement=new Movement();
        $data=array("provider"=>$_POST["provider"],"category_id" =>$_POST["category"]);

        if($movement->save($data))
        {
            $result['msg']= 'OK';
        }
        else{
            $result['msg']= 'error';
        }

        echo json_encode($result);
        die();
    }
    public function  actionFind(){
//        $result = array();
//         $movement=new Movement();
//        //$movement->findFromRelation($tables, $keys, $req = null)
    }


}
