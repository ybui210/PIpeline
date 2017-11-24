<?php
    require_once("../../include/favicon.php");
    require_once("../../include/configdb.php");
    require_once("../../include/navBar.php");
    require_once("../../include/getUserTypeAndVerifyLogin.php");
?>
<!DOCTYPE html>
<html>
<head>

    <title>View Listings</title>
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
        <?php displaySideBar("Listings Pending Review", $userType); ?>
        <div class="col-sm-9 col-lg-10">
            <div class="">
                <h1>Listings pending Review</h1>
                <?php
                $sql = "SELECT * FROM Listings WHERE status = 'reviewed'";
                $result = $link->query($sql);

                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    $id = $row["listingID"];
                    $name = $row["name"];
                    $intro = $row["introduction"];
                    ?>
                    <div class="row">
                        <a href="adminReviewPage.php?name=<?php echo $name ?>">
                            <div class="w3-card-4" margin="10">
                                <header class="w3-container w3-light-grey">
                                    <h4><?php echo $name; ?></h4>
                                </header>
                                <div class="w3-container" style="height:70px">
                                    <p><?php echo $intro; ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                }



                ?>

            </div>
            <!-- your page content -->
        </div>
    </div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</body>
</html>
