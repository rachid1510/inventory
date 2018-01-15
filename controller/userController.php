<?php
require ("model/Model.php");
include ("config/config.php");
class userController
{
    //

    public function actionIndex($page=null)
    {


        $users = array();
        $user = Model::create('User');
        /*
         * pagination
         */
//        $limit = 20;
//
//        if (isset($_POST["pagination"]) and !empty($_POST["pagination"]) and is_numeric($_POST["pagination"])) {
//            $limit = $_POST["pagination"];
//        }
//
//        $start_from = 0;
//        $p = 1;
//        if ($page != null and is_numeric($page)) {
//            $p = $page;
//        }
//        $start_from = ($p - 1) * $limit;

//        $condition = "";
//
//        if (!empty($_POST["costumer_name"])) {
//            $condition = "c.name like '%" . $_POST["costumer_name"] . "%'";
//        }
//        if (!empty($_POST["costumer_tel"])) {
//            if ($condition == '') {
//                $condition = "c.phone_number like '%" . $_POST["costumer_tel"] . "%'";
//            } else {
//                $condition .= " AND c.phone_number like '%" . $_POST["costumer_tel"] . "%'";
//            }
//        }

        $users = $user->find();

//        if($condition !='')
//        {
//            $customers=$customer->findFromRelation( "costumers c",$condition ,array("fields"=>"c.*","limit"=>$start_from.','.$limit));
//
//        }
//        else {
//
//            $customers = $customer->find();
//        }

//      if(isset($_POST['export'])) {
//          $labels = ['id', 'Nom', 'Type', 'Mail','Ville', 'dèpartement', 'adresse'];
//            $header = ['id', 'name', 'type', 'mail','city', 'departement', 'adress'];
//            $customer->export_excel($customers, $header, $labels,'La liste des clients');
//        }
         require 'view/user/index.php';

    }
    public function actionAdd()
    {
        $result = array();

        /*
         * bind data from post
         */
        $name=(isset($_POST["user_name"]))? trim($_POST["user_name"]) : '';
        $mail=(isset($_POST["user_mail"])) ? trim($_POST["user_mail"]) :'' ;
        $role=(isset($_POST["user_role"])) ? $_POST["user_role"] :'' ;
        $password=(isset($_POST["user_passe"]))? $_POST["user_passe"] :'';

        /*
         * instance costumer
         */
        $user=Model::create('User');
        $personal=Model::create('Personal');
        $data=array("name"=>$name,"email"=>$mail,"fonction"=>$role,"password"=>$password,'disabled'=>'0');
       $user_id=$user->save($data);


        if($user_id>0)
        {
//            if($role=='installateur')
//            {
//
//            }
            $result = array("msg"=>"OK");

        }
        else{
            $result = array("msg"=>"ERRORR");
        }
        echo json_encode($result);
        die();

    }

    /*/*
      * function edit
      */
    public function actionEdit(){

        $users=array();
        $user_id=$_POST['id'];
        $user = Model::create('User');
        $users=$user->findFromRelation( "users u","u.id=$user_id" ,array("fields"=>"u.*"));
        echo json_encode($users);

    }

    public function actionUpdate()
    {
        $result = array();

        /*
         * bind data from post
         */
        $name=(isset($_POST["user_name"]))? trim($_POST["user_name"]) : '';
        $mail=(isset($_POST["user_mail"])) ? trim($_POST["user_mail"]) :'' ;
        $role=(isset($_POST["user_role"])) ? $_POST["user_role"] :'' ;
        $password=(isset($_POST["user_passe"]))? $_POST["user_passe"] :'';
        $user_id=(isset($_POST["id_user"]))? $_POST["id_user"] :'';
        $user=Model::create('User');
        if(!empty($password)){
            $data=array("id"=>$user_id,"name"=>$name,"email"=>$mail,"fonction"=>$role,"password"=>$password);
        }
        else{
            $data=array("id"=>$user_id,"name"=>$name,"email"=>$mail,"fonction"=>$role);
        }
        if($user->save($data)>0)
        {
            $result=array("msg"=>"OK");
        }
        else{
            $result=array("msg"=>"error");
        }
        echo json_encode($result);


    }

    public function actionDisabled()
    {
        $result = array();
        $user_id=$_POST['id'];
        $user=Model::create('User');
        $data=array("id"=>$user_id,"disabled"=>1);
        if($user->save($data))
        {
            $result=array("msg"=>"OK");
        }
        else{
            $result=array("msg"=>"error");
        }
        echo json_encode($result);


    }

    public function actionEnabled()
    {
        $result = array();
        $user_id=$_POST['id'];
        $user=Model::create('User');
        $data=array("id"=>$user_id,"disabled"=>'0');
        if($user->save($data))
        {
            $result=array("msg"=>"OK");
        }
        else{
            $result=array("msg"=>"error");
        }
        echo json_encode($result);


    }
}
