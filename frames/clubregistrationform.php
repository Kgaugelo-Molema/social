<?php
$servername = "localhost";
$username = "gateway1_tasuser";
$password = "tasuser123";
$dbname = "gateway1_tas";
$mysql_table = "SocialClub";

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
    if ($_POST["clubname"] != "")
    {
        $clubname = $_POST["clubname"];
        $target = $_POST["target"];
        $fee = $_POST["fee"];
        //$clubid = $_POST["clubid"];
        $sqlText = "SELECT ID FROM $mysql_table WHERE Name = '$clubname'";
        $result = $conn->query($sqlText);
        if (!$conn->query($sqlText)) {
            echo "$sqltext<br>";
            die( "Error: Failed to get data from '$mysql_table' ".$conn->error."<br>");
        }
    
        if ($result->num_rows > 0) {
            $msg = "$clubname already exists.";
        }
        else {
            //Create social club meta data record
            $sqlText = "SET @UUID = UUID();
                        INSERT INTO $mysql_table (ID, Name) VALUES (@UUID, '$clubname');
                        INSERT INTO ClubMetaData (ID, SocialClubID, MonthlyMembershipTarget, MonthlyMembershipFee) VALUES (UUID(), @UUID, $target, $fee);";

            if (!$conn->multi_query($sqlText)) {
                echo "$sqltext<br>";
                die( "Error: Failed to insert data into table '$mysql_table' ".$conn->error."<br>");
            }        
            $notify = "Social club created successfully.";
        }
    }
}

//////////////////////Get social clubs//////////////////////
//$sql = "SELECT ID, Name, CreationDate FROM socialclub ORDER BY Name";
//$result = $conn->query($sql);
//if (!$conn->query($sql)) {
//    echo "$sql<br>";
//    die( "Error: Failed to return data from table SocialClub ".$conn->error."<br>");
//}

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
        <div class="tm-intro tm-detail modalForm">
            <section id="tm-section-1">
                <div class="tm-container text-xs-center tm-section-1-inner">
                    <p>Club Registration</p>
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
                                    <td><input type="text" placeholder="Social club name" name="clubname" autofocus></td>
                                </tr>
                                <tr>
                                    <td><input type="number" min="0" placeholder="Monthly target" name="target"></td>
                                </tr>
                                <tr>
                                    <td><input type="number" step="0.01" placeholder="Monthly fee" name="fee"></td>
                                </tr>
                                <tr>
                                    <td><input class="tm-intro-link tm-light-blue-bordered-btn" type="submit" onclick="return checksocialclubfields(this.form)"></td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </section>
        </div>
    </body>
</html>
