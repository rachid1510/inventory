
<?php

include ("layouts/header.php");?>


<div class="row">

    <div class="col-md-12">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">les installations par mois</h3>
            </div>
            <div class="box-body">
                <div class="chart">
                    <canvas id="mycanvas"></canvas>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">les boitiers les plus installés</h3>

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
                <h3 class="box-title">les Sim les plus installés</h3>
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
                </div>
            </div>
            <!-- /.box-body -->
        </div>


    </div>


</div>

<?php include ("layouts/footer.php");?>
