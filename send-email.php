<?php
header('Content-Type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!filter_has_var(INPUT_POST, "submit")) {
        
        if (!empty($_POST['services'])) {
            foreach($_POST['services'] as $value) {
                if (!empty($value)) {
                    $checkedServices[] = $value;
                }
            }
            
            if (is_array($checkedServices)) {
                $services = implode(",", $checkedServices);
            }
        }
        
        $location = $_POST["location"];
        $adult = $_POST["adult"];
        $kids = $_POST["kids"];
        $eventType = $_POST["eventType"];
        $date = $_POST["date"];

        $email = $_POST['email'];
        $name = $_POST["yourName"];
        $phone = $_POST['phone'];  
        $message = $_POST['messageText'];

        $email = sanitizeEmail($email);
        $name = cleanInput($name);  
        $phone = cleanInput($phone);  
        $message = cleanInput($message);
        
        // Send Email to admin
        $subject = "Contact Form";
        $message = cutString($message, 1000);                
        $message = nl2br($message);
        $messageOkText = "Your message has been sent successfully. We will contact you as soon as possible.";
        $messageBody = '
            <table border="1" width="100%" cellspacing="3" cellpadding="4">
                <tbody>
                    <tr> <td style="font-size: 14px; font-weight: bold; background-color: #000000; color: #FFFFFF;">E-Mail</td> </tr>
                    <tr> <td>'.$email.'</td> </tr>
                    <tr> <td style="font-size: 14px; font-weight: bold; background-color: #000000; color: #FFFFFF;">Name</td> </tr>
                    <tr> <td>'.$name.'</td> </tr>                           
                    <tr> <td style="font-size: 14px; font-weight: bold; background-color: #000000; color: #FFFFFF;">Phone</td> </tr>
                    <tr> <td>'.$phone.'</td> </tr>
                    <tr> <td style="font-size: 14px; font-weight: bold; background-color: #000000; color: #FFFFFF;">Message</td> </tr>
                    <tr> <td>'.$message.'</td> </tr>   
                </tbody>
            </table>';
        $altBody = "Name";
        $addAddress = "kateseo@adsologist.com"; 
        $responseMessage = '
                <div style="width: 432px; height: 500px; margin: 5rem auto; background-color: #FFFFFF; border-radius: 1.5rem; box-shadow: 5px 5px 20px #4D4D4D26; z-index: 1;" class="alert alert-success" role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div style="padding: 2rem 1rem;">
                        <h2 style="text-align: center; font-size: 1.5rem; font-weight: bold;">Completed!</h2>
                        <p style="color: #7E7E7E; margin-top: 2rem; font-size: 0.8rem">Our agent will contact you within 2-3 business days.</p>
                        <h3 style="color: #7E7E7E; font-size: 1rem">Name<h3>
                        <p style="font-size: 1.1rem;color: black;">'.$name.'</p>
                        <h3 style="color: #7E7E7E; padding-bottom: 0; font-size: 1rem;">Phone Number<h3>
                        <p style="font-size: 1.1rem; color:black;">+'.$phone.'</p>
                        <h3 style="color: #7E7E7E; font-size: 1rem">Message<h3>
                        <p style="font-size: 1.1rem; color:black;">'.$message.'</p>
                        <div style="text-align:center;">
                            <button style="background-color: #262626; outline: none; width: 180px; height: 40px; border-radius: 20px; text-align: center; font-size: 1rem; margin-top:2rem;">
                                <a style="text-decoration: none; color: #ffffff;" href="/hakunamadada">Confirm</a>
                            </button>
                        </div>
                    </div>
                </div>
            ';

        sendMail($subject, $messageBody, $altBody, $addAddress, $responseMessage);

        // Send email to User
        $companyName = "Adsologist Inc.";
        $site_url = "https://www.adsologist.com";
        $site_phone = "+1 437 255 0237";
        $subject_To = "Thank you for enquiring with us, one of our experts will be in touch with you as soon as possible.";
        $messageBody_To = '
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="max-width: 100%; background-color: #f1f5f9; padding: 30px;">
                <tbody>
                    <tr>
                        <td>
                            <table border="0" cellspacing="0" cellpadding="0" align="center" style="width: 600px; max-width: 100%; background-color: #2a2a2a; border: 1px solid #CCC; padding: 50px; border-radius: 10px;">
                                <tbody>                            
                                    <tr> <td align="center" style="padding-bottom: 20px;"><img src="'.$site_url.'/assets/images/logo.png" alt="ADsologist Logo"></td> </tr>
                                    <tr> <td>&nbsp;</td> </tr>
                                    <tr> <td align="center" valign="middle" style="color: #ffffff; font-family: Arial, Helvetica, sans-serif; font-size: 18px; font-weight: bold; padding-bottom: 20px;">Dear '.$name.'</td> </tr>
                                    <tr> <td>&nbsp;</td> </tr>
                                    <tr> <td align="center" valign="middle" style="color: #ffffff; font-family: Arial, Helvetica, sans-serif; font-size: 13px; line-height: 20px;">We wanted to reach out and thank you for taking the time to fill out our contact form on our website. Your inquiry is important to us and we appreciate the opportunity to connect with you.</td> </tr>
                                    <tr> <td>&nbsp;</td> </tr>
                                    <tr> <td align="center" valign="middle" style="color: #ffffff; font-family: Arial, Helvetica, sans-serif; font-size: 13px; line-height: 20px;">At ADsologist, we are dedicated to providing top-notch service and support to all of our clients. Our team is working hard to review your request and will get back to you as soon as possible with the information you need.</td> </tr>
                                    <tr> <td>&nbsp;</td> </tr>
                                    <tr> <td align="center" valign="middle" style="color: #ffffff; font-family: Arial, Helvetica, sans-serif; font-size: 13px; line-height: 20px;">If you have any additional questions or concerns, please don\'t hesitate to reach out to us. <br />We are here to help!</td> </tr>
                                    <tr> <td>&nbsp;</td> </tr>
                                    <tr> <td align="center" valign="middle" style="color: #ffffff; font-family: Arial, Helvetica, sans-serif; font-size: 13px; line-height: 20px;">Best regards,</td> </tr>                                                                
                                    <tr> <td align="center" valign="middle" style="color: #ffffff; font-family: Arial, Helvetica, sans-serif; font-size: 13px; line-height: 20px; font-weight: bold;">The ADsologist Team.</td> </tr>                            
                                    <tr> <td>&nbsp;</td> </tr>
                                    <tr> <td>&nbsp;</td> </tr>
                                    <tr> <td align="center" valign="middle" style="color: #ffffff; font-family: Arial, Helvetica, sans-serif; font-size: 13px;">If you need help or have any questions, please visit <a href="'.$site_url.'/contact.html" style="color:#0094aa;">'.$site_url.'/contact</a><br /> Or you can reach it at '.$site_phone.'.</td> </tr>                            
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
        echo '<div class="alert alert-warning" role="alert"><i class="fa-solid fa-circle-exclamation"></i>Form is not submitted</div>';
        exit;
    }
}

// Sanitize user Input to escape HTML entities and filter out dangerous characters
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
        // make sure it ends in a word
        $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
    }
    return $string;
}

// Function to send email using PHPMailer
function sendMail($subject, $messageBody, $altBody, $addAddress, $responseMessage = Null) {
    $company = "Adsologist Inc.";
    $MessageFaultText = "Your message could not be sent. Please try again later.";

    // Create a new PHPMailer instance; passing 'true' enables exceptions
    $mail = new PHPMailer;

    // Passing 'true' enables exceptions 
    try {
        // Server Setting
        //  $mail->SMTPDebug = 1;
        $mail->isSMTP();

        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;

        $mail->SMTPSecure = 'tls';   
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;;
        $mail->SMTPAuth = true;

        $mail->Username = "kateseo@adsologist.com";

        $mail->Password = "qjdxzcgkismaqtkc";

        $mail->setFrom('kateseo@adsologist.com', $company);
        $mail->addAddress($addAddress);
        $mail->addAddress('kateseo@adsologist.com');

        // Content
        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $messageBody;
        $mail->AltBody = $altBody;
        if($mail -> send()) {
           ob_clean(); 
            exit(json_encode(array('message'=>$responseMessage)));
        } else {
            echo '<div class="alert alert-warning" role="alert">'.$MessageFaultText.'</div>';
        }
    
} catch(Exception $e) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
}
?>