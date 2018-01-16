<?php

include "layouts/header.php"; ?>

<div class="row">
    <div class="col-md-12">
        <h3>Modification d'intervention</h3>
    </div>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <form id="filtre" name="filtre" role="form" method="post" action="" enctype="multipart/form-data">
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
                    <input type="hidden" id="id_intervention_fk" value="<?php echo $interventions[0]["id"] ;?>">
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

                        <label><?php echo $interventions[0]["starthour"] ;?></label>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Heure fin</label>

                        <label><?php echo $interventions[0]["endhour"] ;?></label>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Durée</label>

                        <label><?php
                            echo "calcul de l'heure";
//                            $date= $interventions[0]["starthour"]->diff( $interventions[0]["endhour"]); ?>
                        </label>

                    </div>
<!--                    <div class="form-group col-md-2">-->
<!--                        <label class="control-label">kilometrage</label>-->
<!---->
<!--                        <input type="text" class="form-control" name="kilometrage">-->
<!---->
<!--                    </div>-->



                    <br/>
                    <br/>

                    <div class="form-group col-md-4 pull-right">
                    <a href="#" id="intervention_update" name="modifier" class="btn btn-primary">Modifier</a>
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
                    <div class="modal fade" id="modalinterventionupdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Modification d'intervention</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-success" style="display: none">
                                        <strong>Success!</strong> les modifications ont été fait avec succés.
                                    </div>
                                    <div class="alert alert-danger" style="display: none">
                                        <strong>Danger!</strong>Erreure.
                                    </div>
                                    <form id="interventionupdate" class="form-horizontal" role="form" method="POST"  enctype="multipart/form-data" action="../update_intervention">

                                        <div class="form-group" id="nombreproduct" style="">
                                            <label class="col-md-4 control-label">Heure début</label>
                                            <div class="col-md-6">
                                                <input type="time" class="form-control" name="starthour" id="starthour">

                                            </div>
                                        </div>

                                        <div class="form-group" id="nombreproduct" style="">
                                            <label class="col-md-4 control-label">Heure fin</label>
                                            <div class="col-md-6">
                                                <input type="time" class="form-control" name="endhour" id="endhour">

                                            </div>
                                        </div>


                                        <div class="form-group" id="nombreproduct" style="">
                                            <label class="col-md-4 control-label">Durée</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="duree" id="duree">

                                            </div>
                                        </div>
                                        <div class="form-group import_file">
                                            <label class="col-md-4 control-label">Importer l'intervention</label>
                                            <div class="col-md-6">
                                                <input type="file" class="form-control" value="Upload Intervention" name="fileToUpload"/>

                                            </div>
                                        </div>

                                        <input type="hidden" id="id" name="id" value="<?php echo $interventions[0]["id"] ;?>">
                                        <div class="form-group">

                                            <div class="col-md-6 col-md-offset-4 pull-right">
                                                <!--                                <a title="intervention/exporter" alt="exportintervention" class="btn btn-primary btn-lg submitfrm" id="" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Patienter...">Valider</a>-->
                                                <input type="button" onclick="update_intervention(<?php echo $interventions[0]["id"] ;?>)"  value="valider" class="btn btn-primary btn-lg"/>

                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </div>
        </div>
</div>




<?php
include "layouts/footer.php"; ?>
