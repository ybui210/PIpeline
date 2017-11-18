<?php 
    require_once("../../include/favicon.php");
    require_once("../../include/configdb.php");
?>
<!DOCTYPE html>

<html>
<meta name="viewport" content="width=device-width, initial-scale=1">    
<head>
    <title>My Listings</title>
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
    <div class="row">
        <nav class="navbar navbar-inverse topNavBarDiv">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Pipeline</a>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Browse Listings</a></li>
                    <li><a href="latestListings.php">Active Listings</a></li>
                    <li><a href="createListing.php">Create Listing</a></li>
                    <li><a href="#">News</a></li>
                </ul>
                <form class="navbar-form navbar-left" method="post" action="searchListings.php">
                    <div class="form-group">
                        <input name="searchkey" type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
        </nav>
    </div>

    <div class="row">
        <div class="col-sm-3 col-lg-2 navBarDiv">
            <nav class="nav nav-pills nav-stacked leftNavbar">
                <li><a href="profile.php">Profile</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li class="active"><a href="myListings.php">My Listings</a></li>
                <li><a href="savedListings.php">Saved Listings</a></li>
                <li><a href="">Drafts</a></li>
            </nav>
        </div>
        
        <!************************************/>
        <div class="col-sm-6 col-lg-10">
            <h1>My Listings</h1>
            <?php
            $sql = "SELECT listingId, name, introduction FROM Listings;";
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
                            <h4>NAME<?php echo $name;?></h4>
                        </header>

                        <div class="w3-container">
                            <img src="Images/placeholder.png" alt="Image Unavailable" class="w3-left w3-circle" style="height:60px">
                            <p><?php echo $intro; ?>
                            </p>
                            <div>
                                <form method="post" action="removeEditListing.php">
                                    <button type="submit" name="Remove" value="<?php echo $id;?>" class="w3-right w3-button w3-red">Remove</button>
                                    <button type="submit" name="Edit" value="<?php echo $id;?>" class="w3-right w3-button w3-green">Edit</button>
                            
                                </form>
                            </div>
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