<?php
/**
 * Created by PhpStorm.
 * User: post2
 * Date: 02/01/2018
 * Time: 09:54
 */
use setasign\Fpdi\Fpdi;
include ("config/config.php");
require ("model/Model.php");
require_once('model/fpdf/fpdf.php');
require_once('model/fpdi2/src/autoload.php');
class InterventionController
{
    public function actionIndex($page=null)
    {
        /*
         * creation des models
         */
        $intervention= Model::create('Intervention');
        $installateur = Model::create('Personal');
        $client=Model::create('Costumer');
        $instalateurname=array();
        $clientname=array();
        if(isset($_POST['export'])) {
//        if (!empty($_POST)) {
            $error=" ";
            if (empty($_POST["instalateur"]) or empty($_POST["costumer"])) {
                if (empty($_POST["instalateur"]))
                $error = "veuillez choisir l'installateurr";
                if (empty($_POST["costumer"]))
                $error1 = "veuillez choisir le costumer";
            } else {

                ob_end_clean();
                $type = (isset($_POST["type"])) ? $_POST["type"] : ' ';
                $marque = (isset($_POST["marque"])) ? $_POST["marque"] : ' ';
                $matricule = (isset($_POST["matricule"])) ? $_POST["matricule"] : ' ';
                $kilometrage = (isset($_POST["kilometrage"])) ? $_POST["kilometrage"] : ' ';
                $intervened_at = (isset($_POST["instervened_at"])) ? $_POST["instervened_at"] : ' ';
                $instalateur = $_POST["instalateur"];
                $costumer = $_POST["costumer"];



                $data = array("type" => $type, "marque" => $marque, "matricule" => $matricule, "kilometrage" => $kilometrage, "id_costumer"=>$costumer,"id_instalateur" => $instalateur, "intervened_at" => $intervened_at);
                $inter = $intervention->save($data);
                $instalateurname = $installateur->find(array("fields" => "CONCAT( first_name,' ', last_name) AS personnal_name", "conditions" => "id=$instalateur"));
                $clientname = $client->find(array("fields" => "name", "conditions" => "id=$costumer"));


                $pdf = new Fpdi();


                $pdf->SetFont('Helvetica', 'B', 10);
                $pdf->SetTextColor(7, 20, 80);
                $pdf->SetXY(165, 25);
                $today = date("Ymd");
                $pdf->Write(0, "FI".$today."_".$instalateur."_".$inter);// la tu écrit ton texte depuis sql
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetXY(60, 88);
                $pdf->Write(0, $instalateurname[0]['personnal_name']);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetXY(117, 45);
                $pdf->Write(0, $clientname[0]['name']);
                $pdf->Output('intervention'.$instalateurname[0]['personnal_name'].$inter.'.pdf', 'D');// t'ouvre un pop-up te demandant d'enregistrer ou d'ouvrir le pdf

//                if ($inter > 0) {
//                    $result = array("msg" => "OK");
//                } else {
//                    $result = array("msg" => "ERROR");
//                }
                }
            }


        $limit=20;
        if(isset($_POST["pagination"]) and !empty($_POST["pagination"]) and is_numeric($_POST["pagination"])) {
            $limit = $_POST["pagination"];
        }
        $start_from=0;
        $p=1;
        if ($page != null && is_numeric($page)) { $p  = $page; }
        $start_from = ($p-1) * $limit;

        $interventions=array();
        $condition="";
        if(!empty($_POST["marque"]))
        {
            $condition= "iv.marque like '%".$_POST["marque"]. "%'";

        }
        if(!empty($_POST["type"]))
        {
            if($condition=='')
            {
                $condition= "iv.type='".$_POST["type"]."'";
            }else{
                $condition .= " AND iv.type='".$_POST["type"]."'";
            }
        }
        if(!empty($_POST["instalateur"]))
        {
            if($condition=='')
            {
                $condition= "iv.id_instalateur='".$_POST["instalateur"]."'";
            }else{
                $condition .= " AND iv.id_instalateur='".$_POST["instalateur"]."'";
            }
        }
        if(!empty($_POST["matricule"]))
        {
            if($condition=='')
            {
                $condition= "iv.matricule like '%".$_POST["matricule"]. "%'";
            }else{
                $condition .= " AND iv.matricule like '%".$_POST["matricule"]. "%'";
            }
        }
        if($condition!=''){
            $interventions=$intervention->findFromRelation( "interevention iv,personals p"," iv.id_instalateur=p.id and ".$condition ,array("fields"=>"iv.*,CONCAT( p.first_name,' ', p.last_name) AS personnal_name","limit"=>$start_from.','.$limit));

        }else{
            $interventions=$intervention->findFromRelation( "interevention iv,personals p"," iv.id_instalateur=p.id " ,array("fields"=>"iv.*,CONCAT( p.first_name,' ', p.last_name) AS personnal_name","limit"=>$start_from.','.$limit,"orderBy"=>"iv.id desc"));

        }
        $total_records = count($interventions);
        $total_pages = ceil($total_records / $limit);

        $costumers=array();
//        $costumer = Model::create('Costumer');
        $costumers=$client->find("Costumers",array("fields"=>"*"));

        $installateurs = array();

        $installateurs = $installateur->find();

        require 'view/interventions/index.php';
    }
    public function actionEdit($id){

        $interventions=array();
        $intervenion_id=$id;
        $intervention= Model::create('Intervention');
        $interventions=$intervention->findFromRelation( "interevention iv,personals p"," iv.id_instalateur=p.id and iv.id=$intervenion_id " ,array("fields"=>"iv.*,CONCAT( p.first_name,' ', p.last_name) AS personnal_name"));
        require 'view/interventions/update.php';

    }
    public function actionUpdate1($id){
        echo $id;

        require 'view/interventions/update.php';

    }
    public function actionUpdate($id)
    {

        $result = array();

        /*
         * bind data from post
         */
        $type = (isset($_POST["type"])) ? $_POST["type"] : ' ';
        $marque = (isset($_POST["marque"])) ? $_POST["marque"] : ' ';
        $matricule = (isset($_POST["matricule"])) ? $_POST["matricule"] : ' ';
        $kilometrage = (isset($_POST["kilometrage"])) ? $_POST["kilometrage"] : ' ';
        $intervened_at = (isset($_POST["instervened_at"])) ? $_POST["instervened_at"] : ' ';
        $instalateur =(isset($_POST["instalateur"])) ? $_POST["instalateur"] : ' ';

        /*
         * instance costumer
         */
        $intervention= Model::create('Intervention');
        if(isset($_POST["id_intervention"])) {
            $id = $_POST["id_intervention"];
            $data = array("id"=> $id,"type" => $type, "marque" => $marque, "matricule" => $matricule, "id_instalateur" => $instalateur ,"kilometrage" => $kilometrage , "intervened_at" => $intervened_at);

            if ($intervention->save($data)) {
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
?>