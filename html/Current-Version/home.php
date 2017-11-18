<?php
    require_once("../../include/configdb.php");
    require_once("../../include/sideBar.php");
    require_once("../../include/getUserTypeAndVerifyLogin.php");
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
                              <li><a href="#">Active Listing</a></li>
                              <li><a href="createListing.php">Create Listing</a></li>
                              <li><a href="#">News</a></li>
                              <li class="hidden-lg hidden-md hidden-sm"><a href="">Account</a></li>
                              <li class="hidden-lg hidden-md hidden-sm"><a href="">Password</a></li>
                              <li class="hidden-lg hidden-md hidden-sm"><a href="">Profile</a></li>
                              <li class="hidden-lg hidden-md hidden-sm"><a href="">Notifications</a></li>
                              <li class="hidden-lg hidden-md hidden-sm"><a href="">System History</a></li>
                              <li class="hidden-lg hidden-md hidden-sm"><a href="">Social Connections</a></li>

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

          </div>

          <div class="row">
            
            <?php
                displaySideBar("Home", $userType);
              ?>
              <div class="col-sm-9 col-lg-10">
                  <div class="row header">

                  </div>
                <!-- your page content -->
            </div>
          </div>
        </div>
      <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    </body>
  </html>
