
<?php

include ("layouts/header.php");?>


<div class="row">

    <div class="col-md-12">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Les installations par mois</h3>
            </div>
            <div class="box-body">
                <div class="chart">
                    <canvas id="mycanvas" style="height:250px"></canvas>
                    <select name="instalation" id="instalation">
                        <option value="">selectionner l'année</option>
                        <?php foreach($instalations as $instalation):?>
                            <option value="<?php echo $instalation["annee"] ?>" ><?php echo $instalation["annee"]; ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Les Sim les plus installés</h3>

            </div>
            <div class="box-body">
                <div class="chart">
                    <canvas id="canvas2" style="height:250px"></canvas>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Les boitiers les plus installés</h3>
            </div>
            <div class="box-body">
                <div class="chart">
                    <canvas id="canvas3" style="height:250px"></canvas>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Performance des installateurs</h3>
            </div>
            <div class="box-body">
                <div class="chart">
                    <canvas id="canvas4" style="height:250px"></canvas>
                    <select name="installateur" id="installateur">
                        <option value="">selectionner l'installateur</option>
                        <?php foreach($installateurs as $installateur):?>
                            <option value="<?php echo $installateur["id"] ?>" ><?php echo $installateur['first_name'].' '.$installateur['last_name']; ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>
            </div>
            <!-- /.box-body -->
        </div>


    </div>


</div>

<?php include ("layouts/footer.php");?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.js"></script>
<script src="<?php echo $url;?>/dist/js/utils.js"></script>
<script src="<?php echo $url;?>/dist/js/graphs.js"></script>
