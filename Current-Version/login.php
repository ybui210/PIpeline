<!DOCTYPE HTML>
<html>
    <header>
        <title>Login</title> <!-- Decided by Davin, open to change -->
        <link rel="stylesheet" type="text/css" href="Styles/login.css">
        
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
                    } else {
                        echo "Login";
                    } 
                ?>
            </h1>
            <form class="cf" method="post" action="">
                <div id="formBox">
                    <input type="email" id="input-email" placeholder="Email"><br>
                    <?php 
                        if ($forgotPassword) {
                            echo "";
                        } else if($requestInvitation) {
                            echo "<input type=\"text\" id=\"input-first-name\" placeholder=\"First Name\">";
                            echo "<input type=\"text\" id=\"input-middle-name\" placeholder=\"Middle Name\">";
                            echo "<input type=\"text\" id=\"input-last-name\" placeholder=\"Last Name\">";
                            echo "<input type=\"text\" id=\"input-linkedin-url\" placeholder=\"LinkedIn URL\">";
                            echo "<h2>You are an:</h2>";
                            echo "<input type=\"radio\" name=\"individualOrOrganization\" value=\"individual\"> Individual";
                            echo "<input type=\"radio\" name=\"individualOrOrganization\" value=\"organization\"> Organanization";
                        } else {
                            echo "<input type=\"password\" id=\"input-name\" placeholder=\"Password\">";
                        }
                    ?>
                    <?php
                        if (($forgotPassword) || ($requestInvitation)) {
                            echo "";
                        } else {
                            echo "<div id=\"rememberMeSection\"><input type=\"checkbox\" checked/><label for=\"rememberMe\">Remember Me</label></div>";
                        }
                    ?>

                    <input type="submit" value="Submit" id="submitButton">
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