

function Add() {

    var $tr    = $("#tblCustomers").find("tr").last(); //$(this).closest('#tblCustomers>tr:last');
    var $clone = $tr.clone();
     $clone.find(':button').attr("onclick",'save()');
    $clone.find('.remove:button').attr("onclick","Remove(this)");
    $tr.after($clone);

};

function update(id) {


   // var type= $("#type"+id).val();
    var type=$('input[name=type'+id+']:checked').val();

    var kilometrage= $("#kilometrage"+id).val();
    var remarque= $("#remarque"+id).val();
    var boitier= $("#boitier"+id).val();
    var sim= $("#sim"+id).val();
    var vehicule= $("#vehicule"+id).val();

    $.ajax({
        type: "POST",
        url: url+'/intervention/update',
        data:{id_intervention:id,type:type,kilometrage:kilometrage,remarque:remarque,imei_boitier:boitier,imei_carte:sim,vehicule:vehicule},
        dataType:'json',
        success: function(resultat ) {
            console.log(resultat);
            if(resultat.msg == 'OK') {
                $(".alert.alert-success").show(0).delay(4000).hide(0);


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