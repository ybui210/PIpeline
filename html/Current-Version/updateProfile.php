<?php
require_once("../configdb.php");
session_start();

// validation part
$userid = $_SESSION["userEmail"];
/*if(!isset($userid)) {
    header("Location:login.php");
    exit;
}*/

if (isset($_POST['submit'])) {
    $account =  mysqli_real_escape_string($link, $_POST["account"]);
    $birthday =  mysqli_real_escape_string($link, $_POST["birthday"]);
    $locations =  mysqli_real_escape_string($link, $_POST["locations"]);
    $bio =  mysqli_real_escape_string($link, $_POST["bio"]);
    $gender =  mysqli_real_escape_string($link, $_POST["gender"]);
    $link =  mysqli_real_escape_string($link, $_POST["link"]);

$sql = "UPDATE Users SET location='$locations', bio='$bio', gender='$gender' WHERE email='$userid'";

if ($link->query($sql) === TRUE) {
    echo "Updated";
        } else {
            echo "Error: " . $sql . "<br>" . $link->error;
        }
    
} 

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

            <div class="row">
                <div class="col-sm-3 col-lg-2 navBarDiv hidden-xs">

                    <nav class="nav nav-pills nav-stacked leftNavbar">
                        <li><a href="account.php">Account</a></li>
                        <li><a href="changePassword.php">Password</a></li>
                        <li  class="active"><a href="updateProfile.php">Profile</a></li>
                        <li><a href="notificationPreferens.php">Notifications</a></li>
                        <li><a href="">System History</a></li>
                        <li><a href="">Social Connections</a></li>
                    </nav>
                </div>

                <!-- your page content -->
                <div class="col-sm-9 col-lg-10">
                    <div class="updateProfile">
                        <h1>Update Your Profile</h1>

                        <form class="form-horizontal" action="updateProfile.php" method="POST">

                            <div class="form-group">
                                <label for="account" class="col-sm-2 control-label">Account</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="account" name="account">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="birthday" class="col-sm-2 control-label">Birthday</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" id="birthday" name="birthday">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="locations" class="col-sm-2 control-label">Locations</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="locations" name="locations">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="bio" class="col-sm-2 control-label">Bio</label>
                                <div class="col-sm-4">
                                    <textarea class="form-control" rows="5" id="bio" name="bio"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="gender" class="col-sm-2 control-label">Gender</label>
                                <div class="col-sm-4">
                                    <select class="form-control" id="gender" name="gender">
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="link" class="col-sm-2 control-label">Link</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="link" name="link">
                                </div>
                            </div>

                             <div class="form-group">
                                <div class="col-sm-2 "></div>
                                <div class="col-sm-4">
                                    <button type="submit" class="btn btn-default" name="submit">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        

    </body>
</html>
