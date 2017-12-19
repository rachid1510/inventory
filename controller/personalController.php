<?php

require ("model/Model.php");

class personalController
{
    //

    public function actionIndex()
    {
        $installateurs = array();
        $installateur = Model::create('Personal');
        $installateurs = $installateur->find();

        require 'view/personals/index.php';

    }
    public function actionDetails($id=null)
    {

        $details = array();
        $detail = Model::create('InventoryPersonal');
        $details=$detail->findFromRelation("inventory_personals i,personals p,products c","i.personal_id='".$id."' and i.product_id=c.id ",array("fields"=>"i.*,CONCAT(p.first_name, ' ',p.last_name) AS personal_name"));
        echo $details[0]['personal_name'];
        require 'view/personals/details.php';



    }

     
}
