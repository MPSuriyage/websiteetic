<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = '';

function clean_text($string)
{
	$string = trim($string);
	$string = stripslashes($string);
	$string = htmlspecialchars($string);
	return $string;
}

if(isset($_POST["preIncubationFormSubmit"]))
{

    if($_POST["downloadType"] == "preIncubation"){
        $subject = "Download Pre-Incubation Application";
    } elseif ($_POST["downloadType"] == "incubation")
    {
        $subject = "Download Incubation Application";
    } else {
        $subject = "Download Commercialization Application";
    }
	$message = '
		<h3 align="center">Applicant Details</h3>
		<table border="1" width="100%" cellpadding="5" cellspacing="5">
			<tr>
				<td width="30%">Email</td>
				<td width="70%">'.$_POST["Email"].'</td>
			</tr>
		</table>
	';


	require('phpmailer/src/PHPMailer.php');
	require('phpmailer/src/SMTP.php');
	require('phpmailer/src/Exception.php');
	
	$mail = new PHPMailer;
	$mail->IsSMTP();								//Sets Mailer to send message using SMTP
	$mail->SMTPDebug = 1;
	$mail->Host = 'smtp.gmail.com';		//Sets the SMTP hosts of your Email hosting, this for gmail
	$mail->Mailer   = "smtp";
	$mail->Port = '465';								//Sets the default SMTP server port
	$mail->SMTPAuth = true;							//Sets SMTP authentication. Utilizes the Username and Password variables
	$mail->Username = 'xxxxxxxx@gmail.com';		//Sets SMTP username
	$mail->Password = 'xxxxxxx';					//Sets SMTP password
	$mail->SMTPSecure = 'ssl';							//Sets connection prefix. Options are "", "ssl" or "tls"
	$mail->From = 'xxxxxxxx@gmail.com';					//Sets the From email address for the message
	$mail->FromName = 'ETIC - University of Peradeniya';				//Sets the From name of the message
	$mail->AddAddress("");		//Adds a "To" address
	$mail->WordWrap = 80;							//Sets word wrapping on the body of the message to a given number of characters
	$mail->IsHTML(true);							//Sets message type to HTML
	$mail->Subject = $subject;				//Sets the Subject of the message
	$mail->Body = $message;							//An HTML or plain text message body
	if($mail->Send())								//Send an Email. Return true on success or false on error
	{
		
		$message = '<div class="alert alert-success">Thank you for your time.!</div>';
		unlink($path);
	}
	else
	{
		$message = '<div class="alert alert-danger">Sorry, There was an error downloading the application. Please try later.</div>';
	}

}

?>