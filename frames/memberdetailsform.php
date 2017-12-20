<?php
$servername = "localhost";
$username = "gateway1_socuser";
$password = "socuser123";
$dbname = "gateway1_social";
$mysql_table = "members";

$conn = new mysqli($servername, $username, $password, '');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error."<br>");
} 
if (!$conn->select_db($dbname)) {
	die( "Error: Failed to select database '$dbname' ".$conn->error."<br>");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
}

?>
<html>
	<head>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="icon" type="image/png" href="../img/tm-lumino-logo.png">
            <link rel="stylesheet" href="../css/templatemo-style.css">
	</head>
	<body>
            <h3>Member Details</h3>
    </body>
</html>
