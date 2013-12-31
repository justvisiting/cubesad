<?php
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<?php
    include_once 'custom_functions.php';
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <title>Thanks For Register</title>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="author" content="" />		
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
    <link rel="stylesheet" href="assets/stylesheets/all.css" type="text/css" />

    <!--[if gte IE 9]>
    <link rel="stylesheet" href="assets/stylesheets/ie9.css" type="text/css" />
    <![endif]-->

    <!--[if gte IE 8]>
    <link rel="stylesheet" href="assets/stylesheets/ie8.css" type="text/css" />
    <![endif]-->
</head>
<body class="frontSignup">
    <div id="content" style="min-height: 50px;">
        <div id="contentHeader">
            <h1>Add Publisher</h1>
        </div>
        <div class="container">
                <div class="grid-24">
                <div class="box plain">
                    <div class="notify notify-success">
                        <h3>Successfully Registered</h3>
                        <p>
                            Thanks For register here.
                            Click <a href="signin.php">Here To Sign in.</a>
                        </p>
                    </div>
<!-- .notify --></div>
            </div>
        </div>
    </div>
</body>
</html>