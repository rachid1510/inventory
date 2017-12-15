<?php
require ("model/Model.php");
class movementController
{
    /*
    * action index display list off movements from database
    */
    public function actionIndex()
    {
        //$category = Model::create('Category');
        require 'view/movements/index.php';
    }
    /*
     * action add insert into table movements
     */
    public function actionAdd()
    {
        $result = array();
        //$movement=new Move;ment();
        $movement = Model::create('Movement');
        $data = array("provider" => $_POST["provider"], "category_id" => $_POST["category"]);
        $movement_id = $movement->save($data);
        $file = $_FILES['upload']['tmp_name'];//$_POST["upload"];
        if ($movement_id > 0) {
            $insert =$this->prepare_query($_POST["category"], $movement_id, $file);
            if($insert)
            {
                $result['msg'] = 'OK';
            }
        } else {
            $result['msg'] = 'error';
        }
        //header('content-type:application/json');
        return $result;
        die();
    }
    public function prepare_query($category,$move_id,$file)
    {
        $product_array = array();
        //$phpexcel=Model::create("PHPExcel");
        include 'model/phpexcel/IOFactory.php';
        $objPHPExcel = PHPExcel_IOFactory::load($file);
        $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        $product_object = Model::create('Product');
        $arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet
        $insert=false;
        if ($category == 2) {
            for ($i = 2; $i <= $arrayCount; $i++) {
                $product_array = array(
                    "imei_product" => trim($allDataInSheet[$i]["A"]),
                    "label" => trim($allDataInSheet[$i]["B"]),
                    "model" => trim($allDataInSheet[$i]["D"]),
                    "state" => 'disabled',
                    "status" => 1,
                    "movement_id" => $move_id,
                    "user_id" => 1
                );
                if($product_object->save($product_array)>0)
                {
                    $insert=true;
                }
            }
        }
        else{
            for ($i = 2; $i <= $arrayCount; $i++) {
                $product_array = array(
                    "imei_product" => trim($allDataInSheet[$i]["A"]),
                    "label" => trim($allDataInSheet[$i]["B"]),
                    "model" => trim($allDataInSheet[$i]["D"]),
                    "state" => 'disabled',
                    "status" => 1,
                    "movement_id" => $move_id,
                    "user_id" => 1
                );
                if($product_object->save($product_array)>0)
                {
                    $insert=true;
                }
            }

        }
        return $insert;
    }
}