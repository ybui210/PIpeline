<?php
    function displayBlacklistMessage() {
        $result = "<script>alert(\"You are on our blacklist\")</script>";
        return $result;
    }
    function displayWarningMessage() {
        $result = "<script>alert(\"You've been sending too many messages. Please try again tomorrow.\")</script>";
        return $result;
    }
    function displayRequestSentMessage() {
        $result = "<script>alert(\"Request has been sent.\")</script>";
        return $result;
    }
    function displayYouDoNotHaveAnAccountMessage() {
        $result = "<script>alert(\"You Do Not Have An Account With Us.\")</script>";
        return $result;
    }
    function displayMessage($msg) {
        $result = "<script>alert(" . $msg . ")</script>";
        return $result;
    }
?>