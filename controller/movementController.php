<?php
session_start();
require ("model/Model.php");
include ("config/config.php");
class movementController
{
    /*
    * action index display list off movements from database
    */
    public function actionIndex()
    {
        /*
        * check session
        */
        session_start();

        if (!isset($_SESSION["login"])) {
            header("Location:login.php?error=e");
        }
        $categories=array();
        $category = Model::create('Category');
        $categories=$category->find("categories",array("fields"=>"*"));

        $movement = Model::create('Movement');
        $movements=$movement->find("movements",array("fields"=>"*"));
        if(isset($_POST['export'])) {
            $header = ['id', 'provider', 'order_ref','date_arrived','plan','observtion','category_id','user_id','created_at','updated_at','quantity'];
            $movement->export_excel($movements, $header, 'liste des Movements');
        }
        require 'view/movements/index.php';

    }
   /*
    * function validation data
    */
    public function validation_data($category,$order_ref,$file)
    {

        $errors=array();
        if (empty($category)) {

            $errors[]="La catégorie ne peut pas etre vide<br>";
        }
        if (empty($order_ref)) {

            $errors[]="La reférence de la commande ne peut pas etre vide<br>";
        }
        if(empty($file))
        {
            $errors[]="Veuillez importer le fichier <br>";
        }
//        if (!$_FILES['your_var_name']['tmp_name'])
//        {
//            $errors[]="Veuillez importer le fichier <br>";
//        }

        return $errors;
    }
    /*
     * action add insert into table movements
     */
    public function actionAdd()
    {
        $result = array();
        //$movement=new Move;ment();
        $movement = Model::create('Movement');
        $file='';
        if (isset($_FILES['upload']))
        {
            $file=$_FILES['upload']['name'];
        }
        $result=$this->validation_data($_POST["category"],$_POST["order_id"],$file);
        if(count($result)==0) {
            $file = $_FILES['upload']['tmp_name'];//$_POST["upload"];
            $data = array("plan" => $_POST["plan"], "quantity" => $_POST["quantite"], "order_ref" => $_POST["order_id"], "provider" => $_POST["provider"], "category_id" => $_POST["category"], 'date_arrived' => $_POST['date_arrived'], 'user_id' => $_SESSION['user_id']);
            $movement_id = $movement->save($data);

            $insert = true;
            if ($movement_id > 0) {
                $insert = $this->prepare_query($_POST["category"], $movement_id, $file);

                if ($insert) {
                    $result = array('msg' => 'OK');
                } else {
                    $result = array('msg' => 'Error:les produits n\'ont pas été ajoutés correctement');
                }

            } else {
                $result = array('msg' => 'error');

            }
            header('content-type:application/json');
            echo json_encode($result);
        }
        else{
            echo json_encode(array("msg"=>$result));
        }
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
                    "user_id" => $_SESSION['user_id'],
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
                    "user_id" => $_SESSION['user_id'],
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
    /*
     *
     * export data
     */

    public function actionEdit(){
        if(isset($_POST["id"])){
            $movement_id=$_POST["id"];
            $movements=array();
            $movement = Model::create('Movement');
            $movements=$movement->findFromRelation("movements m","m.id=$movement_id",array("fields"=>"m.*"));//  find("movements",array("fields"=>"*"));

            echo json_encode($movements);
        }
    }


    /*
    * action add insert into table movements
    */
    public function actionUpdate()
    {
        $result = array();
        $movement = Model::create('Movement');
        $movement_id=$_POST['id_movement'];
        $data = array("id"=>$movement_id,"plan" => $_POST["plan"],"quantity" => $_POST["quantite"],"order_ref" => $_POST["order_id"],"provider" => $_POST["provider"], "category_id" => $_POST["category"],'date_arrived'=>$_POST['date_arrived'],'user_id'=>$_SESSION['user_id']);
         if($movement->save($data)){
             $result = array('msg' => 'OK');
         }
         else
         {
             $result = array('msg' => 'error');
         }
        $movement_id = $movement->save($data);

        echo json_encode($result);

    }
}