<?php
require ("model/Model.php");

class dashboardController
{
    public function  actionIndex(){

      require 'view/dashboard/index.php';

    }
    public function actionGetdata()
    {

       // echo json_encode(array("test"=>"gggg"));
        $instalations=array();
        $instalation= model::create('Installation');
        $instalations=$instalation->find(array("fields"=>"COUNT(*) nombre,MONTH(`installed_at`) mois","groupBy"=>"YEAR(`installed_at`),MONTH(`installed_at`)"));
        //$sql="SELECT COUNT(*) nombre,MONTH(`installed_at`) mois FROM `installations` GROUP BY YEAR(`installed_at`), MONTH(`installed_at`)";
        // header('content-type:application/json');
        echo json_encode($instalations);
    }
    public function actionGetboitier()
    {

        // echo json_encode(array("test"=>"gggg"));
        $instalations=array();
        $instalation= model::create('Installation');
        $products = $instalation->findFromRelation( "installations i,products p,details_installations d","i.id=d.installation_id and d.product_id=p.id and p.model= and d.status=0 ",array("fields"=>"p.*,m.provider,m.date_arrived"));
        $instalations=$instalation->find(array("fields"=>"COUNT(*) nombre,MONTH(`installed_at`) mois","groupBy"=>"YEAR(`installed_at`),MONTH(`installed_at`)"));
        //$sql="SELECT COUNT(*) nombre,MONTH(`installed_at`) mois FROM `installations` GROUP BY YEAR(`installed_at`), MONTH(`installed_at`)";
        // header('content-type:application/json');
        echo json_encode($instalations);
    }

}