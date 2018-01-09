<?php include "layouts/header.php"; ?>


        <!-- Left side column. contains the logo and sidebar -->


        <!-- Content Wrapper. Contains page content -->


            <section class="content">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">

                                <h3><?php if (!empty($boitiers))
                                    echo $boitiers[0]['nombre'];
                                    else echo "0"; ?></h3>

<!--                                <p>Boitier Installés</p>-->
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="#" class="small-box-footer">Boitier Installés</a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">

                                <h3><?php if (!empty($sims))
                                    echo $sims[0]['nombre'];
                                    else echo  "0"?></h3>


<!--                                <p>Carte installés</p>-->
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer">Carte installés</a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-yellow">
                            <div class="inner">

                                <h3><?php if(!empty($boitiersbloqs))
                                     echo $boitiersbloqs[0]['nombre'];
                                     else echo "0";?></h3>


<!--                                <p>boitier bloqués</p>-->
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">boitier bloqués</a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-red">
                            <div class="inner">

                                <h3><?php if (!empty($simsbloqs))
                                    echo $simsbloqs[0]['nombre'];
                                    else echo "0"; ?></h3>


                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="#" class="small-box-footer">Carte  bloqués </a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <div class="row">
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-orange">
                            <div class="inner">

                                <h3><?php if (!empty($simsopentech))
                                    echo $simsopentech[0]['nombre'];
                                    else echo "0"; ?></h3>



                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>

                            <a href="#" class="small-box-footer">Total carte en stock Opentech</a>

                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-olive">
                            <div class="inner">

                                <h3><?php if (!empty($boitiersopentech))
                                    echo $boitiersopentech[0]['nombre'];
                                    else echo "0"; ?></h3>


                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer">Total Boitier en stock Opentech</a>
                        </div>
                    </div>

                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3><?php if (!empty($boitierspersonel))
                                    echo $boitierspersonel[0]['nombre'];
                                    else echo "0"; ?></h3>

                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">Total Boitier en stock Personnel</a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-blue">
                            <div class="inner">
                                <h3><?php if (!empty($simspersonel))
                                    echo $simspersonel[0]['nombre'];
                                    else echo "0"; ?></h3>

                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="#" class="small-box-footer">Total Carte en stock Personnel</a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>


            </section>
            <!-- /.content -->



        <!-- /.content-wrapper -->


<?php
    include "layouts/footer.php"; ?>
