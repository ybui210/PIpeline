<?php
    $sql = "SELECT * FROM Blacklist WHERE BINARY email='$email'";
    $result = $link->query($sql);
    $okToSend = false;
    if ($result->num_rows != 0) {
        $emailIsOnTheBlackList = true;
    } else {
        $sql = "SELECT * FROM SuspectedSpammers WHERE email='$email'";
        $result = $link->query($sql);
        if ($result->num_rows == 0) {
            $sql = "INSERT INTO SuspectedSpammers(email) VALUES ('$email')";
            $result = $link->query($sql);
        } else {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $numberOfMessagesSent = $row["numberOfMessagesSent"];
            $whenLastMessageWasSent = $row["whenLastMessageWasSent"];
            $numberOfWarningsSent = $row["numberOfWarningsSent"];
            $whenLastWarningWasSent = $row["whenLastWarningWasSent"];
            if ($numberOfMessagesSent >= 5) {
                if(getdate()['mday'] == date('j', strtotime('+1 day', strtotime($whenLastMessageWasSent)))) {
                    $userHasSentTooManyMessages = true;
                    ++$numberOfWarningsSent;
                    $sql = "UPDATE SuspectedSpammers SET numberOfWarningsSent='$numberOfWarningsSent', whenLastWarningWasSent=NOW() WHERE email='$email'";
                    $result = $link->query($sql);
                    if ($numberOfWarningsSent >= 10) {
                        $sql = "INSERT INTO Blacklist VALUES('$email')";
                        $result = $link->query($sql);
                    }
                } else {
                    $userHasSentTooManyMessages = false;
                    $numberOfMessagesSent = 1;
                    $sql = "UPDATE SuspectedSpammers SET numberOfMessagesSent='$numberOfMessagesSent' WHERE email='$email'";
                    $result = $link->query($sql);
                }
            } else {
                ++$numberOfMessagesSent;
                $sql = "UPDATE SuspectedSpammers SET numberOfMessagesSent='$numberOfMessagesSent' WHERE email='$email'";
                $result = $link->query($sql);
                $okToSend = true;
            }
        }
    }
?>