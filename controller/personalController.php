<?php
require ("model/Model.php");
include ("config/config.php");
class personalController
{
    //

    public function actionIndex()
    {

        $installateurs = array();
        $installateur = Model::create('Personal');
        $installateurs = $installateur->find(array("fields"=>"*","orderBy"=>"id"));
        require 'view/personals/index.php';


    }
    public function actionDetails($id=null)
    {

        $details = array();
        $detail = Model::create('InventoryPersonal');
        $details=$detail->findFromRelation("inventory_personals i,personals p,products c","i.personal_id=$id and i.product_id=c.id ",array("fields"=>"i.status as inv_p_status,i.created_at as date_reception,c.*,CONCAT(p.first_name, ' ',p.last_name) AS personal_name"));
        //echo $details[0]['personal_name'];
        require 'view/personals/details.php';



    }
    public function actionGetBox(){
        $box = array();
        $personal=$_POST['id'];
        //echo $personal;
        $InventoryPersonal = Model::create('InventoryPersonal');
        if($personal==0){
            $box=$InventoryPersonal->findFromRelation("inventory_personals i,products p,movements m","i.product_id=p.id and m.id=p.movement_id and m.category_id=1 and i.status='1'",array("fields"=>"p.*"));


        }else{
            $box=$InventoryPersonal->findFromRelation("inventory_personals i,products p,movements m","i.personal_id=$personal and i.product_id=p.id and m.id=p.movement_id and m.category_id=1 and i.status='1'",array("fields"=>"p.*"));

        }
        echo json_encode($box);
       }
    public function actionGetSim(){
        $sims = array();
        $personal=$_POST['id'];
        $InventoryPersonal = Model::create('InventoryPersonal');
        if($personal==0) {
            $sims = $InventoryPersonal->findFromRelation("inventory_personals i,products p,movements m","i.product_id=p.id and m.id=p.movement_id and m.category_id=1 and i.status='1'",  array("fields" => "p.*"));

        }else{
              $sims = $InventoryPersonal->findFromRelation("inventory_personals i,products p,movements m", "i.personal_id=$personal and i.product_id=p.id and m.id=p.movement_id and m.category_id=2 and i.status='1'", array("fields" => "p.*"));

        }
        echo json_encode($sims);

    }
     
}
