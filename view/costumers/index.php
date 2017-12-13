     <div class="row">
     <div class="col-md-12">
       
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <div class="pull-left">
           <h3>La liste des clients</h3>
         </div>

         <div class="pull-right">
           <a href="#" id="showmodal" class="btn btn-primary">Nouveau client</a>
         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                               
                <th class="text-center" style="width: 10%;"> Nom </th>
                <th class="text-center" style="width: 10%;"> Type </th>
                <th class="text-center" style="width: 10%;"> Telèphone </th>
                <th class="text-center" style="width: 10%;"> Ville </th>
                <th class="text-center" style="width: 10%;"> Département </th>
                <th class="text-center" style="width: 10%;"> Nombre d'installation </th>
                <th class="text-center" style="width: 10%;"> Actions </th>
              </tr>
            </thead>
            <tbody>
               <tr>
                <td class="text-center"> </td>
                 <td class="text-center"> </td>
                <td class="text-center"> </td>
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
                    <h4 class="modal-title" id="myModalLabel">Créer le client</h4>
                </div>
                <div class="modal-body">

                    <form id="formRegister" class="form-horizontal" role="form" method="POST" action="{{ url('register') }}">
                         <div class="form-group">
                            <label class="col-md-4 control-label">Nom</label>
                            <div class="col-md-6">
                                <input type="text" name="costumerName" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Télèphone</label>
                            <div class="col-md-6">
                                <input type="text" name="costumer_name" class="form-control">
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
                                <input type="text" name="costumer_city" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Département</label>
                            <div class="col-md-6">
                                <input type="text" name="costumer_departement" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Adresse</label>
                            <div class="col-md-6">
                                <input type="text" name="costumer_adresse" class="form-control">
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