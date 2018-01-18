<?php
/**
 * Created by PhpStorm.
 * User: post2
 * Date: 18/01/2018
 * Time: 12:26
 */
$product_array = array();
//$objPHPExcel=Model::create("PHPExcel");
require 'model/phpexcel/IOFactory.php';
$objPHPExcel = PHPExcel_IOFactory::load($file);
$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
$product_object = Model::create('Product');
$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet
$insert=true;
if ($category == 2) {
    for ($i = 2; $i <= $arrayCount; $i++) {
        $product_array= array(
            "imei_product" => trim($allDataInSheet[$i]["A"]),
            "label" => trim($allDataInSheet[$i]["B"]),
            "model" => trim($allDataInSheet[$i]["D"]),
            "state" => 'disabled',
            "status" => '1',
            "movement_id" => $move_id,
            "user_id" => $_SESSION['user_id'],
        );
        if(!$this->check_exist_product($allDataInSheet[$i]["A"],$product_object)) {
            if ($product_object->save($product_array) == 0) {
                $insert = false;
            }
        }
        else{
            $insert = false;
        }

    }

}
else {
    for ($i = 2; $i <= $arrayCount; $i++) {
        $product_array = array(
            "imei_product" => trim($allDataInSheet[$i]["A"]),
            "label" => trim($allDataInSheet[$i]["B"]),
            "model" => trim($allDataInSheet[$i]["B"]),
            "state" => 'enabled',
            "status" => '1',
            "movement_id" => $move_id,
            "user_id" => $_SESSION['user_id'],
        );
        if (!$this->check_exist_product($allDataInSheet[$i]["A"], $product_object)) {
            if ($product_object->save($product_array) == 0) {
                $insert = false;
            }
        } else {
            $insert = false;
        }
    }
}
