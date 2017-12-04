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
                    <a class=\"navbar-brand\" href=\"home.php\">Pipeline</a>
                </div>
                <div class=\"collapse navbar-collapse\" id=\"bs-example-navbar-collapse-1\">
                    <ul class=\"nav navbar-nav\">
                        <li ><a href=\"latestListings.php\">Browse Listings<span class=\"sr-only\">(current)</span></a></li>
                        <li><a href=\"createListing.php\">Create Listing</a></li>
                        <li class=\"hidden-lg hidden-md hidden-sm\"><a href=\"account.php\">Account</a></li>
                        <li class=\"hidden-lg hidden-md hidden-sm\"><a href=\"connections.php\">Connections</a></li>
                        <li class=\"hidden-lg hidden-md hidden-sm\"><a href=\"myListings.php\">My Listings</a></li>
                        <li class=\"hidden-lg hidden-md hidden-sm\"><a href=\"savedListings.php\">Saved Listings</a></li>
                        <li class=\"hidden-lg hidden-md hidden-sm\"><a href=\"drafts.php\">Drafts</a></li>";
        if ($userType == "admin") {
            echo "<li class=\"hidden-lg hidden-md hidden-sm\"><a href=\"adminViewListings.php\">Listings Pending Review</a></li>";
            include("configdb.php");
            $sql = "SELECT COUNT(*) FROM Messages WHERE readStatus IS NULL";
            $result = $link->query($sql);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if ($row["COUNT(*)"] == 0) {
                echo "<li class=\"hidden-lg hidden-md hidden-sm\"><a href=\"messages.php\">Messages</a></li>";
            } else {
                echo "<li class=\"hidden-lg hidden-md hidden-sm\"><a href=\"messages.php\"><b>Messages " . $row["COUNT(*)"] . "</b></a></li>";
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
        echo "<li class=\"hidden-lg hidden-md hidden-sm\"><a href=\"logout.php\">Logout</a></li>";
        echo "</ul>
                    <form method=\"post\" action=\"searchListings.php\" class=\"navbar-form navbar-left\">
                        <div class=\"form-group\">
                            <input type=\"text\" class=\"form-control\" placeholder=\"Search\" name=\"searchkey\">
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

        if ($selected == "Connections") {
            echo "<li class=\"active\"><a href=\"connections.php\">Connections</a></li>";
        } else {
            echo "<li><a href=\"connections.php\">Connections</a></li>";
        }
        
        if ($selected == "My Listings") {
            echo "<li class=\"active\"><a href=\"myListings.php\">My Listings</a></li>";
        } else {
            echo "<li><a href=\"myListings.php\">My Listings</a></li>";
        }
        
        if ($selected == "Saved Listings") {
            echo "<li class=\"active\"><a href=\"savedListings.php\">Saved Listings</a></li>";
        } else {
            echo "<li><a href=\"savedListings.php\">Saved Listings</a></li>";
        }
        
        if ($selected == "Drafts") {
            echo "<li class=\"active\"><a href=\"drafts.php\">Drafts</a></li>";
        } else {
            echo "<li><a href=\"drafts.php\">Drafts</a></li>";
        }
        
        if ($userType == "admin") {
            if ($selected == "Listings Pending Review") {
                echo "<li class=\"active\"><a href=\"adminViewListings.php\">Listings Pending Review</a></li>";
            } else {
                echo "<li><a href=\"adminViewListings.php\">Listings Pending Review</a></li>";
            }
            include("configdb.php");
            $sql = "SELECT COUNT(*) FROM Messages WHERE readStatus IS NULL";
            $result = $link->query($sql);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if ($row["COUNT(*)"] == 0) {
                if ($selected == "Messages") {
                    echo "<li class=\"active\"><a href=\"messages.php\">Messages</a></li>";
                } else {
                    echo "<li><a href=\"messages.php\">Messages</a></li>";
                }
            } else {
                if ($selected == "Messages") {
                    echo "<li class=\"active\"><a href=\"messages.php\"><b>Messages " . $row["COUNT(*)"] . "</b></a></li>";
                } else {
                    echo "<li><a href=\"messages.php\"><b>Messages " . $row["COUNT(*)"] . "</b></a></li>";
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
        
        echo "<li><a href=\"logout.php\">Logout</a></li>";

        echo "</nav></div>";
    }
?>