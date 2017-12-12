<?php  
    /**
    * check session
    **/
    session_start();
    if(empty($_SESSION['user_id'] ))	{ header("location:login.php");	}
    include ("config/config.php");
    /**
     * include head
     */
    include ("layouts/header.php");
    /*
     * list off controller
     */
    $controllers=['product','movement'];
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
        $instanceController->$action();

    }
    else{

        echo 'method not exist';
    }
    }
    include ("layouts/footer.php");