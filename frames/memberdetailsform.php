<?php
$servername = "localhost";
$username = "gateway1_tasuser";
$password = "tasuser123";
$dbname = "gateway1_tas";
$mysql_table = "members";

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
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if ($_POST["membername"] != "")
    {
        $membername = $_POST["membername"];
        $membersurname = $_POST["membersurname"];
        $clubid = $_POST["clubid"];
        $sqlText = "SELECT ID FROM $mysql_table WHERE Name = '$membername' AND Surname = '$membersurname' AND SocialClubId = '$clubid'";
        $result = $conn->query($sqlText);
        if (!$conn->query($sqlText)) {
            echo "$sqltext<br>";
            die( "Error: Failed to get data from '$mysql_table' ".$conn->error."<br>");
        }
    
        if ($result->num_rows > 0) {
            $msg = "$membername $membersurname is already a member of the social club.";
        }
        else {
            $sqlText = "INSERT INTO $mysql_table (ID, Name, Surname, SocialClubID) VALUES (UUID(), '$membername', '$membersurname', '$clubid');";
            if (!$conn->query($sqlText)) {
                echo "$sqltext<br>";
                die( "Error: Failed to insert data into table '$mysql_table' ".$conn->error."<br>");
            }        
            $notify = "Member added to social club.";
        }
    }
}

//////////////////////Get social clubs//////////////////////
$sql = "SELECT ID, Name, CreationDate FROM socialclub ORDER BY Name";
$result = $conn->query($sql);
if (!$conn->query($sql)) {
    echo "$sql<br>";
    die( "Error: Failed to return data from table SocialClub ".$conn->error."<br>");
}

////////////////////////////////////////////////////////////

?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="../img/tm-lumino-logo.png">
        <link rel="stylesheet" href="../css/templatemo-style.css">
        <link rel="stylesheet" href="../css/bootstrap.min.css">                                    
        <script src="../js/scripts.js"></script>
    </head>
    <body>
        <div class="tm-intro tm-detail">
            <section id="tm-section-1">
                <div class="tm-container text-xs-center tm-section-1-inner">
                    <p class="intro-text">Member Details</p>
                    <form name="clubdetails" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data" id="form1">
                        <table>
                            <tbody>
                                <tr>
                                    <td style="color:red;"><?php echo $msg; ?></td>
                                </tr>
                                <tr>
                                    <td style="color:green;"><?php echo $notify; ?></td>
                                </tr>
                                <tr>
                                    <td><input type="text" placeholder="Name" name="membername" autofocus></td>
                                </tr>
                                <tr>
                                    <td><input type="text" placeholder="Surname" name="membersurname"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="clubid">
                                            <option value="none">--Select Social Club--</option>
<?php
                                            if ($result->num_rows > 0) {
                                                $rowsremaining = $result->num_rows;
                                                $row = $result->fetch_assoc();

                                                $result = $conn->query($sql);
                                                while($row = $result->fetch_assoc()) {
                                                    echo '<option value="'.$row["ID"].'"> '.$row["Name"].'</option>';
                                                }
                                            }
?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input class="tm-intro-link tm-light-blue-bordered-btn" type="submit" onclick="return checkmemberfields(this.form)"></td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </section>
        </div>
    </body>
</html>
