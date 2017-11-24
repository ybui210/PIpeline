<?php 
    require_once("../../include/favicon.php");
    require_once("../../include/configdb.php");
    require_once("../../include/navBar.php");
    require_once("../../include/getUserTypeAndVerifyLogin.php");
?>
<!DOCTYPE html>
<html>
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <head>
        <title>Latest Listings</title>
        <?php echo getFavicon(); ?>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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
                <div class="col-sm-6 col-lg-10">
                    <h1>Latest Listings</h1>
                    <?php
                    $sql = "SELECT listingId, name, introduction FROM Listings";
                    $result = $link->query($sql);
                    //for ($i=0; $i<5; $i++){
                    while ($row = $result->fetch_array(MYSQLI_ASSOC)){
                        $id = $row["listingId"];
                        $name = $row["name"];
                        $intro = $row["introduction"];
                        if ($intro != null){
                        ?>
                        <div class="row">
                            <div class="w3-card-4" margin="10">

                                <header class="w3-container w3-light-grey">
                                  <h4><?php echo $name;?></h4>
                                </header>

                                <div class="w3-container" style="height:70px">
                                  <img src="Images/placeholder.png" alt="Image Unavailable" class="w3-left w3-circle" style="height:60px">
                                  <p><?php echo $intro; ?></p>
                                </div>
                            </div>

                        </div>
                    <?php
                    }}
                    ?>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    </body>
</html>