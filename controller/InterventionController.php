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
        if(!empty($_POST["costumer"]))
        {
            $condition= "iv.id_costumer='".$_POST["costumer"]."'";

        }
        if(!empty($_POST["numero"]))
        {
            if($condition=='')
            {
                $condition= "iv.id like '".$_POST["numero"]."'";
            }else{
                $condition .= " AND iv.id like '".$_POST["numero"]."'";
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

        if($_SESSION['fonction']=='installateur')
        {
            if($condition=='')
            {
                $condition= "p.user_id=".$_SESSION["user_id"];
            }else{
                $condition .= " AND p.user_id=".$_SESSION["user_id"];
            }
        }
        if(!empty($_POST["instervened_at"]))
        {
            if($condition=='')
            {
                $condition= "iv.intervened_at like '".$_POST["instervened_at"]. "'";
            }else{
                $condition .= " AND iv.intervened_at like '".$_POST["instervened_at"]. "'";
            }
        }
        if(!empty($_POST["status"]))
        {
            if($condition=='')
            {
                $condition= "iv.status ='".$_POST["status"]."'";
            }else{
                $condition .= " AND iv.status ='".$_POST["status"]."'";
            }
        }
        if(!empty($_POST["validation"]))
        {
            if($condition=='')
            {
                $condition= "iv.validation ='".$_POST["validation"]."'";
            }else{
                $condition .= " AND iv.validation ='".$_POST["validation"]."'";
            }
        }
        if($condition!=''){
            $interventions=$intervention->findFromRelation( "interevention iv left join personals p on iv.id_instalateur=p.id left join costumers c on c.id=iv.id_costumer "," c.id=iv.id_costumer and ".$condition ,array("fields"=>"iv.*,c.name,CONCAT( p.first_name,' ', p.last_name) AS personnal_name","limit"=>$start_from.','.$limit));

        }else{
            $interventions=$intervention->findFromRelation( "interevention iv left join personals p on iv.id_instalateur=p.id left join costumers c on c.id=iv.id_costumer"," iv.id_instalateur=p.id" ,array("fields"=>"iv.*,c.name,CONCAT( p.first_name,' ', p.last_name) AS personnal_name","limit"=>$start_from.','.$limit,"orderBy"=>"iv.id desc"));

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


        $interventions=$intervention->findFromRelation( "interevention iv left join personals p on iv.id_instalateur=p.id left join costumers c on c.id=iv.id_costumer","iv.id=$intervenion_id " ,array("fields"=>"iv.*,CONCAT( p.first_name,' ', p.last_name) AS personnal_name,c.name as costumer"));
        $details_intervention= Model::create('DetailsIntervention');

        $interventions_details=$details_intervention->findFromRelation("details_intervention di","di.id_intervention=".$intervenion_id,array("fields"=>"di.*"));

        $detail = Model::create('InventoryPersonal');
        $details_boxs = $detail->findFromRelation("inventory_personals i,products c,movements m","i.personal_id=".$interventions[0]['id_instalateur']." and i.product_id=c.id and c.movement_id=m.id and m.category_id=1 and i.status='1'",array("fields"=>"c.*"));
        $details_sims = $detail->findFromRelation("inventory_personals i,products c,movements m","i.personal_id=".$interventions[0]['id_instalateur']." and i.product_id=c.id and c.movement_id=m.id and m.category_id=2 and i.status='1'",array("fields"=>"c.*"));
        $vehicle = Model::create('Vehicle');
        $vehicles = $vehicle->findFromRelation("vehicles v", "v.costumer_id=".$interventions[0]['id_costumer'], array("fields" => "distinct v.*"));


        require 'view/interventions/update.php';

    }
    public function actionUpdate_intervention(){


            $intervened_start = (isset($_POST["starthour"])) ? $_POST["starthour"] : '';
            $intervened_end = (isset($_POST["endhour"])) ? $_POST["endhour"] : '';
            $duree = (isset($_POST["duree"])) ? trim($_POST["duree"]) : '';
            $id=$_POST["id"];
            $intervention= Model::create('Intervention');
            $target_dir = "uploads/";
            $target_file = $target_dir .'intervention'.$id ;
            $target_file2 = 'intervention'.$id ;
            $target_file1 = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $ext = strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));
            $uploadOk = 1;

        if (isset($_FILES['fileToUpload'])) {
// Check if file already exists
            if (file_exists($target_file)) {
                echo "file Déja exist.";
                $uploadOk = 0;
            }
// Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                echo "Votre fichier est trés gros.";
                $uploadOk = 0;
            }
// Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Votre fichier n'est pas uploader.";
// if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file.".".$ext)) {
                    $data = array("id"=>$id,"starthour"=>$intervened_start,"endhour" => $intervened_end,"upload"=>$target_file2.".".$ext,'status'=>'Terminée');

                } else {
                    echo "il y'a v'est un probléme au moment de l'upload.";
                    $result = array("msg" => "ERRORR");
                    echo json_encode($result);
                }
            }

            }
        else {
            $data = array("id"=>$id,"starthour"=>$intervened_start,"endhour" => $intervened_end,'status'=>'En cours');

        }

        if ($intervention->save($data)) {
            $result = array("msg" => "OK");

        } else {
            $result = array("msg" => "ERRORR");
        }


    }

    public function actionUpdate()
    {
        $result = array();

        /*
         * bind data from post
         */

        $intervened_at = (isset($_POST["intervened_at"])) ? $_POST["intervened_at"] : '';
        $type = (isset($_POST["type"])) ? trim($_POST["type"]) : '';
        $remarque = (isset($_POST["remarque"])) ? $_POST["remarque"] : '';
        $matricule = (isset($_POST["matricule"])) ? $_POST["matricule"] : '';
        $kilometrage = (isset($_POST["kilometrage"])) ?intval($_POST["kilometrage"])  : '';
        $intervened_at = (isset($_POST["instervened_at"])) ? $_POST["instervened_at"] : '';
        $imei_boitier = (isset($_POST["imei_boitier"])) ? intval($_POST["imei_boitier"]) : '';
        $imei_carte = (isset($_POST["imei_carte"])) ? intval($_POST["imei_carte"]) : '';
        $vehicule =(isset($_POST["vehicule"])) ? intval($_POST["vehicule"]) : '';
        $id= intval($_POST["id_intervention"]);
        $id_intervention_fk=$_POST["id_intervention_fk"];
        /*
         * instance costumer
         */
        $detail_intervention= Model::create('DetailsIntervention');
           if($id>0){
               $data = array("type" => $type,"id"=>$id ,"imei_boitier"=> $imei_boitier,"imei_carte"=>$imei_carte,"kilometrage" => $kilometrage,"id_vehicule"=>$vehicule,"remarque"=>$remarque);

           }
           else{
               $data = array("id_intervention"=>$id_intervention_fk,"type" => $type ,"imei_boitier"=> $imei_boitier,"imei_carte"=>$imei_carte,"kilometrage" => $kilometrage,"id_vehicule"=>$vehicule,"remarque"=>$remarque);

           }
            if ($detail_intervention->save($data)) {
                $result = array("msg" => "OK");

//                if($type=='i' and $imei_boitier !='' and $imei_carte !='')
//                {
//
//                }

            } else {
                $result = array("msg" => "ERRORR1");
            }



        echo json_encode($result);
        die();

    }
    public function actionExporter()
    {
        $result = array();
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
        $data = array("validation_resp"=>'0',"id_instalateur" => $instalateur,"id_costumer"=>$costumer, "status"=>'En cours',"intervened_at" => $intervened_at);
        $inter = $intervention->save($data);
        /*
         * get list of product personnal
         */
        $details_boxs = $detail->findFromRelation("inventory_personals i,products c,movements m","i.personal_id=".$instalateur." and i.product_id=c.id and c.movement_id=m.id and m.category_id=1 and i.status='1'",array("fields"=>"c.*","limit"=>$nombre));
        $details_sims = $detail->findFromRelation("inventory_personals i,products c,movements m","i.personal_id=".$instalateur." and i.product_id=c.id and c.movement_id=m.id and m.category_id=2 and i.status='1'",array("fields"=>"c.*","limit"=>$nombre));
       /*
        * save detail intervenetion
        */
       if(count($details_boxs)>= $nombre and count($details_sims)>=$nombre) {
           for ($k = 0; $k < $nombre; $k++) {
               $data1 = array("id_intervention" => $inter, "imei_boitier" => $details_boxs[$k]["id"], "imei_carte" => $details_sims[$k]["id"]);
               $details_intervention->save($data1);
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
           $today = date("ymd");
           $pdf->Write(0, "FI" . $today . "-" . $instalateur . "-" . $inter);// la tu écrit ton texte depuis sql
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
           $yb = 120;
           for ($i = 0; $i < count($details_boxs); $i++) {
               $yb = $yb + 10 + 0.5;
               $pdf->SetTextColor(0, 0, 0);
               $pdf->SetFontSize(8);
               $pdf->SetXY(115, $yb);
               $pdf->Write(0, $details_boxs[$i]['imei_product']);
           }
           $yc = 120;
           for ($j = 0; $j < count($details_sims); $j++) {
               $yc = $yc + 10 + 0.5;
               $pdf->SetTextColor(0, 0, 0);
               $pdf->SetFontSize(8);
               $pdf->SetXY(160, $yc);
               $pdf->Write(0, $details_sims[$j]['label']);
           }

           $pdf->Output('intervention' . strtolower($instalateurname[0]['personnal_name']) . $inter . '.pdf', 'D');// t'ouvre un pop-up te demandant d'enregistrer ou d'ouvrir le pdf
//           $result = array("content"=>'intervention'.$instalateurname[0]['personnal_name'].$inter.'.pdf',"msg" =>"OK" );
//           echo json_encode($result);
       }
       else{
           $result = array("msg" => "Le nombre saisi est supérieur aux stock personnel de l\'installateur selectionné");
           echo json_encode($result);
       }
    }
  public function actionDelete()
  {
      $result = array();
      $id=$_POST['id'];
      $details_intervention= Model::create('DetailsIntervention');
      if($details_intervention->delete($id)){
          $result = array("msg"=>"OK");
      }
      else{
          $result = array("msg"=>"ERROR");
      }

      echo json_encode($result);
  }

    public function actionValidationresponsable()
    {
        $result = array();
        $intervention_id=$_POST['id'];
        $user=Model::create('Intervention');
        $data=array("id"=>$intervention_id,"validation_resp"=>'1');
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
?>