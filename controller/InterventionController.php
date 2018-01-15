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

                $detail= Model::create('InventoryPersonal');
                $details_boxs = $detail->findFromRelation("inventory_personals i,products c,movements m","i.personal_id=".$instalateur." and i.product_id=c.id and c.movement_id=m.id and m.category_id=1 and i.status='1'",array("fields"=>"c.*"));
                $details_sims = $detail->findFromRelation("inventory_personals i,products c,movements m","i.personal_id=".$instalateur." and i.product_id=c.id and c.movement_id=m.id and m.category_id=2 and i.status='1'",array("fields"=>"c.*"));

                $details_intervention= Model::create('DetailsIntervention');
                if (count($details_sims)>=count($details_boxs)) {
                    for ($i = 0; $i < count($details_sims); $i++)
                    {

                        $data1 = array("imei_boitier" =>$details_boxs[$i]["imei_product"], "imei_carte" => $details_sims[$i]["label"] );
                        $details_intervention->save($data1);
                    }

                }
                else{
                    for ($i = 0; $i < count($details_boxs); $i++)
                    {

                        $data1 = array("imei_boitier" => $details_boxs[$i]["imei_product"] ,"imei_carte" => $details_sims[$i]["label"]);
                        $details_intervention->save($data1);
                    }

                }

                $instalateurname = $installateur->find(array("fields" => "CONCAT( first_name,' ', last_name) AS personnal_name", "conditions" => "id=$instalateur"));
                $clientname = $client->find(array("fields" => "*", "conditions" => "id=$costumer"));

                $pdf = new Fpdi();
                $pdf->setSourceFile('dist/img/fichedintervention.pdf');
                $tt=$pdf->importPage(1);
                // set the sourcefile
                $pdf->setSourceFile('dist/img/fichedintervention.pdf');
                // import page 1
                $tplIdx = $pdf->importPage(1);

                $pdf->AddPage();
                    // use the imported page and place it at point 10,10 with a width of 100 mm
                $pdf->useTemplate($tplIdx, 10, 10, 200);

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

                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetXY(117, 58);
                $pdf->Write(0, $clientname[0]['phone_number']);

                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetXY(117, 63);
                $pdf->Write(0, $clientname[0]['mail']);

                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetXY(117, 53);
                $pdf->Write(0, $clientname[0]['adress']);
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
            $interventions=$intervention->findFromRelation( "interevention iv,personals p"," iv.id_instalateur=p.id and iv.id_costumer=c.id and ".$condition ,array("fields"=>"iv.*,c.name,CONCAT( p.first_name,' ', p.last_name) AS personnal_name","limit"=>$start_from.','.$limit));

        }else{
            $interventions=$intervention->findFromRelation( "interevention iv,personals p, costumers c"," iv.id_instalateur=p.id and iv.id_costumer=c.id " ,array("fields"=>"iv.*,c.name,CONCAT( p.first_name,' ', p.last_name) AS personnal_name","limit"=>$start_from.','.$limit,"orderBy"=>"iv.id desc"));

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
        $details_boxs = array();
        $details_sims=array();
        $vehicles = array();

        $intervenion_id=$id;
        $intervention= Model::create('Intervention');

        $interventions=$intervention->findFromRelation( "interevention iv,personals p"," iv.id_instalateur=p.id and iv.id=$intervenion_id " ,array("fields"=>"iv.*,CONCAT( p.first_name,' ', p.last_name) AS personnal_name"));
        $details_intervention= Model::create('DetailsIntervention');

        $interventions_details=$details_intervention->findFromRelation("details_intervention di","di.id_intervention=".$intervenion_id,array("fields"=>"di.*"));
        $detail = Model::create('InventoryPersonal');
        $details_boxs = $detail->findFromRelation("inventory_personals i,products c,movements m","i.personal_id=".$interventions[0]['id_instalateur']." and i.product_id=c.id and c.movement_id=m.id and m.category_id=1 and i.status='1'",array("fields"=>"c.*"));
        $details_sims = $detail->findFromRelation("inventory_personals i,products c,movements m","i.personal_id=".$interventions[0]['id_instalateur']." and i.product_id=c.id and c.movement_id=m.id and m.category_id=2 and i.status='1'",array("fields"=>"c.*"));
        $vehicle = Model::create('Vehicle');
        $vehicles = $vehicle->findFromRelation("vehicles v", "v.costumer_id=".$interventions[0]['id_costumer'], array("fields" => "distinct v.*"));

        require 'view/interventions/update.php';

    }
    public function actionUpdate1($id){
        echo $id;

        require 'view/interventions/update.php';

    }
    public function actionUpdate()
    {
        $result = array();

        /*
         * bind data from post
         */

        $intervened_at = (isset($_POST["intervened_at"])) ? $_POST["intervened_at"] : '';
        $type = (isset($_POST["type"])) ? trim($_POST["type"]) : '';
        $marque = (isset($_POST["marque"])) ? $_POST["marque"] : '';
        $matricule = (isset($_POST["matricule"])) ? $_POST["matricule"] : '';
        $kilometrage = (isset($_POST["kilometrage"])) ?intval($_POST["kilometrage"])  : '';
        $intervened_at = (isset($_POST["instervened_at"])) ? $_POST["instervened_at"] : '';
        $imei_boitier = (isset($_POST["imei_boitier"])) ? intval($_POST["imei_boitier"]) : '';
        $imei_carte = (isset($_POST["imei_carte"])) ? intval($_POST["imei_carte"]) : '';
        $vehicule =(isset($_POST["vehicule"])) ? intval($_POST["vehicule"]) : '';
        $id= intval($_POST["id_intervention"]);
        /*
         * instance costumer
         */
        $intervention= Model::create('DetailsIntervention');

            $data = array("type" => $type,"id_intervention"=>$id ,"imei_boitier"=> $imei_boitier,"imei_carte"=>$imei_carte,"kilometrage" => $kilometrage,"id_vehicule"=>$vehicule);

            if ($intervention->save($data)) {
                $result = array("msg" => "OK");

            } else {
                $result = array("msg" => "ERRORR1".$id.$type);
            }



        echo json_encode($result);
        die();

    }
    public function actionExporter()
    {
        /*
         * instanciation
         */
        $intervention= Model::create('Intervention');
        $installateur = Model::create('Personal');
        $client=Model::create('Costumer');
        $detail= Model::create('InventoryPersonal');
        $details_intervention= Model::create('DetailsIntervention');
        /*
         * data binding
         */
        $instalateur = $_POST["instalateur"];
        $costumer = $_POST["costumer"];
        $nombre = $_POST["personalproduct"];
        $intervened_at=$_POST["instervened_at"];
        /*
         * seave intervention
         */
        $data = array("id_costumer"=>$costumer,"id_instalateur" => $instalateur, "status"=>'incompleted',"intervened_at" => $intervened_at);
        $inter = $intervention->save($data);
        /*
         * get list of product personnal
         */
        $details_boxs = $detail->findFromRelation("inventory_personals i,products c,movements m","i.personal_id=".$instalateur." and i.product_id=c.id and c.movement_id=m.id and m.category_id=1 and i.status='1'",array("fields"=>"c.*","limit"=>$nombre));
        $details_sims = $detail->findFromRelation("inventory_personals i,products c,movements m","i.personal_id=".$instalateur." and i.product_id=c.id and c.movement_id=m.id and m.category_id=2 and i.status='1'",array("fields"=>"c.*","limit"=>$nombre));
       /*
        * save detail intervenetion
        */
       if(count($details_boxs)>= $nombre and count($details_sims)>=$nombre){
           for($k=0;$k<$nombre;$k++)
           {
               $data1 = array("id_intervention"=>$inter, "imei_boitier"=> $details_boxs[$k]["id"],"imei_carte"=>$details_sims[$k]["id"]);
               $details_intervention->save($data1);
           }
       }

        $instalateurname = $installateur->find(array("fields" => "CONCAT( first_name,' ', last_name) AS personnal_name", "conditions" => "id=$instalateur"));
        $clientname = $client->find(array("fields" => "*", "conditions" => "id=$costumer"));

        $pdf = new Fpdi();
          // set the sourcefile
        $pdf->setSourceFile('dist/img/fichedintervention.pdf');
        // import page 1
        $tplIdx = $pdf->importPage(1);

        $pdf->AddPage();
        // use the imported page and place it at point 10,10 with a width of 100 mm
        $pdf->useTemplate($tplIdx, 10, 10, 200);

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

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(117, 58);
        $pdf->Write(0, $clientname[0]['phone_number']);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(117, 63);
        $pdf->Write(0, $clientname[0]['mail']);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(117, 53);
        $pdf->Write(0, $clientname[0]['adress']);
        $yb=120;
        for ($i=0;$i<count($details_boxs);$i++)
        {
            $yb=$yb+10+0.5;
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFontSize(8);
            $pdf->SetXY(115, $yb);
            $pdf->Write(0, $details_boxs[$i]['imei_product']);
        }
        $yc=120;
        for ($j=0;$j<count($details_sims);$j++)
        {
            $yc=$yc+10+0.5;
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFontSize(8);
            $pdf->SetXY(160,$yc);
            $pdf->Write(0, $details_sims[$j]['label']);
        }
        $pdf->Output('intervention'.$instalateurname[0]['personnal_name'].$inter.'.pdf', 'D');// t'ouvre un pop-up te demandant d'enregistrer ou d'ouvrir le pdf

    }

}
?>