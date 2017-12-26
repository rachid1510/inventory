<?php
require ("model/Model.php");

class dashboardController
{
    public function  actionIndex(){

        session_start();

        if (isset($_SESSION["login"]) and $_SESSION["fonction"]=='admin' ) {
            require 'view/dashboard/index.php';
        }
        else
            header('location:home.php');



    }
    public function actionGetinstallation()
    {

        // echo json_encode(array("test"=>"gggg"));
        $instalations=array();
        $instalation= model::create('Installation');
        $instalations=$instalation->find(array("fields"=>"COUNT(*) nombre,MONTH(`installed_at`) mois,YEAR(`installed_at`) annee","groupBy"=>"YEAR(`installed_at`),MONTH(`installed_at`)"));
        //$sql="SELECT COUNT(*) nombre,MONTH(`installed_at`) mois FROM `installations` GROUP BY YEAR(`installed_at`), MONTH(`installed_at`)";
        // header('content-type:application/json');
        echo json_encode($instalations);
    }
    public function actionGetboitier()
    {

        $boitiers= array();
        $product= model::create('Product');
        $boitiers=$product->findFromRelation("products p,movements m,details_installations d, installations i",'p.movement_id=m.id and d.product_id=p.id and m.category_id=1 and i.id=d.installation_id',array("fields"=>"COUNT(*) nombre,p.model,MONTH(i.installed_at)","groupBy"=>"p.model,YEAR(i.installed_at),MONTH(i.installed_at)"));
        echo json_encode($boitiers);

    }
    public function actionGetSim()
    {
        $product=model::create('Product');
        $sims=array();
        $sims=$product->findFromRelation("products p,movements m,details_installations d, installations i",'p.movement_id=m.id and d.product_id=p.id and m.category_id=2 and i.id=d.installation_id',array("fields"=>"COUNT(*) nombre,p.model,MONTH(i.installed_at) mois","groupBy"=>"p.model,YEAR(i.installed_at),MONTH(i.installed_at)"));

        echo json_encode($sims);



    }


}