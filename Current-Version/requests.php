<?php
    include '../configdb.php';
    $admin = false;
    session_start();
    if (isset($_SESSION["userEmail"])) {
        $userEmail = $_SESSION["userEmail"];
        $sql = "SELECT type FROM Users WHERE email='$userEmail'";
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
?>
<!DOCTYPE html>
  <html>
    <head>

        <link href="Styles/home.css" rel="stylesheet" />
        <link href="Styles/All/requests.css" rel="stylesheet" />
        
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>
        <div class="container-fluid">
          <div class="row">
              <nav class="navbar navbar-default">
                  <div class="container-fluid">
                      <!-- Brand and toggle get grouped for better mobile display -->
                      <div class="navbar-header">
                          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                              <span class="sr-only">Toggle navigation</span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                          </button>
                          <a class="navbar-brand" href="#">Pipeline</a>
                      </div>

                      <!-- Collect the nav links, forms, and other content for toggling -->
                      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                          <ul class="nav navbar-nav">
                              <li class="active"><a href="#">Browse Listing <span class="sr-only">(current)</span></a></li>
                              <li><a href="#">Active Listing</a></li>
                              <li><a href="createListing.php">Create Listing</a></li>
                              <li><a href="#">News</a></li>
                              <li class="hidden-lg hidden-md hidden-sm"><a href="">Account</a></li>
                              <li class="hidden-lg hidden-md hidden-sm"><a href="">Password</a></li>
                              <li class="hidden-lg hidden-md hidden-sm"><a href="">Profile</a></li>
                              <li class="hidden-lg hidden-md hidden-sm"><a href="">Notifications</a></li>
                              <li class="hidden-lg hidden-md hidden-sm"><a href="">System History</a></li>
                              <li class="hidden-lg hidden-md hidden-sm"><a href="">Social Connections</a></li>

                          </ul>
                          <form class="navbar-form navbar-left">
                              <div class="form-group">
                                  <input type="text" class="form-control" placeholder="Search">
                              </div>
                              <button type="submit" class="btn btn-default">Submit</button>
                          </form>
                      </div><!-- /.navbar-collapse -->
                  </div><!-- /.container-fluid -->
              </nav>
          </div>

          <div class="row">
            <div class="col-sm-3 col-lg-2 navBarDiv hidden-xs">

                <nav class="nav nav-pills nav-stacked leftNavbar">
                  <li><a href="home.php">Account</a></li>
                  <li><a href="">Password</a></li>
                  <li><a href="">Profile</a></li>
                  <li><a href="">Notifications</a></li>
                  <li><a href="">System History</a></li>
                  <li><a href="">Social Connections</a></li>
                    <?php
                        if ($admin) {
                            $sql = "SELECT COUNT(*) FROM Messages WHERE readStatus IS NULL";
                            $result = $link->query($sql);
                            $row = $result->fetch_array(MYSQLI_ASSOC);
                            if ($row["COUNT(*)"] == 0) {
                                echo "<li><a href=\"\">Messages</a></li>";
                            } else {
                                echo "<li><a href=\"\"><b>Messages " . $row["COUNT(*)"] . "</b></a></li>";
                            }
                            $sql = "SELECT COUNT(*) FROM Requests";
                            $result = $link->query($sql);
                            $row = $result->fetch_array(MYSQLI_ASSOC);
                            if ($row["COUNT(*)"] == 0) {
                                echo "<li class=\"active\"><a href=\"requests.php\">Requests</a></li>";
                            } else {
                                echo "<li class=\"active\"><a href=\"requests.php\"><b>Requests " . $row["COUNT(*)"] . "</b></a></li>";
                            }
                        }
                    ?>
                </nav>
              </div>
              <div class="col-sm-9 col-lg-10">
                  <div class="row header">

                  </div>
                <!-- your page content -->
            </div>
          </div>
        </div>
        <table id="table">
            <tr>
                <th class="nameColumn">Name</th>
                <th class="typeColumn">Type of User</th>
                <th class="whenColumn">When</th>
            </tr>
            <?php
                function getMonth($monthNumber) {
                    if ($monthNumber == 0) {
                        return "Jan.";
                    } else if ($monthNumber == 1) {
                        return "Feb.";
                    } else if ($monthNumber == 2) {
                        return "Mar.";
                    } else if ($monthNumber == 3) {
                        return "Apr.";
                    } else if ($monthNumber == 4) {
                        return "May";
                    } else if ($monthNumber == 5) {
                        return "June";
                    } else if ($monthNumber == 6) {
                        return "July";
                    } else if ($monthNumber == 7) {
                        return "Aug.";
                    } else if ($monthNumber == 8) {
                        return "Sept.";
                    } else if ($monthNumber == 9) {
                        return "Oct.";
                    } else if ($monthNumber == 10) {
                        return "Nov.";
                    } else {
                        return "Dec.";
                    }
                }
                $sql = "SELECT * FROM Requests";
                $result = $link->query($sql);
                $numberOfRequests = $result->num_rows;
                for ($i = 0; $i < $numberOfRequests; $i++) {
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    echo "<tr>";
                    echo "<td>" . $row["firstName"] . " ";
                    if ($row["middleName"] != "") {
                        echo $row["middleName"] . " ";
                    }
                    echo $row["lastName"] . "</td>";
                    echo "<td>" . $row["typeOfUser"] . "</td>";
                    $whenSent = strtotime($row["whenSent"]);
                    $time = gmdate('Y', $whenSent) . "-" . gmdate('m', $whenSent) . "-" . gmdate('d', $whenSent) . " " . gmdate('h', $whenSent) . ":" . gmdate('i', $whenSent) . ":" . gmdate('s', $whenSent);
                    $datetime1 = new DateTime($time);
                    $currentDateAndTime = new DateTime(gmdate());
                    $interval = $datetime1->diff($currentDateAndTime);
                    echo $datetime1->format('h : i : s') . "<br>";
                    echo $currentDateAndTime->format('h : i : s') . "<br>";
                    if ($interval->format('Y') != 0) {
                        echo "<td>" . $datetime1->format('M d Y') . "</td>";
                    } else {
                        if ($interval->format('%m') != 0) {
                            echo "<td>" . $interval->format('%m months ago') . "</td>";
                        } else {
                            if ($interval->format('%a') > 0) {
                                echo "<td>" . $interval->format('%a days ago') . "</td>";
                            } else {
                                if ($interval->format('%h') > 0) {
                                    echo "<td>" . $interval->format('%h hours ago') . "</td>";
                                } else {
                                    if ($interval->format('%i') > 0) {
                                        echo "<td>" . $interval->format('%i minutes ago') . "</td>";
                                    } else {
                                        echo "<td>" . $interval->format('%s seconds ago') . "</td>";
                                    }
                                }
                            }
                        }
                    }
                    echo "</tr>";
                }
            ?>
        </table>
      <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    </body>
  </html>
