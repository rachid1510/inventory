<?php

include "layouts/header.php"; ?>

<div class="row">
    <div class="col-md-12">
        <h3>Modification d'intervention</h3>
    </div>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <form id="filtre" name="filtre" role="form" method="post" action="">
                    <?php
                    if (isset($error) && !empty($error)) : ?>
                        <div class="alert alert-warning">
                            <strong>Warning!</strong> veullez selectionner l'instalateur
                        </div>
                    <?php endif;
                    if (isset($error1) && !empty($error1)) : ?>
                        <div class="alert alert-warning">
                            <strong>Warning!</strong> veullez selectionner le cleint.
                        </div>
                    <?php endif; ?>
                    <div class="form-group col-md-2">
                        <label class="control-label">date</label>
                        <input type="date" class="form-control datePicker" name="instervened_at">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Marque</label>

                        <input type="text" class="form-control" name="marque">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Matricule</label>

                        <input type="text" class="form-control" name="matricule">

                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">kilometrage</label>

                        <input type="text" class="form-control" name="kilometrage">

                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label">Client</label>
                        <select name="costumer" class="form-control">
                            <option value="">selectionner un client</option>
                            <?php foreach($costumers as $customer):?>
                                <option value="<?php echo $customer["id"] ?>" ><?php echo $customer["name"] ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label">Installateur</label>
                        <select name="instalateur" class="form-control">
                            <option value="">selectionner un Installateur</option>
                            <?php foreach($installateurs as $instalateur):?>
                                <option value="<?php echo $instalateur["id"] ?>" ><?php echo $instalateur["first_name"].' '. $instalateur["last_name"] ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                    <br/>
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                    <button type="submit" name="export" class="btn btn-primary">Exporter </button>


                </form>


                <!-- /.box-body -->
            </div>
                <div class="panel-body">
                    <div class="alert alert-success" style="display: none">
                        <strong>Success!</strong> Intervention a été crée avec succés.
                    </div>
                    <div class="alert alert-danger" style="display: none">
                        <strong>Danger!</strong>Erreur.
                    </div>

     <table id="tblCustomers" class="table-responsive table-bordered">
        <thead>
        <tr>

            <th class="text-center" style="width: 10%;"> Type </th>
            <th class="text-center" style="width: 10%;"> Véhicule </th>
            <th class="text-center" style="width: 10%;"> Imei_boitier </th>
            <th class="text-center" style="width: 10%;"> Imei_carte </th>
            <th class="text-center" style="width: 10%;"> Kilometrage </th>
            <th class="text-center" style="width: 10%;"> Remarque </th>
            <th class="text-center" style="width: 10%;"> Modif </th>

        </tr>
        </thead>
        <tbody>
        <?php
        $i=0;
        foreach($interventions_details as $intervention):?>
            <tr>

                <td>
                    <input type="radio" name="type"  value="I"> I
                    <input type="radio" name="type" value="V"> V
                    <input type="radio" name="type" value="D"> D
                    <input type="radio" name="type" value="R"> R

                     </td>
                <td>
                    <select name="vehicule" id="vehicule" class="form-control">
                        <option value="">Veuillez selectionner un vehicule</option>
                        <?php foreach($vehicles as $vehicle):?>
                            <option value="<?php echo $vehicle["id"] ?>" ><?php echo $vehicle['imei']; ?></option>
                        <?php endforeach; ?>

                    </select>
                </td>
                <td>
                <select name="boitier" id="boitier" class="form-control">
                    <option value="">Veuillez selectionner un boitier</option>
                    <?php foreach($details_boxs as $details_box):
                        if($intervention["imei_boitier"]==$details_box["id"]):?>
                        <option selected="selected" value="<?php echo $details_box["id"] ?>" ><?php echo $details_box['imei_product']; ?></option>
                        <?php else: ?>
                        <option value="<?php echo $details_box["id"] ?>" ><?php echo $details_box['imei_product']; ?></option>
                    <?php endif;
                    endforeach; ?>

                </select>
                </td>
                <td>
                    <select name="sim" id="sim" class="form-control">
                        <option value="">Veuillez selectionner une carte sim</option>
                        <?php foreach($details_sims as $details_sim):
                            if($intervention["imei_carte"]==$details_sim["id"]):?>
                                    <option selected="selected" value="<?php echo $details_sim["id"] ?>" ><?php echo $details_sim['label']; ?></option>)
                          <?php else: ?>
                                <option value="<?php echo $details_sim["id"] ?>" ><?php echo $details_sim['label']; ?></option>
                          <?php  endif; ?>
                        <?php endforeach; ?>

                    </select>
                </td>

               <input type="hidden" name="id_intervention" id="id_intervention" value="<?php echo $intervention['id']; ?>" />

                <td><input type="text" name="kilometrage" id="kilometrage" value="<?php echo $intervention['kilometrage']; ?>" /></td>
                <td><input type="text" name="remarque" id="remarque" value="<?php echo $intervention['remarque']; ?>" /></td>

                <td><input type="button" class="btn btn-primary" onclick="Add(<?php echo $i;?>)" value="Valider" /></td>


            </tr>
        <?php
            $i++;
        endforeach; ?>

        </tbody>

    </table>
                </div>
        </div>
        </div>
        </div>
</div>




<?php
include "layouts/footer.php"; ?>
