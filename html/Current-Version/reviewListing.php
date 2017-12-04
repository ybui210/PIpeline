<?php
    require_once("../../include/favicon.php");
    require_once("../../include/configdb.php");
    require_once("../../include/navBar.php");
    require_once("../../include/getUserTypeAndVerifyLogin.php");
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
        die();
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
        <div class="container-fluid" >
            <?php displayNavBar($userType); ?>
            <div class="row">
                <?php displaySideBar("Not a side bar option", $userType); ?>
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
                            <?php if ($_SESSION["view"]==1)
                            { ?>
                            <form action="editListing.php" method="POST">
                                <button type="submit" class="btn btn-default btn-success" name="Edit" value="<?php echo $id;?>">Edit</button>
                                <button type="submit" class="btn btn-default btn-danger" name="Remove" value="<?php echo $id;?>"> Delete</button>
                            </form>
                            <?php } else { ?>
                            <form action="reviewListing.php" method="POST">
                                <input type="hidden" name="listingId" value="<?php echo $id ?>">
                                <dd><button type="submit" class="btn btn-default" name="submit" >Submit</button></dd>
                            </form>
                            <?php } ?>
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