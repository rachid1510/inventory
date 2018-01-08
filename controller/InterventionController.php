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
        $instalateurname=array();
        if(isset($_POST['export'])) {
//        if (!empty($_POST)) {
            $error=" ";
            if (empty($_POST["instalateur"])) {
                $error = "veuillez choisir l'installateur";
            } else {

                ob_end_clean();
                $type = (isset($_POST["type"])) ? $_POST["type"] : ' ';
                $marque = (isset($_POST["marque"])) ? $_POST["marque"] : ' ';
                $matricule = (isset($_POST["matricule"])) ? $_POST["matricule"] : ' ';
                $kilometrage = (isset($_POST["kilometrage"])) ? $_POST["kilometrage"] : ' ';
                $intervened_at = (isset($_POST["instervened_at"])) ? $_POST["instervened_at"] : ' ';
                $instalateur = $_POST["instalateur"];


                $data = array("type" => $type, "marque" => $marque, "matricule" => $matricule, "kilometrage" => $kilometrage, "id_instalateur" => $instalateur, "intervened_at" => $intervened_at);
                $inter = $intervention->save($data);
                $instalateurname = $installateur->find(array("fields" => "CONCAT( first_name,' ', last_name) AS personnal_name", "conditions" => "id=$instalateur"));

                $pdf = new Fpdi();


                // set the sourcefile
                $pdf->setSourceFile('dist/img/fichedintervention.pdf');
                // import page 1
                $tplIdx = $pdf->importPage(1);
                for ($i=0;$i<5;$i++){
                    $pdf->AddPage();
                    // use the imported page and place it at point 10,10 with a width of 100 mm
                    $pdf->useTemplate($tplIdx, 10, 10, 200);

                    // now write some text above the imported page
                    $pdf->SetFont('Helvetica', '', 10);
                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->SetXY(160, 30);
                    $today = date("Ymd");
                    $pdf->Write(0, "FI" . $today . "_" . $instalateur . "_" . $inter);// la tu écrit ton texte depuis sql
                    $pdf->SetXY(60, 88);
                    $pdf->Write(0, $instalateurname[0]['personnal_name']);

                    $pdf->Output('intervention'.$i. $instalateurname[0]['personnal_name'] . $inter . '.pdf', 'D');// t'ouvre un pop-up te demandant d'enregistrer ou d'ouvrir le pdf

//                if ($inter > 0) {
//                    $result = array("msg" => "OK");
//                } else {
//                    $result = array("msg" => "ERROR");
//                }
                }
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

        $installateurs = array();

        $installateurs = $installateur->find();

        require 'view/interventions/index.php';
    }

}
?>