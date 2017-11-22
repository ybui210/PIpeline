<?php
    require_once("../../include/configdb.php");
    require_once("../../include/navBar.php");
    require_once("../../include/getUserTypeAndVerifyLogin.php");
    session_start();

    // validation part
    $userid = $_SESSION["userEmail"];
    /*if(!isset($userid)) {
        header("Location:login.php");
        exit;
    }*/
    /* Done */
    if (isset($_POST['submitUpdateProfile'])) {
        $account =  mysqli_real_escape_string($link, $_POST["account"]);
        $birthday =  mysqli_real_escape_string($link, $_POST["birthday"]);
        $locations =  mysqli_real_escape_string($link, $_POST["locations"]);
        $bio =  mysqli_real_escape_string($link, $_POST["bio"]);
        $gender =  mysqli_real_escape_string($link, $_POST["gender"]);
        $link =  mysqli_real_escape_string($link, $_POST["link"]);

        $sql = "UPDATE Users SET location='$locations', bio='$bio', gender='$gender' WHERE email='$userid'";

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
                <?php displaySideBar("Profile", $userType); ?>
                <!-- your page content -->
                <div class="col-sm-9 col-lg-10">
                    <div class="updateProfile">
                        <h1>Update Your Profile</h1>

                        <form class="form-horizontal" action="updateProfile.php" method="POST">

                            <div class="form-group">
                                <label for="account" class="col-sm-2 control-label">Account</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="account" name="account">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="birthday" class="col-sm-2 control-label">Birthday</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" id="birthday" name="birthday">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="locations" class="col-sm-2 control-label">Locations</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="locations" name="locations">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="bio" class="col-sm-2 control-label">Bio</label>
                                <div class="col-sm-4">
                                    <textarea class="form-control" rows="5" id="bio" name="bio"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="gender" class="col-sm-2 control-label">Gender</label>
                                <div class="col-sm-4">
                                    <select class="form-control" id="gender" name="gender">
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="link" class="col-sm-2 control-label">Link</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="link" name="link">
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