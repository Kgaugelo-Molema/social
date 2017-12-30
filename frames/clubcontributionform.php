<?php
$servername = "localhost";
$username = "gateway1_tasuser";
$password = "tasuser123";
$dbname = "gateway1_tas";
$mysql_table = "clubfees";

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

//////////////////////Get social club details//////////////////////
$clubid = "";
if (isset($_GET["club"])) {
    $clubName = $_GET["club"];
    $sql = "SELECT ID, Name, CreationDate FROM socialclub WHERE Name = '$clubName'";
    $result = $conn->query($sql);
    if (!$conn->query($sql)) {
        echo "$sql<br>";
        die( "Error: Failed to return data from table SocialClub ".$conn->error."<br>");
    }
    while($row = $result->fetch_assoc()) {
        $clubid = $row["ID"];
    }
}
////////////////////////////////////////////////////////////
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $clubName = $_POST["clubnamehidden"];
    $sql = "SELECT ID, Name, CreationDate FROM socialclub WHERE Name = '$clubName'";
    $result = $conn->query($sql);
    if (!$conn->query($sql)) {
        echo "$sql<br>";
        die( "Error: Failed to return data from table SocialClub ".$conn->error."<br>");
    }
    while($row = $result->fetch_assoc()) {
        $clubid = $row["ID"];
    }

    if ($clubid != "") {
        $memberid = $_POST["memberid"];
        $fee = $_POST["fee"];
        $sqlText = "INSERT INTO $mysql_table (ID, SocialClubID, MemberID, Contribution)
                   VALUES (UUID(), '$clubid', '$memberid', $fee)";
        if (!$conn->query($sqlText)) {
            echo "$sqltext<br>";
            die( "Error: Failed to insert data into '$mysql_table'<br>".$conn->error."<br>");
        }
        $notify = "Member fees updated successfully.";
    }
    else {
        $msg = "Invalid club name found.";
    }
}
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
                    <p>Club Contributions</p>
                    <form name="clubcontributions" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data" id="form1">
                        <input name="clubnamehidden" type="hidden" value="<?php echo $clubName ?>">
                        <table>
                            <thead>
                                <tr>
                                    <td style="color:red;"><?php echo $msg; ?></td>
                                </tr>
                                <tr>
                                    <td style="color:green;"><?php echo $notify; ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="memberid">
                                            <option value="none">--Select Club Member--</option>
<?php
                                            //////////////////////Get social clubs members//////////////
                                            if (isset($_GET["club"]) & $clubid != "")
                                            {
                                                $sql = "SELECT ID, Name, Surname, CreationDate FROM members WHERE SocialClubID = '$clubid' ORDER BY Name";
                                                $result = $conn->query($sql);
                                                if (!$conn->query($sql)) {
                                                    echo "$sql<br>";
                                                    die( "Error: Failed to return data from table Members ".$conn->error."<br>");
                                                }
                                                if ($result->num_rows > 0) {
                                                    $rowsremaining = $result->num_rows;
                                                    $row = $result->fetch_assoc();
                                                    $result = $conn->query($sql);
                                                    while($row = $result->fetch_assoc()) {
                                                        echo '<option value="'.$row["ID"].'"> '.$row["Name"].'&nbsp;'.$row["Surname"].'</option>';
                                                    }
                                                }
                                            }
                                            ////////////////////////////////////////////////////////////
?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="number" step="0.01" placeholder="Contribution" name="fee"></td>
                                </tr>
                                <tr>
                                    <td><input class="tm-intro-link tm-light-blue-bordered-btn" type="submit" onclick="return checkcontributionfields(this.form)"></td>
                                </tr>
                            </thead>
                        </table>
                    </form>
                </div>
            </section>
        </div>
        <script>
            function reloadPage(form) {
                window.location = "./clubcontributionform.php?clubid=" + form.clubid.value;
            }
        </script>
    </body>
</html>
