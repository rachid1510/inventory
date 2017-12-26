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

        $categories=array();
        $category = Model::create('Category');
        $categories=$category->find("categories",array("fields"=>"*"));

        $movement = Model::create('Movement');
        $movements=$movement->find("movements",array("fields"=>"*"));

        session_start();

        if (isset($_SESSION["login"])) {
            require 'view/movements/index.php';
        }
        else
            header("Location:login.php?error=e");
    }
    /*
     * action add insert into table movements
     */
    public function actionAdd()
    {
        $result = array();
        //$movement=new Move;ment();
        $movement = Model::create('Movement');
        $data = array("plan" => $_POST["plan"],"quantity" => $_POST["quantite"],"order_ref" => $_POST["order_id"],"provider" => $_POST["provider"], "category_id" => $_POST["category"],'date_arrived'=>$_POST['date_arrived']);
        $movement_id = $movement->save($data);
        $file = $_FILES['upload']['tmp_name'];//$_POST["upload"];
        $insert=true;
        if ($movement_id > 0) {
            $insert =$this->prepare_query($_POST["category"], $movement_id, $file);

            if($insert)
            {
                $result = array('msg' => 'OK');
            }else{
                $result = array('msg' => 'Error:les produits n\'ont pas été ajoutés correctement');
            }

          } else {
            $result = array('msg' => 'error');

        }
        header('content-type:application/json');
        echo json_encode($result);

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
                    "user_id" => 3
                );

                if ($product_object->save($product_array) == 0) {
                    $insert = false;
                }
            }

        }
        else{
            for ($i = 2; $i <= $arrayCount; $i++) {
                $product_array= array(
                    "imei_product" => trim($allDataInSheet[$i]["C"]),
                    "label" => trim($allDataInSheet[$i]["B"]),
                    "model" => trim($allDataInSheet[$i]["Y"]),
                    "state" => 'disabled',
                    "status" => '1',
                    "movement_id" => $move_id,
                    "user_id" => 3
                );
                if ($product_object->save($product_array) == 0) {
                    $insert = false;
                }
            }


        }
        return $insert;
    }
    /*
     * function edit
     */
    public function actionEdit(){
        $movement = Model::create('Movement');
        $movements=$movement->findFromRelation("movements m , categories c","c.id=m.category_id and m.id=129",array("fields"=>"m.*,c.id as cat_id , c.label"));//  find("movements",array("fields"=>"*"));
        $moves=array("order_ref"=>$movements[0]["order_ref"],"plan"=>$movements[0]["plan"]);
        header('content-type:application/json');
        echo json_encode($moves);
        die();
    }
}