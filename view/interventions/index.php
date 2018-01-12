<?php
include "layouts/header.php"; ?>
<div class="row">
    <div class="col-md-12">
        <h3>La liste des interventions</h3>
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
                        <input type="date" class="form-control" name="instervened_at">
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


                    <br/>
                    <div class="col-md-2 pull-right">
                        <button type="submit" class="btn btn-primary">Rechercher</button>

                    </div>

                </form>
                <a href="#" id="export_intervention" class="btn btn-primary">Exporter</a>


            <!-- /.box-body -->
        </div>
    <div class="panel-body">
        <div class="col-md-4">
            <form role="form" method="post" action="">

                <div class="col-md-4 col-lg-4 col-sm-12">
                    <select class="form-control" name="pagination" onchange="this.form.submit()">

                        <option value="20" <?php if($limit==20){ echo 'selected = "selected"';}?>>20</option>
                        <option value="30" <?php if($limit==30){ echo 'selected = "selected"';}?>>30</option>
                        <option value="50" <?php if($limit==50){ echo 'selected = "selected"';}?>>50</option>
                        <option value="100" <?php if($limit==100){ echo 'selected = "selected"';}?>>100</option>
                    </select>
                </div>
                <!--                    <input type="text" class="form-control" name="pagination" placeholder="pagination">-->

            </form>
        </div>
    <table class="table table-bordered" id="liste">
        <thead>
        <tr>
            <th class="text-center" style="width: 10%;"> Ref d'intervention </th>
            <th class="text-center" style="width: 10%;"> Date d'intervention </th>
            <th class="text-center" style="width: 10%;"> Intervenant </th>
            <th class="text-center" style="width: 10%;"> client </th>
<!--            <th class="text-center" style="width: 10%;"> Type </th>-->
            <th class="text-center" style="width: 10%;"> Remarque </th>
            <th class="text-center" style="width: 10%;"> Modification d'interevention </th>

        </tr>
        </thead>
        <tbody>
        <?php foreach($interventions as $intervention):?>
            <tr>
                <td class="text-center"> <?php echo 'FI'.$intervention['id']; ?> </td>
                <td class="text-center"> <?php echo $intervention['intervened_at']; ?> </td>
                <td class="text-center"> <?php echo $intervention['personnal_name']; ?> </td>
                <td class="text-center"> <?php echo $intervention['name']; ?> </td>
<!--                <td class="text-center"> --><?php //echo $intervention['type']; ?><!-- </td>-->
                <th class="text-center"> <?php echo $intervention['remarque']; ?></th>

                <td class="text-center">
                    <div class="btn-group">
                        <a href="<?php echo $url;?>/intervention/edit/<?php echo $intervention['id']; ?>"  class="btn btn-info btn-xs"  title="Edit" data-toggle="tooltip">
                            <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        <!--  <a href="#" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
                            <span class="glyphicon glyphicon-trash"></span>
                          </a>-->
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
        <?php
        $next=  $start_from+$limit;
        $pagLink = "<div class='pagination pull-right'><ul class='pagination'>";
        if($p>1)
        {
            $prec= $p - 1;
            $pagLink .= "<li class='paginate_button'><a href='".$url."/intervention/index/".$prec."'>Précédent</a></li>";
        }
        for ($i=$p; $i<=$p+5; $i++) {

            if($i==$p)
            {
                $pagLink .= "<li class='paginate_button active'><a href='".$url."/intervention/index/".$i."'>".$i."</a></li>";

            }
            else
            {
                $pagLink .= "<li class='paginate_button'><a href='".$url."/intervention/index/".$i."'>".$i."</a></li>";
            }

            if($i>=$total_pages)
            {
                break;
            }
        };
        if($p<$total_records)
        {
            $next= $p + 1;
            //$url = "index.php?c=Patient&a=Afficher&page=" . $p + 1;
            $pagLink .= "<li class='paginate_button'><a  href='".$url."/intervention/index/".$next."'>Suivant</a></li>";
        }

        echo $pagLink . "</ul></div>"; ?>
    </div>
    </div>
    </div>

    <div class="modal fade" id="modalinterventionexporter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">L'Affectation des boîtiers aux personnels</h4>
                </div>
                <div class="modal-body">
<!--                    <div class="alert alert-success" style="display: none">-->
<!--                        <strong>Success!</strong> l'affectation avec succés.-->
<!--                    </div>-->
<!--                    <div class="alert alert-danger" style="display: none">-->
<!--                        <strong>Danger!</strong>Erreure a été se produit.-->
<!--                    </div>-->
                    <form id="exportintervention" class="form-horizontal" role="form" method="POST" action="intervention/exporter">

                        <div class="form-group">
                            <label class="col-md-4 control-label">date</label>
                            <div class="col-md-6">
                              <input type="date" class="form-control datePicker" name="instervened_at">
                            </div>
                        </div>

                        <div class="form-group" id="nombreproduct" style="">
                            <label class="col-md-4 control-label">Nombre à exporter</label>
                            <div class="col-md-6">
                                <input type="text" name="personalproduct" id="personalproduct"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Client</label>
                            <div class="col-md-6">
                            <select name="costumer" class="form-control chosen-select">
                                <option value="">selectionner un client</option>
                                <?php foreach($costumers as $customer):?>
                                    <option value="<?php echo $customer["id"] ?>" ><?php echo $customer["name"] ?></option>
                                <?php endforeach; ?>

                            </select>
                            </div>
                        </div>
                        <div class="form-group">

                            <label class="col-md-4 control-label">Installateur</label>
                            <div class="col-md-6">

                                <select name="instalateur" class="form-control chosen-select">
                                    <option value="">selectionner un Installateur</option>
                                    <?php foreach($installateurs as $instalateur):?>
                                        <option value="<?php echo $instalateur["id"] ?>" ><?php echo $instalateur["first_name"].' '. $instalateur["last_name"] ?></option>
                                    <?php endforeach; ?>

                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="products" id="products" value="">
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4 pull-right">
<!--                                <a title="intervention/exporter" alt="exportintervention" class="btn btn-primary btn-lg submitfrm" id="" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Patienter...">Valider</a>-->
                             <input type="submit" value="valider" class="btn btn-primary btn-lg"/>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>



<?php
    include "layouts/footer.php"; ?>
