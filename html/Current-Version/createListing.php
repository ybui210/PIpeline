<?php
    require_once("../../include/favicon.php");
    require_once("../../include/configdb.php");
    require_once("../../include/navBar.php");
    require_once("../../include/getUserTypeAndVerifyLogin.php");

    $valueError = 0;
    $nameListing = "";
    $intro =  "";
    $jurisdiction =   "";
    $investmentType =   "";
    $commodities =   "";
    $depositType =   "";
    $developmentStage = "";
    $resourceSize =   "";
    $acquisitionStrategy =   "";
    $dueDilligence =  "";
    $purchaserInfo =   "";
    $minPrice =   "";
    $maxPrice =   "";
    $details =   "";

    if ( isset( $_POST['submit'] ) ) {
        $nameListing = mysqli_real_escape_string($link, $_POST["name"]);
        $intro =  mysqli_real_escape_string($link, $_POST["intro"]);
        $jurisdiction =  mysqli_real_escape_string($link,$_POST["jurisdiction"]);
        $investmentType =  mysqli_real_escape_string($link,$_POST["investmentType"]);
        $commodities =  mysqli_real_escape_string($link,$_POST["commodities"]);
        $depositType =  mysqli_real_escape_string($link,$_POST["depositType"]);
        $developmentStage = mysqli_real_escape_string($link, $_POST["developmentStage"]);
        $resourceSize =  mysqli_real_escape_string($link,$_POST["resourceSize"]);
        $acquisitionStrategy =  mysqli_real_escape_string($link,$_POST["acqusitionStrategy"]);
        $dueDilligence =  mysqli_real_escape_string($link,$_POST["dueDilligence"]);
        $purchaserInfo =  mysqli_real_escape_string($link,$_POST["purchaserInfo"]);
        $minPrice =  mysqli_real_escape_string($link,$_POST["minPrice"]);
        $maxPrice =  mysqli_real_escape_string($link,$_POST["maxPrice"]);
        $details =  mysqli_real_escape_string($link,$_POST["details"]);

        if($minPrice>=0 && $maxPrice>=0){
            $sql = "INSERT INTO Listings (name, introduction, jurisdiction, investmentType, depositType, developmentStage, resourceSize, acquisitionStrategy, dueDiligence, purchaserInformation, priceBracketMin, 
            priceBracketMax, additionalDetails, email, status)
            VALUES ('$nameListing', '$intro', '$jurisdiction', '$investmentType', '$depositType', '$developmentStage', '$resourceSize', '$acquisitionStrategy', '$dueDilligence', '$purchaserInfo', '$minPrice', '$maxPrice', '$details', '$userid', 'draft' )";
            if ($link->query($sql) === TRUE) {
            } else {
                echo "Error: " . $sql . "<br>" . $link->error;
            }
        } else {
            $valueError=1;
            echo "valueError is set";
        }
        $id = mysqli_insert_id($link);
        header("Location: reviewListing.php?id=$id");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Create Listing</title>
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

                <h1>Create a New Listing</h1>

                <form class="form-horizontal" action="createListing.php" method="POST">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="name" name="name" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="intro" class="col-sm-2 control-label">Listing Introduction</label>
                        <div class="col-sm-4">
                            <textarea type="text" class="form-control" id="intro" rows="5" name="intro"><?php echo $intro ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="jurisdiction" class="col-sm-2 control-label">Jurisdiction</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="jurisdiction" name="jurisdiction">
                                <option>Canada</option>
                                <option>USA</option>
                                <option>Middle East</option>
                                <option>Africa</option>
                                <option>Australia</option>
                                <option>South America</option>
                                <option>Asia</option>
                                <option>Mexico</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="investmentType" class="col-sm-2 control-label">Investment Type</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="investmentType" name="investmentType">
                                <option>Business for Sale</option>
                                <option>Joint Partnership</option>
                                <option>Public Equity</option>
                                <option>Private Equity</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="commodities" class="col-sm-2 control-label">Commodities</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="commodities" name="commodities" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="depositType" class="col-sm-2 control-label">Deposit Type</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="depositType" name="depositType" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="developmentStage" class="col-sm-2 control-label">Development Stage</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="developmentStage" name="developmentStage" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="resourceSize" class="col-sm-2 control-label">Resource Size</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="resourceSize" name="resourceSize" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="minPrice" class="col-sm-2 control-label">Price Bracket</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" id="minPrice" name="minPrice" />
                            <p>to</p>
                            <input type="number" class="form-control" id="maxPrice" name="maxPrice" />
                            <?php
                            if($valueError == 1){
                                echo "Value must be a positive integer.";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="photos" class="col-sm-2 control-label" >Photos</label>
                        <input type="file" id="photos" name="photos">
                    </div>

                    <div class="form-group">
                        <label for="details" class="col-sm-2 control-label">Additional Details</label>
                        <div class="col-sm-4">
                            <textarea type="text" class="form-control" id="details" rows="5" name="details"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default" name="submit" >Review and Submit your Listing</button>
                        </div>
                    </div>
                </form>
                </div>
                <!-- your page content -->
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>