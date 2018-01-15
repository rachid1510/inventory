<?php /**
 * include head
 */
include ("layouts/header.php");?>
<div class="row">
     <div class="col-md-12">
         <div class="pull-left">
             <h3>La liste des utilisateurs</h3>
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

         <div class="pull-right col-md-3"><br>

           <a href="#" id="showmodal" class="btn btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i> Nouveau utilisateur</a>
         </div>
        </div>
        <div class="panel-body">


          <table class="table table-bordered" id="liste">
            <thead>
              <tr>
                  <th class="text-center" style="width: 10%;"> # </th>
                 <th class="text-center" style="width: 10%;"> Nom d'utilisateur </th>
                  <th class="text-center" style="width: 10%;"> E-mail </th>
                 <th class="text-center" style="width: 10%;"> Fonction </th>
                  <th class="text-center" style="width: 10%;"> Etat </th>
                <th class="text-center" style="width: 10%;"> Actions </th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($users as $user):?>

            <tr>
                <td class="text-center">  <?php echo $user['id']; ?></td>
                <td class="text-center">  <?php echo $user['name']; ?></td>
                 <td class="text-center"> <?php echo $user['email']; ?> </td>
                <td class="text-center"> <?php echo $user['fonction']; ?> </td>
                <td class="text-center"> <?php echo ($user['disabled']==0)?'<a onclick="disableduser('.$user['id'].')"><span class="alert alert-danger" style="padding: 3px;cursor: pointer">Désactiver</span></a>':'<a onclick="enableduser('.$user['id'].')"><span class="alert alert-success" style="padding: 3px;cursor: pointer">Activer</span></a>'; ?> </td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="#" onclick="javascript:update_user(<?php echo $user['id'];?>)" class="btn btn-info btn-xs"  title="Edit" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <!--<a href="#" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>-->
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

 <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Créer l'utilisateur</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success" style="display: none">
                        <strong>Success!</strong> L 'utilisateur a été crée avec succés.
                    </div>
                    <div class="alert alert-danger" style="display: none">
                        <strong>Danger!</strong>Erreure a été se produit.
                    </div>
                    <form id="adduser" class="form-horizontal" role="form" method="POST">
                         <div class="form-group has-error">
                            <label class="col-md-4 control-label">Nom d'utilisateur</label>
                            <div class="col-md-6">
                                <input type="text" name="user_name" id="user_name" class="form-control required" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Mot de passe</label>
                            <div class="col-md-6">
                                <input type="password" name="user_passe" id="user_passe" class="form-control">
                            </div>
                        </div>



                         <div class="form-group">
                            <label class="col-md-4 control-label">Rôle</label>
                            <div class="col-md-6">
                             <select name="user_role" id="user_role" class="form-control">
                                 <option value="admin">Admin</option>
                                 <option value="technique">Technique</option>
                                 <option value="stock">Stock</option>
                                 <option value="installateur">Installateur</option>
                             </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">E-mail</label>
                            <div class="col-md-6">
                                <input type="text" name="user_mail" id="user_mail" class="form-control">
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4 pull-right">
                                <input type="hidden" name="id_user" value="" id="id_user">
                                <a title="user/add" alt="adduser" class="btn btn-primary btn-lg submitfrm" id="user_form_submit" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Patienter...">Valider</a>


                                <!--<button type="submit" class="btn btn-primary">
                                    Valider
                                </button>-->
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
<?php include ("layouts/footer.php");?>