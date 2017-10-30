<?php
    $user = 'admin';
    $db_password = 'C%&YQf&0WB55LRc5iIsVpT6tG45Qn3&iD03KfccfC';
    $db = 'Pipeline_V2_Database';
    $host = 'pipeline-v2-database.c5klbzwvfdnx.us-west-2.rds.amazonaws.com';
    $port = 3306;

    $link = mysqli_init();
    $success = mysqli_real_connect($link, $host, $user, $db_password, $db, $port);
    if ($success == false) {
        exit("Can't connect to the database at all!");
    }
    if (isset($_POST["submitLogin"])) {
        $loginEmail = $_POST["email"];
        $password = $_POST["password"];
        $sql = "SELECT * FROM TempUsers WHERE BINARY email='$loginEmail' AND BINARY password='$password'";
        $result = $link->query($sql);
        if ($result->num_rows == 0) {
                echo "Incorrect user id or password<br>";
        } else {
            header("location: home.php");
            die();
        }
    }
?>
<!DOCTYPE HTML>
<html>
    <header>
        <title>Login</title> <!-- Decided by Davin, open to change -->
        <link rel="stylesheet" type="text/css" href="Styles/Desktop/login.css">
        
        <?php
            include 'favicon.php';
        ?>
    </header>
    <body>
        <div id="header"> <!-- To hold the login buttons and labels that take you to different sections of the page -->
        </div>
        <!-- Holds all objects not in the header -->
        <div id="content">
            <h1>
                <?php 
                    $forgotPassword = false;
                    $requestInvitation = false;
                    if (isset($_POST["forgotPassword"])) {
                        echo "Forgot Password";
                        $forgotPassword = true;
                    } else if (isset($_POST["requestInvitation"])) {
                        echo "Request Invitation";
                        $requestInvitation = true;
                    } else if (isset($_POST["submitLogin"])) {
                        $loginEmail = $_POST["email"];
                        $password = $_POST["password"];
                        $sql = "SELECT * FROM TempUsers WHERE BINARY email='$loginEmail' AND BINARY password='$password'";
                        $result = $link->query($sql);
                        if ($result->num_rows == 0) {
                                echo "Incorrect user id or password<br>";
                        } else {
                            echo "It worked";
                        }
                    } else {
                        echo "Login";
                    } 
                ?>
            </h1>
            <form class="cf" method="post" action="">
                <div id="formBox">
                    <input type="email" id="input-email" name="email" placeholder="Email"><br>
                    <?php 
                        if ($forgotPassword) {
                            echo "";
                            echo "<input type=\"submit\" name=\"submitForgotPassword\" value=\"Submit\" id=\"submitButton\">";
                        } else if($requestInvitation) {
                            echo "<input type=\"text\" id=\"input-first-name\" placeholder=\"First Name\">";
                            echo "<input type=\"text\" id=\"input-middle-name\" placeholder=\"Middle Name\">";
                            echo "<input type=\"text\" id=\"input-last-name\" placeholder=\"Last Name\">";
                            echo "<input type=\"text\" id=\"input-linkedin-url\" placeholder=\"LinkedIn URL\">";
                            echo "<h2>You are an:</h2>";
                            echo "<input type=\"radio\" name=\"individualOrOrganization\" value=\"individual\"> Individual";
                            echo "<input type=\"radio\" name=\"individualOrOrganization\" value=\"organization\"> Organanization";
                            echo "<input type=\"submit\" name=\"submitRequestInvitation\" value=\"Submit\" id=\"submitButton\">";
                        } else {
                            echo "<input type=\"password\" name=\"password\" id=\"input-name\" placeholder=\"Password\">";
                            echo "<input type=\"submit\" name=\"submitLogin\" value=\"Submit\" id=\"submitButton\">";
                        }
                    ?>
                    <?php
                        if (($forgotPassword) || ($requestInvitation)) {
                            echo "";
                        } else {
                            echo "<div id=\"rememberMeSection\"><input type=\"checkbox\" checked/><label for=\"rememberMe\">Remember Me</label></div>";
                        }
                    ?>

                    <div id="additionalOptions">
                        <button id="requestInvitationBtn" class="alternativeOptions" type="submit" name="requestInvitation">Request Invitation</button>
                        <?php
                            if ($forgotPassword) {
                                echo 
                                    "<button id=\"alternativeTwoBtn\" class=\"alternativeOptions\" type=\"submit\" name=\"login\">Login</button>";
                            } else {
                                echo "<button id=\"alternativeTwoBtn\" class=\"alternativeOptions\" type=\"submit\" name=\"forgotPassword\">Forgot Password</button>";
                            }
                        ?>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>