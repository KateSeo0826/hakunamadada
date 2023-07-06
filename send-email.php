<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


require 'vendor/autoload.php';

$email = $_POST['EmailAddress'];
$phone = $_POST['PhoneNo'];  
$text = $_POST['Text'];  
$call = $_POST['Call'];  
$message = $_POST['Message'];

echo $message . "\n" . $email ;

$email = sanitizeEmail($email);
$phone = cleanInput($phone);  
$text = cleanInput($text);  
$call = cleanInput($call);  
$message = cleanInput($message);

//Check fields are empty or not
if(empty($email) || empty($phone) || empty($text) || empty($call) || empty($message)) {
 echo '<div class="alert alert-warning" role="alert"><i class="fas fa-exclamation-circle"></i> Please complete all required fields!</div>';
 exit;
}
else{
    if(!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {

        //Send Email to admin
        $subject = "Contact Form";
        $message = cutString($message, 1000);                
        $message = nl2br($message);  //Replace new lines with <br>
        $messageOkText = "Your message has been sent successfully. We will contact you as soon as possible.";
        $messageBody = `<table border="1" width="100%" cellspacing="3" cellpadding="4">
        <tbody>
            <tr><td style="font-size: 14px; font-weight: bold; background-color: #000000; color: #FFFFFF;">E-Mail</td></tr>
            <tr><td>'.$email.'</td></tr>
            <tr><td style="font-size: 14px; font-weight: bold; background-color: #000000; color: #FFFFFF;">Phone</td></tr>
            <tr><td>'.$phone.'</td></tr>                           
            <tr><td style="font-size: 14px; font-weight: bold; background-color: #000000; color: #FFFFFF;">Message</td></tr>
            <tr><td>'.$text.'</td></tr>
            <tr><td style="font-size: 14px; font-weight: bold; background-color: #000000; color: #FFFFFF;">Message</td></tr>
            <tr><td>'.$call.'</td></tr>
        </tbody>
        </table>`;
        $altBody = 'Name: '.$email;
        $addAddress = "kateseo@adsologist.com"; 
        $responseMessage = '<div class="alert alert-success" role="alert"><i class="fa-solid fa-circle-check"></i>Hi, I am good</div>';
        
        sendMail($subject, $messageBody, $altBody, $addAddress, $responseMessage);

        //Send email to User
        $companyName = "Adsologist Inc.";
                $site_url = "https://www.adsologist.com";
                $site_phone = "+1 437 255 0237";
                $subject_To = "Thank you for enquiring with us, one of our experts will be in touch with you as soon as possible.";
                $messageBody_To = '<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="max-width:100%;background-color: #f1f5f9;padding: 30px;">
                <tbody>
                    <tr>
                        <td>
                            <table border="0" cellspacing="0" cellpadding="0" align="center" style="width:600px;max-width:100%;background-color: #2a2a2a;border: 1px solid #CCC;padding: 50px;border-radius: 10px;">
                                <tbody>                            
                                    <tr> <td align="center" style="padding-bottom:20px;"><img src="'.$site_url.'/assets/images/logo.png" alt="ADsologist Logo"></td> </tr>
                                    <tr> <td>&nbsp;</td> </tr>
                                    <tr> <td align="center" valign="middle" style="color:#ffffff; font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold; padding-bottom: 20px;">Dear '.$email.'</td> </tr>
                                    <tr> <td>&nbsp;</td> </tr>
                                    <tr> <td align="center" valign="middle" style="color:#ffffff; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:20px;">We wanted to reach out and thank you for taking the time to fill out our contact form on our website. Your inquiry is important to us and we appreciate the opportunity to connect with you.</td> </tr>
                                    <tr> <td>&nbsp;</td> </tr>
                                    <tr> <td align="center" valign="middle" style="color:#ffffff; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:20px;">At ADsologist, we are dedicated to providing top-notch service and support to all of our clients. Our team is working hard to review your request and will get back to you as soon as possible with the information you need.</td> </tr>
                                    <tr> <td>&nbsp;</td> </tr>
                                    <tr> <td align="center" valign="middle" style="color:#ffffff; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:20px;">If you have any additional questions or concerns, please don\'t hesitate to reach out to us. <br />We are here to help!</td> </tr>
                                    <tr> <td>&nbsp;</td> </tr>
                                    <tr> <td align="center" valign="middle" style="color:#ffffff; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:20px;">Best regards,</td> </tr>                                                                
                                    <tr> <td align="center" valign="middle" style="color:#ffffff; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:20px;font-weight: bold;">The ADsologist Team.</td> </tr>                            
                                    <tr> <td>&nbsp;</td> </tr>
                                    <tr> <td>&nbsp;</td> </tr>
                                    <tr> <td align="center" valign="middle" style="color:#ffffff; font-family:Arial, Helvetica, sans-serif; font-size:13px;">If you need help or have any questions, please visit <a href="'.$site_url.'/contact.html" style="color:#0094aa;">'.$site_url.'/contact</a><br /> Or you can reach it at '.$site_phone.'.</td> </tr>                            
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
                </table>';
                $altBody_To = "Thank you for enquiring with us, one of our experts will be in touch with you as soon as possible.";
                $addAddress = $email;
                sendMail($subject_To,$messageBody_To,$altBody_To,$addAddress);
    } else {
        //echo 'Invalid Email Format'
        echo '<div class="alert alert-warning" role="alert"><i class="fa-solid fa-circle-exclamation"></i>Please enter a valid email address!</div>';
        exit;
    }
}
//Sanitize user Input to escape HTML entities and filter out dangerous characters.
function cleanInput($input) {
    $input = trim($input);
    $deger = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return $deger;
}

function sanitizeEmail($input){
    $input = trim($input);
    $deger = filter_var($input, FILTER_SANITIZE_EMAIL);
    return $deger;
}

function cutString($string, $length) {
    $string = strip_tags($string);
    if (strlen($string) > $length) {
        // truncate string
        $stringCut = substr($string, 0, $length);
        // make sure it ends in a word so assassinate doesn
        $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
    }
    return $string;
}

//Function to send email useing PHPMailer



function sendMail($subject,$messageBody,$altBody,$addAddress,$responseMessage = NULL) {

$company = "Adsologist Inc.";
$MessageFaultText = "Your message could not be sent. Please try again later.";

//Create a new PHPMailer instance; passing 'true' enables exceptions
$mail = new PHPMailer;


//Passing 'true' enables exceptions 
$username = var_dump($_Mail_USERNAME);
try {

    //Server Setting
    // $mail->SMTPDebug = 0;
    $mail->isSMTP();

    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;

    $mail->SMTPSecure = 'ssl';   
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;;
    $mail->SMTPAuth = true;

    $mail->Username = '';

    $mail->Password = '';

    $mail->setFrom('kateseo@adsologist.com', $company);
    $mail->addAddress($addAddress);
    $mail->addAddress('kateseo@adsologist.com');

//Content
    $mail->CharSet = 'UTF-8';
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $messageBody;
    $mail->AltBody = $altBody;
    

if($mail -> send()) {
    echo $responseMessage;
}
else {
     echo '<div class="alert alert-warning" role="alert">'.$MessageFaultText.'</div>';
}

}catch(Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
}
// echo "email sent"
// //send the message, check for errors
// if (!$mail->send()) {
//     echo 'Mailer Error: ' . $mail->ErrorInfo;
// } else {
//     echo 'Message sent!';
//     //Section 2: IMAP
//     //Uncomment these to save your message in the 'Sent Mail' folder.
//     #if (save_mail($mail)) {
//     #    echo "Message saved!";
//     #}
// }

//Section 2: IMAP
//IMAP commands requires the PHP IMAP Extension, found at: https://php.net/manual/en/imap.setup.php
//Function to call which uses the PHP imap_*() functions to save messages: https://php.net/manual/en/book.imap.php
//You can use imap_getmailboxes($imapStream, '/imap/ssl', '*' ) to get a list of available folders or labels, this can
//be useful if you are trying to get this working on a non-Gmail IMAP server.
// function save_mail($mail)
// {
//     //You can change 'Sent Mail' to any other folder or tag
//     $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';

//     //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
//     $imapStream = imap_open($path, $mail->Username, $mail->Password);

//     $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
//     imap_close($imapStream);

//     return $result;
// }




?>