<?php  
    /**
    * check session
    **/
    /*session_start();
    if(empty($_SESSION['user_id'] ))	{ header("location:login.php");	}*/
    /**
     * include head
     */
    include ("layouts/header.php");
    /*
     * list off controller
     */
    $controllers=['product','movement'];
    if (!empty($_GET['c']) && !empty($_GET['a']) && in_array($_GET['c'], $controllers))
    {
     /*
      * name off controller dynamic
      */
        $controller = $_GET['c'].'Controller';
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
        $action = 'action' . $_GET['a'];
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