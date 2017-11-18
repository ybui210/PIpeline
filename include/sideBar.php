<?php
    function displaySideBar($selected, $admin) {
        echo "<div class=\"col-sm-3 col-lg-2 navBarDiv hidden-xs\"><nav class=\"nav nav-pills nav-stacked leftNavbar\">";
        
        if ($selected == "Home") {
            echo "<li class=\"active\"><a href=\"home.php\">Home</a></li>";
        } else {
            echo "<li><a href=\"home.php\">Home</a></li>";
        }
        if ($selected == "Account") {
            echo "<li class=\"active\"><a href=\"account.php\">Account</a></li>";
        } else {
            echo "<li><a href=\"account.php\">Account</a></li>";
        }

        if ($selected == "Password") {
            echo "<li class=\"active\"><a href=\"changePassword.php\">Password</a></li>";
        } else {
            echo "<li><a href=\"changePassword.php\">Password</a></li>";
        }

        if ($selected == "Profile") {
            echo "<li class=\"active\"><a href=\"updateProfile.php\">Profile</a></li>";
        } else {
            echo "<li><a href=\"updateProfile.php\">Profile</a></li>";
        }

        if ($selected == "Notifications") {
            echo "<li class=\"active\"><a href=\"notificationPreferens.php\">Notifications</a></li>";
        } else {
            echo "<li><a href=\"notificationPreferens.php\">Notifications</a></li>";
        }

        if ($selected == "System History") {
            echo "<li class=\"active\"><a href=\"\">System History</a></li>";
        } else {
            echo "<li><a href=\"\">System History</a></li>";
        }

        if ($selected == "Social Connections") {
            echo "<li class=\"active\"><a href=\"\">Social Connections</a></li>";
        } else {
            echo "<li><a href=\"\">Social Connections</a></li>";
        }

        if ($admin) {
            include("../../include/configdb.php");
            $sql = "SELECT COUNT(*) FROM Messages WHERE readStatus IS NULL";
            $result = $link->query($sql);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if ($row["COUNT(*)"] == 0) {
                if ($selected == "Messages") {
                    echo "<li class=\"active\"><a href=\"\">Messages</a></li>";
                } else {
                    echo "<li><a href=\"\">Messages</a></li>";
                }
            } else {
                if ($selected == "Messages") {
                    echo "<li class=\"active\"><a href=\"\"><b>Messages " . $row["COUNT(*)"] . "</b></a></li>";
                } else {
                    echo "<li><a href=\"\"><b>Messages " . $row["COUNT(*)"] . "</b></a></li>";
                }

            }
            $sql = "SELECT COUNT(*) FROM Requests WHERE readStatus IS NULL";
            $result = $link->query($sql);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if ($row["COUNT(*)"] == 0) {
                if ($selected == "Requests") {
                    echo "<li class=\"active\"><a href=\"requests.php\">Requests</a></li>";
                } else {
                    echo "<li><a href=\"requests.php\">Requests</a></li>";
                }

            } else {
                if ($selected == "Requests") {
                    echo "<li class=\"active\"><a href=\"requests.php\"><b>Requests " . $row["COUNT(*)"] . "</b></a></li>";
                } else {
                    echo "<li><a href=\"requests.php\"><b>Requests " . $row["COUNT(*)"] . "</b></a></li>";
                }
            }
        }

        echo "</nav></div>";
    }
?>