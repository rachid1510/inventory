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

 <table id="tblCustomers" class="table table-bordered" id="liste">
        <thead>
        <tr>
            <th class="text-center" style="width: 10%;"> Ref d'intervention </th>
            <th class="text-center" style="width: 10%;"> Date d'intervention </th>
            <th class="text-center" style="width: 10%;"> Type </th>
            <th class="text-center" style="width: 10%;"> Marque </th>
            <th class="text-center" style="width: 10%;"> Matricule </th>
            <th class="text-center" style="width: 10%;"> Kilometrage </th>
            <th class="text-center" style="width: 10%;"> Remarque </th>
            <th class="text-center" style="width: 10%;"> Modif </th>

        </tr>
        </thead>
        <tbody>
        </tbody>
    <tfoot>

    <?php foreach($interventions as $intervention):?>
        <tr>
        <td><input type="text" id="id_intervention" value="<?php echo 'FI'.$intervention['id']; ?>" /></td>
        <td><input type="date" id="intervened_at" value="<?php echo $intervention['intervened_at']; ?>" /> </td>
        <td><input type="text" id="type" value="<?php echo $intervention['type']; ?>" /> </td>
        <td><input type="text" id="marque" value="<?php echo $intervention['marque']; ?>" /></td>
        <td><input type="text" id="matricule" value="<?php echo $intervention['matricule']; ?>" /> </td>
        <td><input type="text" id="kilometrage" value="<?php echo $intervention['kilometrage']; ?>" /></td>
        <td><input type="text" id="remarque" value="<?php echo $intervention['remarque']; ?>" /></td>
        <td><input type="button" class="btn btn-primary" onclick="Add()" value="Add" /></td>

        </tr>
    <?php endforeach; ?>

    </tfoot>
</table>
                </div>
        </div>
        </div>
        </div>
</div>




<?php
include "layouts/footer.php"; ?>
