

function Add() {
    AddRow($("#type").clone(),$("#kilometrage").clone(),$("#remarque").clone(), $("#boitier").clone(), $("#sim").clone(),$("#vehicule").clone());
    var id= $("#id_intervention").val();
    var type= $("#type").val();
    var kilometrage= $("#kilometrage").val();
    var remarque= $("#remarque").val();
    var boitier= $("#boitier").val();
    var sim= $("#sim").val();
    var vehicule= $("#vehicule").val();

};

function AddRow(type,kilometrage,remarque,boitier,sim,vehicule) {
    //Get the reference of the Table's TBODY element.
    var tBody = $("#tblCustomers > TBODY")[0];

    //Add Row.
     var row = tBody.insertRow(-1);

    var cell = $(row.insertCell(-1));
    cell.append(type);

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

    var btnAdd = $("<input class=\"btn btn-primary\"/>");
    btnAdd.attr("type", "button");
    btnAdd.attr("onclick", "Add(this);");
    btnAdd.val("Add");
    cell.append(btnAdd);

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