<?php
$servername = "localhost";
$username = "gateway1_tasuser";
$password = "tasuser123";
$dbname = "gateway1_tas";
$mysql_table = "socialclubstats";

$conn = new mysqli($servername, $username, $password, '');
$msg = "";
$notify = "";
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error."<br>");
} 
if (!$conn->select_db($dbname)) {
	die( "Error: Failed to select database '$dbname' ".$conn->error."<br>");
}
$clubName = "";
$actual = 0;
$target = 0;
if (isset($_GET['clubname'])) {
    $clubName = $_GET['clubname'];
    $sqlText = "SELECT ID, Name, Actual, Target FROM $mysql_table WHERE Name = '$clubName'";
    $result = $conn->query($sqlText);
    if (!$conn->query($sqlText)) {
        echo "$sqltext<br>";
        die( "Error: Failed to get data from '$mysql_table' ".$conn->error."<br>");
    }
    while($row = $result->fetch_assoc()) {
        $actual = $row["Actual"];
        $target = $row["Target"] - $row["Actual"];
    }
}

?>

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
                    labels: ['Actual','Target'],					
                    datasets: [
                        {
<?php                            
                            echo "label: '$clubName',";
                            echo "data: [$actual,$target],";						
?>                                    
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