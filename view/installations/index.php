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
                                <form role="form" method="post" action="installation">


                                    <div class="form-group col-md-4">
                                        <label class="control-label">date</label>
                                        <input type="date" class="form-control" name="installed_at" placeholder="IMEI">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="control-label">client</label>

                                        <select name="client" class="form-control">
                                            <?php foreach($costumers as $customer):?>
                                            <option value="<?php echo $customer["id"] ?>" ><?php echo $customer["name"] ?></option>
                                            <?php endforeach; ?>

                                        </select>

                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="control-label">Matricule</label>

                                        <select name="matricule" class="form-control chosen-select">
                                            <?php foreach($vehicles as $vehicle):?>

                                                 <option value="<?php echo $vehicle["id"] ?>"><?php echo $vehicle["imei"] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Rechercher</button>
                                </form>
                            </div>
                            <br>
                            <div class="col-md-3 pull-right">
                                <a href="#" id="showmodal" class="btn btn-primary">Créer installation</a>

                            </div>
                        </div>
                        <div class="panel-body">

                            <table class="table table-bordered" id="liste">
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

                                        <select name="personal_id" class="form-control chosen-select" id="personal_id">
                                            <option value="0">Veuillez selectionner un installateur</option>
                                            <?php foreach($personals as $persoanl):?>
                                                <option value="<?php echo $persoanl['id'];?>"><?php echo $persoanl['first_name']. ' '.$persoanl['last_name'];?></option>

                                            <?php endforeach; ?>
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

                                            <select name="selected_costmer" class="form-control chosen-select" id="selected_costmer">
                                                <option value="0">Veuillez selectionner un client</option>
                                                <?php foreach($costumers as $costumer):?>
                                                <option value="<?php echo $costumer['id'];?>"><?php echo $costumer['name'];?></option>

                                                <?php endforeach; ?>
                                            </select>

                                    </div>
                                </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Véhicule</label>
                                <div class="col-md-6">

                                        <select name="selected_vehicle" class="form-control chosen-select" id="selected_vehicle">
                                            <option value="0">Veuillez selectionner un matricule</option>
                                            <?php foreach($vehicles as $vehicle):?>
                                                <option value="<?php echo $vehicle['id'];?>"><?php echo $vehicle['imei'];?></option>

                                            <?php endforeach; ?>
                                        </select>

                                </div>
                            </div>
                            <div class="row">


                                    <div class="col-md-6">
                                        <legend class="scheduler-border">Boitier</legend>

                                        <label>Imei</label><label class="pull-right" style="color:red" id="typebox"></label>

                                        <select name="selected_box" class="form-control chosen-select" id="selected_box" >
                                            <option value="0">Veuillez selectionner un bôitier</option>
                                            <?php foreach($boitiers as $box):?>
                                                <option value="<?php echo $box['id'];?>" title="<?php echo $box['label'];?>"><?php echo $box['imei_product'];?></option>

                                            <?php endforeach; ?>

                                        </select>

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

                                        <label class="pull-right" style="color:red" id="typecard"></label>

                                        <select name="selected_card" class="form-control chosen-select" id="selected_card" >
                                            <option value="0">Veuillez selectionner une carte</option>
                                            <?php foreach($cartes as $c):?>
                                                <option value="<?php echo $c['id'];?>" title="<?php echo $c['imei_product'];?>"><?php echo $c['label'];?></option>
                                            <?php endforeach; ?>
                                        </select>

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


                                        <a title="installation/add" alt="addinstallation" class="btn btn-primary btn-lg submitfrm" id="" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Patienter...">Valider</a>

                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>


<?php include ("layouts/footer.php");?>