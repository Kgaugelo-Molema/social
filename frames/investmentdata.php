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
    $sqlText = "SELECT ID, Name, Actual, Target, Fee, Contributions FROM $mysql_table WHERE Name = '$clubName'";
    $result = $conn->query($sqlText);
    if (!$conn->query($sqlText)) {
        echo "$sqltext<br>";
        die( "Error: Failed to get data from '$mysql_table' ".$conn->error."<br>");
    }
    while($row = $result->fetch_assoc()) {
        $actual = $row["Contributions"];
        $target = ($row["Fee"] * $row["Target"]) - $row["Contributions"];
    }
}

?>

<html>
<head>
    <script src="../js/Chart.min.js"></script>
    <link rel="stylesheet" href="../css/templatemo-style.css">                                   <!-- Templatemo style -->
    <link rel="icon" type="image/png" href="../img/tm-lumino-logo.png">
</head>
<body>
    <h2 class="tm-news-title dark-gray-text"><?php echo $clubName ?></h2>
    <table>
        <tr>
            <th>Joining fees collected: </th>
            <td>&nbsp;</td>
            <td>R</td>
            <td><?php echo number_format($actual, 2) ?></td>
        </tr>
        <tr>
            <th>Joining fees to collect: </th>
            <td>&nbsp;</td>
            <td>R</td>
            <td><?php echo number_format($target, 2) ?></td>
        </tr>
    </table>
</body>
</html>