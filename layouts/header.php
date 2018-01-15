<?php include ("config/config.php");?>
<!doctype html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gestion de stock| Acuueil</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css">

<!--    <link rel="stylesheet" href="<?php echo $url;?>/dist/css/bootstrap.css">-->
    <link rel="stylesheet" href="<?php echo $url;?>/dist/css/font-awesome.css">
    <link rel="stylesheet" href="<?php echo $url;?>/dist/css/chosen.min.css">
    <link rel="stylesheet" href="<?php echo $url;?>/dist/css/style.css">
    <link rel="stylesheet" href="<?php echo $url;?>/dist/css/AdminLTE.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini" >
<br>
<div class="wrapper">
<header id="header">
      <div class="logo pull-left" style="height: 100%;"><a href="<?php echo $url;?>" style="display:block;height: 100%;"> <img src="<?php echo $url;?>/dist/img/logo-website_new.png" alt="logo_opentech"/></a></div>
      <div class="header-content">
      <div class="header-date pull-left">
        <strong><?php echo date("Y-m-d H:i:s");?></strong>
      </div>
      <div class="pull-right clearfix">
        <ul class="info-menu list-inline list-unstyled">

            <?php if($_SESSION['fonction']=='stock' || $_SESSION['fonction']=='admin'):?>
            <li class="profile">
                <a data-toggle="dropdown" class="toggle" aria-expanded="false">
                    <i class="glyphicon glyphicon-globe" aria-hidden="true"></i></a>
                <ul class="dropdown-menu alet alert-danger" style="right: 0px !important;left:auto !important;">
                    <li id="carte_link" class="" style="display: none">Alert stock carte SIM <span></span></li>
                    <li id="boitier_link" class="alet alert-danger" style="display: none">Alert stock Boitier <span></span></li>
                </ul>
            </li>
            <?php endif;?>

            <?php if($_SESSION['fonction']=='admin'):?>
                <li class="profile">
                    <a data-toggle="dropdown" class="toggle" aria-expanded="false">
                        <i class="glyphicon glyphicon-bell" aria-hidden="true"></i></a>
                    <ul class="dropdown-menu alet alert-danger" style="right: 0px !important;left:auto !important;">
                        <li id="intervention_alert" class="" style="display: none">Alert intervention incomplete <span></span></li>

                    </ul>
                </li>
            <?php endif;?>
            <li>
             <span><i class="glyphicon glyphicon-user"></i><?php if(isset($_SESSION["login"])){
                     echo ' Bonjour:'. strtoupper($_SESSION["login"]);

                 } ?></span>
            </li>
            <li class="last">
                <a href="<?php echo $url;?>/logout.php">
                    <i class="glyphicon glyphicon-off"></i>
                    Logout
                </a>
            </li>
        </ul>
      </div>
     </div>
    </header>
    <div class="sidebar">
        <ul>
            <?php if($_SESSION['fonction']=='admin'):?>
            <li>
                <a href="<?php echo $url;?>/dashboard">
                    <i class="glyphicon glyphicon-home"></i>
                    <span>DASHBOARD</span>
                </a>
            </li>
            <?php endif;?>

            <!--  <li>
              <a href="home.php">
                <i class="glyphicon glyphicon-home"></i>
                <span>Catégories</span>
              </a>
            </li> -->

            <li>
                <a href="<?php echo $url;?>/movement">
                    <i class="glyphicon glyphicon-move"></i>
                    <span>COMMANDES</span>
                </a>
            </li>

            <li>
                <a   class="submenu-toggle">
                    <i class="glyphicon glyphicon-barcode"></i>
                    <span>STOCK</span>
                </a>
                <ul class="nav submenu">
                    <li><a href="<?php echo $url;?>/product/boitier">Boîtier </a> </li>
                    <li><a href="<?php echo $url;?>/product/sim">Cartes SIM <span id="carte_link"></span></a> </li>
                </ul>
            </li>


            <li>
                <a href="<?php echo $url;?>/costumer">
                    <i class="glyphicon glyphicon-th-list"></i>
                    <span>CLIENTS</span>
                </a>
            </li>
            <li>
                <a href="<?php echo $url;?>/vehicle">
                    <i class="glyphicon glyphicon-bed"></i>
                    <span>VEHICULES</span>
                </a>
            </li>
            <li>

                <a href="<?php echo $url;?>/intervention">
                    <i class="glyphicon glyphicon-cog"></i>
                    <span>INTERVENTION</span>
                </a>
            </li>
            <li>
                <a href="<?php echo $url;?>/installation">
                    <i class="glyphicon glyphicon-wrench"></i>
                    <span>INSTALLATIONS</span>
                </a>
            </li>

            <li>

                <a href="<?php echo $url;?>/personal">
                    <i class="glyphicon glyphicon-user"></i>
                    <span>INSTALLATEUR</span>
                </a>
            </li>
<!--            <li>-->
<!--                <a href="--><?php //echo $url;?><!--/home">-->
<!--                    <i class="glyphicon glyphicon-stats"></i>-->
<!--                    <span>STATISTIQUE</span>-->
<!--                </a>-->
<!--            </li>-->
            <li>
                <a href="<?php echo $url;?>/docs.php">
                    <i class="glyphicon glyphicon-download-alt"></i>
                    <span>DOCUMENTS</span>
                </a>
            </li>
            <?php if($_SESSION['fonction']=='admin'):?>
            <li>
                <a href="<?php echo $url;?>/user">
                    <i class="glyphicon glyphicon-user"></i>
                    <span>UTILISATEURS</span>
                </a>
            </li>
            <?php endif;?>

<!--            <li>-->
<!--                <a href="--><?php //echo $url;?><!--/home">-->
<!--                    <i class="glyphicon glyphicon-stats"></i>-->
<!--                    <span>CHAT</span>-->
<!--                </a>-->
<!--            </li>-->

        </ul>

   </div>


<div class="page">
  <div class="container-fluid">
