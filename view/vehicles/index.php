<?php include ("layouts/header.php");?>
<div class="row">
     <div class="col-md-12">
         <div class="pull-left">
         <h3>La liste des véhicules</h3>
         </div>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">

         <div class="col-md-9 pull-left">
                <form id="filtre" name="filtre" role="form" method="post" action="vehicle" >
                    <div class="form-group col-md-3">
                        <label class="control-label">Matricule</label>
                        <input type="text" class="form-control" name="matricule_searsh" placeholder="Matricule">
                    </div>

                    <div class="form-group col-md-3">
                        <label class="control-label">client</label>

                        <select name="client" class="form-control chosen-select">
                            <option value="0">Veuillez selectionner un client</option>
                            <?php foreach($costumers as $customer):?>
                                <option value="<?php echo $customer["id"] ?>" ><?php echo $customer["name"] ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <br/>
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                </form>
          </div>
         <div class="pull-right">
           <a href="#" id="showmodal" class="btn btn-primary">Nouveau véhicule</a>
         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                               
                <th class="text-center" style="width: 10%;"> Matricule </th>
                <th class="text-center" style="width: 10%;"> Model </th>
                <th class="text-center" style="width: 10%;"> Client </th>
                <th class="text-center" style="width: 10%;"> Actions </th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($vehicles as $vehicle):?>
               <tr>
                <td class="text-center"> <?php echo $vehicle['imei']; ?> </td>
                 <td class="text-center"> <?php echo $vehicle['model']; ?> </td>
                <td class="text-center"> <?php echo $vehicle['name']; ?></td>
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
                    <h4 class="modal-title" id="myModalLabel">Créer véhicule</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success" style="display: none">
                        <strong>Success!</strong> Le véhicule a été crée avec succés.
                    </div>
                    <div class="alert alert-danger" style="display: none">
                        <strong>Danger!</strong>Erreure a été se produit.
                    </div>
                    <form id="addvehicle" class="form-horizontal" role="form" method="POST">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Matricule</label>
                            <div class="col-md-6">
                                <input type="text" name="vehicle_imei" id="vehicle_imei" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Model</label>
                            <div class="col-md-6">
                                <input type="text" name="vehicle_model" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Client</label>
                            <div class="col-md-6">
                                <select name="costumer_id" class="form-control chosen-select" id="costumer_id">
                                    <option value="">Veuillez selectionner un client</option>
                                    <?php foreach($costumers as $costumer):?>
                                        <option value="<?php echo $costumer['id'];?>"><?php echo $costumer['name'];?></option>

                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4 pull-right">
                                <a title="vehicle/add" alt="addvehicle" class="btn btn-primary btn-lg submitfrm" id="" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Patienter...">Valider</a>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
<?php include ("layouts/footer.php");?>