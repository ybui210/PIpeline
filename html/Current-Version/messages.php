<?php
    require_once("../../include/favicon.php");
    require_once("../../include/configdb.php");
    require_once("../../include/navBar.php");
    require_once("../../include/getUserTypeAndVerifyLogin.php");
    session_start();
    if ($userType != "admin") {
        header("location: index.php");
        die();
    }
    if (isset($_POST["delete"])) {
        $messageID = $_POST["messageID"];
        $sql = "DELETE FROM Messages WHERE messageID='$messageID'";
        $result = $link->query($sql);
        $row = $result->fetch_array(MYSQLI_ASSOC);
    }
?>
<!DOCTYPE html>
  <html>
    <head>
        <title>Messages</title>
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
            <?php displaySideBar("Messages", $userType); ?>
              <div class="col-sm-9 col-lg-10">
                  <div class="row header">

                  </div>
                <table id="table">
            <tr>
                <th class="nameColumn">From</th>
                <th class="typeColumn">Subject</th>
                <th class="whenColumn">When</th>
            </tr>
            <?php
                $sql = "SELECT * FROM Messages";
                $result = $link->query($sql);
                $numberOfMessages = $result->num_rows;
                for ($i = 0; $i < $numberOfMessages; $i++) {
                    $sql = "SELECT * FROM Messages";
                    $result = $link->query($sql);
                    $j = 0;
                    do {
                        $row = $result->fetch_array(MYSQLI_ASSOC);
                    } while ($i != $j++);
                    $messageID = $row["messageID"];
                    if (is_null($row["readStatus"])) {
                        echo "<tr class=\"unread\" onclick=\"window.location = 'messageDetails.php?messageID=" . $messageID . "'\">";
                    } else {
                        echo "<tr class=\"read\" onclick=\"window.location = 'messageDetails.php?messageID=" . $messageID . "'\">";
                    }
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["subject"] . "</td>";
                    
                    $messageEmail = $row["email"];
                    $sql = "SELECT TIMESTAMPDIFF(YEAR, whenSent, NOW()) AS yearDifference, TIMESTAMPDIFF(MONTH, whenSent, NOW()) AS monthDifference, TIMESTAMPDIFF(DAY, whenSent, NOW()) AS dayDifference, TIMESTAMPDIFF(HOUR, whenSent, NOW()) AS hourDifference, TIMESTAMPDIFF(MINUTE, whenSent, NOW()) AS minuteDifference, TIMESTAMPDIFF(SECOND, whenSent, NOW()) AS secondDifference FROM Messages WHERE messageID='$messageID'";
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