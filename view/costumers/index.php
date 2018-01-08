<?php /**
 * include head
 */
include ("layouts/header.php");?>
<div class="row">
     <div class="col-md-12">
         <div class="pull-left">
             <h3>La liste des Clients</h3>
         </div>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <div class="col-md-9 pull-left">
                <form id="filtre" name="filtre" role="form" method="post" action="" >
                    <div class="form-group col-md-3">
                        <label class="control-label">Nom</label>
                        <input type="text" class="form-control" name="costumer_name" placeholder="Nom client">
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Télèphone</label>
                        <input type="text" class="form-control" name="costumer_tel" placeholder="Télèphone">
                    </div>


<!--                    <a title="costumer/search" class="btn btn-primary">Rechercher</a>-->
<!--                    <button type="button" class="btn btn-default">Rechercher</button>-->
                    <br/>
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                    <button type="submit" name="export" class="btn btn-primary"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exporter</button>

                </form>
            </div>

         <div class="pull-right col-md-3"><br>

           <a href="#" id="showmodal" class="btn btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i> Nouveau client</a>
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
          <table class="table table-bordered" id="liste">
            <thead>
              <tr>
                               
                <th class="text-center" style="width: 10%;"> Nom </th>
                <th class="text-center" style="width: 10%;"> Type </th>
                  <th class="text-center" style="width: 10%;"> Mail </th>
                <th class="text-center" style="width: 10%;"> Telèphone </th>
                <th class="text-center" style="width: 10%;"> Ville </th>
                <th class="text-center" style="width: 10%;"> Département </th>

                <th class="text-center" style="width: 10%;"> Actions </th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($customers as $customer):?>

            <tr>
                <td class="text-center">  <?php echo $customer['name']; ?></td>
                 <td class="text-center"> <?php echo $customer['type']; ?> </td>
                <td class="text-center"> <?php echo $customer['mail']; ?> </td>
                <td class="text-center"> <?php echo $customer['phone_number']; ?> </td>
                <td class="text-center">  <?php echo $customer['city']; ?></td>
                <td class="text-center"> <?php echo $customer['departement']; ?> </td>

                <td class="text-center">
                  <div class="btn-group">
                    <a href="#" onclick="javascript:update_costumer(<?php echo $customer['id'];?>)" class="btn btn-info btn-xs"  title="Edit" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <!--<a href="#" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>-->
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
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
                    <h4 class="modal-title" id="myModalLabel">Créer le client</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success" style="display: none">
                        <strong>Success!</strong> Le client a été crée avec succés.
                    </div>
                    <div class="alert alert-danger" style="display: none">
                        <strong>Danger!</strong>Erreure a été se produit.
                    </div>
                    <form id="addcostumer" class="form-horizontal" role="form" method="POST">
                         <div class="form-group has-error">
                            <label class="col-md-4 control-label">Nom</label>
                            <div class="col-md-6">
                                <input type="text" name="costumer_name" id="costumer_name" class="form-control required" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Télèphone</label>
                            <div class="col-md-6">
                                <input type="text" name="costumer_phone" id="costumer_phone" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Mail</label>
                            <div class="col-md-6">
                                <input type="text" name="costumer_mail" id="costumer_mail" class="form-control">
                            </div>
                        </div>


                         <div class="form-group">
                            <label class="col-md-4 control-label">Type</label>
                            <div class="col-md-6">
                             <select name="costumer_type" class="form-control">
                                 <option>socièté</option>
                                 <option>Particulier</option>
                             </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Ville</label>
                            <div class="col-md-6">
                                <input type="text" name="costumer_city" id="costumer_city" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Département</label>
                            <div class="col-md-6">
                                <input type="text" name="costumer_departement" id="costumer_departement" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Adresse</label>
                            <div class="col-md-6">
                                <input type="text" id="costumer_adress" name="costumer_adress" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4 pull-right">
                                <input type="hidden" name="id_costumer" value="" id="id_costumer">
                                <a title="costumer/add" alt="addcostumer" class="btn btn-primary btn-lg submitfrm" id="costumer_form_submit" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Patienter...">Valider</a>


                                <!--<button type="submit" class="btn btn-primary">
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