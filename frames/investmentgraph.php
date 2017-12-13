<html>
<head>
    <script id="tinyhippos-injected">if (window.top.ripple) { window.top.ripple("bootstrap").inject(window, document); }</script>
    <script src="../js/Chart.min.js"></script>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    <iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px; height: 0px; margin: 0px; position: absolute; left: 0px; right: 0px; top: 0px; bottom: 0px;"></iframe>
    <canvas id="myChart" width="1366" height="683" style="width: 1366px; height: 683px;"></canvas>
    <script>
            var ctx = document.getElementById("myChart").getContext('2d');
            var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                    labels: ['Property','Forex','Shares'],					
                    datasets: [
                        {
                            label: 'Investments',
                            data: [0.5,0.2,0.3],						
                            backgroundColor: [  'rgba(255, 99, 132, 0.2)',
                                                'rgba(54, 162, 235, 0.2)',
                                                'rgba(255, 206, 86, 0.2)',
                                                'rgba(75, 192, 192, 0.2)',
                                                'rgba(153, 102, 255, 0.2)',
                                                'rgba(255, 159, 64, 0.2)'
                                            ],
                            borderColor: [
                                    'rgba(255,99,132,1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
		},
		options: {
                            scales: {
                                    yAxes: [{
                                            ticks: {
						beginAtZero:true
                                            }
					}]
				}
			}
		});
    </script>
	
</body>
</html>