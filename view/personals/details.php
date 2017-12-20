<?php /**
 * include head
 */
include ("layouts/header.php");?>
    <div class="row">
        <div class="col-md-12">
            <div class="pull-left">
                <h3> Details conçernant l'installateur</h3>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>

                                <th class="text-center" style="width: 10%;"> Installateur </th>
                                <th class="text-center" style="width: 10%;"> Status </th>
                                <th class="text-center" style="width: 10%;"> Date de reception de produit </th>
                                <th class="text-center" style="width: 10%;"> Imei </th>
                                <th class="text-center" style="width: 10%;"> label </th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($details as $detail):?>

                                    <tr>
                                        <td class="text-center"> <?php  echo $detail['personal_name']; ?></td>
                                        <td class="text-center"> <?php  echo $detail['status']; ?> </td>
                                        <td class="text-center"> <?php  echo $detail['created_at']; ?> </td>
                                        <td class="text-center"> <?php  echo $detail['imei_product']; ?> </td>
                                        <td class="text-center"> <?php  echo $detail['label']; ?> </td>

<!--                                        <td class="text-center">-->
<!---->
<!--                                            <a href="details" class="btn btn-danger btn-xs"  title="Details" data-toggle="tooltip">-->
<!--                                                <span class="glyphicon glyphicon-plus"></span>-->
<!--                                            </a>-->
<!--                                        </td>-->
                                    </tr>
                                    <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include ("layouts/footer.php");?>