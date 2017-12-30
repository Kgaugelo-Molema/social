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
    $clubName = $_POST["clubnamehidden"];
    $membername = $_POST["membername"];
    $membersurname = $_POST["membersurname"];
                $sqlText = "SELECT m.ID, m.Name, m.Surname FROM socialclub s
                       JOIN members m ON m.SocialClubID = s.ID
                       WHERE s.Name = '$clubName' AND m.Name = '$membername' AND m.Surname = '$membersurname'";
    $result = $conn->query($sqlText);
    if (!$conn->query($sqlText)) {
        echo "$sqltext<br>";
        die( "Error: Failed to get data from '$mysql_table' ".$conn->error."<br>");
    }
    $memberExists = $result->num_rows > 0;
    if ($result->num_rows > 0) {
        $msg = "$membername $membersurname is already a member of the social club.";
    }
    //$clubid = $_POST["clubid"];
    $sqlText = "SELECT ID FROM socialclub WHERE Name = '$clubName'";
    $result = $conn->query($sqlText);
    if (!$conn->query($sqlText)) {
        echo "$sqltext<br>";
        die( "Error: Failed to get data from 'SocialClub'<br>".$conn->error."<br>");
    }
    
    $clubNameValid = ($result->num_rows != 0);
    if ($result->num_rows == 0) {
        $msg = "'$clubName' is an invalid social club name.";
    }
    
    if($clubNameValid & !$memberExists) {
        while($row = $result->fetch_assoc()) {
            $clubid = $row["ID"];                    
        }
        $sqlText = "INSERT INTO $mysql_table (ID, Name, Surname, SocialClubID) VALUES (UUID(), '$membername', '$membersurname', '$clubid');";
        if (!$conn->query($sqlText)) {
            echo "$sqltext<br>";
            die( "Error: Failed to insert data into table '$mysql_table' ".$conn->error."<br>");
        }        
        $notify = "Member added to social club.";
        header("Location:./memberdetailsform.php?club=$clubName");
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
            <p>Member list</p>
<?php
            //////////////////////Get social club member data//////////////////////
            $clubName = "";
            if (isset($_GET["club"])) {   
                $clubName = $_GET["club"];
                echo "ClubID: $clubName";
                $sql = "SELECT m.ID, m.Name, m.Surname FROM socialclub s
                       JOIN members m ON m.SocialClubID = s.ID
                       WHERE s.Name = '$clubName'";
                $result = $conn->query($sql);
                if (!$conn->query($sql)) {
                    echo "$sql<br>";
                    die( "Error: Failed to return social club members<br>".$conn->error."<br>");
                }
            ////////////////////////////////////////////////////////////
                if ($result->num_rows > 0) {
                    $rowsremaining = $result->num_rows;
                    $row = $result->fetch_assoc();

                    $result = $conn->query($sql);
                    echo "<table>
                            <tbody>";
                    while($row = $result->fetch_assoc()) {
                        echo   "<tr>
                                    <td>".$row["Name"]."</td><td>&nbsp;</td><td>".$row["Surname"]."</td>
                                </tr>";
                    }
                    echo    "</tbody>
                         </table>";
                }
            }
?>
        </div>
    </body>
</html>
