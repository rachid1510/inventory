

function Add() {
    var $tr    = $("#tblCustomers").find("tr").last(); //$(this).closest('#tblCustomers>tr:last');
    var $clone = $tr.clone();
     $clone.find(':button').attr("onclick",'update(0)');
    $clone.find('select:eq(0)').attr("id",'vehicule0');
    $clone.find('select:eq(1)').attr("id",'boitier0');
    $clone.find('select:eq(2)').attr("id",'sim0');
    $clone.find('td:eq(0):radio').attr("name",'type0');
    $clone.find(':input[type="number"]').attr("id",'kilometrage0');
    $clone.find(':input[type="text"]').attr("id",'remarque0');
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
        data:{id_intervention:id,id_intervention_fk:id_intervention_fk,type:type,kilometrage:kilometrage,remarque:remarque,imei_boitier:boitier,imei_carte:sim,vehicule:vehicule},
        dataType:'json',
        success: function(resultat ) {
            console.log(resultat);
            if(resultat.msg == 'OK') {
                $(".alert.alert-success").show(0).delay(4000).hide(0);
                setTimeout(function(){
                    window.location.reload(1);
                }, 5000);

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
function AddRow(intervened_at,type, marque,matricule,kilometrage,remarque,boitier,sim,vehicule) {
    //Get the reference of the Table's TBODY element.
    var tBody = $("#tblCustomers > TBODY")[0];

    //Add Row.
     var row = tBody.insertRow(-1);

    cell = $(row.insertCell(-1));
    cell.append(vehicule);
    cell = $(row.insertCell(-1));
    cell.append(type);

    cell = $(row.insertCell(-1));
    cell.append(boitier);

    cell = $(row.insertCell(-1));
    cell.append(sim);

    cell = $(row.insertCell(-1));
    cell.append(kilometrage);

    cell = $(row.insertCell(-1));
    cell.append(remarque);

    //Add Button cell.
    cell = $(row.insertCell(-1));
    var btnRemove = $("<input class=\"btn btn-primary\"/>");
    btnRemove.attr("type", "button");
    btnRemove.attr("onclick", "Remove(this);");
    btnRemove.val("Remove");
    cell.append(btnRemove);
};

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