<?php
$servername = "localhost";
$username = "gateway1_tasuser";
$password = "tasuser123";
$dbname = "gateway1_tas";
$mysql_table = "clubmedia";

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
if (isset($_GET["clubname"])) {   
    $clubName = $_GET["clubname"];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 
    $clubName = $_POST["clubnamehidden"];
    $randkey = rand(1000,100000);
    //$guidkey = bin2hex((string)$randkey);
    $guidkey = bin2hex(openssl_random_pseudo_bytes(16));
    $targetfilename = rand(1000,100000)."-".$_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
    $folder="uploads/";
 
 move_uploaded_file($file_loc,$folder.$targetfilename);

 // Valid file extensions
 $extensions_arr = array("image/jpg","image/jpeg","image/png","image/gif");
 
 // Check extension
 if( in_array($file_type,$extensions_arr) ){
     // Insert record
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
    
    if($clubNameValid) {
        while($row = $result->fetch_assoc()) {
            $clubid = $row["ID"];                    
        }
      $sqlText = "insert into $mysql_table(ID, Name, FileLocation, FileType, SocialClubID) values(UUID(), '$targetfilename', '$folder$targetfilename', '$file_type', '$clubid')";
        //$result = $conn->query($sqlText);
        if (!$conn->query($sqlText)) {
            echo "$sqlText<br>";
            die( "Error: Failed to insert data into $mysql_table ".$conn->error."<br>");
        }
        $notify = "Image uploaded successfully.";
    }
 } 
}
?>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="img/tm-lumino-logo.png">
    <link rel="stylesheet" href="css/templatemo-style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">                                    
    <script src="js/scripts.js"></script>
</head>
<body>
    <div class="tm-intro tm-detail modalForm">
        <section id="tm-section-1">
            <div class="tm-container text-xs-center tm-section-1-inner">
                <p>Media Upload</p>
                <span style="color:red;"><?php echo $msg; ?></span>
                <span style="color:green;"><?php echo $notify; ?></span>
                <form method="post" action="<?php echo basename(__FILE__); ?>" enctype='multipart/form-data'>
                    <input name="clubnamehidden" type="hidden" value="<?php echo $clubName ?>">
                    <input type='file' name='file' /><br>
                    <input class="tm-intro-link tm-light-blue-bordered-btn" type='submit' value='Save File' name='upload'>
                </form>
            </div>
        </section>
    </div>
</body>