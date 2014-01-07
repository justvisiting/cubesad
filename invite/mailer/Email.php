<?php

class Email
{

	public function parse_template($template_name,$data){
		 
		$path   = 'mailer/templates/'.$template_name.'.html';
		$template  = file_get_contents($path);
		 
		foreach($data as $tag=>$value){
			
			if(is_array($value)){
				 
				foreach($value as $t=>$v)
				{
					$template  = str_replace($t, $v,$template);
				}
				 
			}else{
				$template  = str_replace($tag, $value,$template);
				 
			}
		}
		return $template;
		 
	}
	
	 public function SendEmail($template_name,$data_replace,$to,$from,$password,$from_name,$subject)
	{
		require_once("mailer/class.phpmailer.php");
			$mail = new PHPMailer();
				$body = $this->parse_template($template_name,$data_replace);
				//  $body             =  $msg_body; //Strip backslashes
				$mail->IsSMTP();
				//$mail->Host       = "localhost"; // SMTP server
				$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
													   // 1 = errors and messages
													   // 2 = messages only
				$mail->SMTPAuth   = true;                  // enable SMTP authentication
				//$mail->SMTPSecure = "ssl";
				$mail->Host       = 'localhost';		// sets the SMTP server
				$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
				$mail->Username   = $from; // SMTP account username
				$mail->Password   = $password;        // SMTP account password	
				$mail->SetFrom($from,$from_name);
				$mail->AddAddress($to);
				$mail->Subject = $subject;
				$mail->MsgHTML($body);
				//$mail->IsHTML(true);
				//$mail->attachments=$attachment;
				try {
					$mail->Send(); 
					//echo 'thax for subscrption';
					}
					catch (Exception $e) {
						echo 'Caught exception: ',  $e->getMessage(), "\n";
					}
	
	}
/*	public function SendEmail($template_name,$data_replace,$to,$from,$password,$from_name,$subject){
			require 'mailer/class.phpmailer.php';
			$body = $this->parse_template($template_name,$data_replace);
			//Create a new PHPMailer instance
			$mail = new PHPMailer();
			//Tell PHPMailer to use SMTP
			$mail->IsSMTP();
			//Enable SMTP debugging
			// 0 = off (for production use)
			// 1 = client messages
			// 2 = client and server messages
			$mail->SMTPDebug  = 2;
			//Ask for HTML-friendly debug output
			$mail->Debugoutput = 'html';
			//Set the hostname of the mail server
			$mail->Host       = 'smtp.gmail.com';
			//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
			$mail->Port       = 587;
			//Set the encryption system to use - ssl (deprecated) or tls
			$mail->SMTPSecure = 'tls';
			//Whether to use SMTP authentication
			$mail->SMTPAuth   = true;
			//Username to use for SMTP authentication - use full email address for gmail
			$mail->Username   = $from;
			//Password to use for SMTP authentication
			$mail->Password   = $password;
			//Set who the message is to be sent from
			$mail->SetFrom($from, $from_name);
			//Set an alternative reply-to address
			$mail->AddReplyTo($from,$from_name);
			//Set who the message is to be sent to
			$mail->AddAddress($to,$from_name);
			//Set the subject line
			$mail->Subject = $subject;
			//Read an HTML message body from an external file, convert referenced images to embedded, convert HTML into a basic plain-text alternative body
			$mail->MsgHTML($body);
			//Replace the plain text body with one created manually
			//$mail->AltBody = 'This is a plain-text message body';
			//Attach an image file
			//$mail->AddAttachment('assets/images/3809_3D_Color_Cube.jpg');

			//Send the message, check for errors
				try{
					$mail->Send(); 
					//echo 'thax for subscrption';
					}
					catch(Exception $e){
						//echo 'Caught exception: ',  $e->getMessage(), "\n";
					}
	}*/
}
/*
class Emailrequire_once("mailer/Email.php");
$email = new Email();
$email->SendEmail('billing_issue',$mail,/*mail receiver*///CONTACT_MAIL,$mail['email_data'],$mail['user_name_data'],'Billing Issues');
//$email->SendEmail('billing_issue',$mail,$mail['email_data'],$mail['email_data'],$mail['user_name_data'],'Billing Issues');

?>

