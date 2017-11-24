<?php
/**
 * Created by PhpStorm.
 * User: Andra
 * Date: 2017-11-13
 * Time: 8:15 PM
 */

    require_once("../../include/favicon.php");
    require_once("../../include/configdb.php");

    $varName = $_GET['name'];

    if ( isset( $_POST['submit'] ) ) {

        $listingId = mysqli_real_escape_string($link, $_POST["listingId"]);
        $sql = "UPDATE Listings SET status='approved' WHERE listingID= '$listingId' ";

        if ($link->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $link->error;
        }

        header("Location: adminViewListings.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Review Listings</title>
        <?php echo getFavicon(); ?>
        <link href="Styles/home.css" rel="stylesheet" />
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
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
                                <li class="active"><a href="createListing.php">Create Listing</a></li>
                                <li><a href="#">News</a></li>

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
            </div>
            <div class="row">
                <div class="col-sm-3 col-lg-2 navBarDiv hidden-xs">

                    <nav class="nav nav-pills nav-stacked leftNavbar">
                        <li><a href="">Users</a></li>
                        <li ><a href="">All Listings</a></li>
                        <li><a href="">Listings pending Review</a></li>
                    </nav>
                </div>
                <div class="col-sm-9 col-lg-10">
                    <div class="">

                        <h1>Review Your Listing</h1>
                        <dl class="dl-horizontal">

                            <h1><?php echo $varName?></h1>
                            <?php
                            $sql = "SELECT * FROM Listings WHERE name = '$varName'";
                            $result = $link->query($sql);

                            $row = $result->fetch_array(MYSQLI_ASSOC);
                            $id = $row["listingID"];
                            $name = $row["name"];
                            $intro = $row["introduction"];
                            $jurisdiction = $row["jurisdiction"];
                            $depositType = $row["depositType"];
                            $developmentStage = $row["developmentStage"];
                            $resourceSize = $row["resourceSize"];
                            $acquisitionStrategy = $row["acquisitionStrategy"];
                            $dueDilligence = $row["dueDiligence"];
                            $purchaserInfo = $row["purchaserInformation"];
                            $priceBracketMin = $row["priceBracketMin"];
                            $priceBracketMax = $row["priceBracketMax"];
                            $additionalDetails = $row["additionalDetails"];

                            ?>

                            <dt>Name</dt>
                            <dd><?php echo $name?></dd>
                            <div>
                                <dt>Listing Introduction</dt>
                                <dd><?php echo $intro?></dd>
                            </div>
                            <div>
                                <dt>Jurisdiction</dt>
                                <dd><?php echo $jurisdiction?></dd>
                            </div>

                            <dt>Deposit Type</dt>
                            <dd><?php echo $depositType?></dd>
                            <dt>Development Stage</dt>
                            <dd><?php echo $developmentStage?></dd>
                            <dt>Resource Size</dt>
                            <dd><?php echo $resourceSize?></dd>
                            <dt>Acquisition Strategy</dt>
                            <dd><?php echo $acquisitionStrategy?></dd>
                            <dt>Due Dilligence</dt>
                            <dd><?php echo $dueDilligence?></dd>
                            <dt>Purchaser Information</dt>
                            <dd><?php echo $purchaserInfo?></dd>
                            <dt>Price Bracket</dt>
                            <dd><?php echo $priceBracketMin?></dd>
                            <dd>to</dd>
                            <dd><?php echo $priceBracketMax?></dd>
                            <dt>Photos</dt>
                            <dd></dd>
                            <dt>Additional Details</dt>
                            <dd><?php echo $additionalDetails?></dd>
                            <br>
                            <dt></dt>
                            <form action="adminReviewPage.php" method="POST">
                                <input type="hidden" name="listingId" value="<?php echo $id ?>">
                                <dd><button type="submit" class="btn btn-default" name="submit" >Approve</button></dd>
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