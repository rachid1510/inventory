<?php include "layouts/header.php"; ?>


<!-- Left side column. contains the logo and sidebar -->


<!-- Content Wrapper. Contains page content -->


<section class="content">
    <div class="row">
  <?php  if ($handle = opendir('docs')) {

    while (false !== ($entry = readdir($handle))) {

    if ($entry != "." && $entry != "..") {?>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner" style="text-align: center">
                    <h3><i class="fa fa-file-pdf-o" aria-hidden="true"></i></h3>

                    <p><?php  echo "$entry";?></p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="<?php echo $url.'/docs/'.$entry;?>" target="_blank" class="small-box-footer">Télécharger <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

   <?php }
    }

    closedir($handle);
    }?>

        <!-- ./col -->
    </div>
    <!-- /.row -->
    <!-- Main row -->

    <!-- /.row (main row) -->

</section>
<!-- /.content -->



<!-- /.content-wrapper -->


<?php
include "layouts/footer.php"; ?>
