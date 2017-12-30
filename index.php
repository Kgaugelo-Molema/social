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
    //Get Social club data
    $clubName = "";
    if (isset($_GET['name']))
    {
        $clubName = $_GET['name'];
        $sql = "SELECT ID, Name, CreationDate FROM socialclub ORDER BY Name";
        $result = $conn->query($sql);
        if (!$conn->query($sql)) {
            echo "$sql<br>";
            die( "Error: Failed to return data from table SocialClub ".$conn->error."<br>");
        }
        
    }

    //////////////////////Get social clubs//////////////////////
    $sql = "SELECT ID, Name, CreationDate FROM socialclub ORDER BY Name";
    $result = $conn->query($sql);
    if (!$conn->query($sql)) {
        echo "$sql<br>";
        die( "Error: Failed to return data from table SocialClub ".$conn->error."<br>");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Investment Tracking</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:100,300,400">   <!-- Google web font "Open Sans" -->
    <link rel="stylesheet" href="font-awesome-4.5.0/css/font-awesome.min.css">                <!-- Font Awesome -->
    <link rel="stylesheet" href="css/bootstrap.min.css">                                      <!-- Bootstrap style -->
    <link rel="stylesheet" href="css/magnific-popup.css">                                     <!-- Magnific pop up style -->
    <link rel="stylesheet" href="css/templatemo-style.css">                                   <!-- Templatemo style -->
    <link rel="icon" type="image/png" href="img/tm-lumino-logo.png">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
          <![endif]-->
</head>

    <body id="top" class="home">
       
        <div class="container-fluid">
            <div class="row">
              
                <div class="tm-navbar-container">
                
                <!-- navbar   -->
                <nav class="navbar navbar-full navbar-fixed-top">

                    <button class="navbar-toggler hidden-md-up" type="button" data-toggle="collapse" data-target="#tmNavbar">
                        &#9776;
                    </button>
                        
                    <div class="collapse navbar-toggleable-sm" id="tmNavbar">                            

                        <ul class="nav navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#top">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tm-section-2">Membership</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tm-section-3">Stats</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tm-section-4">Contact Us</a>
                            </li>
<!--                            <li class="nav-item">
                                <a class="nav-link external" href="columns.html">About</a>
                            </li>-->
                        </ul>

                    </div>
                  
                </nav>

              </div>  

           </div>

           <div class="row">
                <div class="tm-intro">
                    <section id="tm-section-1">                        
                        <div class="tm-container text-xs-center tm-section-1-inner">
<!--                            <img src="img/tm-lumino-logo.png" alt="Logo" class="tm-logo">-->
                            <h1 class="tm-site-name">Social Club</h1>
                            <form>
                                <table>
<?php
                                        
    if ($result->num_rows > 0) {
        $rowsremaining = $result->num_rows;
        $row = $result->fetch_assoc();

        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            echo '  <tr>
                        <td>
                            <a href="./index.php?name='.$row["Name"].'" class="tm-intro-link">'.$row["Name"].'</a>
                        </td>
                    </tr>';
        }
    }
?>
                                    <tr>
                                        <td>
                                            <script>
                                                function setRegisterUrl()
                                                {   //this forces the address on the browser
                                                    document.location = "./#register";
                                                }
                                            </script>
                                            <a class="btn tm-light-blue-bordered-btn" onclick="return setRegisterUrl()">Register club</a>                                                
                                        </td>
                                    </tr>
                                </table>                                
                            </form>
                            <br>
                        </div>                                               
                   </section>

                </div>
            </div>

            <div class="row gray-bg">
                
                <div id="tm-section-2" class="tm-section">
                    <div class="tm-container tm-container-wide">
                        <div class="tm-news-item">
                            
<!--                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-news-item-img-container">
                                <img src="img/tm-600x300-01.jpg" alt="Image" class="img-fluid tm-news-item-img">  
                            </div>-->
                            
                            <script>
                                function setName()
                                {
                                    var name = document.getElementById("user").value;
                                    document.getElementById("lblname").innerHTML = name;
                                }
                            </script>
                            
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-news-container">
                                <iframe src="frames/memberlist.php?club=<?php echo $clubName ?>" style="width:100%;height:145px" frameborder="0" scrolling="no">
                                </iframe><br><br>                                
                                <script>
                                    function setDetailsUrl(clubmembersection)
                                    {   //this forces the address on the browser
                                        document.location = "./?name=" + clubmembersection;
                                    }
                                </script>
                                <input name="clubnamehidden" type="hidden" value="<?php echo $clubName ?>">
                                <a class="btn tm-light-blue-bordered-btn tm-news-link" type="submit" onclick="return setDetailsUrl('<?php echo $clubName ?>#memberdetails')">Add Member</a>                                                
                            </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-news-container flex-order-1">
                            <iframe id="memfees" src="frames/clubcontributions.php?club=<?php echo $clubName ?>" style="width:500px;height:150px" frameborder="0" scrolling="no">
                            </iframe><br><br>
                            <a class="btn tm-light-blue-bordered-btn tm-news-link" type="submit" onclick="return setDetailsUrl('<?php echo $clubName ?>#contributionsdetails')">Add Contributions</a>                                                

                        </div>
                            
                        </div>


                        <div class="tm-news-item">

<!--                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 flex-order-2 tm-news-item-img-container">
                                <img src="img/tm-600x300-02.jpg" alt="Image" class="img-fluid tm-news-item-img">
                            </div>-->

<!--                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-news-container flex-order-1">
                                <iframe id="memfees" src="frames/clubcontributions.php?club=<?php echo $clubName ?>" style="width:500px;height:150px" frameborder="0" scrolling="no">
                                </iframe><br><br>
                                <a class="btn tm-light-blue-bordered-btn tm-news-link" type="submit" onclick="return setDetailsUrl('<?php echo $clubName ?>#contributionsdetails')">Add Contributions</a>                                                
                                
                            </div>-->
                        </div>

                    </div>                    
               </div>

            <!--BEGIN Summary data-->
                <div id="tm-section-3" class="tm-section">
                    <div class="tm-container tm-container-wide">

                        <div class="tm-news-item">

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-news-item-img-container">
                                <iframe id="invgraph" src="frames/investmentgraph.php?clubname=<?php echo $clubName ?>" style="width:500px;height:380px" frameborder="0" scrolling="no">
                                </iframe>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-news-container">
                                <iframe id="invdata" src="frames/investmentdata.php?clubname=<?php echo $clubName ?>" style="width:300px;height:160px" frameborder="0" scrolling="no">
                                </iframe>                                
                            </div>
                        </div>
                    </div>                    
               </div>
                
            <!--END Summary data-->
                
            </div> <!-- row -->

            <div class="row">

                <section id="tm-section-4" class="tm-section">
                    <div class="tm-container text-xs-center">
                        
                        <h2 class="blue-text tm-title">Media Gallery</h2>
                        <div class="tm-img-grid">
                            <div class="tm-gallery-img-container">
                                <a href="img/tm-450x300-01.jpg" class="tm-gallery-img-link">
                                    <img src="img/tm-450x300-01.jpg" alt="Image" class="img-fluid tm-gallery-img"> <!-- 300x200 -->
                                </a>
                            </div>
                            <div class="tm-gallery-img-container">
                                <a href="img/tm-450x300-07.jpg" class="tm-gallery-img-link">
                                    <img src="img/tm-450x300-07.jpg" alt="Image" class="img-fluid tm-gallery-img">  
                                </a>
                            </div>
                            <div class="tm-gallery-img-container">
                                <a href="img/tm-450x300-02.jpg" class="tm-gallery-img-link">
                                    <img src="img/tm-450x300-02.jpg" alt="Image" class="img-fluid tm-gallery-img">
                                </a>                           
                            </div>
                            <div class="tm-gallery-img-container">
                                <a href="img/tm-450x300-09.jpg" class="tm-gallery-img-link">
                                    <img src="img/tm-450x300-09.jpg" alt="Image" class="img-fluid tm-gallery-img">
                                </a>
                            </div>
                            <div class="tm-gallery-img-container">
                                <a href="img/tm-450x300-03.jpg" class="tm-gallery-img-link">
                                    <img src="img/tm-450x300-03.jpg" alt="Image" class="img-fluid tm-gallery-img">
                                </a>
                            </div>
                            <div class="tm-gallery-img-container">
                                <a href="img/tm-450x300-08.jpg" class="tm-gallery-img-link">
                                    <img src="img/tm-450x300-08.jpg" alt="Image" class="img-fluid tm-gallery-img">
                                </a>
                            </div>
                            <div class="tm-gallery-img-container">
                                <a href="img/tm-450x300-10.jpg" class="tm-gallery-img-link">
                                    <img src="img/tm-450x300-10.jpg" alt="Image" class="img-fluid tm-gallery-img">
                                </a>
                            </div>
                            <div class="tm-gallery-img-container">
                                <a href="img/tm-450x300-04.jpg" class="tm-gallery-img-link">
                                    <img src="img/tm-450x300-04.jpg" alt="Image" class="img-fluid tm-gallery-img">
                                </a>
                            </div>
                            <div class="tm-gallery-img-container">
                                <a href="img/tm-450x300-05.jpg" class="tm-gallery-img-link">
                                    <img src="img/tm-450x300-05.jpg" alt="Image" class="img-fluid tm-gallery-img">
                                </a>
                            </div>
                            <div class="tm-gallery-img-container">
                                <a href="img/tm-450x300-11.jpg" class="tm-gallery-img-link">
                                    <img src="img/tm-450x300-11.jpg" alt="Image" class="img-fluid tm-gallery-img">
                                </a>
                            </div>
                            <div class="tm-gallery-img-container">
                                <a href="img/tm-450x300-06.jpg" class="tm-gallery-img-link">
                                    <img src="img/tm-450x300-06.jpg" alt="Image" class="img-fluid tm-gallery-img">
                                </a>
                            </div>
                            <div class="tm-gallery-img-container">
                                <a href="img/tm-450x300-12.jpg" class="tm-gallery-img-link">
                                    <img src="img/tm-450x300-12.jpg" alt="Image" class="img-fluid tm-gallery-img">
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

            </div> <!-- row -->
            
            <div class="row gray-bg">

                <section id="tm-section-4" class="tm-section">
                    <div class="tm-container">

                        <h2 class="blue-text tm-title text-xs-center">Contact Us</h2>
                      
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                            <form action="index.html" method="post" class="tm-contact-form">                                
                                <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 tm-form-group-left">
                                    <input type="text" id="contact_name" name="contact_name" class="form-control" placeholder="Name"  required/>
                                </div>
                                <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 tm-form-group-right">
                                    <input type="email" id="contact_email" name="contact_email" class="form-control" placeholder="Email"  required/>
                                </div>
                                <div class="form-group">
                                    <input type="text" id="contact_subject" name="contact_subject" class="form-control" placeholder="Subject"  required/>
                                </div>
                                <div class="form-group">
                                    <textarea id="contact_message" name="contact_message" class="form-control" rows="6" placeholder="Message" required></textarea>
                                </div>
                            
                                <button type="submit" class="btn tm-light-blue-bordered-btn pull-xs-right">Submit</button>                          
                            </form>   
                        </div> <!-- col -->
                        
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 margin-top-xs-50">
                            <h3 class="light-blue-text tm-subtitle">For assistance please contact</h3>
<!--                            <p>Nunc rutrum ac ante euismod cursus. Suspendisse imperdiet feugiat massa nec iaculis</p>-->
                            <p>
                                Tel: <a href="tel:0835924242">+27 83 592 4242</a><br>
                                Email: <a href="mailto:info@gatewaysystems.co.za">info@gatewaysystems.co.za</a>
                            </p>
                        </div>
                    </div>                    
                </section>

                <div id="register" class="modalDialog">
                    <div>
                        <a href="#close" title="Close" class="close" onclick="return reloadPage()">X</a>
                        <center>
                            <iframe src="frames/clubregistrationform.php" frameborder="0" scrolling="no" style="height: 300px">
                            </iframe>
                        </center>
                    </div>                              
                </div> 

                <div id="memberdetails" class="modalDialog">
                    <div>
                        <a href="#close" title="Close" class="close" onclick="return reloadPage()">X</a>
                        <center>
<?php                            
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $clubName = $_POST["clubnamehidden"];
        echo "Posted Club: $clubName<br>";
    }
?>
                            <iframe name="memberframe" src="frames/memberdetailsform.php?club=<?php echo $clubName ?>" frameborder="0" scrolling="no" style="height: 300px">
                            </iframe>
                        </center>
                    </div>                                                
                </div> 

                <div id="contributionsdetails" class="modalDialog">
                    <div>
                        <a href="#close" title="Close" class="close" onclick="return reloadPage()">X</a>
                        <center>
<?php                            
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $clubName = $_POST["clubnamehidden"];
        echo "Posted Club: $clubName<br>";
    }
?>
                            <iframe name="contributionsframe" src="frames/clubcontributionform.php?club=<?php echo $clubName ?>" frameborder="0" scrolling="no" style="height: 300px">
                            </iframe>
                        </center>
                    </div>                                                
                </div> 
                
                <!-- footer -->
                <footer class="tm-footer">                
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <p class="text-xs-center tm-footer-text">Copyright &copy; 2017 <a href="www.gatewaysystems.co.za">Gateway Systems</a></p>                    
                    </div>                
                </footer>  

            </div> <!-- row -->
           
        </div> <!-- container-fluid -->
        <!-- load JS files -->
        
        <script src="js/jquery-1.11.3.min.js"></script>             <!-- jQuery (https://jquery.com/download/) -->
        <script src="https://www.atlasestateagents.co.uk/javascript/tether.min.js"></script> <!-- Tether for Bootstrap, http://stackoverflow.com/questions/34567939/how-to-fix-the-error-error-bootstrap-tooltips-require-tether-http-github-h --> 
        <script src="js/bootstrap.min.js"></script>                 <!-- Bootstrap (http://v4-alpha.getbootstrap.com/) -->
        <script src="js/jquery.singlePageNav.min.js"></script>      <!-- Single Page Nav (https://github.com/ChrisWojcik/single-page-nav) -->
        <script src="js/jquery.magnific-popup.min.js"></script>     <!-- Magnific pop-up (http://dimsemenov.com/plugins/magnific-popup/) -->
        
        <!-- Templatemo scripts -->
        <script>     
       
            $(document).ready(function(){

                var mobileTopOffset = 54;
                var desktopTopOffset = 80;
                var topOffset = desktopTopOffset;

                if($(window).width() <= 767) {
                    topOffset = mobileTopOffset;
                }
                
                /* Single page nav
                -----------------------------------------*/
                $('#tmNavbar').singlePageNav({
                   'currentClass' : "active",
                    offset : topOffset,
                    'filter': ':not(.external)'
                }); 

                /* Handle nav offset upon window resize
                -----------------------------------------*/
                $(window).resize(function(){
                    if($(window).width() <= 767) {
                        topOffset = mobileTopOffset;
                    } 
                    else {
                        topOffset = desktopTopOffset;
                    }

                    $('#tmNavbar').singlePageNav({
                        'currentClass' : "active",
                        offset : topOffset,
                        'filter': ':not(.external)'
                    });
                });
                

                /* Collapse menu after click 
                -----------------------------------------*/
                $('#tmNavbar a').click(function(){
                    $('#tmNavbar').collapse('hide');
                });

                /* Turn navbar background to solid color starting at section 2
                ---------------------------------------------------------------*/
                var target = $("#tm-section-2").offset().top - topOffset;

                if($(window).scrollTop() >= target) {
                    $(".tm-navbar-container").addClass("bg-inverse");
                }
                else {
                    $(".tm-navbar-container").removeClass("bg-inverse");
                }

                $(window).scroll(function(){
                   
                    if($(this).scrollTop() >= target) {
                        $(".tm-navbar-container").addClass("bg-inverse");
                    }
                    else {
                        $(".tm-navbar-container").removeClass("bg-inverse");
                    }
                });


                /* Smooth Scrolling
                 * https://css-tricks.com/snippets/jquery/smooth-scrolling/
                --------------------------------------------------------------*/
                $('a[href*="#"]:not([href="#"])').click(function() {
                    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
                        && location.hostname == this.hostname) {
                        
                        var target = $(this.hash);
                        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                        
                        if (target.length) {
                            
                            $('html, body').animate({
                                scrollTop: target.offset().top - topOffset
                            }, 1000);
                            return false;
                        }
                    }
                }); 

              
                /* Magnific pop up
                ------------------------- */
                $('.tm-img-grid').magnificPopup({
                    delegate: 'a', // child items selector, by clicking on it popup will open
                    type: 'image',
                    gallery: {enabled:true}            
                });            
            });
            window.setInterval(function() {reloadFrame()},60000);
            function reloadFrame() {
                document.getElementById('invgraph').contentWindow.location = "frames/investmentgraph.php?clubname=<?php echo $clubName ?>";
                document.getElementById('invdata').contentWindow.location = "frames/investmentdata.php?clubname=<?php echo $clubName ?>";
            }
            function reloadPage() {
                window.location.reload(false);
            }

        </script>             

</body>
</html>