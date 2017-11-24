<?php
	function displayNavBar($userType) {
        echo "<div class=\"row\">
        <nav class=\"navbar navbar-default\">
            <div class=\"container-fluid\">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class=\"navbar-header\">
                    <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#bs-example-navbar-collapse-1\" aria-expanded=\"false\">
                        <span class=\"sr-only\">Toggle navigation</span>
                        <span class=\"icon-bar\"></span>
                        <span class=\"icon-bar\"></span>
                        <span class=\"icon-bar\"></span>
                    </button>
                    <a class=\"navbar-brand\" href=\"#\">Pipeline</a>
                </div>
                <div class=\"collapse navbar-collapse\" id=\"bs-example-navbar-collapse-1\">
                    <ul class=\"nav navbar-nav\">
                        <li ><a href=\"#\">Browse Listing <span class=\"sr-only\">(current)</span></a></li>
                        <li><a href=\"#\">Active Listing</a></li>
                        <li><a href=\"createListing.php\">Create Listing</a></li>
                        <li><a href=\"#\">News</a></li>
                        <li class=\"hidden-lg hidden-md hidden-sm\"><a href=\"account.php\">Account</a></li>
                        <li class=\"hidden-lg hidden-md hidden-sm\"><a href=\"\">System History</a></li>
                        <li class=\"hidden-lg hidden-md hidden-sm\"><a href=\"\">Social Connections</a></li>";

        if ($userType == "admin") {
            include("configdb.php");
            $sql = "SELECT COUNT(*) FROM Messages WHERE readStatus IS NULL";
            $result = $link->query($sql);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if ($row["COUNT(*)"] == 0) {
                echo "<li class=\"hidden-lg hidden-md hidden-sm\"><a href=\"\">Messages</a></li>";
            } else {
                echo "<li class=\"hidden-lg hidden-md hidden-sm\"><a href=\"\"><b>Messages " . $row["COUNT(*)"] . "</b></a></li>";
            }
            $sql = "SELECT COUNT(*) FROM Requests WHERE readStatus IS NULL";
            $result = $link->query($sql);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if ($row["COUNT(*)"] == 0) {
                echo "<li class=\"hidden-lg hidden-md hidden-sm\"><a href=\"requests.php\">Requests</a></li>";
            } else {
                echo "<li class=\"hidden-lg hidden-md hidden-sm\"><a href=\"requests.php\"><b>Requests " . $row["COUNT(*)"] . "</b></a></li>";
            }
        }
        
        echo "</ul>
                    <form class=\"navbar-form navbar-left\">
                        <div class=\"form-group\">
                            <input type=\"text\" class=\"form-control\" placeholder=\"Search\">
                        </div>
                        <button type=\"submit\" class=\"btn btn-default\">Submit</button>
                    </form>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>

    </div>";
    }
	
    function displaySideBar($selected, $userType) {
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

        if ($userType == "admin") {
            include("configdb.php");
            $sql = "SELECT COUNT(*) FROM Messages WHERE readStatus IS NULL";
            $result = $link->query($sql);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if ($row["COUNT(*)"] == 0) {
                if ($selected == "Messages") {
                    echo "<li class=\"active\"><a href=\"\">" . $userType . "Messages</a></li>";
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