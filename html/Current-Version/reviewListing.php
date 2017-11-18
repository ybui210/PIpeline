<?php
    require_once("../../include/favicon.php");
    require_once("../../include/configdb.php");
/**
 * Created by PhpStorm.
 * User: Andra
 * Date: 2017-11-13
 * Time: 11:43 AM
 */

$id = mysqli_real_escape_string($link, $_GET["id"]);

$sql = "SELECT * FROM Listings WHERE listingID = $id";
$result = $link->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $row = $result->fetch_assoc();
}

if ( isset( $_POST['submit'] ) ) {

    $listingId = mysqli_real_escape_string($link, $_POST["listingId"]);
    $sql = "UPDATE Listings SET status='reviewed' WHERE listingID= '$listingId' ";

    if ($link->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $link->error;
    }

    header("Location: submittedListing.php");
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Review Listing</title>
    <?php echo getFavicon(); ?>
    <link href="Styles/home.css" rel="stylesheet" />
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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
                        <li ><a href="#">Browse Listing <span class="sr-only">(current)</span></a></li>
                        <li><a href="#">Active Listing</a></li>
                        <li class="active"><a href="createListing.php">Create Listing</a></li>
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
                <li><a href="">Account</a></li>
                <li ><a href="">Password</a></li>
                <li><a href="">Profile</a></li>
                <li><a href="">Notifications</a></li>
                <li><a href="">System History</a></li>
                <li><a href="">Social Connections</a></li>
            </nav>
        </div>
        <div class="col-sm-9 col-lg-10">
            <div class="">
                <h1>Review Your Listing</h1>
                <dl class="dl-horizontal">
                    <dt>Name</dt>
                    <dd><?php echo $row["name"]?></dd>
                    <div>
                        <dt>Listing Introduction</dt>
                        <dd><?php echo $row["introduction"]?></dd>
                    </div>
                    <div>
                        <dt>Jurisdiction</dt>
                        <dd><?php echo $row["jurisdiction"]?></dd>
                    </div>

                    <dt>Deposit Type</dt>
                    <dd><?php echo $row["depositType"]?></dd>
                    <dt>Development Stage</dt>
                    <dd><?php echo $row["developmentStage"]?></dd>
                    <dt>Resource Size</dt>
                    <dd><?php echo $row["resourceSize"]?></dd>
                    <dt>Acquisition Strategy</dt>
                    <dd><?php echo $row["acquisitionStrategy"]?></dd>
                    <dt>Due Dilligence</dt>
                    <dd><?php echo $row["dueDiligence"]?></dd>
                    <dt>Purchaser Information</dt>
                    <dd><?php echo $row["purchaserInformation"]?></dd>
                    <dt>Price Bracket</dt>
                    <dd><?php echo $row["priceBracketMin"]?></dd>
                    <dd>to</dd>
                    <dd><?php echo $row["priceBracketMax"]?></dd>
                    <dt>Photos</dt>
                    <dd></dd>
                    <dt>Additional Details</dt>
                    <dd><?php echo $row["additionalDetails"]?></dd>
                    <br>
                    <dt></dt>
                    <form action="reviewListing.php" method="POST">
                        <input type="hidden" name="listingId" value="<?php echo $id ?>">
                        <dd><button type="submit" class="btn btn-default" name="submit" >Submit</button></dd>
                    </form>

                </dl>







            </div>
            <!-- your page content -->
        </div>
    </div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</body>
</html>