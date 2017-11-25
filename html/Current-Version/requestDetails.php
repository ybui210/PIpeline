<?php
    require_once("../../include/favicon.php");
    require_once("../../include/configdb.php");
    require_once("../../include/navBar.php");
    require_once("../../include/getUserTypeAndVerifyLogin.php");
    session_start();
    $admin = false;
    $requestID = "";
    $email = "";
    $firstName = "";
    $middleName = "";
    $lastName= "";
    $linkedInURL = "";
    $typeOfUser = "";
    if ($userType != "admin") {
        header("location: home.php");
        die();
    }
    if (isset($_GET["requestID"])) {
        $requestID = mysqli_real_escape_string($link, $_GET["requestID"]);
        $sql = "SELECT * FROM Requests WHERE requestID='$requestID'";
        $result = $link->query($sql);
        if ($result->num_rows == 0) {
            header("location: requests.php");
            die();
        }
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $email = $row["email"];
        $firstName = $row["firstName"];
        $middleName = $row["middleName"];
        $lastName = $row["lastName"];
        $linkedInURL = $row["linkedInURL"];
        $typeOfUser = $row["type"];
        $individualOrOrganization = $row["individualOrOrganization"];
        $interests = array();
        $index = 0;
        $sql = "SELECT interest FROM RequestToInterests WHERE BINARY email='$email'";
        $result = $link->query($sql);
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $interests[$index++] = $row["interest"];
        }
        $sql = "UPDATE Requests SET readStatus=\"\" WHERE requestID='$requestID'";
        $result = $link->query($sql);
    } else {
        header("location: requests.php");
        die();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Request Details</title>
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
              <?php displaySideBar("Requests", $userType); ?>
              <div class="col-sm-9 col-lg-10">
                  <div class="row header">

                  </div>
                  <table id="table">
                    <tr>
                        <th class="email">Email</th>
                        <td><?php echo $email; ?></td>
                    </tr>
                    <tr>
                        <th class="name">Name</th>
                        <td>
                            <?php 
                                echo $firstName . " ";
                                if (!is_null($middleName)) {
                                    echo $middleName . " ";
                                }
                                echo $lastName;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="linkedInURL">LinkedIn URL</th>
                        <td><?php echo "<a href=\"" . $linkedInURL . "\"  target=\"_blank\">" . $linkedInURL . "</a>"; ?></td>
                    </tr>
                    <tr>
                        <th class="typeOfUser">Type of User</th>
                        <td><?php echo $typeOfUser; ?></td>
                    </tr>
                    <tr>
                        <th class="individualOrOrganization">Individual/Organization</th>
                        <td><?php echo $individualOrOrganization; ?></td>
                    </tr>
                    <tr>
                        <th class="interests">Interests</th>
                        <td>
                            <?php
                                for ($i = 0; $i < $index; ++$i) {
                                    if ($i == 0) {
                                        echo $interests[$i];
                                    } else {
                                        echo ", " . $interests[$i];
                                    }
                                }
                            ?>
                        </td>
                    </tr>
                </table>
                  <form action="requests.php" method="post">
                      <input style="display:none;" name="email" value=<?php echo "\"" . $email . "\""; ?>>
                      <input style="display:none;" name="requestID" value=<?php echo "\"" . $requestID . "\""; ?>>
                      <button type="submit" name="approvedOrDenied" value="approved">Approve</button>
                      <button type="submit" name="approvedOrDenied" value="denied">Deny</button>
                  </form>
            </div>
          </div>
        </div>
      <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>