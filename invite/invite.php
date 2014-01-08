<?php
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<?php
    include_once 'mailer/Email.php';
    $showDefault = '1'; //default publisher;
    $adminEmail = "nitesh.mali.sspl@gmail.com"; // this mail will be received by admin with publisher/advertiser details.
    if(isset($_POST["send_email_to_publisher"])){
        global $errormessage;
        $name = isset($_POST["pub_fullname"]) && strlen($_POST["pub_fullname"]) > 0 ? $_POST["pub_fullname"] : NULL ;
        $clientEmail = isset($_POST["pub_email_address"]) && strlen($_POST["pub_email_address"]) > 0 ? $_POST["pub_email_address"] : NULL ;
        $phone = isset($_POST["pub_phone_number"]) && strlen($_POST["pub_phone_number"]) > 0 ? $_POST["pub_phone_number"] : NULL ;
        $links = isset($_POST["pub_links"]) && strlen($_POST["pub_links"]) > 0 ? $_POST["pub_links"] : NULL ;
        $comments = isset($_POST["pub_comments"]) && strlen($_POST["pub_comments"]) > 0 ? $_POST["pub_comments"] : NULL ;
        
        if(!isset($name)){
            $errormessage = "Enter Full Name";
            $editdata = $_POST;
        }else if(!isset($clientEmail)){
            $errormessage = "Enter Email Address";
            $editdata = $_POST;
        }else if(!isset($phone)){
            $errormessage = "Enter Phone Number";
            $editdata = $_POST;
        }else if(!isset($links)){
            $errormessage = "Enter play store links";
            $editdata = $_POST;
        }else{
           $body = "Hi Admin,"
                   . "<br/><br/>"
                   . "Publisher Details are :<br/>"
                   . "Full Name : $name <br/>"
                   . "Email Address : $clientEmail <br/>"
                   . "Phone Number : $phone <br/>"
                   . "Play store links : $links <br/>"
                   . "Comments : $comments";
           if(Email::sendEmail("Invite Publisher",$body,$adminEmail,$clientEmail,"Madserve")){
                $confirm = "send";
                //send email
           }
        }
    }
    
    if(isset($_POST["send_email_to_advertiser"])){
        $showDefault = '2'; //advertiser;
        global $errormessage;
        $name = isset($_POST["adv_fullname"]) && strlen($_POST["adv_fullname"]) > 0 ? $_POST["adv_fullname"] : NULL ;
        $clientEmail = isset($_POST["adv_email_address"]) && strlen($_POST["adv_email_address"]) > 0 ? $_POST["adv_email_address"] : NULL ;
        $phone = isset($_POST["adv_phone_number"]) && strlen($_POST["adv_phone_number"]) > 0 ? $_POST["adv_phone_number"] : NULL ;
        $website = isset($_POST["adv_website"]) && strlen($_POST["adv_website"]) > 0 ? $_POST["adv_website"] : NULL ;
        $comments = isset($_POST["adv_comments"]) && strlen($_POST["adv_comments"]) > 0 ? $_POST["adv_comments"] : NULL ;
        
        if(!isset($name)){
            $errormessage = "Enter Full Name";
            $editdata = $_POST;
        }else if(!isset($clientEmail)){
            $errormessage = "Enter Email Address";
            $editdata = $_POST;
        }else if(!isset($phone)){
            $errormessage = "Enter Phone Number";
            $editdata = $_POST;
        }else if(!isset($website)){
            $errormessage = "Enter website url";
            $editdata = $_POST;
        }else{
            $body = "Hi Admin,"
                   . "<br/><br/>"
                   . "Advertiser Details are :<br/>"
                   . "Full Name : $name <br/>"
                   . "Email Address : $clientEmail <br/>"
                   . "Phone Number : $phone <br/>"
                   . "Website : $website <br/>"
                   . "Comments : $comments";
            if(Email::sendEmail("Invite Advertiser",$body,$adminEmail,$clientEmail,"Madserve")){
                $confirm = "send";
                //send email
            }
        }
    }
?>
    
<head>
    <?php if ($showDefault == 1){ ?>
        <title>Publisher - Invite Page</title>
    <?php } else { ?>
        <title>Advertiser - Invite Page</title>
    <?php }?>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="author" content="" />		
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/favicon.ico" />
    <link rel="stylesheet" href="css/all.css" type="text/css" />

    <!--[if gte IE 9]>
    <link rel="stylesheet" href="css/ie9.css" type="text/css" />
    <![endif]-->

    <!--[if gte IE 8]>
    <link rel="stylesheet" href="css/ie8.css" type="text/css" />
    <![endif]-->
    
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script>
        $(document).ready(function(){
            <?php if ($showDefault == 1){ ?>
                $(".publisher").show();
                $(".advertiser").hide();
            <?php } else { ?>
                $(".publisher").hide();
                $(".advertiser").show();
            <?php }?>
            $("#publisher").click(function(){
                $(".box").hide();
                $(".publisher").show();
                $(".advertiser").hide();
                $("title").html("Publisher - Invite Page");
            });
            $("#advertiser").click(function(){
                $(".box").hide();
                $(".publisher").hide();
                $(".advertiser").show();
                $("title").html("Advertiser - Invite Page");
            });
        }); 
    </script>
</head>
<?php
?>
<body class="frontSignup">
    <div id="content">
        <div id="contentHeader">
            <h1>Add User</h1>
        </div>
        <div class="container">
            <?php if(isset($confirm)){?>
                <br/><br/>
                <div class="box plain">
                    <div class="notify notify-success">Thanks</div>
                </div>
            <?php }else {?>
            <button id="publisher" class="btn  btn-large btn-blue">Invite Publisher</button>
            <button id="advertiser" class="btn  btn-large btn-blue">Invite Advertiser</button>
            <br/><br/>
            <div class="grid-24 publisher">
                <?php if (isset($errormessage)){ ?>
                    <div class="box plain"><div class="notify notify-error"><h3>Error</h3><p><?php echo $errormessage; ?></p></div> <!-- .notify --></div>
                <?php } ?>
                <form method="post" id="cruduser" name="cruduser" class="form uniformForm">
                    <input type="hidden" name="send_email_to_publisher" value="1" />
                    <div class="widget">
                        <div class="widget-header">
                            <span class="icon-article"></span>
                            <h3>Invite Publisher</h3>
                        </div> <!-- .widget-header -->

                        <div class="widget-content">
                                <div class="field-group">
                                    <div class="field">
                                        <input type="text" value="<?php echo isset($editdata["pub_fullname"]) ? $editdata["pub_fullname"] : ""; ?>" name="pub_fullname" id="pub_fullname" size="28" class="" />			
                                        <label for="pub_fullname"><strong>Your Name (required)</strong></label>
                                    </div>
                                </div> <!-- .field-group -->

                                <div class="field-group">
                                    <div class="field">
                                        <input type="text" value="<?php echo isset($editdata["pub_email_address"]) ? $editdata["pub_email_address"] : ""; ?>" name="pub_email_address" id="pub_email_address" size="28" class="" />			
                                        <strong>
                                            <label for="pub_email_address"><strong>E-Mail Address</strong></label>
                                        </strong>
                                    </div>
                                </div> <!-- .field-group -->
                                <div class="field-group">
                                    <div class="field">
                                        <input type="text" value="<?php echo isset($editdata["pub_phone_number"]) ? $editdata["pub_phone_number"] : ""; ?>" name="pub_phone_number" id="pub_phone_number" size="28" class="" />			
                                        <label for="pub_phone_number">Phone Number</label>
                                    </div>
                                </div> <!-- .field-group -->
                                
                                <div class="field-group">
                                    <div class="field">
                                        <textarea cols="60" rows="10" name="pub_links" ><?php echo isset($editdata["pub_links"]) ? $editdata["pub_links"] : ""; ?></textarea>
                                        <label for="pub_links">Enter play store links</label>
                                    </div>
                                </div> <!-- .field-group -->
                                
                                <div class="field-group">
                                    <div class="field">
                                        <input type="text" value="<?php echo isset($editdata["pub_comments"]) ? $editdata["pub_comments"] : ""; ?>" name="pub_comments" id="pub_comments" size="28" class="" />			
                                        <label for="pub_comments">Comments</label>
                                    </div>
                                </div> <!-- .field-group -->
                            </div> <!-- .widget-content -->
                    </div> <!-- .widget -->
                    <div class="actions">
                        <button type="submit" class="btn  btn-large btn-blue">Send</button>
                    </div> <!-- .actions -->
                </form>
            </div>
            
            <!-- advertiser -->
            
            <div class="grid-24 advertiser" style="display:none">
                <?php if (isset($errormessage)){ ?>
                    <div class="box plain"><div class="notify notify-error"><h3>Error</h3><p><?php echo $errormessage; ?></p></div> <!-- .notify --></div>
                <?php } ?>
                <form method="post" id="cruduser" name="cruduser" class="form uniformForm">
                    <input type="hidden" name="send_email_to_advertiser" value="1" />
                    <div class="widget">
                        <div class="widget-header">
                            <span class="icon-article"></span>
                            <h3>Invite Advertiser</h3>
                        </div> <!-- .widget-header -->

                        <div class="widget-content">
                                <div class="field-group">
                                    <div class="field">
                                        <input type="text" value="<?php echo isset($editdata["adv_fullname"]) ? $editdata["adv_fullname"] : ""; ?>" name="adv_fullname" id="adv_fullname" size="28" class="" />			
                                        <label for="adv_fullname"><strong>Your Name (required)</strong></label>
                                    </div>
                                </div> <!-- .field-group -->

                                <div class="field-group">
                                    <div class="field">
                                        <input type="text" value="<?php echo isset($editdata["adv_email_address"]) ? $editdata["adv_email_address"] : ""; ?>"  name="adv_email_address" id="adv_email_address" size="28" class="" />			
                                        <strong>
                                            <label for="adv_email_address"><strong>E-Mail Address</strong></label>
                                        </strong>
                                    </div>
                                </div> <!-- .field-group -->
                                <div class="field-group">
                                    <div class="field">
                                        <input type="text" value="<?php echo isset($editdata["adv_phone_number"]) ? $editdata["adv_phone_number"] : ""; ?>" name="adv_phone_number" id="adv_phone_number" size="28" class="" />			
                                        <label for="adv_phone_number">Phone Number</label>
                                    </div>
                                </div> <!-- .field-group -->
                                
                                <div class="field-group">
                                    <div class="field">
                                        <input type="text" value="<?php echo isset($editdata["adv_website"]) ? $editdata["adv_website"] : "http://"; ?>" name="adv_website" id="adv_website" size="28" class="" />	
                                        <label for="adv_website">Website</label>
                                    </div>
                                </div> <!-- .field-group -->
                                
                                <div class="field-group">
                                    <div class="field">
                                        <input type="text" value="<?php echo isset($editdata["adv_comments"]) ? $editdata["adv_comments"] : ""; ?>" name="adv_comments" id="adv_comments" size="28" class="" />			
                                        <label for="adv_comments">Comments</label>
                                    </div>
                                </div> <!-- .field-group -->
                            </div> <!-- .widget-content -->
                    </div> <!-- .widget -->
                    <div class="actions">
                        <button type="submit" class="btn  btn-large btn-blue">Send</button>
                    </div> <!-- .actions -->
                </form>
            </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>