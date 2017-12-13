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
    {   $result = array();
        $movement=new Movement();
        $data=array("provider"=>$_POST["provider"],"category_id" =>$_POST["category"]);
        if($movement->save($data))
        {
            $result['msg']= 'OK';
        }
        else{
            $result['msg']= 'error';
        }
        header('Content-type: application/json');
        return json_encode($result);
        //die();
    }
}
