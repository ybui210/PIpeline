<?php
/**
 * Created by PhpStorm.
 * User: Andra
 * Date: 2017-11-13
 * Time: 8:15 PM
 */

    require_once("../../include/favicon.php");
    require_once("../../include/configdb.php");
    require_once("../../include/navBar.php");
    require_once("../../include/getUserTypeAndVerifyLogin.php");

    $listingIdFromViewListings = $_GET['id'];

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
            <?php displayNavBar($userType); ?>
            <div class="row">
                <?php displaySideBar("", $userType); ?>
                <div class="col-sm-9 col-lg-10">
                    <div class="">
                        <h1>Review Your Listing</h1>
                        <dl class="dl-horizontal">

                            <?php
                            $sql = "SELECT * FROM Listings WHERE listingID = '$listingIdFromViewListings'";
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