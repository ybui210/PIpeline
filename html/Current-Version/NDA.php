<?php
//require_once("../configdb.php");
    require_once("../../include/favicon.php");
    require_once("../../include/configdb.php");
    require_once("../../include/navBar.php");
    require_once("../../include/getUserTypeAndVerifyLogin.php");
	session_start();
    ini_set('display_errors',1);
    error_reporting(E_ALL);
// validation part
//$userid = $_SESSION["userEmail"];
//if(!isset($userid)) {
   // header("Location:login.php");
    //exit;
//}
?>
<!DOCTYPE html>
<html>
    <head>

        <link href="Styles/home.css" rel="stylesheet" />
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>

    <body>
        <!--Import jQuery before materialize.js-->


        <!--
<nav>
<div class="nav-wrapper">
<a href="#" class="brand-logo right">Logo</a>
<ul id="nav-mobile" class="left hide-on-med-and-down">
<li><a href="">Profile</a></li>
<li><a href="">Dashboard</a></li>
<li><a href="">My Listings</a></li>
<li><a href="">Saved Listings</a></li>
<li><a href="">Drafts</a></li>
</ul>
</div>
</nav>
-->

        <!--<div class="w3-sidebar w3-bar-block" style="width:25%"> 
<a href="#" class="w3-bar-item w3-button">Link 1</a>
<a href="#" class="w3-bar-item w3-button">Link 2</a>
<a href="#" class="w3-bar-item w3-button">Link 3</a>
</div>

<div style="margin-left:25%">
... page content ...
</div>-->
        <div class="container-fluid" >
            <div class="row">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="#">Pipeline</a>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                                <li><a href="#">Browse Listing <span class="sr-only">(current)</span></a></li>
                                <li><a href="#">Active Listing</a></li>
                                <li><a href="createListing.php">Create Listing</a></li>
                                <li><a href="#">News</a></li>
                                <li class="hidden-lg hidden-md hidden-sm"><a href="">Account</a></li>
                                <li class="hidden-lg hidden-md hidden-sm"><a href="">Password</a></li>
                                <li class="hidden-lg hidden-md hidden-sm"><a href="">Profile</a></li>
                                <li class="hidden-lg hidden-md hidden-sm"><a href="">Notifications</a></li>
                                <li class="hidden-lg hidden-md hidden-sm"><a href="">System History</a></li>
                                <li class="hidden-lg hidden-md hidden-sm"><a href="">Social Connections</a></li>

                            </ul>
                            <form class="navbar-form navbar-left">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Search">
                                </div>
                                <button type="submit" class="btn btn-default">Submit</button>
                            </form>
                        </div><!-- /.navbar-collapse -->
                    </div><!-- /.container-fluid -->
                </nav>
                <!--
<nav class="navbar navbar-inverse topNavBarDiv">
<div class="container-fluid">
<div class="navbar-header">
<a class="navbar-brand" href="#">Pipeline</a>
</div>
<ul class="nav navbar-nav">
<li class="active"><a href="#">Browse Listings</a></li>
<li><a href="#">Active Listings</a></li>
<li><a href="createListing.php">Create Listing</a></li>
<li><a href="#">News</a></li>
</ul>
<form class="navbar-form navbar-left">
<div class="form-group">
<input type="text" class="form-control" placeholder="Search">
</div>
<button type="submit" class="btn btn-default">Submit</button>
</form>
</div>
</nav>-->

            </div>
            <!-- your page content -->
            <div class="NDA">
                <div class="row">
                    <h1 class="text-center">Access to this listing requires you to accept a Non-Disclosure Agreement</h1>

                    <div class="col-xs-12 hidden-xs" style=" margin-bottom: 10px;">
                        <div class="col-xs-1"></div>
                        <div class="col-xs-10">
                            <object data="Uploads/nda.pdf" type="application/pdf" width="100%" height="450px">
                                <a href="Uploads/nda.pdf"></a>
                            </object>
                        </div>
                    </div>

                    <form action="NDA.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
                        <div class="col-sm-offset-4 col-lg-offset-5">
                            <div class="form-group">
                                <a href="Uploads/nda.jpg" download="nda.jpg" class="btn btn-success" role="button">Save The NDA File Into Your Computer</a>
                            </div>
                        </div>
                        <div class="col-sm-offset-4 col-lg-offset-5">
                            <div class="form-group">
                                <input type="submit" value="Upload The Signed NDA's Picture" name="submit" id="submit" class="btn btn-success">
                                <label class="btn btn-default btn-file">
                                    Choose File <input type="file" name="fileToUpload" id="fileToUpload" style="display: none;">
                                </label>
                            </div>
                            <?php

                            // Check if image file is a actual image or fake image
                            if(isset($_POST["submit"])) {
                                //$target_dir = "nda/";
                                $target_dir = getcwd() . '/nda/';
                                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                                $uploadOk = 1;
                                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
								
                                if($check !== false) {
                                    echo "File is an image - " . $check["mime"] . ".";
                                    $uploadOk = 1;
                                } else {
                                    echo "File is not an image.";
                                    $uploadOk = 0;
                                }

                                /* Check if file already exists
                                if (file_exists($target_file)) {
                                    echo "Sorry, file already exists.";
                                    $uploadOk = 0;
                                }
								*/
                                // Check file size
                                if ($_FILES["fileToUpload"]["size"] > 500000) {
                                    echo "Sorry, your file is too large.";
                                    $uploadOk = 0;
                                }
                                // Allow certain file formats
                                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                                   && $imageFileType != "gif") {
                                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                    $uploadOk = 0;
                                }
                                // Check if $uploadOk is set to 0 by an error
                                if ($uploadOk == 0) {
                                    echo "Sorry, your file was not uploaded.";
                                    // if everything is ok, try to upload file
                                } else {
                                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                                        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                                    } else {
                                        echo "Sorry, there was an error uploading your file.";
                                    }
                                }

                            }
                            ?>
                        </div>
                        <div class="col-sm-offset-4 col-lg-offset-5">
                            <div class="form-group">
                                <a href="home.php" class="btn btn-danger" role="button">Decline and Back to the Home Page</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>


    </body>
</html>
