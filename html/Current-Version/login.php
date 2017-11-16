<?php

    require_once("../../include/configdb.php");

    $forgotPassword = false;
    $incorrectLoginInfo = false;
    $requestInvitation = false;
    $emailDoesNotExist = false;
    $requestSent = false;
    $passwordSent = false;
    $interests = array();
    if (isset($_POST["submitForgotPassword"])) {
        $emailAddress = mysqli_real_escape_string($link, $_POST["email"]);
        $sql = "SELECT * FROM Users WHERE BINARY email='$emailAddress'";
        $result = $link->query($sql);
        if ($result->num_rows == 0) {
            $emailDoesNotExist = true;
        } else {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $subject = 'Your Pipeline Password';
            $message = "
                    <html>
                    <header>
                    <style>
                    html, body {
                    font-family: \"Helvetica Neue\", HelveticaNeue, \"TeX Gyre Heros\", TeXGyreHeros, FreeSans, \"Nimbus Sans L\", \"Liberation Sans\", Arimo, Helvetica, Arial, sans-serif;
                    height:100%;
                    }
                    body {
                    margin: 0px;
                    }
                    #header {
                    height: 10vh;
                    background-color: #136cb2;
                    margin: 0;
                    text-align: center;
                    }
                    h1 {
                    color: #FFF;
                    line-height: 10vh;
                    }
                    #mainSection {
                    color: #777;
                    text-align: center;
                    }
                    #passwordHeader {
                    font-size: 2em;
                    }
                    #password {
                    font-size: 2em;
                    }
                    </style>
                    </header>
                    <body>
                    <div id=\"header\">
                    <h1>Pipeline</h1>
                    </div>
                    <div id=\"mainSection\">
                    <p id=\"passwordHeader\">Your password is:</p>
                    <p id=\"password\">" . $row["password"] . "</p><!--19 -->
                    </div>
        
                    <script>
                    var password = document.getElementById(\"password\");
                    if (password.innerHTML.length > 90) {
                    password.style.fontSize = \"0.1em\";
                    } else if (password.innerHTML.length > 80) {
                    password.style.fontSize = \"0.7em\";
                    } else if (password.innerHTML.length > 70) {
                    password.style.fontSize = \"0.8em\";
                    } else if (password.innerHTML.length > 60) {
                    password.style.fontSize = \"0.9em\";
                    } else if (password.innerHTML.length > 50) {
                    password.style.fontSize = \"1em\";
                    } else if (password.innerHTML.length > 40) {
                    password.style.fontSize = \"1.2em\";
                    } else if (password.innerHTML.length > 30) {
                    password.style.fontSize = \"1.5em\";
                    } else if (password.innerHTML.length > 20) {
                    password.style.fontSize = \"1.8em\";
                    }
                    </script>
                    </body>
                    </html>
                    ";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: no-reply@gmail.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            mail($emailAddress, $subject, $message, $headers);
            $passwordSent = true;
        }
    } else if (isset($_POST["submitRequestInvitation"])) {
        $email = mysqli_real_escape_string($link, $_POST["email"]);
        $firstName = mysqli_real_escape_string($link, $_POST["firstName"]);
        $middleName = mysqli_real_escape_string($link, $_POST["middleName"]);
        $lastName = mysqli_real_escape_string($link, $_POST["lastName"]);
        $linkedInURL = mysqli_real_escape_string($link, $_POST["linkedInURL"]);
        $individualOrOrganization = mysqli_real_escape_string($link, $_POST["individualOrOrganization"]);
        $type = mysqli_real_escape_string($link, $_POST["type"]);
        if(!empty($_POST['interests'])) {
            $i = 0;
            foreach($_POST['interests'] as $selected){
                $interests[$i++] = $selected;
            }
        }
        include "okToSend.php";
        if ($okToSend) {
            $sql = "SELECT * FROM Requests WHERE BINARY email='$email'";
            $result = $link->query($sql);
            if ($result->num_rows == 0) {
                $sql = "INSERT INTO Requests(email, firstName, middleName, lastName, linkedInURL, whenSent, individualOrOrganization, type) VALUES ('$email', '$firstName', '$middleName', '$lastName', '$linkedInURL', NOW(), '$individualOrOrganization', '$type')";
                $result = $link->query($sql);
                for ($i = 0; $i < count($interests); $i++) {
                    $sql = "INSERT INTO RequestToInterests VALUES ('$email', '$interests[$i]')";
                    $result = $link->query($sql);
                }
            } else {
                $sql = "UPDATE Requests SET firstName='$firstName', middleName='$middleName', lastName='$lastName', linkedInURL='$linkedInURL', individualOrOrganization='$individualOrOrganization', type='$type' WHERE email='$email'";
                $result = $link->query($sql);
                $sql = "DELETE FROM RequestToInterests WHERE BINARY email='$email'";
                $result = $link->query($sql);
                for ($i = 0; $i < count($interests); $i++) {
                    $sql = "INSERT INTO RequestToInterests VALUES ('$email', '$interests[$i]')";
                    $result = $link->query($sql);
                }
            }
            $requestSent = true;
            
        }
    } else if (isset($_POST["submitLogin"])) {
        $loginEmail = mysqli_real_escape_string ($link, $_POST["email"]);
        $password = mysqli_real_escape_string ($link, $_POST["password"]);
        $sql = "SELECT * FROM Users WHERE BINARY email='$loginEmail' AND BINARY password='$password'";
        $result = $link->query($sql);
        if ($result->num_rows == 0) {
                $incorrectLoginInfo = true;
        } else {
            session_start();
            $_SESSION["userEmail"] = $loginEmail;
            header("location: home.php");
            die();
        }
    } else if (isset($_POST["forgotPassword"])) {
        $forgotPassword = true;
    } else if (isset($_POST["requestInvitation"])) {
        $sql = "SELECT * FROM Interests";
        $result = $link->query($sql);
        $index = 0;
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $interests[$index++] = $row["interest"];
        }
        $requestInvitation = true;
    }
?>
<!DOCTYPE HTML>
<html>
    <header>
        <title>Login</title> <!-- Decided by Davin, open to change -->
        <link rel="stylesheet" type="text/css" href="Styles/login.css">
        
        <?php
            include 'favicon.php';
            if ($emailIsOnTheBlackList) {
                include 'messages.php';
                echo displayBlacklistMessage();
            } else if ($requestSent) {
                include 'messages.php';
                echo displayRequestSentMessage();
            } else if ($emailDoesNotExist) {
                include 'messages.php';
                echo displayYouDoNotHaveAnAccountMessage();
            } else if ($passwordSent) {
                include 'messages.php';
                echo displayPasswordSentMessage();
            }
        
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
                    if ($forgotPassword) {
                        echo "Forgot Password";
                    } else if ($requestInvitation) {
                        echo "Request Invitation";
                    } else if ($incorrectLoginInfo) {
                        echo "Incorrect user id or password<br>";
                    } else {
                        echo "Login";
                    } 
                ?>
            </h1>
            <form class="cf" method="post" action="">
                <div id="formBox">
                    <input type="email" id="input-email" name="email" placeholder="Email" required><br>
                    <?php 
                        if ($requestInvitation) {
                            /* Contact information */
                            echo "<input type=\"text\" id=\"input-first-name\" placeholder=\"First Name\" name=\"firstName\" required>
                                    <input type=\"text\" id=\"input-middle-name\" placeholder=\"Middle Name\" name=\"middleName\" required>
                                    <input type=\"text\" id=\"input-last-name\" placeholder=\"Last Name\" name=\"lastName\" required>
                                    <input type=\"url\" id=\"input-linkedin-url\" placeholder=\"LinkedIn URL\" name=\"linkedInURL\" required>";
                            echo "<h2>You are an:</h2>";
                            echo "<label class=\"radio\"><input id=\"radio1\" type=\"radio\" name=\"individualOrOrganization\" value=\"individual\" checked required><span class=\"outer\"><span class=\"inner\"></span></span>Individual</label><br>
                                <label class=\"radio\"><input id=\"radio2\" type=\"radio\" name=\"individualOrOrganization\" value=\"organization\"><span class=\"outer\"><span class=\"inner\"></span></span>Organization</label><br>";
                            echo "<h2>You wish to join as a(n):</h2>";
                            echo "<label class=\"radio\"><input id=\"radio3\" type=\"radio\" name=\"type\" value=\"creator\" checked required><span class=\"outer\"><span class=\"inner\"></span></span>Creator</label><br>
                                <label class=\"radio\"><input id=\"radio4\" type=\"radio\" name=\"type\" value=\"investor\"><span class=\"outer\"><span class=\"inner\"></span></span>Investor</label><br>
                                <label class=\"radio\"><input id=\"radio4\" type=\"radio\" name=\"type\" value=\"both\"><span class=\"outer\"><span class=\"inner\"></span></span>Both</label><br>";
                            /* Interests */
                            echo "<h2>What are your interests</h2>";
                            echo "<div class=\"cntr\">";
                            for ($i = 0; $i < count($interests); $i++) {
                                echo "<label for=\"checkbox" . $i . "\" class=\"label-cbx\">
                                        <input id=\"checkbox" . $i . "\" type=\"checkbox\" class=\"invisible\" name=\"interests[]\" value=\"" . $interests[$i] . "\">
                                        <div class=\"checkbox\">
                                            <svg viewBox=\"0 0 20 20\">
                                                <path d=\"M3,1 L17,1 L17,1 C18.1045695,1 19,1.8954305 19,3 L19,17 L19,17 C19,18.1045695 18.1045695,19 17,19 L3,19 L3,19 C1.8954305,19 1,18.1045695 1,17 L1,3 L1,3 C1,1.8954305 1.8954305,1 3,1 Z\"></path>
                                                <polyline points=\"4 11 8 15 16 6\"></polyline>
                                            </svg>
                                        </div>
                                        <span>" . $interests[$i] . "</span>
                                    </label><br><br>";
                            }
                        } else if ($forgotPassword) {
                        } else {
                            echo "<input type=\"password\" name=\"password\" id=\"input-name\" placeholder=\"Password\">";
                        }  
                        /* Submit Button */
                        if ($forgotPassword) {
                            echo "<input type=\"submit\" name=\"submitForgotPassword\" value=\"Send Password\" id=\"submitButton\">";
                        } else if ($requestInvitation) {
                            echo "<input type=\"submit\" name=\"submitRequestInvitation\" value=\"Send Request\" id=\"submitButton\">";
                        } else {
                            echo "<input type=\"submit\" name=\"submitLogin\" value=\"Login\" id=\"submitButton\">";
                        }
                    ?>
                </div>
            </form>
            <form class="cf" method="post" action="">
                <div id="additionalOptions">
                    <?php
                        if ($forgotPassword) {
                            echo "<button id=\"requestInvitationBtn\" class=\"alternativeOptions\" type=\"submit\" name=\"requestInvitation\">Request Invitation</button>";
                            echo "<button id=\"alternativeTwoBtn\" class=\"alternativeOptions\" type=\"submit\" name=\"login\">Login</button>";
                        } else if ($requestInvitation) {
                            echo "<button id=\"loginBtn\" class=\"alternativeOptions\" type=\"submit\" name=\"login\">Login</button>";
                            echo "<button id=\"alternativeTwoBtn\" class=\"alternativeOptions\" type=\"submit\" name=\"forgotPassword\">Forgot Password</button>";
                        } else {
                            echo "<button id=\"requestInvitationBtn\" class=\"alternativeOptions\" type=\"submit\" name=\"requestInvitation\">Request Invitation</button>";
                            echo "<button id=\"alternativeTwoBtn\" class=\"alternativeOptions\" type=\"submit\" name=\"forgotPassword\">Forgot Password</button>";
                        }
                    ?>
                </div>
            </form>
        </div>
    </body>
</html>