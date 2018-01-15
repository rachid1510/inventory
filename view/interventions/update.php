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
                        <label class="control-label">date</label> <br/><label><?php echo $interventions[0]["intervened_at"] ;?></label>
<!--                        <input type="date" class="form-control datePicker" name="instervened_at">-->
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Client</label>
                        <br/><label><?php echo $interventions[0]["costumer"] ;?></label>
                    </div>
                    <?php  if($_SESSION['fonction']!='installateur'):?>
                        <div class="form-group col-md-2">
                            <label class="control-label">Installateur</label>
                            <label><?php echo $interventions[0]["personnal_name"] ;?></label>
                        </div>
                    <?php endif;?>
                    <div class="form-group col-md-2">
                        <label class="control-label">Heure début</label>

                        <input type="time" class="form-control" name="starthour">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Heure fin</label>

                        <input type="time" class="form-control" name="endhour">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Durée</label>

                        <input type="text" class="form-control" name="duree" id="duree">

                    </div>
<!--                    <div class="form-group col-md-2">-->
<!--                        <label class="control-label">kilometrage</label>-->
<!---->
<!--                        <input type="text" class="form-control" name="kilometrage">-->
<!---->
<!--                    </div>-->



                    <br/>
                    <div class="form-group col-md-4 pull-right">
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                    <button type="submit" name="export" class="btn btn-primary">Exporter </button>
                        <input type="button" class="btn btn-primary" onclick="Add()" value="Nouvelle ligne" /></td>

                    </div>

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
            <th class="text-center" style="width: 10%;"> Ime boitier </th>
            <th class="text-center" style="width: 10%;"> Imei carte </th>
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
                    <input type="radio"  name="type<?php echo $intervention['id'];?>" <?php echo ($intervention['type']=="i")? "checked":''?>  value="I"> I
                    <input type="radio" name="type<?php echo $intervention['id'];?>" <?php echo ($intervention['type']=='v')? "checked":''?> value="V"> V
                    <input type="radio" name="type<?php echo $intervention['id'];?>" <?php echo ($intervention['type']=='d')? "checked":''?> value="D"> D
                    <input type="radio" name="type<?php echo $intervention['id'];?>" <?php echo ($intervention['type']=='r')? "checked":''?> value="R"> R

                     </td>
                <td>
                    <select name="vehicule<?php echo $intervention['id'];?>" id="vehicule<?php echo $intervention['id'];?>" class="form-control">
                        <option value="">Veuillez selectionner un vehicule</option>
                        <?php foreach($vehicles as $vehicle):
                            if($intervention["id_vehicule"]==$vehicle["id"]):?>
                             <option selected="selected" value="<?php echo $vehicle["id"] ?>" ><?php echo $vehicle['imei']; ?></option>

                            <?php else: ?>
                            <option value="<?php echo $vehicle["id"] ?>" ><?php echo $vehicle['imei']; ?></option>
                        <?php endif;
                        endforeach; ?>

                    </select>
                </td>
                <td>
                <select name="boitier<?php echo $intervention['id'];?>" id="boitier<?php echo $intervention['id'];?>" class="form-control">
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
                    <select name="sim<?php echo $intervention['id'];?>" id="sim<?php echo $intervention['id'];?>" class="form-control">
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

               <input type="hidden" name="id_intervention<?php echo $intervention['id'];?>" id="id_intervention<?php echo $intervention['id'];?>" value="<?php echo $intervention['id']; ?>" />

                <td><input type="number" name="kilometrage<?php echo $intervention['id'];?>" id="kilometrage<?php echo $intervention['id'];?>" value="<?php echo $intervention['kilometrage']; ?>" /></td>
                <td><input type="text" name="remarque<?php echo $intervention['id'];?>" id="remarque<?php echo $intervention['id'];?>" value="<?php echo $intervention['remarque']; ?>" /></td>

                <td><input type="button" class="btn btn-primary" onclick="update(<?php echo $intervention['id'];?>)" value="Valider" />

                    <input type="button" class="btn btn-primary remove" onclick="Delete(this,<?php echo $intervention['id'];?>)" value="Supprimer" /></td>

            </tr>
        <?php

        endforeach;

        ?>

        </tbody>

    </table>
                </div>
        </div>
        </div>
        </div>
</div>




<?php
include "layouts/footer.php"; ?>
