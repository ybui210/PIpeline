<?php
    require_once("../../include/favicon.php");
    require_once("../../include/configdb.php");
    require_once("../../include/navBar.php");
    require_once("../../include/getUserTypeAndVerifyLogin.php");
    $_SESSION["view"]=0;
    if ( isset( $_POST['cancel'] ) ) {
        header("Location: myListings.php");
        exit;
    }
    if (isset($_POST["Remove"]))
    {
        $id = $_POST["Remove"];
        $sql = "DELETE FROM Listings WHERE listingId = ". $id .";";
        $link->query($sql);
        header("Location: myListings.php");
        exit;
    }
    $valueError = 0;
    $id = $_POST["Edit"];
    $sql = "SELECT * FROM Listings WHERE listingId = ". $id .";";
    $result = $link->query($sql);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $name = $row["name"];
    //echo $id." ".$name;
    $intro = $row["introduction"];
    $jur = $row["jurisdiction"];
    $depType = $row["depositType"];
    $investmentType = $row["investmentType"];
    $minPrice = $row["priceBracketMin"];
    $maxPrice = $row["priceBracketMax"];
    $details = $row["additionalDetails"];

    $userid = $_SESSION["userEmail"];

    if ( isset( $_POST['submit'] ) ) {
        $nameListing = mysqli_real_escape_string($link, $_POST["name"]);
        $intro =  mysqli_real_escape_string($link, $_POST["intro"]);
        $jurisdiction =  mysqli_real_escape_string($link,$_POST["jurisdiction"]);
        $investmentType =  mysqli_real_escape_string($link,$_POST["investmentType"]);
        $minPrice =  mysqli_real_escape_string($link,$_POST["minPrice"]);
        $maxPrice =  mysqli_real_escape_string($link,$_POST["maxPrice"]);
        $details =  mysqli_real_escape_string($link,$_POST["details"]);

        if($minPrice>=0 && $maxPrice>=0){
            $sql = "UPDATE Listings SET name=".$nameListing.", introduction=".$intro.", jurisdiction=".$jurisdiction.", investmentType=".$investmentType.", depositType=".$depositType.", developmentStage=".$developmentStage.", resourceSize=".$resourceSize.", acquisitionStrategy=".$acquisitionStrategy.", dueDiligence=".$dueDiLligence.", purchaserInformation=".$purchaserInfo.", priceBracketMin=".$minPrice.", 
            priceBracketMax=".$maxPrice.", additionalDetails=".$details.", email=".$userid.", status='draft' WHERE listingId =".$id;
            if ($link->query($sql) === TRUE) {
            } else {
                echo "Error: " . $sql . "<br>" . $link->error;
            }
        } else {
            $valueError=1;
            echo "valueError is set";
        }

        $id = mysqli_insert_id($link);

        //header("Location: reviewListing.php?id=$id");
        header("Location: myListings.php");
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
</head>

<body>

<div class="container-fluid" >
          <?php displayNavBar($userType); ?>

          <div class="row">
            
            <?php displaySideBar("Home", $userType); ?>
        <div class="col-sm-9 col-lg-10">
            <div class="">

            <h1>Edit Listing</h1>

            <form class="form-horizontal" action="editListing.php" method="POST">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="name" value="<?php echo $name;?>" name="name"/>
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
                        <select class="form-control" id="jurisdiction" value="<?php echo $jur;?>" name="jurisdiction">
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
                    <label for="minPrice" class="col-sm-2 control-label">Price Bracket</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" id="minPrice" value="<?php echo $minPrice;?>" name="minPrice"/>
                        <p>to</p>
                        <input type="number" class="form-control" id="maxPrice" value="<?php echo $maxPrice;?>" name="maxPrice"/>
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
                        <textarea type="text" class="form-control" id="details" rows="5" name="details"><?php echo $details;?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-2">
                        <button type="cancel" class="btn btn-default" name="cancel">Cancel</button>
                    </div>
                    
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-default btn-success" name="submit">Submit Listing</button>
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
