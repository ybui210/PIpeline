<?php
    DEFINE ('USER', 'admin');
    DEFINE ('PASSWORD', 'C%&YQf&0WB55LRc5iIsVpT6tG45Qn3&iD03KfccfC');
    DEFINE ('DATABASE_NAME', 'Pipeline_V2_Database');
    DEFINE ('HOST', 'pipeline-v2-database.c5klbzwvfdnx.us-west-2.rds.amazonaws.com');
    DEFINE ('PORT', 3306);

    $link = mysqli_init();
    if ($success = mysqli_real_connect($link, HOST, USER, PASSWORD, DATABASE_NAME, PORT)) {
        if (!$success) {
            trigger_error("Could not select the database <br />");
            exit();
        }
    } else {
        trigger_error("Could not connect to database <br />");
        exit();
    }
    
?>