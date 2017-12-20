<?php
$servername = "localhost";
$username = "gateway1_socuser";
$password = "socuser123";
$dbname = "gateway1_social";
$mysql_table = "socialclub";

$conn = new mysqli($servername, $username, $password, '');
$msg = "";
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error."<br>");
} 
if (!$conn->select_db($dbname)) {
	die( "Error: Failed to select database '$dbname' ".$conn->error."<br>");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $clubName = $_POST["clubname"];
    $sqlClubId = "SELECT ID FROM SocialClub WHERE Name = '$clubName'";
    $result = $conn->query($sqlClubId);
    if (!$conn->query($sqlClubId)) {
        die( "Error: Failed to get data from '$mysql_table' ".$conn->error."<br>");
    }

    if ($result->num_rows > 0) {
        $msg = "$clubName already exists.";
    }
}

?>
<html>
	<head>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="icon" type="image/png" href="../img/tm-lumino-logo.png">
            <link rel="stylesheet" href="../css/templatemo-style.css">
	</head>
	<body>
            <h3>Social Club Details</h3>
            <form name="clubdetails" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data" id="form1">
                <table>
                    <tr>
                        <td style="color:red;"><?php echo $msg; ?></td>
                    </tr>
                    <tr>
                        <td><input type="text" placeholder="Name" name="clubname"></td>
                    </tr>
                    <tr>
                        <td><input type="submit"></td>
                    </tr>
                </table>
            </form>
    </body>
</html>
