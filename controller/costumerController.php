<?php

require ("model/Model.php");
class costumerController
{
    //

    public function actionIndex($page=null)
    {
        session_start();

        if (!isset($_SESSION["login"])) {

            header("Location:login.php?error=e");

        }
        $customers = array();
        $customers = Model::create('Costumer');
        /*
         * var condition string
         */
        /*
         * pagination
         */
        $limit = 20;

        if (isset($_POST["pagination"]) and !empty($_POST["pagination"]) and is_numeric($_POST["pagination"])) {
            $limit = $_POST["pagination"];
        }

        $start_from = 0;
        $p = 1;
        if ($page != null and is_numeric($page)) {
            $p = $page;
        }
        $start_from = ($p - 1) * $limit;

        $condition = "";

        if (!empty($_POST["costumer_name"])) {
            $condition = "c.name like '%" . $_POST["costumer_name"] . "%'";
        }
        if (!empty($_POST["costumer_tel"])) {
            if ($condition == '') {
                $condition = "c.phone_number like '%" . $_POST["costumer_tel"] . "%'";
            } else {
                $condition .= " AND c.phone_number like '%" . $_POST["costumer_tel"] . "%'";
            }
        }


        if ($condition != '') {
            $customers = $customers->findFromRelation("costumers c", $condition, array("fields" => "c.*", "limit" => $start_from . ',' . $limit));
            if (isset($_POST["export"])) {

            }
        } else {
            $customers = $customers->find();

        }


        if (isset($_POST["export"])) {
//            require_once '../Classes/PHPExcel.php';



//            include 'model/phpexcel/PHPExcel/RichText.php';
            error_reporting(E_ALL);
            /*include 'model/phpexcel/PHPExcel/Autoloader.php';
            include 'model/PHPExcel.php';
            include 'model/phpexcel/PHPExcel/RichText.php';*/
            $objPHPExcel = Model::create('PHPExcel');

// Set the active Excel worksheet to sheet 0
            $objPHPExcel->setActiveSheetIndex(0);
// Initialise the Excel row number
            $rowCount = 1;

//start of printing column names as names of MySQL fields
//            $column = 'A';
//            for ($i = 1; $i < count($customers[0]); $i++) {
//                echo count($customers);
//                $objPHPExcel->getActiveSheet()->setCellValue($column . $rowCount, $customers['0']);
//                $column++;
//            }
//end of adding column names

//start while loop to get data
            foreach($customers as $customer){
                // Set cell An to the "name" column from the database (assuming you have a column called name)
                //    where n is the Excel row number (ie cell A1 in the first row)
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $customer['name']);
                // Set cell Bn to the "age" column from the database (assuming you have a column called age)
                //    where n is the Excel row number (ie cell A1 in the first row)
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $customer['departement']);
                // Increment the Excel row counter
                $rowCount++;
            }




// Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Limesurvey_Results.xls"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');

        }
        require 'view/costumers/index.php';

    }
    public function actionExport()
    {
//        while($row = mysql_fetch_array($result)){
//            // Set cell An to the "name" column from the database (assuming you have a column called name)
//            //    where n is the Excel row number (ie cell A1 in the first row)
//            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['name']);
//            // Set cell Bn to the "age" column from the database (assuming you have a column called age)
//            //    where n is the Excel row number (ie cell A1 in the first row)
//            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['age']);
//            // Increment the Excel row counter
//            $rowCount++;
//        }
//
//// Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
//        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
//// Write the Excel file to filename some_excel_file.xlsx in the current directory
//        $objWriter->save('some_excel_file.xlsx');


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
  /*
   * get costumer product
   */
    public function actionGetProduct(){
        //require 'view/installations/update.php';
        $products=array();
        $costumerprod=Model::create('CostumerProduct');
        $installation_id=$_POST['id'];
        $products=$costumerprod->findFromRelation( "costumer_products c","c.installation_id=$installation_id" ,array("fields"=>"c.*"));
        echo json_encode($products);

    }

    /*/*
      * function edit
      */
    public function actionEdit(){

        $costumers=array();
        $costumer_id=$_POST['id'];
        $Costumer = Model::create('Costumer');
        $costumers=$Costumer->findFromRelation( "costumers c","c.id=$costumer_id" ,array("fields"=>"c.*"));
        echo json_encode($costumers);

    }

    public function actionUpdate()
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
        if(isset($_POST["id_costumer"])) {
            $id = $_POST["id_costumer"];
            $data = array("id"=> $id, "name" => $name, "phone_number" => $phone, "type" => $type, "city" => $city, "departement" => $departement, "adress" => $adress);

            if ($costumer->save($data)) {
                $result = array("msg" => "OK");

            } else {
                $result = array("msg" => "ERRORR");
            }
        }
        else{
            $result = array("msg" => "ERRORR");
        }

        echo json_encode($result);
        die();

    }
}
