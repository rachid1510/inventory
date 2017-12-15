<?php

require ("model/Model.php");
class installationController
{
    //
    public function actionIndex()
    {
        $installations=array();
        $installation = Model::create('Installation');
        $product = Model::create('Product');
//        $vehicule = Model::create('Vehicle');
//        $installateur = Model::create('Personal');

       // $installations = $installation->find();
        $installations=$installation->findFromRelation( "installations i,costumers c,vehicles v,personals p","i.vehicle_id=v.id and i.personal_id=p.id and v.costumer_id=c.id" ,array("fields"=>"i.*,v.imei,c.name,CONCAT( p.first_name,' ', p.last_name) AS personnal_name"));
       //var_dump($installations);
        $html='';

         foreach ($installations as $installation){
                                    $boitier=$this->getProductByTypeInstallation($installation['id'],1,$product);
                                    $sim=$this->getProductByTypeInstallation($installation['id'],2,$product);


                                $html.='<tr> <td class="text-center">'. $installation["installed_at"].'</td>';
                                $html.='<td class="text-center">'.$installation['personnal_name'].'</td>';
                                $html.='<td class="text-center">' .$installation['name'].' </td>';
                                $html.='<td class="text-center">' .$installation['imei'].'</td>';
                                  $html.='<td class="text-center">'. $installation['observation'].'</td>';
                                  $html.='<td class="text-center">'. $sim.'</td>';
                                  $html.='<td class="text-center">'. $boitier.'</td>';

             $html.='<td class="text-center"> <div class="btn-group"><a href="#" class="btn btn-info btn-xs" title="Edit" data-toggle="tooltip"><span class="glyphicon glyphicon-edit"></span></a></div></td></tr>';


                               }
        require 'view/installations/index.php';

    }

    public function actionAdd()
    {
        $result = array();
        $installation=new Installation();
        $data=array("personal-id"=>$_POST["installeur"],"observation"=>$_POST["obser"],"installed_at"=>$_POST["date_installed"],"vehicule_id"=>$_POST["vehicule_id"],);

        if($installation->save($data))
        {
            $result['msg']= 'OK';
        }
        else{
            $result['msg']= 'error';
        }

        echo json_encode($result);
        die();
    }
   public  function getProductByTypeInstallation($installation_id,$category,$product)
   {

       $product=$product->findFromRelation( "details_installations di,products p,movements m","p.movement_id=m.id and di.product_id=p.id and di.installation_id=$installation_id and m.category_id=$category" ,array("fields"=>"p.*"));
       return $product[0]["imei_product"];

   }
}
