     <div class="row">
     <div class="col-md-12">
       
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <div class="pull-left">
           <h3>La liste des véhicules</h3>
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
               <tr>
                <td class="text-center"> </td>
                 <td class="text-center"> </td>
                <td class="text-center"> </td>
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

                    <form id="addvehicule" class="form-horizontal" role="form" method="POST" action="#">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Matricule</label>
                            <div class="col-md-6">
                                <input type="text" name="vehicle_imei" class="form-control">
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
                            <select name="costumer_id" class="form-control">
                                <option>client1</option>
                                <option>client2</option>
                            </select>
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