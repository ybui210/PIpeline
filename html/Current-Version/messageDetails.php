<?php
    require_once("../../include/favicon.php");
    require_once("../../include/configdb.php");
    require_once("../../include/navBar.php");
    require_once("../../include/getUserTypeAndVerifyLogin.php");
    session_start();
    $messageID = "";
    $email = "";
    $name = "";
    $message = "";
    if ($userType != "admin") {
        header("location: home.php");
        die();
    }
    if (isset($_GET["messageID"])) {
        $messageID = $_GET["messageID"];
        $sql = "SELECT * FROM Messages WHERE messageID='$messageID'";
        $result = $link->query($sql);
        if ($result->num_rows == 0) {
            header("location: messages.php");
            die();
        }
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $email = $row["email"];
        $name = $row["name"];
        $subject = $row["subject"];
        $message = $row["message"];
        $sql = "UPDATE Messages SET readStatus=\"\" WHERE messageID='$messageID'";
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
        
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link href="Styles/home.css" rel="stylesheet" />
        <link href="Styles/requests.css" rel="stylesheet" />
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
                        <th class="email">Email</th>
                        <td><?php echo $email; ?></td>
                    </tr>
                    <tr>
                        <th class="name">Name</th>
                        <td>
                            <?php echo $name; ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="subject">Subject</th>
                        <td><?php echo $subject; ?></td>
                    </tr>
                    <tr>
                        <th class="message"></th>
                        <td>
                            <?php
                                $message = str_replace("\n", "<br/>", $message);
                                echo $message;
                            ?>
                        </td>
                    </tr>
                </table>
                  <form action="requests.php" method="post">
                      <input style="display:none;" name="email" value=<?php echo "\"" . $email . "\""; ?>>
                      <input style="display:none;" name="messageID" value=<?php echo "\"" . $messageID . "\""; ?>>
                      <textarea style="width:100%;" rows="10" name="replayMessage"></textarea>
                      <br><button type="submit" name="replied" value="reply">Reply</button>
                  </form>
            </div>
          </div>
        </div>
      <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>