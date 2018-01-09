$(document).ready(function() {
    var list_sim_checked=[];
$("#returntoopentech").click(function(){
    $('#liste').find('input[type="checkbox"]:checked').each(function () {

        if($(this).attr("alt")==1){
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
                    location.reload();
                }
            },
            error:function(e)
            {
                console.log(e);
            }
        });
    }
});

    $("#bloquer").click(function(){
        list_product_checked=[];
        $('#liste').find('input[type="checkbox"]:checked').each(function () {

            if($(this).attr("alt")==3){
                alert("L'un des produits selectionnés est dèjà bloqué");
                return false;
            }
            else{
                list_product_checked.push($(this).val());
            }

        });

        if(list_product_checked.length==0)
        {
            alert("Merci de couche les produits à bloquer");
        }
        else{

            var data={product:list_product_checked};
            $.ajax( {
                type: "POST",
                url: url+'/product/blockedProduct',
                data:data,
                dataType:'json',
                success: function(resultat ) {
                    console.log(resultat);
                    if(resultat.msg='OK') {
                        alert('Les produits ont étés bloqués');
                        location.reload();
                    }
                }
                ,error:function(e)
                {
                    console.log(e);
                }
            });
        }
    });

    $('#actevationfrm').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });
});