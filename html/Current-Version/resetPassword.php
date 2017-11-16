<?php
    require_once("../../include/configdb.php");
    $sql = "DELETE FROM ResetPasswordLinks WHERE expirationDate < now()";
    $result = $link->query($sql);
    $invalidEmail = false;
    $unmatchedPasswords = false;
    if (!isset($_GET["resetPasswordLink"])) {
        header("location: index.php");
        die();
    } else if (isset($_POST["submitSignUp"])) {
        $email = mysqli_real_escape_string($link, $_POST["email"]);
        $password1 = mysqli_real_escape_string($link, $_POST["password1"]);
        $password2 = mysqli_real_escape_string($link, $_POST["password2"]);
        $sql = "SELECT * FROM Users WHERE BINARY email='$email'";
        $result = $link->query($sql);
        if ($result->num_rows == 0) {
            $invalidEmail = true;
        } else {
            if ($password1 == $password2) {
                $password = $password1;
                $hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 9]);
                /* Get all the user's interests from the RequestToInterests table and put it into the UserToInterests table */
                $interests = array();
                $index = 0;
                $sql = "UPDATE Users SET password='$hash' WHERE BINARY email='$email'";
                $result = $link->query($sql);

                /* Delete the sign up link */
                $resetPasswordLink = $_GET["resetPasswordLink"];
                $sql = "DELETE FROM ResetPasswordLinks WHERE BINARY link='$resetPasswordLink'";
                $result = $link->query($sql);

                /* Redirect to the logged in home page */
                session_start();
                $_SESSION["userEmail"] = $email;
                header("location: home.php");
                die();
            } else {
                $unmatchedPasswords = true;
            }
        }
    } else {
        $resetPasswordLink = $_GET["resetPasswordLink"];
        if (!preg_match('/[^A-Za-z0-9]/', $resetPasswordLink)) {
            $sql = "SELECT * FROM ResetPasswordLinks WHERE BINARY link='$resetPasswordLink'";
            $result = $link->query($sql);
            if ($result->num_rows == 0) {
                header("location: index.php");
                die();
            }
        } else {
            header("location: index.php");
            die();
        }
    }
?>
<!DOCTYPE HTML>
<html>
    <header>
        <title>Reset Password</title> <!-- Decided by Davin, open to change -->
        <link rel="stylesheet" type="text/css" href="Styles/login.css">
        
        <?php
            include 'favicon.php';
            require_once 'Mobile-Detect-2.8.26/Mobile_Detect.php';
            $detect = new Mobile_Detect;
            if ($detect->isMobile()) {
                echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"./Styles/Mobile/login.css\">";
            }
        ?>
    </header>
    <body>
        <div id="header"> <!-- To hold the login buttons and labels that take you to different sections of the page -->
        </div>
        <!-- Holds all objects not in the header -->
        <div id="content">
            <h1>
                <?php 
                    if ($invalidEmail) {
                        echo "Please use the same email as the one we sent to";
                    } else if ($unmatchedPasswords) {
                        echo "Passwords didn't match";
                    } else {
                        echo "Enter new password";
                    }
                ?>
            </h1>
            <form class="cf" method="post" action="">
                <div id="formBox">
                    <input type="email" name="email" id="input-email" placeholder="Email" required>
                    <input type="password" name="password1" id="input-name" placeholder="Password" required><br>
                    <input type="password" name="password2" id="input-name" placeholder="Re-Enter Password" required>
                    <input type="submit" name="submitSignUp" value="Reset Password" id="submitButton">
                </div>
            </form>
        </div>
    </body>
</html>