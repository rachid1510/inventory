$(document).ready(function(){
    $.ajax({
        url: "http://localhost/inventory/view/dashboard/index.php",
        method: "GET",
        dataType:'json',
        success: function(data) {

            var player = [];
            var score = [];
            //console.log(data[0].playerid);
            $.each(data,function(key,value) {

             //   console.log(key+'  '+value.playerid);
                console.log(key);
                console.log(value.playerid);

                    player.push("Player " + value.playerid);

                    score.push(value.score);
                

            });
            // }
            // for(var i in data) {
            //     // console.log(data.playerid);
            //     // console.log(data[i]);
            //
            //     player.push("Player " + data[i].playerid);
            //     score.push(data[i].score);
            // }

            var chartdata = {
                labels: player,
                datasets : [
                    {
                        label: 'Player Score',
                        backgroundColor: 'rgba(200, 200, 200, 0.75)',
                        borderColor: 'rgba(200, 200, 200, 0.75)',
                        hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                        hoverBorderColor: 'rgba(200, 200, 200, 1)',
                        data: score
                    }
                ]
            };

            var ctx = $("#mycanvas");

            var barGraph = new Chart(ctx, {
                type: 'bar',
                data: chartdata
            });
        }

    });
});