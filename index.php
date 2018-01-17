<?php
//if($_SERVER["REMOTE_ADDR"]!='192.168.2.19'){
//    header("Location:http://192.168.2.19/inventory_v1/");
//}
   /**
    * check session
    **/
session_start();
if (!isset($_SESSION["login"])) {
    header("Location:login.php");
}

//          session_start();
//
//       if (!empty($_SESSION["login"])) {
//       require 'view/costumers/index.php';
//       }
//       else
//       header("Location:login.php?error=e");
//
   if($_SESSION['fonction']=='admin'){
       $controllers=['product','movement','installation','costumer','vehicle','personal','dashboard','home','intervention','user'];

   }
   elseif($_SESSION['fonction']=='installateur'){
       $controllers=['home','costumer','vehicle','personal','intervention'];

   }
   else{
       $controllers=['product','movement','installation','costumer','vehicle','personal','home','intervention'];

   }
    $currentlink = explode('/', $_SERVER['REQUEST_URI']);
    $ctl = $currentlink[2];

    $act='index';
    if(isset($currentlink[3]) && !empty($currentlink[3])){
        $act=$currentlink[3];
    }

    if (!empty($ctl) && in_array($ctl, $controllers))
    {

     /*
      * name off controller dynamic
      */
        $controller = $ctl.'Controller';
    /*
     * require controller from directory controller
     */
        require ('controller/'.$controller .'.php');
    /*
     * instance object from controller required
     */
         $instanceController = new $controller();
     /*
      * get action from request
      */
        $action = 'action' . $act;
     /*
      * check if method exist
      */
    if (method_exists($instanceController, $action))
    {

        if(count($currentlink)>4){
            if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strcasecmp($_SERVER['HTTP_X_REQUESTED_WITH'], 'xmlhttprequest') == 0) {
                $instanceController->$action();
            }
            else{
                $instanceController->$action($currentlink[4]);
            }

        }else
        {
            $instanceController->$action();
        }


    }
    else{

        echo 'method not exist';
    }
    }
    else
    {
        header("Location:http://".$_SERVER['HTTP_HOST']."/inventory/home");

    }
