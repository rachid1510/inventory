$(document).ready(function() {
    var color = Chart.helpers.color;

    $("#instalation").change(function() {
        $.ajax({

            url: "dashboard/Getinstallation",
            method: "POST",
            dataType: 'json',
            data: {instalation: $(this).val()},
            success: function (data) {

                var date = [];
                var count = [];
                //console.log(data[0].playerid);
                $.each(data, function (key, value) {

                    console.log(value);

                    //   console.log(key+'  '+value.playerid);
                    // console.log(key);
                    date.push("le mois " + value.mois);


                    count.push(value.nombre);


                });

                // }
                // for(var i in data) {
                //     // console.log(data.playerid);
                //     // console.log(data[i]);
                //
                //     player.push("Player " + data[i].playerid);
                //     score.push(data[i].score);
                // }
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
            }
        });
    })
    $.ajax({
        url: "dashboard/GetSim",
        method: "GET",
        dataType: 'json',
        success: function (data) {

            var date = [];
            var count = [];
            //console.log(data[0].playerid);
            $.each(data, function (key, value) {

                //   console.log(key+'  '+value.playerid);
                // console.log(key);


                date.push("model " + value.model);


                count.push(value.nombre);


            });

            var ctx2 = $("#canvas2");
            var config = {
                type: 'pie',
                data: {
                    datasets: [{
                        data: count,
                        backgroundColor: [
                            window.chartColors.red,
                            window.chartColors.orange,
                            window.chartColors.yellow,
                            window.chartColors.blue,
                            window.chartColors.grey,


                        ],
                        label: 'Dataset 1'
                    }],
                    labels: date
                },
                options: {
                    responsive: true
                }
            };
            var myLineChart2 = new Chart(ctx2, config);


        }//succes fermeture


    });

    $.ajax({
        url: "dashboard/Getboitier",
        method: "GET",
        dataType: 'json',
        success: function (data) {

            var date = [];
            var count = [];
            //console.log(data[0].playerid);
            $.each(data, function (key, value) {


                date.push("model " + value.model);


                count.push(value.nombre);


            });

            var ctx3 = $("#canvas3");
            var config = {
                type: 'pie',
                data: {
                    datasets: [{
                        data: count,
                        backgroundColor: [
                            window.chartColors.red,
                            window.chartColors.orange,
                            window.chartColors.yellow,
                            window.chartColors.blue,
                            window.chartColors.grey,


                        ],
                        label: 'Dataset 1'
                    }],
                    labels: date
                },
                options: {
                    responsive: true
                }
            };
            var myLineChart3 = new Chart(ctx3, config);


        }//succes fermeture


    });
    $("#installateur").change(function(){
        $.ajax({
            url: "dashboard/Performance",
            method: "POST",
            dataType: 'json',
            data:{id:$(this).val()},
            success: function (data) {
            console.log(data);
                var date = [];
                var count = [];
                //console.log(data[0].playerid);
                $.each(data, function (key, value) {


                    console.log(value);
                    date.push("le mois " + value.mois);


                    count.push(value.nombre);


                });
                var ctx4 = $("#canvas4");
                var myLineChart4 = new Chart(ctx4, {
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

            }


        });



    });

});