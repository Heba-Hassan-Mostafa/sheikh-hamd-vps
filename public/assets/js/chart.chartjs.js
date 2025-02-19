$(function() {
	'use strict';

    let labelsItems = [];
    let datasetItems = [];



     $.get('/api/chart/question_chart', { random_id: Math.random() }, function (data)
     {
        labelsItems = data.labels;

          let obj = data.datasets;
         $.each(obj, function (i, text)
         {
            const r = Math.round(Math.random() * 255);
            const g = Math.round(Math.random() * 255);
            const b = Math.round(Math.random() * 255);


     datasetItems.push({

                label                       : obj[i].name,
                lineTension                 : 0.3,
                backgroundColor             : "rgba("+ r +", "+ g +", "+ b +", 0.05)",
                borderColor                 : "rgba("+ r +", "+ g +", "+ b +", 1)",
                pointRadius                 : 3,
                pointBackgroundColor        : "rgba("+ r +", "+ g +", "+ b +", 1)",
                pointBorderColor            : "rgba("+ r +", "+ g +", "+ b +", 1)",
                pointHoverRadius            : 3,
                pointHoverBackgroundColor   : "rgba("+ r +", "+ g +", "+ b +", 1)",
                pointHoverBorderColor       : "rgba("+ r +", "+ g +", "+ b +", 1)",
                pointHitRadius              : 10,
                pointBorderWidth            : 2,
                data                        : obj[i].values,
        });


     });

	var ctx9 = document.getElementById('chartArea1');
	new Chart(ctx9, {
		type: 'line',
		data: {
			labels: labelsItems,
            datasets: datasetItems,

		},
		options: {
			maintainAspectRatio: false,
			legend: {
				display: false,
				labels: {
					display: false
				}
			},
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero: true,
						fontSize: 10,
						max: 80,
						fontColor: "rgb(171, 167, 167,0.9)",
					},
					gridLines: {
						display: true,
						color: 'rgba(171, 167, 167,0.2)',
						drawBorder: false
					},
				}],
				xAxes: [{
					ticks: {
						beginAtZero: true,
						fontSize: 11,
						fontColor: "rgb(171, 167, 167,0.9)",
					},
					gridLines: {
						display: true,
						color: 'rgba(171, 167, 167,0.2)',
						drawBorder: false
					},
				}]
			}
		}
	});

});


        /** PIE CHART **/
	

    $(function () {

        let labelsItems = [];
        let datasetItems = [];

        $.get('/api/chart/subscriber_chart', { random_id: Math.random() }, function (data) {

             let coloR = [];
            let dynamicColors = function () {
                const r = Math.round(Math.random() * 255);
                const g = Math.round(Math.random() * 255);
                const b = Math.round(Math.random() * 255);

                return "rgb("+ r +", "+ g +", "+ b +")";
            }

            for (let i in data.labels) {
                coloR.push(dynamicColors());
                $("#names_js").append('<span class="mr-2"><i class="fas fa-circle" style="color: ' + coloR[i] + ';"></i> '+ data.labels[i] +'</span>');
                $("#name_js").append('<span class="mr-2"><i class="fas fa-circle" style="color: ' + coloR[i] + ';"></i> '+ data.labels[i] +'</span>');

            }
              labelsItems = data.labels;
            datasetItems.push({
                data: data.datasets.values,
                backgroundColor: coloR,
                hoverBackgroundColor: coloR,
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            })

              var donutOptions     = {
          maintainAspectRatio : false,
          responsive : true,
          maintainAspectRatio: false,
		legend: {
			display: false,
		},
		animation: {
			animateScale: true,
			animateRotate: true
		},
        }

         // You can switch between pie and douhnut using the method below.
         var donutChartCanvas = document.getElementById("chartPie");
        var donutChart = new Chart(donutChartCanvas, {
          type: 'doughnut',
         data: {
                    labels: labelsItems,
                    datasets: datasetItems,
                },
          options: donutOptions
        });


        });


      });
});
