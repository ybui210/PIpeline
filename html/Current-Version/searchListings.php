<?php 
    require_once("../../include/favicon.php");
    require_once("../../include/configdb.php");
    require_once("../../include/navBar.php");
    require_once("../../include/getUserTypeAndVerifyLogin.php");
    $keyword = $_POST["searchkey"];
    $dir    = 'Uploads/';
    $files = scandir($dir);
?>
<!DOCTYPE html>

<html>
<meta name="viewport" content="width=device-width, initial-scale=1">    
<head>
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
            <h1>Search result for "<?php echo $keyword;?>"</h1>
            <?php
            
            $sql = "SELECT * FROM Listings";
            $result = $link->query($sql);
            
            //go through each listings
            while ($row = $result->fetch_array(MYSQLI_ASSOC)){
                $image = "Images/placeholder.png";
                foreach ($files as $file)
                {
                    $idd = $row["listingID"]."-";
                    if (substr($file, 0, strlen($row["listingID"])+1) == ($idd))
                    {
                        $image = $dir.$file;
                        break;
                    }
                }
                //go through each column in a listing
                foreach($row as $key => $value) {
                    if (strpos(strtolower($value), strtolower($keyword))!== false){
                    ?>
                    <a style="display:block; text-decoration:none; marginTop:10" href="<?php $_SESSION["view"]=1; echo "reviewListing.php?id=".$row["listingID"];?>">
                <div class="row" style="marginTop:10">
                    <div class="w3-card-4" margin="10">

                        <header class="w3-container w3-light-grey">
                            <h4><?php if ($row["name"]==null) echo "N/A"; else echo $row["name"];?></h4>
                        </header>
                       
                        <div class="w3-container">
                            <img src="<?php echo $image;?>" alt="Image Unavailable" class="w3-left w3-circle" style="height:60px; width:60px">
                            <p><?php echo $row["introduction"]; ?>
                            </p>
                            <div>
                                <form method="post" action="editListing.php">
                                    <button type="submit" name="Remove" value="<?php echo $row["listingID"];?>" class="w3-right w3-button w3-red">Remove</button>
                                    <button type="submit" name="Edit" value="<?php echo $row["listingID"];?>" class="w3-right w3-button w3-green">Edit</button>

                                </form>
                            </div>
                        </div>
                                                      
                        </div>
                        
                </div>
            </a>
                <?php
            break;}}}
            
            ?>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

</body>
</html>