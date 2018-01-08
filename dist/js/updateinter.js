

function Add() {
    AddRow($("#id_intervention").val(),$("#intervened_at").val(),$("#type").val(), $("#marque").val(), $("#matricule").val(), $("#kilometrage").val(), $("#remarque").val());


};

function AddRow(id_intervention,intervened_at,type, marque,matricule,kilometrage,remarque) {
    //Get the reference of the Table's TBODY element.
    var tBody = $("#tblCustomers > TBODY")[0];

    //Add Row.
    row = tBody.insertRow(-1);
    var cell = $(row.insertCell(-1));
    cell.html(id_intervention);

    cell = $(row.insertCell(-1));
    cell.html(intervened_at);

    cell = $(row.insertCell(-1));
    cell.html(type);


    cell = $(row.insertCell(-1));
    cell.html(marque);

    cell = $(row.insertCell(-1));
    cell.html(matricule);

    cell = $(row.insertCell(-1));
    cell.html(kilometrage);

    cell = $(row.insertCell(-1));
    cell.html(remarque);

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