<?php
    include("configdb.php");
    session_start();
    if (isset($_SESSION["userEmail"])) {
        $userEmail = $_SESSION["userEmail"];
        $sql = "SELECT type FROM Users WHERE BINARY email='$userEmail'";
        $result = $link->query($sql);
        if ($result->num_rows == 0) {
            header("location: index.php");
            die();
        }
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $userType = $row["type"];
    } else {
        header("location: index.php");
        die();
    }
?>