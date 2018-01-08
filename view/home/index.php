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
                                <h3><?php if(isset($boitiers[0]['nombre'])){ echo $boitiers[0]['nombre'];}else echo '0'; ?></h3>

                                <p>Boitier Installés</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3><?php if(isset($sims[0]['nombre'])){ echo $sims[0]['nombre'];} else echo '0'; ?></h3>

                                <p>Carte installés</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3><?php if(isset($boitiersbloqs[0]['nombre'])){ echo $boitiersbloqs[0]['nombre'];} else { echo '0';} ?></h3>

                                <p>boitier bloqués</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3><?php if(isset($simsbloqs[0]['nombre'])){ echo $simsbloqs[0]['nombre'];} else echo '0'; ?></h3>

                                <p>Carte  bloqués</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <div class="row">
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3><?php if(isset($boitiers[0]['nombre'])){ echo $boitiers[0]['nombre'];} else echo '0'; ?></h3>

                                <p>Total carte en stock Opentech</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="#" class="small-box-footer">  <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3><?php if(isset($sims[0]['nombre'])){ echo $sims[0]['nombre']; } else echo '0';?></h3>

                                <p>Total Boitier en stock Opentech</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
<!--                    <!-- ./col -->
<!--                    <div class="col-lg-3 col-xs-6">-->
<!--                        <!-- small box -->
<!--                        <div class="small-box bg-yellow">-->
<!--                            <div class="inner">-->
<!--                                <h3>--><?php //echo $boitiersbloqs[0]['nombre']; ?><!--</h3>-->
<!---->
<!--                                <p>Total Boitier en stock Personnel</p>-->
<!--                            </div>-->
<!--                            <div class="icon">-->
<!--                                <i class="ion ion-person-add"></i>-->
<!--                            </div>-->
<!--                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <!-- ./col -->
<!--                    <div class="col-lg-3 col-xs-6">-->
<!--                        <!-- small box -->
<!--                        <div class="small-box bg-red">-->
<!--                            <div class="inner">-->
<!--                                <h3>--><?php //echo $simsbloqs[0]['nombre']; ?><!--</h3>-->
<!---->
<!--                                <p>Total Carte en stock Personnel</p>-->
<!--                            </div>-->
<!--                            <div class="icon">-->
<!--                                <i class="ion ion-pie-graph"></i>-->
<!--                            </div>-->
<!--                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <!-- ./col -->
<!--                </div>-->
                <!-- /.row -->
                <!-- Main row -->

                <!-- /.row (main row) -->

            </section>
            <!-- /.content -->



        <!-- /.content-wrapper -->


<?php
    include "layouts/footer.php"; ?>
