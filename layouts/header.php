<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gestion de stock| Acuueil</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css">
<!--    <link rel="stylesheet" href="dist/css/bootstrap.css">-->
    <link rel="stylesheet" href="dist/css/font-awesome.css">
    <link rel="stylesheet" href="dist/css/style.css">
</head>
<body class="hold-transition skin-blue sidebar-mini" >
<div class="wrapper">
<header id="header">
      <div class="logo pull-left"> OSWA - Inventory </div>
      <div class="header-content">
      <div class="header-date pull-left">
        <strong><?php echo date("F j, Y, g:i a");?></strong>
      </div>
      <div class="pull-right clearfix">
        <ul class="info-menu list-inline list-unstyled">
          <li class="profile">
            <a href="#" data-toggle="dropdown" class="toggle" aria-expanded="false">
              <img src="#" alt="user-image" class="img-circle img-inline">
              <span> <i class="caret"></i></span>
            </a>
            <ul class="dropdown-menu">
              <li>
                  <a href="#">
                      <i class="glyphicon glyphicon-user"></i>
                      Profile
                  </a>
              </li>
             <li>
                 <a href="edit_account.php" title="edit account">
                     <i class="glyphicon glyphicon-cog"></i>
                     Settings
                 </a>
             </li>
             <li class="last">
                 <a href="logout.php">
                     <i class="glyphicon glyphicon-off"></i>
                     Logout
                 </a>
             </li>
           </ul>
          </li>
        </ul>
      </div>
     </div>
    </header>
    <div class="sidebar">
        <ul>
            <li>
                <a href="home.php">
                    <i class="glyphicon glyphicon-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!--  <li>
              <a href="home.php">
                <i class="glyphicon glyphicon-home"></i>
                <span>Catégories</span>
              </a>
            </li> -->
            <li>
                <a href="movement">
                    <i class="glyphicon glyphicon-th-list"></i>
                    <span>MOUVEMENTS</span>
                </a>
            </li>

            <li>
                <a href="#" class="submenu-toggle">
                    <i class="glyphicon glyphicon-th-list"></i>
                    <span>PRODUITS</span>
                </a>
                <ul class="nav submenu">
                    <li><a href="boitier">Boîtier</a> </li>
                    <li><a href="sim">Cartes SIM</a> </li>
                </ul>
            </li>

            <li>
                <a href="home.php">
                    <i class="glyphicon glyphicon-signal"></i>
                    <span>INSTALLATIONS</span>
                </a>
            </li>
            <li>
                <a href="home.php">
                    <i class="glyphicon glyphicon-th-large"></i>
                    <span>INSTALLATEUR</span>
                </a>
            </li>
            <li>
                <a href="home.php">
                    <i class="glyphicon glyphicon-picture"></i>
                    <span>CLIENTS</span>
                </a>
            </li>

            <li>
                <a href="home.php">
                    <i class="glyphicon glyphicon-indent-left"></i>
                    <span>STATISTIQUE</span>
                </a>
            </li>

        </ul>

   </div>


<div class="page">
  <div class="container-fluid">
