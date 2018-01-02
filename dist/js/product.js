$(document).ready(function() {
    var list_sim_checked=[];
$("#returntoopentech").click(function(){
    $('#liste').find('input[type="checkbox"]:checked').each(function () {

        if($(this).attr("alt")!=3){
            alert("L'un des produits selectionnés ne peut pas étre retourner");
            return false;
        }
        else{
            list_sim_checked.push($(this).val());
        }

    });

    if(list_sim_checked.length==0)
    {
        alert("Merci de couche les produits à retourner");
    }
    else{
        var data={product:list_sim_checked};
        console.log(url+'/product/returntoopentech');
        $.ajax( {
            type: "POST",
            url: url+'/product/returntoopentech',
            data:data,
            dataType:'json',
            success: function(resultat ) {
                console.log(resultat);
                if(resultat.msg='OK') {
                 alert('Les produits ont étés retournés');
                }
            },
            error:function(e)
            {
                console.log(e);
            }
        });
    }
});
});