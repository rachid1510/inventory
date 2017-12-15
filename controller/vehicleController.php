<?php

require ("model/Model.php");
class vehicleController
{
    //
    public function actionIndex()
    {
        $vehicles=array();
        $vehicles = Model::create('Vehicle');
        $vehicles=$vehicles->findFromRelation( "costumers c,vehicles v","v.costumer_id=c.id" ,array("fields"=>"v.*,c.name"));
        require 'view/vehicles/index.php';

    }
}
