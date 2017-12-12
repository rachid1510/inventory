

     <div class="row">
     <div class="col-md-12">
       
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <div class="pull-left">
           <h3>La liste des mouvements</h3>
         </div>

         <div class="pull-right">
           <a href="#" id="showmodal" class="btn btn-primary">Add New</a>
         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
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
                    <h4 class="modal-title" id="myModalLabel">Créer Installation</h4>
                </div>
                <div class="modal-body">

                    <form id="formRegister" class="form-horizontal" role="form" method="POST" action="{{ url('register') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label class="col-md-4 control-label">Date D'installation</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" name="date_arrived">                                <small class="help-block"></small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Installeur</label>
                            <div class="col-md-6">
                                <select name="installeur" class="form-control">
                                  <option>ACHRAF</option>
                                  <option>Zakaria</option>
                                </select>
                            </div>
                        </div>


                         <div class="form-group">
                            <label class="col-md-4 control-label">Client</label>
                             <select name="client" class="form-control">
                                 <option>client1</option>
                                 <option>client2</option>
                             </select>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Matricule</label>
                            <div class="col-md-6">

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