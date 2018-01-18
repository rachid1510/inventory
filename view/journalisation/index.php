<?php


include "layouts/header.php"; ?>

    <div class="row">
        <div class="col-md-12">
            <div class="pull-left">
                <h3>La Journalisation des transactions</h3>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <div class="col-md-9 pull-left">
                        <!--                <form id="filtre" name="filtre" role="form" method="post" action="" >-->
                        <!--                    <div class="form-group col-md-3">-->
                        <!--                        <label class="control-label">Nom</label>-->
                        <!--                        <input type="text" class="form-control" name="costumer_name" placeholder="Nom client">-->
                        <!--                    </div>-->
                        <!--                    <div class="form-group col-md-3">-->
                        <!--                        <label class="control-label">Télèphone</label>-->
                        <!--                        <input type="text" class="form-control" name="costumer_tel" placeholder="Télèphone">-->
                        <!--                    </div>-->
                        <!---->
                        <!---->
                        <!--<!--                    <a title="costumer/search" class="btn btn-primary">Rechercher</a>-->
                        <!--<!--                    <button type="button" class="btn btn-default">Rechercher</button>-->
                        <!--                    <br/>-->
                        <!--                    <button type="submit" class="btn btn-primary">Rechercher</button>-->
                        <!--                    <button type="submit" name="export" class="btn btn-primary"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exporter</button>-->
                        <!---->
                        <!--                </form>-->
                    </div>


                </div>
                <div class="panel-body">


                    <table class="table table-bordered" id="liste">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 10%;"> # </th>
                            <th class="text-center" style="width: 10%;"> Action </th>
                            <th class="text-center" style="width: 10%;"> user_id</th>
                            <th class="text-center" style="width: 10%;"> Fonction </th>

                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


<?php
include "layouts/footer.php"; ?>