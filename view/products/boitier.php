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
            <div class="row">
            <form id="filtre" name="filtre" role="form" method="post" action="" >
          <div class="col-md-12">


                <div class="form-group col-md-2">
                  <label class="control-label">IMEI</label>
                 <input type="text" class="form-control" id="imei_searsh" name="imei" placeholder="IMEI">
               </div>

               <div class="form-group col-md-2">
                   <label class="control-label">Réf Commande</label>
                   <input type="text" class="form-control" name="ref_order" placeholder="REF COMMANDE">
               </div>

<!--               <div class="form-group col-md-2">-->
<!--                   <label class="control-label">Etat</label>-->
<!--                   <select name="state" class="form-control">-->
<!--                       <option value="">Sélectionnez</option>-->
<!--                       <option value="enabled">Active</option>-->
<!--                       <option value="disabled">Inactive</option>-->
<!---->
<!--                   </select>-->
<!--               </div>-->
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
             <input type="date" class="form-control " name="date_debut" placeholder="DATE ARRIVEE">
           </div>
          </div>
               <div class="form-group col-md-4 pull-right"><br>
               <button type="submit" class="btn btn-primary">Rechercher</button>
                   <button type="submit" name="export" class="btn btn-primary"> <i class="fa fa-file-excel-o" aria-hidden="true"></i> Exporter</button>
               </div>
           </form>
            </div>

<?php if($_SESSION['fonction']=='stock' || $_SESSION['fonction']=='admin'):?>
           <div class="col-md-8 col-xs-12 pull-right" style="text-align: right"><br/>

               <a href="#" id="modalaffactation" class="btn btn-primary">Affecter</a>
               <a href="#" id="modaltransfer" class="btn btn-primary">Transfer</a>
               <a href="#" id="returntoopentech" class="btn btn-primary">Débloquer</a>
               <a href="#" id="bloquer" class="btn btn-primary">Bloquer</a>
               <a href="<?php echo $url;?>/product/boitier"  class="btn btn-primary">Lister</a>

        </div>
<?php endif;?>
        </div>
        <div class="panel-body">
            <div class="col-md-4">
                <form role="form" method="post" action="">

                    <div class="col-md-4 col-lg-4 col-sm-12">
                        <select class="form-control" name="pagination" onchange="this.form.submit()">

                            <option value="20" <?php if($limit==20){ echo 'selected = "selected"';}?>>20</option>
                            <option value="30" <?php if($limit==30){ echo 'selected = "selected"';}?>>30</option>
                            <option value="50" <?php if($limit==50){ echo 'selected = "selected"';}?>>50</option>
                            <option value="100" <?php if($limit==100){ echo 'selected = "selected"';}?>>100</option>
                        </select>
                    </div>
                    <!--                    <input type="text" class="form-control" name="pagination" placeholder="pagination">-->

                </form>
            </div>
            <div class="col-md-2 pull-right" style="text-align: right;"><br/><br/>
                <h4> <?php
                    if($total_records>0){
                        echo ' Affiché  '.$limit*$p.' sur '. $total_records;
                    }else {
                        echo ' Affiché  0  sur '. $total_records;
                    }
                    ?></h4>
            </div>
          <table class="table-bordered table-responsive" id="liste">
            <thead>
              <tr>
                             
                <th class="text-center" style="width: 10%;"> IMEI </th>

                <th class="text-center" style="width: 10%;"> Fournisseur </th>
                <th class="text-center" style="width: 15%;"> Modèle </th>

                <th class="text-center" style="width: 10%;"> Date d'arrivée </th>
                  <th class="text-center" style="width: 10%;"> Ref commande </th>
                  <th class="text-center" style="width: 15%;"> Etat </th>

                  <th class="text-center" style="width: 10%;"> Installateur </th>
                  <th class="text-center" style="width: 10%;"> Matricule </th>
                  <th class="text-center" style="width: 10%;">SIM installé</th>

                <th class="text-center" style="width: 10%;"> Cocher </th>



              </tr>
            </thead>
            <tbody>
            <?php foreach($products as $product):?>

            <tr>
<!--                --><?php //if($product['status']=="0") ?>
                 <td class="text-center"><?php echo $product['imei_product']; ?> </td>

                <td class="text-center"> <?php echo $product['provider']; ?></td>
                <td class="text-center"> <?php echo $product['model']; ?></td>
                <td class="text-center"> <?php echo $product['date_arrived']; ?></td>
                <td class="text-center"> <?php echo $product['order_ref']; ?></td>
                <td class="text-center">   <?php  if($product['status']=="1"){
                        echo '<span style="padding: 0px !important;" class="alert alert-success">en stock</span>';
                    }elseif($product['status']=="2"){
                        echo '<span style="padding: 0px !important;" class="alert alert-warning">en stock personel</span>';
                    }  elseif($product['status'] == "0") {
                    echo '<span style="padding: 0px !important;" class="alert alert-info">Installé</span>';
                    }else{
                        echo '<span style="padding: 0px !important;" class="alert alert-danger">Bloqué</span>';
                    }?></td>




        <td class="text-center"><?php echo (!empty($product['first_name']))? $product['first_name']:'--'; ?> </td>
                <td class="text-center"><?php echo (!empty($product['imei_vehicle']))? $product['imei_vehicle']:'--'; ?> </td>
                <td class="text-center"><?php
                    if(!empty($product['imei_product_inverse'])){

                      echo  $product['imei_product_inverse'];
                    }
                    elseif (!empty($product['costumer_product']))
                    {
                        echo '<span class="alert-danger">'.$product['costumer_product'].'</span>';
                    }
                    else{
                        echo '--';
                    }
                    ?></td>


                <td class="text-center coche"><?php if($product['status']==1 || $product['status']==2 || $product['status']==3){?> <input type="checkbox" id="check<?php echo $product['id']; ?>" alt="<?php echo $product['status'];?>" title="<?php echo $product['first_name'] ;?>" name="<?php echo $product['personal_id'] ;?>" value="<?php echo $product['id']; ?>"><?php }?></td>



              </tr>
            <?php endforeach; ?>

            </tbody>
          </table>
            <?php
                if($p*$limit<$total_records) {
                    $next = $start_from + $limit;
                    $pagLink = "<div class='pagination pull-left'>" . $start_from . "-" . $next . "/" . $total_records . "</div><div class='pagination pull-right'><ul class='pagination'>";

                    // $pagLink = "<div class='pagination pull-right'><ul class='pagination'>";
                    if ($p > 1) {
                        $prec = $p - 1;
                        $pagLink .= "<li class='paginate_button'><a href='" . $url . "/product/boitier/" . $prec . "'>Précédent</a></li>";
                    }
                    for ($i = $p; $i <= $p + 5; $i++) {

                        if ($i == $p) {
                            $pagLink .= "<li class='paginate_button active'><a href='" . $url . "/product/boitier/" . $i . "'>" . $i . "</a></li>";

                        } else {
                            $pagLink .= "<li class='paginate_button'><a href='" . $url . "/product/boitier/" . $i . "'>" . $i . "</a></li>";
                        }

                        if ($i >= $total_pages) {
                            break;
                        }
                    };
                    if ($p * $limit < $total_records) {
                        $next = $p + 1;
                        //$url = "index.php?c=Patient&a=Afficher&page=" . $p + 1;
                        $pagLink .= "<li class='paginate_button'><a  href='" . $url . "/product/boitier/" . $next . "'>Suivant</a></li>";
                    }

                    echo $pagLink . "</ul></div>";
                }?>
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
                                <a title="product/affectationboitier" alt="affectationfrm" class="btn btn-primary btn-lg submitfrm" id="" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Patienter...">Valider</a>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
 


    <!-- Modal trnsfer enter persoan -->
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