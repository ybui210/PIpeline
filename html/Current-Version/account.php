<?php 
    session_start();
    require_once("../../include/favicon.php");
    require_once("../../include/configdb.php");
    require_once("../../include/navBar.php");
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
            <?php displayNavBar($userType); ?>
            <div class="row">
            
            <?php displaySideBar("Account", $userType); ?>

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
