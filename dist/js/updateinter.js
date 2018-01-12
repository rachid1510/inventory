

function Add(row) {
    AddRow($("#intervened_at").clone(),$("#type").clone(), $("#marque").clone(), $("#matricule").clone(), $("#kilometrage").clone(),$("#remarque").clone(), $("#boitier").clone(), $("#sim").clone(),$("#vehicule").clone());
    var id= $("#id_intervention").val()
    var intervened_at= $("#intervened_at").val();
    var type= $("#type").val();
    var marque= $("#marque").val();
    var kilometrage= $("#kilometrage").val();
    var remarque= $("#remarque").val();
    var boitier= $("#boitier").val();
    var sim= $("#sim").val();
    var vehicule= $("#vehicule").val();

    $.ajax({
        type: "POST",
        url: url+'/intervention/update',
        data:{id_intervention:id,intervened_at:intervened_at,type:type,marque:marque,kilometrage:kilometrage,remarque:remarque,imei_boitier:boitier,imei_carte:sim,vehicule:vehicule},
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

};

function AddRow(intervened_at,type, marque,matricule,kilometrage,remarque,boitier,sim,vehicule) {
    //Get the reference of the Table's TBODY element.
    var tBody = $("#tblCustomers > TBODY")[0];

    //Add Row.
     var row = tBody.insertRow(-1);

    var cell = $(row.insertCell(-1));
    cell.append(intervened_at);

    cell = $(row.insertCell(-1));
    cell.append(type);


    cell = $(row.insertCell(-1));
    cell.append(marque);

    cell = $(row.insertCell(-1));
    cell.append(matricule);

    cell = $(row.insertCell(-1));
    cell.append(kilometrage);

    cell = $(row.insertCell(-1));
    cell.append(remarque);

    cell = $(row.insertCell(-1));
    cell.append(boitier);

    cell = $(row.insertCell(-1));
    cell.append(sim);

    cell = $(row.insertCell(-1));
    cell.append(vehicule);
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
    if (confirm("Do you want to delete: " + name)) {

        //Get the reference of the Table.
        var table = $("#tblCustomers")[0];

        //Delete the Table row using it's Index.
        table.deleteRow(row[0].rowIndex);
    }
};