<?php 
    session_start();
    require_once("../../include/favicon.php");
    require_once("../../include/configdb.php");
    require_once("../../include/sideBar.php");
    require_once("../../include/getUserTypeAndVerifyLogin.php");

    $userid = $_SESSION["userEmail"];
    if (isset($_POST['submit'])) {
        $email =  mysqli_real_escape_string($link, $_POST["email"]);
        $phone =  mysqli_real_escape_string($link, $_POST["phone "]);
        $time_zone =  mysqli_real_escape_string($link, $_POST["time_zone"]);
        $privacy =  mysqli_real_escape_string($link, $_POST["privacy"]);

        $sql = "UPDATE Users SET email='$email', phone='$phone', time_zone='$time_zone', privacy='$privacy' WHERE email='$userid'";

        if ($link->query($sql) === TRUE) {
            echo "Updated";
        } else {
            echo "Error: " . $sql . "<br>" . $link->error;
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Account</title>
        <?php echo getFavicon(); ?>
        <link href="Styles/home.css" rel="stylesheet" />
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
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
                                <li><a href="#">Browse Listing <span class="sr-only">(current)</span></a></li>
                                <li><a href="activeListing.php">Active Listing</a></li>
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
                displaySideBar("Account", $userType);
              ?>

                <!-- your page content -->
                <div class="col-sm-9 col-lg-10">
                    <div class="account">
                        <h1>Update Your Account</h1>

                        <form class="form-horizontal" action="account.php" method="POST">

                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">Email Address</label>
                                <div class="col-sm-4">
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone" class="col-sm-2 control-label">Phone</label>
                                <div class="col-sm-4">
                                    <input type="tel" class="form-control" id="phone" name="phone">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="time_zone" class="col-sm-2 control-label">Confirm Password</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="time_zone" id="time_zone">
                                        <option value="-12.0">(GMT -12:00) Eniwetok, Kwajalein</option>
                                        <option value="-11.0">(GMT -11:00) Midway Island, Samoa</option>
                                        <option value="-10.0">(GMT -10:00) Hawaii</option>
                                        <option value="-9.0">(GMT -9:00) Alaska</option>
                                        <option value="-8.0">(GMT -8:00) Pacific Time (US &amp; Canada)</option>
                                        <option value="-7.0">(GMT -7:00) Mountain Time (US &amp; Canada)</option>
                                        <option value="-6.0">(GMT -6:00) Central Time (US &amp; Canada), Mexico City</option>
                                        <option value="-5.0">(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
                                        <option value="-4.0">(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option>
                                        <option value="-3.5">(GMT -3:30) Newfoundland</option>
                                        <option value="-3.0">(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
                                        <option value="-2.0">(GMT -2:00) Mid-Atlantic</option>
                                        <option value="-1.0">(GMT -1:00 hour) Azores, Cape Verde Islands</option>
                                        <option value="0.0">(GMT) Western Europe Time, London, Lisbon, Casablanca</option>
                                        <option value="1.0">(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris</option>
                                        <option value="2.0">(GMT +2:00) Kaliningrad, South Africa</option>
                                        <option value="3.0">(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
                                        <option value="3.5">(GMT +3:30) Tehran</option>
                                        <option value="4.0">(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option>
                                        <option value="4.5">(GMT +4:30) Kabul</option>
                                        <option value="5.0">(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
                                        <option value="5.5">(GMT +5:30) Bombay, Calcutta, Madras, New Delhi</option>
                                        <option value="5.75">(GMT +5:45) Kathmandu</option>
                                        <option value="6.0">(GMT +6:00) Almaty, Dhaka, Colombo</option>
                                        <option value="7.0">(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
                                        <option value="8.0">(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
                                        <option value="9.0">(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
                                        <option value="9.5">(GMT +9:30) Adelaide, Darwin</option>
                                        <option value="10.0">(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
                                        <option value="11.0">(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
                                        <option value="12.0">(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="privacy" class="col-sm-2 control-label">Account Privacy</label>
                                <div class="col-sm-4">
                                    <div class="radio"><label><input type="radio" name="privacy" id="privacy" value="public" checked>Public Profile</label></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="privacy" class="col-sm-2 control-label"></label>
                                <div class="col-sm-4">
                                    <div class="radio"><label><input type="radio" name="privacy" id="privacy" value="protect">Protected Profile</label></div>
                                </div>
                            </div>
                            

                            <div class="form-group">
                                <div class="col-sm-2 "></div>
                                <div class="col-sm-4">
                                    <button type="submit" class="btn btn-default" name="submit">Save</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </body>
</html>
