<?php
    require_once("../../include/favicon.php");
    require_once("../../include/configdb.php");
    require_once("../../include/navBar.php");
    require_once("../../include/getUserTypeAndVerifyLogin.php");
    session_start();

// validation part
/*$userid = $_SESSION["userEmail"];
if(!isset($userid)) {
    header("Location:login.php");
    exit;
}*/
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Notifications</title>
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
            <?php displaySideBar("Notifications", $userType); ?>
                <!-- your page content -->
                <div class="col-sm-9 col-lg-10">
                    <div class="notificationPreferences">
                        <h1>Notification Preferences</h1>

                        <form class="form-horizontal" action="notificationPreferences.php" method="POST">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Connection Request</label>
                                <div class="col-sm-4 checkbox">
                                    <label><input type="checkbox" id="email" name="email" value="email">Email</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-4 checkbox">
                                    <label><input type="checkbox" id="message" name="message" value="message">New Message</label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-4 checkbox">
                                    <label><input type="checkbox" id="mobile" name="mobile" value="mobile">Mobile</label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label">New Message</label>
                                <div class="col-sm-4 checkbox">
                                    <label><input type="checkbox" id="email" name="email" value="email">Email</label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-4 checkbox">
                                    <label><input type="checkbox" id="message" name="message" value="message">New Message</label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-4 checkbox">
                                    <label><input type="checkbox" id="mobile" name="mobile" value="mobile">Mobile</label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Listing Notification</label>
                                <div class="col-sm-4 checkbox">
                                    <label><input type="checkbox" id="email" name="email" value="email">Email</label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-4 checkbox">
                                    <label><input type="checkbox" id="message" name="message" value="message">New Message</label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-4 checkbox">
                                    <label><input type="checkbox" id="mobile" name="mobile" value="mobile">Mobile</label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Listing Access Request</label>
                                <div class="col-sm-4 checkbox">
                                    <label><input type="checkbox" id="email" name="email" value="email">Email</label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-4 checkbox">
                                    <label><input type="checkbox" id="message" name="message" value="message">New Message</label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-4 checkbox">
                                    <label><input type="checkbox" id="mobile" name="mobile" value="mobile">Mobile</label>
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
