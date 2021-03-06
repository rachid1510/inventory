<?php /**
 * include head
 */
include ("layouts/header.php");?>
<div class="row">
    <div class="col-md-12">
        <div class="pull-left">
            <h3>La liste des Installateurs</h3>
        </div>
    </div>
    <div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
        </div>
            <div class="panel-body">
                <form role="form" method="post" action="">
                    <div class="form-group col-md-3">
                        <label class="control-label">Pagination</label>
                        <input type="text" class="form-control" name="pagination" placeholder="pagination">
                    </div>
                    <div class="form-group col-md-2"><br/>
                        <button type="submit" class="invisible">Appliquer</button>
                    </div>
                </form>
                <table class="table table-bordered">
                    <thead>
                    <tr>

                        <th class="text-center" style="width: 10%;"> Prénom </th>
                        <th class="text-center" style="width: 10%;"> Nom </th>
                        <th class="text-center" style="width: 10%;"> Telèphone </th>
                        <th class="text-center" style="width: 10%;"> Details </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($installateurs as $installateur):?>

                        <tr>
                            <td class="text-center"> <?php echo $installateur['first_name']; ?></td>
                            <td class="text-center"> <?php echo $installateur['last_name']; ?> </td>
                            <td class="text-center"> <?php echo $installateur['phone_number']; ?> </td>

                            <td class="text-center">

                                    <a href="personal/details/<?php echo $installateur['id'];?>" class="btn btn-danger btn-xs"  title="Details" data-toggle="tooltip">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>


<?php include ("layouts/footer.php");?>