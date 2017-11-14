<?php
require_once("../../include/configdb.php");
    if (isset($_POST["Remove"]))
    {
        $id = $_POST["Remove"];
        $sql = "DELETE * FROM Listings WHERE listingId = " + $id + ";";
        $result = $link->query($sql);
        header("Location: myListings.php");
        exit;
    }
    else
    {
        $id = $_POST["Edit"];
        $action = "edit";
        echo "Edit listing\n";
    }

?>