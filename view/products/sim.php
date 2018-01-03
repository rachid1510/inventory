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

            <div class="col-md-12">
            <form id="filtre" name="filtre" role="form" method="post" action="" >

            <div class="form-group col-md-2">
              <label class="control-label">SSID</label>
             <input type="text" class="form-control" id="imei_searsh" name="imei" placeholder="SSID">
           </div>
             <div class="form-group col-md-2">
              <label class="control-label">Réf Commande</label>
             <input type="text" class="form-control" name="ref_order" placeholder="REF COMMANDE" value="<?php  if(isset($_POST["ref_order"])){ echo $_POST["ref_order"];} ?>"/>
           </div>

            <div class="form-group col-md-2">
              <label class="control-label">Etat</label>
               <select name="state" class="form-control">
                   <option value="">Sélectionnez</option>
                        <option value="enabled">Active</option>
                        <option value="disabled">Inactive</option>

                </select>
           </div>
            <div class="form-group col-md-2">
                    <label class="control-label">Etat de stock</label>
                    <select name="stock" class="form-control">
                        <option value="">Sélectionnez</option>
                        <option value="0">Installé</option>
                        <option value="1">En stock</option>
                        <option value="2">en stock personel</option>
                        <option value="3">Bloqué</option>
                    </select>
            </div>
                <div class="form-group col-md-2">

                    <label class="col-md-4 control-label">Installateur</label>
                    <select name="personal_search" class="form-control" id="personal_search">
                        <option value="0">Veuillez selectionner un installateur</option>
                        <?php foreach($personals as $persoanl):?>
                            <option value="<?php echo $persoanl['id'];?>"><?php echo $persoanl['first_name']. ' '.$persoanl['last_name'];?></option>

                        <?php endforeach; ?>
                    </select>

                </div>
             <div class="form-group col-md-2">
              <label class="control-label">Date arrivée</label>
             <input type="date" class="form-control" name="date_arrived" placeholder="DATE ARRIVEE">
           </div>
               <div class="form-group col-md-2">
                   <label class="control-label">Date D'activation</label>
                   <input type="date" class="form-control" name="date_activation" placeholder="DATE d'activation">
               </div>
                <br/>
                <div class="form-group col-md-2 pull-right">
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                </div>
           </form>
           </div>


          <div class="col-md-6 pull-right" style="text-align: right;">

           <a href="#" id="modalactivation_btn" class="btn btn-primary">Activer</a>
           <a href="#" id="modalaffactation" class="btn btn-primary">Affecter</a>
           <a href="#" id="modaltransfer" class="btn btn-primary">Transfer</a>
              <a href="#" id="returntoopentech" class="btn btn-primary">Débloquer</a>
              <a href="#" id="bloquer" class="btn btn-primary">Bloquer</a>
           <a href="<?php echo $url;?>/product/sim"  class="btn btn-primary">Lister</a>

         </div>
        </div>
        <div class="panel-body">
            <form role="form" method="post" action="">
                <div class="form-group col-md-3">
                    <label class="control-label">Pagination</label>
                    <input type="text" class="form-control" name="pagination" placeholder="pagination">
                </div>
                <div class="form-group col-md-2"><br/>
                    <button type="submit" class="invisible">Appliquer</button>
                </div>

            </form>
            <div class="col-md-2 pull-right" style="text-align: right;"><br/><br/>
                <h4> <?php
                    if($total_records>0){
                        echo ' Affiché  '.$limit*$p.' sur '. $total_records;
                    }else {
                        echo ' Affiché  0  sur '. $total_records;
                    }
                    ?></h4>
            </div>
          <table class="table table-bordered" id="liste">
            <thead>
              <tr>
                  <th class="text-center" style="width: 10%;"> # </th>
                <th class="text-center" style="width: 10%;"> SSID </th>
                <th class="text-center" style="width: 10%;"> Numèro </th>
                <th class="text-center" style="width: 10%;"> Fournisseur </th>
                <th class="text-center" style="width: 10%;"> Plan </th>

                <th class="text-center" style="width: 10%;"> Activer </th>
                <th class="text-center" style="width: 10%;">Date d'activation </th>
                  <th class="text-center" style="width: 10%;"> Ref commande </th>
                  <th class="text-center" style="width: 10%;"> Etat </th>
                  <th class="text-center" style="width: 10%;"> Installateur </th>
                  <th class="text-center" style="width: 10%;"> Matricule </th>
                  <th class="text-center" style="width: 10%;">Boitier Opentech</th>
                  <th class="text-center" style="width: 10%;">Boitier Client</th>
                  <th class="text-center" style="width: 10%;"> Cocher </th>

              </tr>
            </thead>
            <tbody>
            <?php
            foreach($products as $product):?>

            <tr>
                <td class="text-center"><?php echo $product['id']; ?> </td>
                 <td class="text-center"><?php echo $product['imei_product']; ?> </td>
                <td class="text-center"><?php echo $product['label']; ?></td>
                <td class="text-center"><?php echo $product['provider']; ?> </td>
                <td class="text-center"><?php echo $product['model']; ?> </td>

                <td class="text-center"> <?php
                    if($product['state'] =='disabled') {
                        echo '<span style="padding: 0px !important;" class="alert alert-danger">Désactivée</span>';
                    }
                elseif ($product['state'] =='enabled') {
                    echo '<span style="padding: 0px !important;" class="alert alert-success">Activée</span>';

                }
                   ?></td>
                <td class="text-center"><?php echo $product['enabled_date']; ?> </td>
                <td class="text-center"> <?php echo $product['order_ref']; ?></td>
                <td class="text-center">
                    <?php

                        if ($product['status'] == "1") {
                            echo '<span style="padding: 0px !important;" class="alert alert-success">en stock</span>';
                        } elseif ($product['status'] == "2") {
                            echo '<span style="padding: 0px !important;" class="alert alert-warning">en stock personel</span>';
                        } elseif($product['status'] == "0") {
                            echo '<span style="padding: 0px !important;" class="alert alert-info">Installé</span>';
                        }else{
                            echo '<span style="padding: 0px !important;" class="alert alert-danger">Bloquée</span>';
                        }


                    ?>
                     </td>

                <td class="text-center"><?php echo (!empty($product['first_name']))? $product['first_name']:'--'; ?> </td>
                <td class="text-center"><?php echo (!empty($product['imei_vehicle']))? $product['imei_vehicle']:'--'; ?> </td>
                <td class="text-center"><?php echo (!empty($product['imei_product_inverse']))? $product['imei_product_inverse']:'--'; ?> </td>
                <td class="text-center"><?php echo (!empty($product['costumer_product']))? $product['costumer_product']:'--'; ?> </td>
                <td class="text-center coche"><?php if($product['status']==1 || $product['status']==2 || $product['status']==3){?> <input type="checkbox" id="check<?php echo $product['id']; ?>" alt="<?php echo $product['status'];?>" title="<?php echo $product['first_name'] ;?>" name="<?php echo $product['personal_id'] ;?>" value="<?php echo $product['id']; ?>"><?php }?></td>


              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
            <?php
            if($p*$limit<$total_records) {
                $next = $start_from + $limit;
                $pagLink = "<div class='pagination pull-left'>" . $start_from . "-" . $next . "/" . $total_records . "</div><div class='pagination pull-right'><ul class='pagination'>";
                if ($p > 1) {
                    $prec = $p - 1;
                    $pagLink .= "<li class='paginate_button'><a href='" . $url . "/product/sim/" . $prec . "'>Précédent</a></li>";
                }
                for ($i = $p; $i <= $p + 5; $i++) {

                    if ($i == $p) {
                        $pagLink .= "<li class='paginate_button active'><a href='" . $url . "/product/sim/" . $i . "'>" . $i . "</a></li>";

                    } else {
                        $pagLink .= "<li class='paginate_button'><a href='" . $url . "/product/sim/" . $i . "'>" . $i . "</a></li>";
                    }

                    if ($i >= $total_pages) {
                        break;
                    }
                };
                if ($p * $limit < $total_records) {
                    $next = $p + 1;
                    //$url = "index.php?c=Patient&a=Afficher&page=" . $p + 1;
                    $pagLink .= "<li class='paginate_button'><a  href='" . $url . "/product/sim/" . $next . "'>Suivant</a></li>";
                }

                echo $pagLink . "</ul></div>";
            }?>
        </div>
      </div>
    </div>
  </div>
     <!-- Modal -->
     <div class="modal fade" id="modalactivation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                     <form id="actevationfrm" class="form-horizontal" role="form" method="POST" action="#">


                        <!-- <div class="form-group">
                             <label class="col-md-4 control-label">Position</label>
                             <div class="col-md-6">
                                 <input type="number" class="form-control" name="position">
                                 <small class="help-block"></small>
                             </div>
                         </div>-->
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
                                 <input type="date" class="form-control datePicker" name="date_activation">
                                 <small class="help-block"></small>
                             </div>
                         </div>


                         <div class="form-group">
                             <div class="col-md-6 col-md-offset-4 pull-right">
                                 <a title="product/activation" alt="actevationfrm" class="btn btn-primary btn-lg submitfrm" id="" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Patienter...">Valider</a>

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

                         <div class="form-group" id="nombreaffecter" style="display: none">
                             <label class="col-md-4 control-label">Nombre à affecter</label>
                             <div class="col-md-6">
                                 <input type="text" name="nombreaafecter" id="nombreaafecter"/>
                             </div>
                         </div>
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
                                 <a title="product/affectationsim" alt="affectationfrm" class="btn btn-primary btn-lg submitfrm" id="" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Patienter...">Valider</a>

                             </div>
                         </div>
                     </form>

                 </div>
             </div>
         </div>
     </div>

    <!-- Modal -->
    <div class="modal fade" id="modaltransfer_block" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Le transfer du <span id="transferdulabel"></span> </h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success" style="display: none">
                        <strong>Success!</strong> le transfer avec succés.
                    </div>
                    <div class="alert alert-danger" style="display: none">
                        <strong>Danger!</strong>Erreure a été se produit.
                    </div>
                    <form id="transferfrm" class="form-horizontal" role="form" method="POST">


                        <div class="form-group">
                            <input type="hidden" name="enstockde" id="enstockde" value="">
                            <label class="col-md-4 control-label">Transferer à </label>
                            <div class="col-md-6">

                                <select name="personal_id_stock" class="form-control chosen-select" id="personal_id_stock">
                                    <option value="0">Veuillez selectionner un installateur</option>
                                    <?php foreach($personals as $persoanl):?>
                                        <option value="<?php echo $persoanl['id'];?>"><?php echo $persoanl['first_name']. ' '.$persoanl['last_name'];?></option>

                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="products_transfer" id="products_transfer" value="">
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4 pull-right">
                                <a title="product/transfer" alt="transferfrm" class="btn btn-primary btn-lg submitfrm" id="" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Patienter...">Valider</a>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
     <?php include ("layouts/footer.php");?>