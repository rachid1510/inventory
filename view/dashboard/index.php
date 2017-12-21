 <?php
//
//
//$dsn = 'mysql:dbname=stock;host=127.0.0.1';
//$user = 'root';
//$password = '';
//try {
//    $pdo = new PDO($dsn, $user, $password);
//} catch (PDOException $e) {
//    echo 'Connexion échouée : ' . $e->getMessage();
//}
////$sql="SELECT i.*,v.imei,c.name,CONCAT( p.first_name,' ', p.last_name) AS personnal_name FROM installations i,costumers c,vehicles v,personals p WHERE  i.vehicle_id=v.id  and i.personal_id=p.id and v.costumer_id=c.id";
////SELECT i.*,v.imei,c.name,CONCAT( p.first_name,' ', p.last_name) AS personnal_name FROM installations i,costumers c,vehicles v,personals p WHERE  i.vehicle_id=v.id  and i.personal_id=p.id and v.costumer_id=c.id
//$sql="SELECT COUNT(*) nombre,MONTH(`installed_at`) mois FROM `installations` GROUP BY YEAR(`installed_at`), MONTH(`installed_at`)";
////$sql= "SELECT playerid, score FROM score ORDER BY playerid";
//$pre = $pdo->prepare($sql);
//$data = array();
//$result = array();
//$pre->execute();
//$result = $pre->fetchAll();
//echo json_encode($result);


include ("layouts/header.php");?>




    <!--    <div id="chart-container">-->
    <!--        <canvas id="mycanvas"></canvas>-->
    <!--    </div>-->

    <!-- javascript -->

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
                    <h3 class="box-title">Performance des installateurs</h3>

                </div>
                <div class="box-body">
                    <div class="chart">
                        <canvas id="canvas5" style="height:250px"></canvas>
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
                        <canvas id="canvas6" style="height:250px"></canvas>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>




        </div>





    </div>

<?php include ("layouts/footer.php");?>