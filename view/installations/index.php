<?php /**
 * include head
 */
include ("layouts/header.php");?>

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
                                        <select name="vehicle_id" class="form-control chosen-select">
                                            <option value="1">97961631649</option>
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
                                <tr>
                                    <td class="text-center"> </td>
                                    <td class="text-center"> </td>
                                    <td class="text-center"> </td>
                                    <td class="text-center"> </td>
                                    <td class="text-center"> </td>
                                    <td class="text-center"> </td>
                                    <td class="text-center"> </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-info btn-xs" title="Edit" data-toggle="tooltip">
                                                <span class="glyphicon glyphicon-edit"></span>
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
            <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content ">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel">Créer Installation</h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-success" style="display: none">
                                <strong>Success!</strong> Installation a été crée avec succés.
                            </div>
                            <div class="alert alert-danger" style="display: none">
                                <strong>Danger!</strong>Erreure a été se produit.
                            </div>
                            <form id="addinstallation" class="form-horizontal" role="form"   method="POST" action="installation/add">


                            <div class="form-group">
                                    <label class="col-md-4 control-label">Date D'installation</label>
                                    <div class="col-md-6">
                                        <input type="date"  class="form-control datePicker" name="date_installation">
                                    </div>
                            </div>

                            <div class="form-group">
                                    <label class="col-md-4 control-label">Installateur</label>
                                    <div class="col-md-6">
                                        <select name="personal_id" class="form-control">
                                            <option value="1">SALAH</option>
                                            <option value="2">Zakaria</option>
                                        </select>
                                    </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Status</label>
                                <div class="col-md-6">
                                <label class="form-check-label">
                                    <input checked class="form-check-input" id="status" type="checkbox" value="">
                                    Installation terminée
                                </label>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-md-4 control-label">Client</label>
                                    <div class="col-md-6">
                                        <input type="text" title="selected_costmer" autocomplete="off" class="form-control search_input"   list="costumers" id="textrecherche"  placeholder="Rechercher Client..."/>
                                        <input type="hidden" id="selected_costmer"/>
                                        <datalist id="costumers" class="data_list">
                                            <select name="costumer" class="form-control" id="costumer">
                                                <?php foreach($costumers as $costumer):?>
                                                <option data-value="<?php echo $costumer['id'];?>"><?php echo $costumer['name'];?></option>

                                                <?php endforeach; ?>
                                            </select>
                                        </datalist>
                                    </div>
                                </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Véhicule</label>
                                <div class="col-md-6">
                                    <input type="text" autocomplete="off" title="selected_vehicle" class="form-control search_input"   list="vehicle_ids" id="textrecherche"  placeholder="Rechercher matricule..."/>
                                    <input type="hidden" name="selected_vehicle" id="selected_vehicle"/>
                                    <datalist id="vehicle_ids" class="data_list" >
                                        <select name="vehicle_id" class="form-control" id="vehicle_id">
                                            <?php foreach($vehicles as $vehicle):?>
                                                <option data-value="<?php echo $vehicle['id'];?>"><?php echo $vehicle['imei'];?></option>

                                            <?php endforeach; ?>
                                        </select>
                                    </datalist>
                                </div>
                            </div>
                            <div class="row">

                                    <div class="col-md-6">
                                        <legend class="scheduler-border">Boitier</legend>
                                        <label>Imei</label><label class="pull-right" style="color:red" id="typebox">Type:</label>
                                        <input type="text" autocomplete="off" title="selected_box" class="form-control search_input"   list="boitiers" id="textrecherche"  placeholder="Rechercher imei boitier..."/>

                                        <input type="hidden" name="selected_box" id="selected_box"/>
                                        <datalist id="boitiers" class="data_list" >
                                        <select name="imei_boitier" class="form-control" id="imei_boitier" >
                                            <?php foreach($boitiers as $box):?>
                                                <option data-value="<?php echo $box['id'];?>" title="<?php echo $box['label'];?>"><?php echo $box['imei_product'];?></option>

                                            <?php endforeach; ?>

                                        </select>
                                        </datalist>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" id="gps_client_check" name="gps_client_check" type="checkbox" value="" style="display: inline-block;">
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
                                        <label class="pull-right" style="color:red" id="typecard">Type:</label>
                                        <input type="text" autocomplete="off" title="selected_card"  class="form-control search_input" list="cartes_sim" id="textrecherche"  placeholder="Rechercher ssid sim..."/>
                                        <input type="hidden" name="selected_card" id="selected_card" value=""/>
                                        <datalist id="cartes_sim" class="data_list" >
                                        <select name="imei_gsm" class="form-control" id="imei_gsm" >
                                            <?php foreach($cartes as $c):?>
                                                <option data-value="<?php echo $c['id'];?>" title="<?php echo $c['imei_product'];?>"><?php echo $c['label'];?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        </datalist>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" id="sim_client_check" name="sim_client_check" type="checkbox" value="" style="display: inline-block;">
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
                                    <label for="exampleTextarea">Observation</label>
                                    <textarea class="form-control" id="observation" rows="3"></textarea>
                                </div>
                            <div class="form-group">
                                    <div class="col-md-3 col-md-offset-3 pull-right">
                                        <a title="installation/add" class="btn btn-primary btn-lg" id="submitfrm" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Patienter...">Valider</a>

                                        <!--<button type="submit" class="btn btn-primary">
                                            Annuler
                                        </button>-->
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>


<?php include ("layouts/footer.php");?>