
function checked_change(check,id,todisplay,tohide){

    if($("#"+check+id).is(':checked'))
    {
        $("#"+todisplay+id).show();
        $("#"+tohide+id).hide();
        $("#"+tohide+id).val('');
    }
    else
    {
        $("#"+todisplay+id).hide();
        $("#"+tohide+id).show();
        $("#"+todisplay+id).val('');
    }


}
function Add() {

    var $tr    = $("#tblCustomers").find("tr").last(); //$(this).closest('#tblCustomers>tr:last');
    if($tr.attr("id")==0){ alert("Veuillez valider la première ligne avant d'ajouter une nouvelle !!"); return false;}
    var $clone = $tr.clone();
     $clone.find(':button').attr("onclick",'update(0)');
    $clone.find('select:eq(0)').attr("id",'vehicule0');
    $clone.find('select:eq(1)').attr("id",'boitier0');
    $clone.find('select:eq(2)').attr("id",'sim0');
    $clone.find(':input[type="number"]').attr("id",'kilometrage0');
    $clone.find(':input[type="text"]').attr("id",'remarque0');

    $clone.find('td').eq(0).html(parseInt($tr.find('td').eq(0).html())+1);

    $clone.find('td').eq(1).find('input:radio').attr("name",'type0');
    $clone.find('td').eq(2).find('input:checkbox').attr("id",'newvehicle0');
    $clone.find('td').eq(2).find('input:checkbox').attr("name",'newvehicle0');
    $clone.find('td').eq(2).find('label').attr("for",'newvehicle0');
    $clone.find('td').eq(2).find('input:checkbox').attr("onchange",'checked_change(\'newvehicle\',0,\'newvehicletext\',\'vehicule\')');
    $clone.find('td').eq(2).find('input:text').attr("id",'newvehicletext0');

    $clone.find('td').eq(3).find('input:radio').eq(0).attr("id",'boitieropentech0');
    $clone.find('td').eq(3).find('input:radio').eq(0).attr("name",'boitieropentech0');
    $clone.find('td').eq(3).find('label').eq(0).attr("for",'boitieropentech0');
    $clone.find('td').eq(3).find('input:radio').eq(0).attr("onchange",'checked_change(\'boitieropentech\',0,\'boitier\',\'boitierclt\')');
    $clone.find('td').eq(3).find('input:text').attr("id",'boitierclt0');

    $clone.find('td').eq(3).find('input:radio').eq(1).attr("id",'boitierclient0');
    $clone.find('td').eq(3).find('input:radio').eq(1).attr("name",'boitieropentech0');
    $clone.find('td').eq(3).find('label').eq(1).attr("for",'boitierclient0');
    $clone.find('td').eq(3).find('input:radio').eq(1).attr("onchange",'checked_change(\'boitierclient\',0,\'boitierclt\',\'boitier\')');

    $clone.find('td').eq(4).find('input:radio').eq(0).attr("id",'simopentech0');
    $clone.find('td').eq(4).find('input:radio').eq(0).attr("name",'simopentech0');
    $clone.find('td').eq(4).find('label').eq(0).attr("for",'simopentech0');
    $clone.find('td').eq(4).find('input:radio').eq(0).attr("onchange",'checked_change(\'simopentech\',0,\'sim\',\'simclt\')');
    $clone.find('td').eq(4).find('input:text').attr("id",'simclt0');

    $clone.find('td').eq(4).find('input:radio').eq(1).attr("id",'simcltcheck0');
    $clone.find('td').eq(4).find('input:radio').eq(1).attr("name",'simopentech0');
    $clone.find('td').eq(4).find('label').eq(1).attr("for",'simcltcheck0');
    $clone.find('td').eq(4).find('input:radio').eq(1).attr("onchange",'checked_change(\'simcltcheck\',0,\'simclt\',\'sim\')');








    $clone.find('.remove:button').attr("onclick","Remove(this)");
    $tr.after($clone);

};

function update(id) {


   // var type= $("#type"+id).val();
    var type=$('input[name=type'+id+']:checked').val();
    var id_intervention_fk= $("#id_intervention_fk").val();
    var kilometrage= $("#kilometrage"+id).val();
    var remarque= $("#remarque"+id).val();
    var boitier= $("#boitier"+id).val();
    var sim= $("#sim"+id).val();
    var vehicule= $("#vehicule"+id).val();
    var newvehicletext =$("#newvehicletext"+id).val();
    var boitierclt =$("#boitierclt"+id).val();
    var simclt =$("#simclt"+id).val();
    var costumer_id=$("#costumer_id").val();
    var personal_id=$("#personal_id").val();
    var intervention_date=$("#intervention_date").val();
    var data ={id_intervention:id,
        id_intervention_fk:id_intervention_fk,
        type:type,
        kilometrage:kilometrage,
        remarque:remarque,
        imei_boitier:boitier,
        imei_carte:sim,
        vehicule:vehicule,
        newvehicle:newvehicletext,
        boitierclt:boitierclt,
        simclt:simclt,
        costumer_id:costumer_id,
        personal_id:personal_id,
        intervention_date:intervention_date
    };
    console.log(data);
    if(type=='I') {
        if (boitier == '' && $('input[id=boitieropentech'+id+']').is(':checked')) {
            $(".alert.alert-danger").text("Veuillez sélectionner l'IMEI installé");
            $(".alert.alert-danger").show(0).delay(4000).hide(0);
            return false;
        }
        if (sim == '' && $('input[id=simopentech'+id+']').is(':checked')) {
            $(".alert.alert-danger").text("Veuillez sélectionner la carte GSM installée");
            $(".alert.alert-danger").show(0).delay(4000).hide(0);
            return false;
        }
    }

    if(type=='R') {
        if (boitier == '' && sim == '') {
            $(".alert.alert-danger").text("Veuillez sélectionner l'IMEI ou Numèro gsm reconfiguré");
            $(".alert.alert-danger").show(0).delay(4000).hide(0);
            return false;
        }
    }
    $.ajax({
        type: "POST",
        url: url+'/intervention/update',
        data:data,
        dataType:'json',
        success: function(resultat ) {
            console.log(resultat);
            if(resultat.msg == 'OK') {
                $(".alert.alert-success").show(0).delay(4000).hide(0);
                setTimeout(function(){
                    //window.location.reload(1);
                }, 4000);

            }else
            {
                $(".alert.alert-danger").html(resultat.msg);
                $(".alert.alert-danger").show(0).delay(4000).hide(0);

            }
        },
        error:function(e)
        {
            console.log(e);
        }

    })

}


function Remove(button) {
    //Determine the reference of the Row using the Button.
    var row = $(button).closest("TR");
    var name = $("TD", row).eq(0).html();


        //Get the reference of the Table.
        var table = $("#tblCustomers")[0];

        //Delete the Table row using it's Index.
        table.deleteRow(row[0].rowIndex);

};

function Delete(button,id)
{
        if (!confirm("Êtes-Vous sûr de vouloir supprimer cette ligne?")) {
         return false;
      }
       $.ajax({
        type: "POST",
        url: url+'/intervention/delete',
        data:{id:id},
        dataType:'json',
        success: function(resultat ) {
            console.log(resultat);
            if(resultat.msg == 'OK') {
                Remove(button)
                $(".alert.alert-success").show(0).delay(4000).hide(0);

                ;
            }else
            {
                $(".alert.alert-danger").html(resultat.msg);
                $(".alert.alert-danger").show(0).delay(4000).hide(0);

            }
        },
        error:function(e)
        {
            console.log(e);
        }

    })
}