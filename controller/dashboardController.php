<?php
require ("model/Model.php");
include ("config/config.php");
class dashboardController
{
    public function  actionIndex(){



        if (isset($_SESSION["login"]) and $_SESSION["fonction"]!='admin') {
            header("Location:login.php?error=e");
        }

            $installateurs = array();
            $installateur = Model::create('Personal');
            $installateurs = $installateur->find();
            $instalations=array();
            $instalation= model::create('Installation');
            $instalations=$instalation->find(array("fields"=>"DISTINCT YEAR(`installed_at`) annee","groupBy"=>"YEAR(`installed_at`)"));

            require 'view/dashboard/index.php';





    }
    public function actionGetinstallation()
    {

        // echo json_encode(array("test"=>"gggg"));
        $date=$_POST['instalation'];
        $instalations=array();
        $instalation= model::create('Installation');
        $instalations=$instalation->find(array("conditions"=>"YEAR(`installed_at`)=$date","fields"=>"COUNT(*) nombre,MONTH(`installed_at`) mois,YEAR(`installed_at`) annee","groupBy"=>"YEAR(`installed_at`),MONTH(`installed_at`)"));
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
    public function actionPerformance()
    {
        $id=$_POST['id'];
        $installations=array();
        $installation = Model::create('Installation');
        $installations=$installation->findFromRelation( "installations i,personals p"," i.personal_id=p.id and p.id=$id",array("fields"=>"COUNT(*) nombre,CONCAT( p.first_name,' ', p.last_name) AS personnal_name,MONTH(`installed_at`) mois, WEEK(i.installed_at) semaine","groupBy"=>"YEAR(i.installed_at),MONTH(i.installed_at),WEEK(i.installed_at)"));
        echo json_encode($installations);

    }
    public function actionTotalintervention()
    {
        $id=$_POST['id'];
        $interventions=array();
        $intervention = Model::create('Intervention');
        $interventions=$intervention->findFromRelation( "interevention i,personals p"," i.personal_id=p.id and p.id=$id",array("fields"=>"COUNT(*) nombre,CONCAT( p.first_name,' ', p.last_name) AS personnal_name,MONTH(`installed_at`) mois, WEEK(i.installed_at) semaine","groupBy"=>"YEAR(i.installed_at),MONTH(i.installed_at),WEEK(i.installed_at)"));
        echo json_encode($interventions);

     }


}