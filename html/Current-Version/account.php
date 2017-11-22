<?php 
    require_once("../../include/favicon.php");
    require_once("../../include/configdb.php");
    require_once("../../include/navBar.php");
    require_once("../../include/getUserTypeAndVerifyLogin.php");

    session_start();
    $userid = $_SESSION["userEmail"];

    $failedToUpdateAccount = false;
    $passwordsDoNotMatch = false;
    $invalidPassword = false;
    $failedToUpdateProfile = false;
    $emailAlreadyInUse = false;

    if (isset($_POST['submitUpdateAccount'])) {
        $email = mysqli_real_escape_string($link, $_POST["email"]);
        $phone = $_POST["phone"];
        $sql = "SELECT * FROM Users WHERE email='$email'";
        $result = $link->query($sql);
        if ($result->num_rows == 0) {
            $sql = "ALTER TABLE Listings DROP FOREIGN KEY fk_email;";
            $result = $link->query($sql);
            $sql = "ALTER TABLE Connections DROP FOREIGN KEY fk_creatorEmail;";
            $result = $link->query($sql);
            $sql = "ALTER TABLE Connections DROP FOREIGN KEY fk_investorEmail;";
            $result = $link->query($sql);
            $sql = "ALTER TABLE Connections DROP FOREIGN KEY fk_approvedBy;";
            $result = $link->query($sql);
            $sql = "UPDATE Listings SET email='$email' WHERE email='$userid';";
            $result = $link->query($sql);
            $sql = "UPDATE Connections SET creatorEmail='$email' WHERE creatorEmail='$userid';";
            $result = $link->query($sql);
            $sql = "UPDATE Connections SET investorEmail='$email' WHERE investorEmail='$userid';";
            $result = $link->query($sql);
            $sql = "UPDATE Connections SET approvedBy='$email' WHERE approvedBy='$userid';";
            $result = $link->query($sql);
            $sql = "UPDATE UserToInterests SET email='$email' WHERE email='$userid';";
            $result = $link->query($sql);
            if (strlen($phone) == 0) {
                $sql = "UPDATE Users SET email='$email' WHERE email='$userid';";
            } else if (strlen($email) == 0) {
                $sql = "UPDATE Users SET phoneNumber='$phone' WHERE email='$userid';";
            } else {
                $sql = "UPDATE Users SET email='$email', phoneNumber='$phone' WHERE email='$userid';";
            }
            $result = $link->query($sql);
            $sql = "ALTER TABLE Listings ADD CONSTRAINT fk_email FOREIGN KEY (email) REFERENCES Users(email);";
            $result = $link->query($sql);
            $sql = "ALTER TABLE Connections ADD CONSTRAINT fk_creatorEmail FOREIGN KEY (creatorEmail) REFERENCES Users(email);";
            $result = $link->query($sql);
            $sql = "ALTER TABLE Connections ADD CONSTRAINT fk_investorEmail FOREIGN KEY (investorEmail) REFERENCES Users(email);";
            $result = $link->query($sql);
            $sql = "ALTER TABLE Connections ADD CONSTRAINT fk_approvedBy FOREIGN KEY (approvedBy) REFERENCES Users(email)";
            $result = $link->query($sql);
            $_SESSION["userEmail"] = $email;
        } else {
            $emailAlreadyInUse = true;
        }
    } else if (isset($_POST['submitChangePassword'])) {
        $cur_pass = mysqli_real_escape_string($link, $_POST["cur_pass"]);
        $confirm_pass = mysqli_real_escape_string($link,$_POST["confirm_pass"]);
        $new_pass = mysqli_real_escape_string($link, $_POST["new_pass"]);
        $sql = "SELECT password FROM Users WHERE BINARY email='$userid'";
        $result = $link->query($sql);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $hashedPassword = $row["password"];
        if (password_verify($cur_pass, $hashedPassword)) {
            if($new_pass === $confirm_pass) {
                $hashedPassword = password_hash($new_pass, PASSWORD_DEFAULT, ['cost' => 9]);
                $sql = "UPDATE Users SET password='$hashedPassword' WHERE email='$userid'";
                $result = $link->query($sql);
            } else {
                $passwordsDoNotMatch = true;
            } 
        } else {
            $invalidPassword = true;
        }
    } else if (isset($_POST['submitUpdateProfile'])) {
        $birthday =  mysqli_real_escape_string($link, $_POST["birthday"]);
        $locations =  mysqli_real_escape_string($link, $_POST["locations"]);
        $bio =  mysqli_real_escape_string($link, $_POST["bio"]);
        $gender =  $_POST["gender"];
        $link =  mysqli_real_escape_string($link, $_POST["link"]);

        $sql = "UPDATE Users SET gender='$gender' WHERE email='$userid'";
        $result = $link->query($sql);
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
                        <h1>Update Account</h1>

                        <form class="form-horizontal" action="" method="POST">

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
                                <div class="col-sm-2 "></div>
                                <div class="col-sm-4">
                                    <button type="submit" class="btn btn-default" name="submitUpdateAccount">Update Account</button>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="changePassword">
                        <h1>Change Password</h1>

                        <form class="form-horizontal" action="" method="POST">

                            <div class="form-group">
                                <label for="cur_pass" class="col-sm-2 control-label">Current Password</label>
                                <div class="col-sm-4">
                                    <input type="password" class="form-control" id="cur_pass" rows="5" name="cur_pass">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="new_pass" class="col-sm-2 control-label">New Password</label>
                                <div class="col-sm-4">
                                    <input type="password" class="form-control" id="new_pass" name="new_pass">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="confirm_pass" class="col-sm-2 control-label">Confirm Password</label>
                                <div class="col-sm-4">
                                    <input type="password" class="form-control" id="confirm_pass" name="confirm_pass">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-2 "></div>
                                <div class="col-sm-4">
                                    <button type="submit" class="btn btn-default" name="submitChangePassword">Change Password</button>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="updateProfile">
                        <h1>Update Profile</h1>

                        <form class="form-horizontal" action="" method="POST">

                            <div class="form-group">
                                <label for="birthday" class="col-sm-2 control-label">Birthday</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" id="birthday" name="birthday">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="locations" class="col-sm-2 control-label">Location</label>
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
                                        <option>Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="link" class="col-sm-2 control-label">LinkedIn URL</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="link" name="link">
                                </div>
                            </div>

                             <div class="form-group">
                                <div class="col-sm-2 "></div>
                                <div class="col-sm-4">
                                    <button type="submit" class="btn btn-default" name="submitUpdateProfile">Update Profile</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>
