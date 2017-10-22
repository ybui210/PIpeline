<!DOCTYPE HTML>
<html>
    <header>
        <title>Login</title> <!-- Decided by Davin, open to change -->
        <link rel="stylesheet" type="text/css" href="Styles/login.css">
        
        <!-- All this favicon code was taken from https://www.favicon-generator.org/ -->
        <link rel="apple-touch-icon" sizes="57x57" href="./Images/Favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="./Images/Favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="./Images/Favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="./Images/Favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="./Images/Favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="./Images/Favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="./Images/Favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="./Images/Favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="./Images/Favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="./Images/Favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="./Images/Favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="./Images/Favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="./Images/Favicon/favicon-16x16.png">
        <link rel="manifest" href="./Images/Favicon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
    </header>
    <body>
        <div id="header"> <!-- To hold the login buttons and labels that take you to different sections of the page -->
        </div>
        <!-- Holds all objects not in the header -->
        <div id="content">
            <h1>Login</h1>
            <form class="cf">
                <div id="formBox">
                    <div class="half left cf">
                        <input type="email" id="input-email" placeholder="Email"><br>
                        <input type="password" id="input-name" placeholder="Password">
                    </div>
                    <div id="rememberMeSection">
                        <input type="checkbox" id="rememberMe"/>
                        <label for="rememberMe">Remember Me</label>
                    </div>
                    <input type="submit" value="Submit" id="submitButton">
                    <div id="additionalOptions">
                        <a href="" id="requestInvitation">Request Invitation</a>
                        <a href="" id="forgotPassword">Forgot Password</a>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>