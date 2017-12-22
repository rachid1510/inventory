<?php /**
 * include head
 */
include ("layouts/header.php");?>
     <div class="row">
     <div class="col-md-12">
        <div class="pull-left">
           <h3>La liste des boitiers</h3>
         </div>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">

          <div class="col-md-10">
           <form id="filtre" name="filtre" role="form" method="post" action="boitier" >

            <div class="form-group col-md-3">
              <label class="control-label">IMEI</label>
             <input type="text" class="form-control" name="imei" placeholder="IMEI">
           </div>
             <div class="form-group col-md-3">
              <label class="control-label">Réf Commande</label>
             <input type="text" class="form-control" name="ref_order" placeholder="REF COMMANDE">
           </div>
             <div class="form-group col-md-3">
              <label class="control-label">Date arrivée</label>
             <input type="date" class="form-control " name="date_debut" placeholder="DATE ARRIVEE">
           </div>
               <div class="form-group col-md-3"><br>
               <button type="submit" class="btn btn-primary">Rechercher</button>
               </div>
           </form>
           </div>
        

           <div class="col-md-2 pull-right"><br/>

               <a href="#" id="modalaffactation" class="btn btn-primary">Affecter</a>


        </div>
        <div class="panel-body">
          <table class="table table-bordered" id="liste">
            <thead>
              <tr>
                             
                <th class="text-center" style="width: 10%;"> IMEI </th>
                <th class="text-center" style="width: 10%;"> TYPE de Boitier </th>
                <th class="text-center" style="width: 10%;"> Fournisseur </th>
                <th class="text-center" style="width: 15%;"> Modèle </th>

                <th class="text-center" style="width: 10%;"> Date d'arrivée </th>
                  <th class="text-center" style="width: 10%;"> Ref commande </th>
                  <th class="text-center" style="width: 15%;"> Etat </th>
                <th class="text-center" style="width: 10%;"> Cocher </th>

                <th class="text-center" style="width: 10%;"> Actions </th>

              </tr>
            </thead>
            <tbody>
            <?php foreach($products as $product):?>

            <tr>
                
                 <td class="text-center"><?php echo $product['imei_product']; ?> </td>
                <td class="text-center"> <?php echo $product['label']; ?></td>
                <td class="text-center"> <?php echo $product['provider']; ?></td>
                <td class="text-center"> <?php echo $product['model']; ?></td>
                <td class="text-center"> <?php echo $product['date_arrived']; ?></td>
                <td class="text-center"> <?php echo $product['order_ref']; ?></td>
                <td class="text-center">   <?php  if($product['status']=="1"){
                        echo '<span style="padding: 0px !important;" class="alert alert-success">en stock</span>';
                    }elseif($product['status']=="2"){
                        echo '<span style="padding: 0px !important;" class="alert alert-warning">en stock personel</span>';
                    }else{ echo '<span style="padding: 0px !important;" class="alert alert-danger">Installé</span>';
                    }?></td>
                <td class="text-center"> <input type="checkbox" name="checked_box[]" value="<?php echo $product['id']; ?>"></td>

                <td class="text-center">
                  <div class="btn-group">
                    <a href="#" class="btn btn-info btn-xs"  title="Edit" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a href="#" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>

                  </div>
                </td>

              </tr>
            <?php endforeach; ?>

            </tbody>
          </table>
            <?php
            $pagLink = "<div class='pagination pull-right'><ul class='pagination'>";
            if($p>1)
            {
                $prec= $p - 1;
                $pagLink .= "<li class='paginate_button'><a href='".$url."/product/boitier/".$prec."'>Précédent</a></li>";
            }
            for ($i=$p; $i<=$p+5; $i++) {

                    if($i==$p)
                    {
                        $pagLink .= "<li class='paginate_button active'><a href='".$url."/product/boitier/".$i."'>".$i."</a></li>";

                    }
                    else
                    {
                        $pagLink .= "<li class='paginate_button'><a href='".$url."/product/boitier/".$i."'>".$i."</a></li>";
                    }

                if($i>=$total_pages)
                {
                    break;
                }
            };
            if($p<$total_records)
            {
                $next= $p + 1;
                //$url = "index.php?c=Patient&a=Afficher&page=" . $p + 1;
                $pagLink .= "<li class='paginate_button'><a  href='".$url."/product/boitier/".$next."'>Suivant</a></li>";
            }

            echo $pagLink . "</ul></div>";
            ?>
        </div>
      </div>
    </div>
  </div>

    <div class="modal fade" id="modalaffactation_block" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">L'Affectation des boîtiers aux personnels</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success" style="display: none">
                        <strong>Success!</strong> l'affectation avec succés.
                    </div>
                    <div class="alert alert-danger" style="display: none">
                        <strong>Danger!</strong>Erreure a été se produit.
                    </div>
                    <form id="affectationfrm" class="form-horizontal" role="form" method="POST">
                        <div class="form-group">

                            <label class="col-md-4 control-label">Installateur</label>
                            <div class="col-md-6">

                                <select name="personal_id" class="form-control chosen-select" id="personal_id">
                                    <option value="0">Veuillez selectionner un installateur</option>
                                    <?php foreach($personals as $persoanl):?>
                                        <option value="<?php echo $persoanl['id'];?>"><?php echo $persoanl['first_name']. ' '.$persoanl['last_name'];?></option>

                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="products" id="products" value="">
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4 pull-right">
                                <a title="affectation" alt="affectationfrm" class="btn btn-primary btn-lg submitfrm" id="" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Patienter...">Valider</a>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
 
 <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Ajouter Mouvement</h4>
                </div>
                <div class="modal-body">
  
                    <form id="formRegister" class="form-horizontal" role="form" method="POST" action="{{ url('register') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
  
                        <div class="form-group">
                            <label class="col-md-4 control-label">Ref commande</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="order_id">
                                <small class="help-block"></small>
                            </div>
                        </div>
  
                        <div class="form-group">
                            <label class="col-md-4 control-label">Fournisseur</label>
                            <div class="col-md-6">
                                <select name="provider" class="form-control">
                                  <option>Four1</option>
                                  <option>Four2</option>
                                </select>
                            </div>
                        </div>


                         <div class="form-group">
                            <label class="col-md-4 control-label">PLAN</label>
                            <div class="col-md-6">
                               <input type="text" class="form-control" name="order_id">
                                <small class="help-block"></small>
                            </div>
                        </div>
  
                        <div class="form-group">
                            <label class="col-md-4 control-label">Date arrivée</label>
                            <div class="col-md-6">
                                <input type="date" class="form-control" name="date_arrived">
                                <small class="help-block"></small>
                            </div>
                        </div>
  
                       <div class="form-group">
                            <label class="col-md-4 control-label">Importer fichier</label>
                            <div class="col-md-6">
                               <input type="file" class="form-control" name="order_id">
                                
                            </div>
                        </div>
  
  
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4 pull-right">
                                <button type="submit" class="btn btn-primary">
                                    Valider
                                </button>
                            </div>
                        </div>
                    </form>                       
  
                </div>
            </div>
        </div>
    </div>
<?php include ("layouts/footer.php");?>