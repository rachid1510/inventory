

            <div class="row">
                <div class="col-md-12">
                    <h3>La liste des installations</h3>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading clearfix">


                            <div class="col-md-9 pull-left">
                                <form>
                                    <div class="form-group col-md-4">
                                        <label class="control-label">date</label>
                                        <input type="date" class="form-control datePicker" name="imei" placeholder="IMEI">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="control-label">client</label>
                                        <select name="installeur" class="form-control">
                                            <option>ACHRAF</option>
                                            <option>Zakaria</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="control-label">Matricule</label>
                                        <select name="installeur" class="form-control">
                                            <option>97961631649</option>
                                            <option>65464694616</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <br>
                            <div class="col-md-3 pull-right">
                                <a href="#" class="btn btn-primary">Filtrer</a>
                                <a href="#" id="showmodal" class="btn btn-primary">Créer installation</a>

                            </div>
                        </div>
                        <div class="panel-body">

                            <table class="table table-bordered">
                                <thead>
                                <tr>

                                    <th class="text-center" style="width: 10%;"> Date d'installation </th>
                                    <th class="text-center" style="width: 10%;"> Installateur</th>
                                    <th class="text-center" style="width: 10%;"> Client </th>
                                    <th class="text-center" style="width: 10%;"> Matricule </th>
                                    <th class="text-center" style="width: 10%;"> Observation </th>
                                    <th class="text-center" style="width: 10%;"> Carte Sim </th>
                                    <th class="text-center" style="width: 10%;"> Boitier </th>
                                    <th class="text-center" style="width: 10%;"> Modification d'installation </th>
                                </tr>
                                </thead>
                                <tbody>
                                        <?php echo $html;
                                            ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content ">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel">Créer une Installation</h4>
                        </div>
                        <div class="modal-body">

                            <form id="addinstallation" class="form-horizontal" role="form" method="POST" action="installation/add">


                                <div class="form-group">
                                    <label class="col-md-4 control-label">Date D'installation</label>
                                    <div class="col-md-6">
                                        <input type="date"  class="form-control datePicker" name="date_installed">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Installateur</label>
                                    <div class="col-md-6">
                                        <select name="installeur" class="form-control">
                                            <option>ACHRAF</option>
                                            <option>Zakaria</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-md-4 control-label">Client</label>
                                    <div class="col-md-6">
                                        <select name="client" class="form-control">
                                            <option>client1</option>
                                            <option>client2</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Matricule</label>
                                    <div class="col-md-6">
                                        <select name="vehicule_id" class="form-control">
                                            <option>véhicule1</option>
                                            <option>véhicule2</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                        <legend class="scheduler-border">Boitier</legend>
                                        <label>Imei</label>
                                        <select name="imei" class="form-control">
                                            <option>1216464416</option>
                                            <option>1216464646</option>
                                        </select>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" id="gps_client_check" type="checkbox" value="" style="display: inline-block;">
                                                Boitier client
                                            </label>
                                        </div>
                                        <div id="autoUpdate1" style="display: none;">
                                            <label>Imei</label>
                                            <input type="text" class="form-control" name="imei">
                                            <label>Marque</label>
                                            <input type="text" class="form-control" name="Marque">

                                        </div>


                                    </div>


                                    <div class="col-md-6">
                                        <legend class="scheduler-border">SIM</legend>
                                        <label>gsm</label>
                                        <select name="gsm" class="form-control">
                                            <option>1216464416</option>
                                            <option>1216464646</option>
                                        </select>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" id="sim_client_check" type="checkbox" value="" style="display: inline-block;">
                                                Sim client
                                            </label>
                                        </div>
                                        <div id="autoUpdate2" style="display: none;">
                                            <label>gsm</label>
                                            <input type="text" class="form-control" name="gsm">
                                            <label>Opérateur</label>
                                            <input type="text" class="form-control" name="operateur">
                                        </div>
                                    </div>

                                </div>




                                <div class="form-group">
                                    <label name="obser">Observation</label>
                                    <textarea class="form-control" id="observation" rows="3"></textarea>
                                </div>


                                <div class="form-group">
                                    <div class="col-md-3 col-md-offset-3 pull-right">
                                        <button id="submitfrm" type="submit" class="btn btn-primary">
                                            Valider
                                        </button>
                                        <button type="reset" class="btn btn-primary">
                                            Annuler
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>



   <!--  <div class="row">
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

 <!-- Modal
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
    </div>-->