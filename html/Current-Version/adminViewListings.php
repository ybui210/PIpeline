<?php

require_once("../../include/configdb.php");



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
                <li><a href="">Users</a></li>
                <li ><a href="">All Listings</a></li>
                <li><a href="">Listings pending Review</a></li>
            </nav>
        </div>
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
