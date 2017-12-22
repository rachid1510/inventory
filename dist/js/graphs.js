$(document).ready(function(){


    $.ajax({
        url: "dashboard/getdata",
        method: "GET",
        dataType:'json',
        success: function(data) {
            console.log(data);
            var date = [];
            var count = [];
            //console.log(data[0].playerid);
            $.each(data,function(key,value) {

                //   console.log(key+'  '+value.playerid);
                // console.log(key);
                console.log(value);

                date.push("le mois " + value.mois);

                count.push(value.nombre);


            });
            console.log(count);
            // }
            // for(var i in data) {
            //     // console.log(data.playerid);
            //     // console.log(data[i]);
            //
            //     player.push("Player " + data[i].playerid);
            //     score.push(data[i].score);
            // }
            var ctx2 = $("#canvas1");
            var ctx = $("#mycanvas");
            var myLineChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: date,
                    datasets: [
                        {
                            label: "le nombre d'installation par mois",
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "rgba(75,192,192,0.4)",
                            borderColor: "rgba(75,192,192,1)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "rgba(75,192,192,1)",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(75,192,192,1)",
                            pointHoverBorderColor: "rgba(220,220,220,1)",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: count,
                            spanGaps: false,
                        }

                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
            // var chartdata = {
            //     labels: player,
            //     datasets : [
            //         {
            //             label: 'Player Score',
            //             backgroundColor: 'rgba(200, 200, 200, 0.75)',
            //             borderColor: 'rgba(200, 200, 200, 0.75)',
            //             hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
            //             hoverBorderColor: 'rgba(200, 200, 200, 1)',
            //             data: score
            //         }
            //     ]
            // };




        }


    });
    $.ajax({
        url: "Dashboard/getdata",
        method: "GET",
        dataType:'json',
        success: function(data) {
           console.log(data);
            var date = [];
            var count = [];
            //console.log(data[0].playerid);
            $.each(data,function(key,value) {

                //   console.log(key+'  '+value.playerid);
                // console.log(key);
                console.log(value);

                date.push("le mois " + value.mois);

                count.push(value.nombre);


            });
            console.log(count);
            // }
            // for(var i in data) {
            //     // console.log(data.playerid);
            //     // console.log(data[i]);
            //
            //     player.push("Player " + data[i].playerid);
            //     score.push(data[i].score);
            // }
            var ctx2 = $("#canvas1");
            var ctx = $("#mycanvas");
            var myLineChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: date,
                    datasets: [
                        {
                            label: "le nombre d'installation par mois",
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "rgba(75,192,192,0.4)",
                            borderColor: "rgba(75,192,192,1)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "rgba(75,192,192,1)",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(75,192,192,1)",
                            pointHoverBorderColor: "rgba(220,220,220,1)",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: count,
                            spanGaps: false,
                        }

                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
            // var chartdata = {
            //     labels: player,
            //     datasets : [
            //         {
            //             label: 'Player Score',
            //             backgroundColor: 'rgba(200, 200, 200, 0.75)',
            //             borderColor: 'rgba(200, 200, 200, 0.75)',
            //             hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
            //             hoverBorderColor: 'rgba(200, 200, 200, 1)',
            //             data: score
            //         }
            //     ]
            // };

//fms fleet management system g1939 g1708


        }


    });
});