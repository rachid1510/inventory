<?php /**
 * include head
 */
include ("layouts/header.php");?>
     <div class="row">
     <div class="col-md-12">
        <div class="pull-left">
           <h3>La liste des cartes SIM</h3>
         </div>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <div class="col-md-9 pull-left">
           <form id="filtre_sim">
            <div class="form-group col-md-2">
              <label class="control-label">IMEI</label>
             <input type="text" class="form-control" name="imei" placeholder="IMEI">
           </div>
             <div class="form-group col-md-2">
              <label class="control-label">Réf Commande</label>
             <input type="text" class="form-control" name="ref_order" placeholder="REF COMMANDE">
           </div>

            <div class="form-group col-md-2">
              <label class="control-label">Etat</label>
               <select name="provider" class="form-control">
                        <option>Active</option>
                        <option>Inactive</option>
                </select>
           </div>
             <div class="form-group col-md-2">
              <label class="control-label">Date arrivée</label>
             <input type="date" class="form-control datePicker" name="date_debut" placeholder="DATE ARRIVEE">
           </div>
               <div class="form-group col-md-2">
                   <label class="control-label">Date D'activation</label>
                   <input type="date" class="form-control" name="date_debut" placeholder="DATE d'activation">
               </div>
           </form>
           </div>
        
          <div class="col-md-3 pull-right"><br/>
            <a href="#" id="filtrer" class="btn btn-primary">Filtrer</a>
           <a href="#" id="showmodal" class="btn btn-primary">Activer</a>
           <a href="#" id="modalaffactation" class="btn btn-primary">Affecter</a>

         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered" id="liste">
            <thead>
              <tr>
                  <th class="text-center" style="width: 10%;"> # </th>
                <th class="text-center" style="width: 10%;"> SSID </th>
                <th class="text-center" style="width: 10%;"> Numèro </th>
                <th class="text-center" style="width: 10%;"> Fournisseur </th>
                <th class="text-center" style="width: 10%;"> Plan </th>
                <th class="text-center" style="width: 10%;"> Etat </th>
                <th class="text-center" style="width: 10%;"> Activer </th>
                <th class="text-center" style="width: 10%;">Date d'activation </th>
                  <th class="text-center" style="width: 10%;"> Cocher </th>
                <th class="text-center" style="width: 100px;"> Actions </th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($products as $product):?>

            <tr>
                <td class="text-center"><?php echo $product['id']; ?> </td>
                 <td class="text-center"><?php echo $product['imei_product']; ?> </td>
                <td class="text-center"><?php echo $product['label']; ?></td>
                <td class="text-center"><?php echo $product['provider']; ?> </td>
                <td class="text-center"><?php echo $product['model']; ?> </td>
                <td class="text-center"> <?php echo $product['status']; ?></td>
                <td class="text-center"> <?php echo $product['state']; ?></td>
                <td class="text-center"><?php echo $product['date_arrived']; ?> </td>
                <td class="text-center coche"><?php if($product['status']==1 || $product['status']==2){?> <input type="checkbox" id="check<?php echo $product['id']; ?>"  name="checked_box[]" value="<?php echo $product['id']; ?>"><?php }?></td>

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
                $pagLink .= "<li class='paginate_button'><a href='".$url."/product/sim/".$prec."'>Précédent</a></li>";
            }
            for ($i=$p; $i<=$p+5; $i++) {

                if($i==$p)
                {
                    $pagLink .= "<li class='paginate_button active'><a href='".$url."/product/sim/".$i."'>".$i."</a></li>";

                }
                else
                {
                    $pagLink .= "<li class='paginate_button'><a href='".$url."/product/sim/".$i."'>".$i."</a></li>";
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
                $pagLink .= "<li class='paginate_button'><a  href='".$url."/product/sim/".$next."'>Suivant</a></li>";
            }

            echo $pagLink . "</ul></div>";
            ?>
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
                     <h4 class="modal-title" id="myModalLabel">Activer les cartes SIM</h4>
                 </div>
                 <div class="modal-body">
                     <div class="alert alert-success" style="display: none">
                         <strong>Success!</strong> l'activation avec succés.
                     </div>
                     <div class="alert alert-danger" style="display: none">
                         <strong>Danger!</strong>Erreure a été se produit.
                     </div>
                     <form id="actevationfrm" class="form-horizontal" role="form" method="POST" action="activation">


                         <div class="form-group">
                             <label class="col-md-4 control-label">Position</label>
                             <div class="col-md-6">
                                 <input type="number" class="form-control" name="position">
                                 <small class="help-block"></small>
                             </div>
                         </div>
                         <div class="form-group">
                             <label class="col-md-4 control-label">Nombre à activer</label>
                             <div class="col-md-6">
                                 <input type="number" class="form-control" name="nomber">
                                 <small class="help-block"></small>
                             </div>
                         </div>

                         <div class="form-group">
                             <label class="col-md-4 control-label">Date activation</label>
                             <div class="col-md-6">
                                 <input type="date" class="form-control" name="date_activation">
                                 <small class="help-block"></small>
                             </div>
                         </div>


                         <div class="form-group">
                             <div class="col-md-6 col-md-offset-4 pull-right">
                                 <a title="activation" alt="actevationfrm" class="btn btn-primary btn-lg submitfrm" id="" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Patienter...">Valider</a>

                             </div>
                         </div>
                     </form>

                 </div>
             </div>
         </div>
     </div>


     <!-- Modal -->
     <div class="modal fade" id="modalaffactation_block" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                     <h4 class="modal-title" id="myModalLabel">L'Affectation des cartes aux personnels</h4>
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
     <?php include ("layouts/footer.php");?>