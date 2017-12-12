<?php  session_start();
	if(empty($_SESSION['id'] ))	{ header("location:login.php");	}
	
   include("head.php");
   $demo="";
   if(isset($_GET['a']))
   {
	   $demo=$_GET['a'];
   }
   if($demo!='Demo')
   {
   include ("header.php");  
   include ("menu.php"); 
   }
    include ("debutmain.php");  
	if (!isset($_GET['c']))
	{			
	  include ("view/template/home.php"); 
	
	}
	else 
	{
		
		
		
		$controleursAutorises = array('Patient','Consultation','Paiement','Document','Utilisateur','Attente','Vaccin','Rendezvous','Configuration');

			

		   if (!empty($_GET['c']) && !empty($_GET['a']) && in_array($_GET['c'], $controleursAutorises))
			{
				
				 $controleur = 'Controller' . $_GET['c'];
				require ('controller/'.$controleur .'.php');
				
				$controleur = new $controleur();

				$action = 'action' . $_GET['a'];

			
				if (method_exists($controleur, $action))
				{
					$controleur->$action();
					
				}
				else{
					
					echo 'method not exist';
				}
				
				
				
		
				
			}
			else{
				
				
				echo  '<div class="row alert alert-success"style="margin:auto; padding:50px; text-align:center"  ><span class="alert  ">Ecore de construction</span></div>';
			}
	}
	
	
	?>


  </div>
  <!-- /.content-wrapper -->
  <?php include("footer.php");  ?>