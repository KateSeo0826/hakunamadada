<?php
if(!empty($_POST["send"])) {
    $userName = $_POST["userName"]
    $userEmail = $_POST["userEmail"]
    $userMessage = $_POST["userMessage"]
    $userText = $_POST["userText"]
    $userCall = $_POST["userCall"]
    $toEmail = $_POST["kateseo@adsologist.com"]

    @mailHeaders = "Name: " .$userName .
    "\r\n Email: " . $userEmail .
    "\r\n Phone: " . $userPhone .
    "\r\n Text: " . $userText .
    "\r\n Call: " . $userCall .
    "\r\n Message: " . $userMessage . "\r\n";

    if(mail($toEmail, $userName, $mailHeaders)){
        $message = "Your Information is received Successfully."
    }


}


?>