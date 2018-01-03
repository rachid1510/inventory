<?php  
    /**
    * check session
    **/

//          session_start();
//
//       if (!empty($_SESSION["login"])) {
//       require 'view/costumers/index.php';
//       }
//       else
//       header("Location:login.php?error=e");
//

$controllers=['product','movement','installation','costumer','vehicle','personal','dashboard','home','intervention'];
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
        include 'home.php';
    }
