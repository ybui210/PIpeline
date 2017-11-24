<?php
    require_once("../../include/favicon.php");
    require_once("../../include/configdb.php");
    require_once("../../include/navBar.php");
    require_once("../../include/getUserTypeAndVerifyLogin.php");
    session_start();
    $admin = false;
    if (isset($_SESSION["userEmail"])) {
        $userEmail = $_SESSION["userEmail"];
        $sql = "SELECT type FROM Users WHERE BINARY email='$userEmail'";
        $result = $link->query($sql);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $userType = $row["type"];
        if ($userType == "admin") {
            $admin = true;
        }
    } else {
        header("location: index.php");
        die();
    }
    if (isset($_POST["approvedOrDenied"])) {
        $approvedOrDenied = $_POST["approvedOrDenied"];
        if ($approvedOrDenied == "approved") {
            $requestID = $_POST["requestID"];
            $sql = "SELECT * FROM Requests WHERE requestID='$requestID'";
            $result = $link->query($sql);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if (is_null($row["inviteSent"])) {
                $emailAddress = $row["email"];
                $linkURL = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                $linkURL = substr($linkURL, 0, -12);
                $linkURL .= "signUp.php?signUpLink=";
                $length = 50;
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $uniqueLinkFound = false;
                while (!$uniqueLinkFound) {
                    $randomString = '';
                    for ($i = 0; $i < $length; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }
                    $sql = "SELECT * FROM SignUpLinks WHERE link='$randomString'";
                    $result = $link->query($sql);
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    if ($row->num_rows == 0) {
                        $uniqueLinkFound = true;
                    }
                }
                $expirationDate = date("Y-m-d H:i:s", strtotime("+7 day"));
                $sql = "INSERT INTO SignUpLinks(link, expirationDate) VALUES('$randomString', '$expirationDate')";
                $result = $link->query($sql);
                $linkURL .= $randomString;
                $subject = 'Pipeline Request Approved';
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
                                    <p id=\"passwordHeader\">Your request was approved! Here's your link:</p>
                                    <p id=\"password\"><a href=\"" . $linkURL . "\">" . $linkURL . "</a></p>
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
                $headers .= 'From: daniel@pipeline-listings.com' . "\r\n" . 'Reply-To: daniel@pipeline-listings.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                mail($emailAddress, $subject, $message, $headers);
                $sql = "UPDATE Requests SET inviteSent=\"\" WHERE requestID='$requestID'";
                $result = $link->query($sql);
            }
        } else {
            $requestID = $_POST["requestID"];
            $sql = "SELECT * FROM Requests WHERE requestID='$requestID'";
            $result = $link->query($sql);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $emailAddress = $row["email"];
            $subject = 'Pipeline Request Denied';
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
                                <p id=\"passwordHeader\">Your request was unfortunately denied</p>
                            </div>
                        </body>
                    </html>
                ";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: daniel@pipeline-listings.com' . "\r\n" . 'Reply-To: daniel@pipeline-listings.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            mail($emailAddress, $subject, $message, $headers);
            $requestEmail = $_POST["email"];
            $sql = "DELETE FROM RequestToInterests WHERE email='$requestEmail'";
            $result = $link->query($sql);
            $sql = "DELETE FROM Requests WHERE email='$requestEmail'";
            $result = $link->query($sql);
        }
    }
?>
<!DOCTYPE html>
  <html>
    <head>
        <title>Requests</title>
        <?php echo getFavicon(); ?>
        <link href="Styles/home.css" rel="stylesheet" />
        <link href="Styles/requests.css" rel="stylesheet" />
        
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>
        <div class="container-fluid">
          <?php displayNavBar($userType); ?>
          <div class="row">
            <?php displaySideBar("Requests", $admin); ?>
              <div class="col-sm-9 col-lg-10">
                  <div class="row header">

                  </div>
                <table id="table">
            <tr>
                <th class="nameColumn">Name</th>
                <th class="typeColumn">Type of User</th>
                <th class="whenColumn">When</th>
            </tr>
            <?php
                $sql = "SELECT * FROM Requests WHERE inviteSent IS NULL";
                $result = $link->query($sql);
                $numberOfRequests = $result->num_rows;
                for ($i = 0; $i < $numberOfRequests; $i++) {
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    if (is_null($row["readStatus"])) {
                        echo "<tr class=\"unread\" onclick=\"window.location = 'requestDetails.php?requestID=" . $row["requestID"] . "'\">";
                    } else {
                        echo "<tr class=\"read\" onclick=\"window.location = 'requestDetails.php?requestID=" . $row["requestID"] . "'\">";
                    }
                    echo "<td>" . $row["firstName"] . " ";
                    if ($row["middleName"] != "") {
                        echo $row["middleName"] . " ";
                    }
                    echo $row["lastName"] . "</td>";
                    echo "<td>" . $row["type"] . "</td>";
                    
                    $requestEmail = $row["email"];
                    $sql = "SELECT TIMESTAMPDIFF(YEAR, whenSent, NOW()) AS yearDifference, TIMESTAMPDIFF(MONTH, whenSent, NOW()) AS monthDifference, TIMESTAMPDIFF(DAY, whenSent, NOW()) AS dayDifference, TIMESTAMPDIFF(HOUR, whenSent, NOW()) AS hourDifference, TIMESTAMPDIFF(MINUTE, whenSent, NOW()) AS minuteDifference, TIMESTAMPDIFF(SECOND, whenSent, NOW()) AS secondDifference FROM Requests WHERE email='$requestEmail'";
                    $result = $link->query($sql);
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    $yearDifference = $row["yearDifference"];
                    $monthDifference = $row["monthDifference"];
                    $dayDifference = $row["dayDifference"];
                    $hourDifference = $row["hourDifference"];
                    $minuteDifference = $row["minuteDifference"];
                    $secondDifference = $row["secondDifference"];
                    if ($yearDifference != 0) {
                        if ($yearDifference == 1) {
                            echo "<td>" . $yearDifference . " year ago</td>";
                        } else {
                            echo "<td>" . $yearDifference . " years ago</td>";
                        }
                    } else {
                        if ($monthDifference != 0) {
                            if ($monthDifference == 1) {
                                echo "<td>" . $monthDifference . " month ago</td>";
                            } else {
                                echo "<td>" . $monthDifference . " months ago</td>";
                            }
                        } else {
                            if ($dayDifference > 0) {
                                if ($dayDifference == 1) {
                                    echo "<td>" . $dayDifference . " day ago</td>";
                                } else {
                                    echo "<td>" . $dayDifference . " days ago</td>";
                                }
                            } else {
                                if ($hourDifference > 0) {
                                    if ($hourDifference == 1) {
                                        echo "<td>" . $hourDifference . " hour ago</td>";
                                    } else {
                                        echo "<td>" . $hourDifference . " hours ago</td>";
                                    }
                                } else {
                                    if ($minuteDifference > 0) {
                                        if ($minuteDifference == 1) {
                                            echo "<td>" . $minuteDifference . " minute ago</td>";
                                        } else {
                                            echo "<td>" . $minuteDifference . " minutes ago</td>";
                                        }
                                    } else {
                                        if ($secondDifference == 1) {
                                            echo "<td>" . $secondDifference . " second ago</td>";
                                        } else {
                                            echo "<td>" . $secondDifference . " seconds ago</td>";
                                        }
                                    }
                                }
                            }
                        }
                    }
                    echo "</tr>";
                }
            ?>
        </table>
            </div>
          </div>
        </div>
      <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
  </html>