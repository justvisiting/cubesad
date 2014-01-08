<?php

class Email{
    public static function sendEmail($subject,$body,$to,$from,$from_name){
        require_once("class.phpmailer.php");
        //$from = "";
        //$from_name = "Madserve";
        $uname = "test@gmail.com";
        $password = "test";
        $mail = new PHPMailer();
        $mail->IsSMTP();
        //$mail->Host       = "localhost"; // SMTP server
        $mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                                                                                   // 1 = errors and messages
                                                                                   // 2 = messages only
        $mail->SMTPAuth   = true;                  // enable SMTP authentication
        $mail->SMTPSecure = "tls"; 
        //$mail->SMTPSecure = "ssl";
        $mail->Host       = 'smtp.gmail.com';		// sets the SMTP server
        $mail->Port       = 587;                    // set the SMTP port for the GMAIL server
        $mail->Username   = $uname; // SMTP account username
        $mail->Password   = $password;        // SMTP account password	
        $mail->SetFrom($from,$from_name);
        $mail->AddAddress($to);
        $mail->Subject = $subject;
        $mail->MsgHTML($body);
        //$mail->IsHTML(true);
        //$mail->attachments=$attachment;
        try {
            $mail->Send();
            return true;
        //echo 'thax for subscrption';
        }catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            return false;
        }
    }
}
?>

