<?php /**
 * include head
 */
include ("layouts/header.php");?>
     <div class="row">
     <div class="col-md-12">
       
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <div class="pull-left">
           <h3>La liste des Commandes</h3>
         </div>

         <div class="pull-right">
           <a   id="showmodal" class="btn btn-primary">Créer une Commande</a>
         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered" id="liste">
            <thead>
              <tr>
                               
                <th class="text-center" style="width: 10%;"> Ref commande </th>
                <th class="text-center" style="width: 10%;"> Date arrivée </th>
                <th class="text-center" style="width: 10%;"> Fournisseur </th>
                <th class="text-center" style="width: 10%;"> Plan </th>
                <th class="text-center" style="width: 10%;"> Quantité </th>
                 <th class="text-center" style="width: 10%;"> Observation </th>
                <th class="text-center" style="width: 100px;"> Actions </th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($movements as $movement):?>
               <tr>
                <td class="text-center"><?php echo $movement['order_ref'];?>  </td>
                <td class="text-center"><?php echo $movement['date_arrived'];?>  </td>
                <td class="text-center"><?php echo $movement['provider'];?></td>
                <td class="text-center"><?php echo $movement['plan'];?> </td>
                <td class="text-center"><?php echo $movement['quantity'];?></td>
                <td class="text-center"><?php echo $movement['observtion'];?> </td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="#" onclick="javascript:update_movement(<?php echo $movement['id'];?>)" class="btn btn-info btn-xs"  title="Edit" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                   <!-- <a href="#" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>-->
                    </a>
                  </div>
                </td>
              </tr>
              <?php endforeach;?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>



 <!-- Modal create -->
    <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Créer Mouvement</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success" style="display: none">
                        <strong>Success!</strong> La commande a été ajouter avec succès.
                    </div>
                    <div class="alert alert-danger" style="display: none">
                        <strong>Danger!</strong> Error:la commande n'a pas été ajouter
                    </div>
                    <form id="addmovement" class="form-horizontal" role="form" enctype="multipart/form-data"  method="POST" >

                        <div class="form-group">
                            <label class="col-md-4 control-label">Catégorie</label>
                            <div class="col-md-6">
                                <select name="category" class="form-control" id="category">
                                    <option value="">Veuillez selectionner une catégorie</option>
                                    <option value="1">Boitier</option>
                                    <option value="2">Carte SIM</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Ref commande</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="order_id" id="order_id">
                                <small class="help-block"></small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Fournisseur</label>
                            <div class="col-md-6">
                                <select name="provider" class="form-control" id="provider">
                                  <option>Four1</option>
                                  <option>Four2</option>
                                </select>
                            </div>
                        </div>


                         <div class="form-group">
                            <label class="col-md-4 control-label">PLAN/model</label>
                            <div class="col-md-6">
                               <input type="text" class="form-control" name="plan" id="plan">
                                <small class="help-block"></small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">QUANTITE</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="quantite" id="quantite">
                                <small class="help-block"></small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Date arrivée</label>
                            <div class="col-md-6">
                                <input type="date"  class="form-control datePicker" name="date_arrived" id="date_arrived">
                                <small class="help-block"></small>
                            </div>
                        </div>

                       <div class="form-group import_file">
                            <label class="col-md-4 control-label">Importer fichier</label>
                            <div class="col-md-6">
                               <input type="file" class="form-control" name="upload" id="" required>

                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4 pull-right">
                                <a title="movement/add" alt="addmovement" class="btn btn-primary btn-lg submitfrm" id="id_movement_form_submit" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Patienter...">Valider</a>
                                <input type="hidden" name="id_movement" value="" id="id_movement">
                               <!-- <button   id="" type="submit" class="btn btn-primary">
                                    submit
                                </button>-->
                                <!--<button id="submitfrm" title="movement/add" class="btn btn-primary btn-lg" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Patienter...">
                                     Valider
                                </button>-->
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


<?php include ("layouts/footer.php");?>
<script src="<?php echo $url;?>/dist/js/movement.js"></script>
