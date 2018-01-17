<?php
include "layouts/header.php"; ?>
<div class="row">
    <div class="col-md-12">
        <h3>La liste des interventions</h3>
    </div>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <div class="alert alert-warning validation" style="display: none">
                    <strong>Warning!</strong> L'intervention a été validé.
                </div>
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
                        <label class="control-label">Numèro</label>

                        <input type="text" class="form-control" name="numero" placeholder="152">
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
               <?php  if($_SESSION['fonction']!='installateur'):?>
                    <div class="form-group col-md-2">
                        <label class="control-label">Installateur</label>
                        <select name="instalateur" class="form-control">
                            <option value="">selectionner un Installateur</option>
                            <?php foreach($installateurs as $instalateur):?>
                                <option value="<?php echo $instalateur["id"] ?>" ><?php echo $instalateur["first_name"].' '. $instalateur["last_name"] ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                    <?php endif;?>

                    <div class="form-group col-md-2">
                        <label class="control-label">Status</label>
                        <select name="status" class="form-control">
                                <option value="">selectionner le Status</option>
                                <option value="En cours">En cours</option>
                                <option value="Terminée">Terminée</option>
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label">Validation</label>
                        <select name="validation" class="form-control">
                            <option value="">selectionner l'état</option>
                            <option value="1">Validé</option>
                            <option value="0">Non Validé</option>
                        </select>
                    </div>

                    <br/>
                    <div class="col-md-2 pull-right">
                        <button type="submit" class="btn btn-primary">Rechercher</button>
                        <a href="#" id="export_intervention" class="btn btn-primary">Exporter</a>
                    </div>


                </form>





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
            <th class="text-center" style="width: 10%;"> Etat </th>
            <th class="text-center" style="width: 10%;"> Validation de responsable </th>
            <th class="text-center" style="width: 10%;"> Modification d'interevention </th>

        </tr>
        </thead>
        <tbody>
        <?php foreach($interventions as $intervention):?>
            <tr>
                <td class="text-center"> <?php $phpdate = strtotime( $intervention['intervened_at'] ); echo 'FI'.date( 'ymd',$phpdate).'-'.$intervention['personnal_id'].'-'.$intervention['id']; ?> </td>
                <td class="text-center"> <?php echo $intervention['intervened_at']; ?> </td>
                <td class="text-center"> <?php echo $intervention['personnal_name']; ?> </td>
                <td class="text-center"> <?php echo $intervention['name']; ?> </td>

                <td class="text-center"> <?php echo $intervention['status']; ?> </td>
                <td class="text-center"> <?php echo ($intervention['validation_resp']=='0')? 'Non Validée':'Validée'; ?>

                </td>


                <td class="">
                    <div class="btn-group">
                        <a href="<?php echo $url;?>/intervention/edit/<?php echo $intervention['id']; ?>"  class="btn btn-info btn-xs"  title="Edit" data-toggle="tooltip">
                            <span class="glyphicon glyphicon-edit"></span>
                        </a>
                       <?php  if($intervention['upload']!=''):?>
                         <a href="<?php echo $url.'/uploads/'.$intervention['upload'];?>" target="_blank" class="btn btn-xs" style="    margin-left: 4px;"  title="Voir la validation client" data-toggle="tooltip">
                            <span class="glyphicon glyphicon-download-alt"></span>
                          </a>
                     <?php endif;?>
                <?php  if($intervention['validation_resp']=='0' && $_SESSION['fonction']=='technique'):?>


                        <a href="#" class="btn btn-success btn-xs" style="    margin-left: 4px;"  onclick="checked_responsable(<?php echo $intervention['id']; ?>)" title="Validation de responsable" data-toggle="tooltip">
                            <span class="glyphicon glyphicon-ok"></span>
                        </a>
                        <?php endif;?>
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
                        <div class="alert alert-success" style="display: none">
                            <strong>Success!</strong> l'affectation avec succés.
                        </div>
                        <div class="alert alert-danger" style="display: none">
                            <strong>Danger!</strong>Erreure a été se produit.
                        </div>
                    <form id="exportintervention" class="form-horizontal" role="form" method="POST" action="intervention/exporter">

                        <div class="form-group">
                            <label class="col-md-4 control-label">date</label>
                            <div class="col-md-6">
                              <input type="date" class="form-control datePicker" name="instervened_at">
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

                                <select name="instalateur" id="instalateur" class="form-control chosen-select">
                                    <option value="">selectionner un Installateur</option>
                                    <?php  foreach($installateurs as $instalateur):
                                       if($_SESSION['fonction']=='installateur'):

                                          if($_SESSION['user_id']==$instalateur["id"]):

                                              ?>
                                              <option selected="selected" value="<?php echo $instalateur["id"] ?>" ><?php echo $instalateur["first_name"].' '. $instalateur["last_name"] ?></option>
                                       <?php endif;

                                       else:?>
                                            <option value="<?php echo $instalateur["id"] ?>" ><?php echo $instalateur["first_name"].' '. $instalateur["last_name"] ?></option>
                                      <?php endif; ?>

                                    <?php endforeach; ?>

                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="nombreproduct" style="">
                            <label class="col-md-4 control-label">Nombre à exporter</label>
                            <div class="col-md-6">
                                <input type="text" name="personalproduct" id="personalproduct"/>
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
