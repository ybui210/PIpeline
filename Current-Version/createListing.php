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
        </nav>

    </div>

    <div class="row">
        <div class="col-sm-3 col-lg-2 navBarDiv">
            <nav class="nav nav-pills nav-stacked leftNavbar">
                <li><a href="profile.php">Profile</a></li>
                <li class="active"><a href="dashboard.php">Dashboard</a></li>
                <li><a href="myListings.php">My Listings</a></li>
                <li><a href="savedListings.php">Saved Listings</a></li>
                <li><a href="">Drafts</a></li>
            </nav>
        </div>
        <div class="col-sm-9 col-lg-10">
            <div class="row header">

            </div>
            <h1>Create a New Listing</h1>

            <form class="form-horizontal">
                <div class="form-group">
                    <label for="intro" class="col-sm-2 control-label">Listing Introduction</label>
                    <div class="col-sm-4">
                        <textarea type="text" class="form-control" id="intro" rows="5"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="jurisdiction" class="col-sm-2 control-label">Jurisdiction</label>
                    <div class="col-sm-4">
                        <select class="form-control" id="jurisdiction">
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
                        <select class="form-control" id="investmentType">
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
                        <select class="form-control" id="commodities">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="depositType" class="col-sm-2 control-label">Deposit Type</label>
                    <div class="col-sm-4">
                        <select class="form-control" id="depositType">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="developmentStage" class="col-sm-2 control-label">Development Stage</label>
                    <div class="col-sm-4">
                        <select class="form-control" id="developmentStage">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="resourceSize" class="col-sm-2 control-label">Resource Size</label>
                    <div class="col-sm-4">
                        <select class="form-control" id="resourceSize">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="acquisitionStrategy" class="col-sm-2 control-label">Acquisition Strategy</label>
                    <div class="col-sm-4">
                        <select class="form-control" id="acquisitionStrategy">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="dueDilligence" class="col-sm-2 control-label">Due Dilligence</label>
                    <div class="col-sm-4">
                        <select class="form-control" id="dueDilligence">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="purchaserInfo" class="col-sm-2 control-label">Purchaser Information</label>
                    <div class="col-sm-4">
                        <select class="form-control" id="purchaserInfo">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="price" class="col-sm-2 control-label">Price Bracket</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="price"></input>
                        <p>to</p>
                        <input type="text" class="form-control" id="toprice"></input>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

</body>
</html>