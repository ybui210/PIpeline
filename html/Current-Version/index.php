<?php
    require_once("../../include/configdb.php");
    function sendMessage($n, $e, $s, $m, $l) {
        $sql = "INSERT INTO Messages(name, email, subject, message) VALUES ('$n', '$e', '$s', '$m')";
        $result = $l->query($sql);
    }
    $emailIsOnTheBlackList = false;
    $userHasSentTooManyMessages = false;
    if (isset($_POST["submitMessage"])) {
        $name = mysqli_real_escape_string($link, $_POST["name"]);
        $email = mysqli_real_escape_string($link, $_POST["email"]);
        $subject = mysqli_real_escape_string($link, $_POST["subject"]);
        $message = mysqli_real_escape_string($link, $_POST["message"]);
        include "okToSend.php";
        if($okToSend) {
            sendMessage($name, $email, $subject, $message, $link);
        }
    }
?>
<!DOCTYPE HTML>
<html>
    <header>
        <title>Welcome to Pipeline</title> <!-- Decided by Davin, open to change -->
        
        <?php
            include 'favicon.php';
        ?>
         <!-- Style sheet for the body structure -->
         <!-- Style sheet for the Contact Us structure -->
        
        <?php
            require_once 'Mobile-Detect-2.8.26/Mobile_Detect.php';
            $detect = new Mobile_Detect;
            if ($detect->isMobile()) {
                echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"./Styles/Mobile/index.css\">";
                echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"./Styles/Mobile/contactUs.css\">";
            } else {
                echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"./Styles/index.css\">";
                echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"./Styles/contactUs.css\">";
            }
        ?>
        
        <?php
            if($emailIsOnTheBlackList) {
                include 'messages.php';
                echo displayBlacklistMessage();
            } else if ($userHasSentTooManyMessages) {
                include 'messages.php';
                echo displayWarningMessage();
            }
        ?>
        <script src="./Scripts/index.js"></script>
    </header>
    <body>
        <div id="header">
            <div id="navigationBar">
                <a href="login.php"><img id="loginButton" src="Images/Login-Button.png" /></a>
        <?php
            if (!$detect->isMobile()) {
                echo "<div id=\"options\">
                        <a href=\"#contactSection\">Contact</a>
                        <a href=\"#aboutSection\">About</a>
                        <a href=\"#howItWorksSection\">How It Works</a>
                        <a href=\"#topSection\">Top</a>
                    </div>";
            } else {
                echo "<div id=\"options\">
                        <a href=\"#contactSection\">Contact</a>
                        <a href=\"#topSection\">Top</a>
                    </div>";
            }
        ?>
                            
            </div>
        </div>
        <!-- Holds all objects not in the header -->
        <div id="content">
            
            <!-- Section meant to attract the user and draw them in -->
            <div id="topSection">
                <span><h1>PIPELINE</h1> <!-- Name of the project -->
                <h2>Deals Made Simple</h2> <!-- Selling line -->
                <section id="downButtonSection" class="demo"><!-- Arrow that takes you to the next section (How It Works) -->
                    <a href="#howItWorksSection"><span></span></a>
                </section></span>
            </div> <!-- End of Top Section -->
            
            <!-- Explains how Pipeline works and what it does differently than competitors -->
            <div id="howItWorksSection" class="allTextSections textSectionsWithDarkBackground">
                
                <!-- Label for the section -->
                <h3>How It Works</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum id mollis augue, a viverra nibh. Pellentesque scelerisque sodales elit sed aliquam. Curabitur eu facilisis diam. Duis nunc dolor, cursus sagittis turpis vel, vulputate malesuada erat. Sed interdum purus quis augue semper, nec auctor tellus facilisis. Etiam ultrices rutrum quam, quis consequat velit posuere eget. Maecenas dignissim, augue nec aliquet finibus, velit risus vehicula nibh, in tempus purus justo eu nunc. Sed in sagittis augue, ac dictum nunc. Ut scelerisque eros sit amet metus porttitor volutpat. Mauris efficitur tristique dui nec commodo. Phasellus faucibus feugiat cursus.</p>

                <p>Sed sit amet sapien libero. Aenean ut turpis quis ipsum iaculis varius. Praesent ac erat in purus semper sagittis. Nunc nec dolor laoreet, consectetur sem sed, consequat justo. Ut at tincidunt dolor, sit amet vulputate enim. Donec sagittis lectus in nibh vestibulum porta. Fusce pretium eget eros eu scelerisque. Vestibulum eget lorem posuere, feugiat tellus eu, pretium nibh. Aenean ut porttitor dui. In hac habitasse platea dictumst. Etiam id bibendum sem.</p>
            </div>
            
            <!-- Explains what Pipeline is in more detail meant for new users not used to this sort of business -->
            <div id="aboutSection" class="allTextSections textSectionWithLightBackground"> 
                
                <h3>ABOUT PIPELINE</h3> <!-- Label for the section -->
                <p>Pipeline is a private and secure project listing platform which allows its invite-only user base to post and catalogue the following:</p>
                <ol>
                    <li> Projects for sale, projects seeking financing and projects seeking joint venture partners</li>
                    <li> To offer Financing to companies looking to expand, purchase assets or fund an acquisition, in the form of debt, equity, profit sharing, off-take agreements or a combination</li>
                    <li> Opportunities to buy or sell publicly traded or publicly quoted entities on the TSX, TSXV, CSE or OTCQB.</li>
                    <li> Offer services to assist with listed public companies in the US or Canada or a request for such services.</li>
                </ol>
                
                <p>
                    The Platform provides a forum for users to review projects and financing opportunities currently available by 
                    their peers and interact in an efficient manner to determine if they wish to proceed to the next level to close
                    on a transaction.
                </p>
                
                <p>
                    The main purpose of the platform is two-fold. Firstly, it's a time-saver for busy business execs (hence the
                    mobile aspect), creating a place where colleagues and partners can quickly scan projects and opportunities of
                    interest. Secondly, it's a resource for users looking for either a project in which to invest, or an opportunity
                    where they might be able to connect a buyer and seller and earn a commission.
                </p>
                
            </div>
            
            <!-- Allows the user to make a message outlining any questions they have and sends it -->
            <div id="contactSection">
                <form class="cf" action="" method="post">
                <h3>CONTACT US</h3>
                <h4>Got any questions? Submit a form to the admin and we will get back to you right away!</h4>
                  <div class="half left cf">
                    <input name="name" type="text" id="input-name" placeholder="Name" required>
                    <input name="email" type="email" id="input-email" placeholder="Email" required>
                    <input name="subject" type="text" id="input-subject" placeholder="Subject" required>
                  </div>
                  <div class="half right cf">
                    <textarea name="message" type="text" id="input-message" placeholder="Message" required></textarea>
                  </div>
                  <input type="submit" value="Submit" id="submitButton" name="submitMessage">
                </form>
            </div>
        </div>
    </body>
</html>