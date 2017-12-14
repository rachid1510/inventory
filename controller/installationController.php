<?php


class installationController
{
    //
    public function actionIndex()
    {

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
}
