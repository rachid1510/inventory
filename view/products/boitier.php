
     <div class="row">
     <div class="col-md-12">
        <div class="pull-left">
           <h3>La liste des boitiers</h3>
         </div>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">

          <div class="col-md-10 pull-left">
           <form>
            <div class="form-group col-md-4">
              <label class="control-label">IMEI</label>
             <input type="text" class="form-control" name="imei" placeholder="IMEI">
           </div>
             <div class="form-group col-md-4">
              <label class="control-label">Réf Commande</label>
             <input type="text" class="form-control" name="ref_order" placeholder="REF COMMANDE">
           </div>
             <div class="form-group col-md-4">
              <label class="control-label">Date arrivée</label>
             <input type="date" class="form-control" name="date_debut" placeholder="DATE ARRIVEE">
           </div>
           </form>
           </div>
        
           <div class="col-md-2 pull-right"><br/>
            <a href="#" id="filtrer" class="btn btn-primary">Filtrer</a>
          

         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                             
                <th class="text-center" style="width: 10%;"> IMEI </th>
                <th class="text-center" style="width: 10%;"> Numèro </th>
                <th class="text-center" style="width: 10%;"> Fournisseur </th>
                <th class="text-center" style="width: 10%;"> Modèle </th>
                <th class="text-center" style="width: 10%;"> Etat </th>
                <th class="text-center" style="width: 10%;"> Activer </th>
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