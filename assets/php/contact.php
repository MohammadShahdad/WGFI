<?php
/*
THIS FILE USES PHPMAILER INSTEAD OF THE PHP MAIL() FUNCTION
*/

require 'PHPMailer/PHPMailerAutoload.php';

/*
*  CONFIGURE EVERYTHING HERE
*/


// an email address that will be in the From field of the email.
$fromEmail = 'demo@domain.com';
$fromName = 'Demo contact form';

// an email address that will receive the email with the output of the form
$sendToEmail = 'demo@domain.com';
$sendToName = 'Demo contact form';

// subject of the email
$subject = 'New message from contact form';

// form field names and their translations.
// array variable name => Text to appear in the email
$fields = array('name' => 'Name:', 'email' => 'Email:', 'message' => 'Message:');

// message that will be displayed when everything is OK :)
$okMessage = 'Contact form successfully submitted. Thank you, I will get back to you soon!';

// If something goes wrong, we will display this message.
$errorMessage = 'There was an error while submitting the form. Please try again later';

/*
*  LET'S DO THE SENDING
*/

// if you are not debugging and don't need error reporting, turn this off by error_reporting(0);
error_reporting(E_ALL & ~E_NOTICE);

try
{

    if(count($_POST) == 0) throw new \Exception('Form is empty');

    $emailTextHtml = "<style type='text/css'>td{text-align: center;} h1{font-size: 1.5em; margin-top: 20px; font-weight: normal; font-face: Helvetica;} img{width:18%;}</style>";
    $emailTextHtml .= "<table width=\"100%\">";
    $emailTextHtml .= "<tr><td><img src=\"cid:logo\" /></td></tr>";
    $emailTextHtml .= "<tr><td><h1>NEW MESSAGE FROM CONTACT FORM</h1></td></tr>";
    $emailTextHtml .= "</table><hr>";
    $emailTextHtml .= "<table width=\"80%\" style=\"margin: 0 auto;  margin-top: 40px;\">";
    foreach ($_POST as $key => $value) {
        // If the field exists in the $fields array, include it in the email
        if (isset($fields[$key])) {
            $emailTextHtml .= "<tr><th style=\"text-align:left; padding: 10px; border-top: 1px solid #f2f2f2;\">$fields[$key]</th><td style=\"text-align:left; padding:10px; border-top: 1px solid #f2f2f2;\">$value</td></tr>";
        }
    }
    $emailTextHtml .= "</table>";

    $mail = new PHPMailer;

    $mail->setFrom($fromEmail, $fromName);
    $mail->addAddress($sendToEmail, $sendToName); // you can add more addresses by simply adding another line with $mail->addAddress();
    $mail->addReplyTo($_POST['email'], $_POST['name']);

    $mail->isHTML(true);
    $mail->AddEmbeddedImage('../media/logo.svg', 'logo', 'logo.svg'); // attach file logo.jpg, and later link to it using identfier logoimg

    $mail->Subject = $subject;
    $mail->msgHTML($emailTextHtml); // this will also create a plain-text version of the HTML email, very handy


    if(!$mail->send()) {
        throw new \Exception('I could not send the email.' . $mail->ErrorInfo);
    }

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    // $responseArray = array('type' => 'danger', 'message' => $errorMessage);
    $responseArray = array('type' => 'danger', 'message' => $e->getMessage());
}


// if requested by AJAX request return JSON response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
// else just display the message
else {
    echo $responseArray['message'];
}
