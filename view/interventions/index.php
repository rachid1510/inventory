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
                    <div class="col-md-2 pull-right">
                        <button type="submit" class="btn btn-primary">Rechercher</button>
                        <button type="submit" name="export" class="btn btn-primary">Exporter </button>
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
            <th class="text-center" style="width: 10%;"> Type </th>
            <th class="text-center" style="width: 10%;"> Marque </th>
            <th class="text-center" style="width: 10%;"> Matricule </th>
            <th class="text-center" style="width: 10%;"> Kilometrage </th>
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
                <td class="text-center"> <?php echo $intervention['type']; ?> </td>
                <td class="text-center"> <?php echo $intervention['marque']; ?> </td>
                <td class="text-center"> <?php echo $intervention['matricule']; ?> </td>
                <td class="text-center"> <?php echo $intervention['kilometrage']; ?></td>
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

</div>



<?php
    include "layouts/footer.php"; ?>
