<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

if(isset($_POST["submit"])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject =  $_POST['subject'];
    $message =  $_POST['message'];
    $number =  $_POST['number'];

    try{
        $mail->isSMTP();
    
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'project2sms2billing@gmail.com';
    $mail->Password = 'pabnainwzyzzttfo';
    $mail->SMTPSecure = 'tls';
    $mail->Port = '587';

    $mail->setFrom('project2sms2billing@gmail.com');
    $mail->addAddress($_POST["email"]);
    $mail->isHTML(true);
    $mail->Subject = $_POST["subject"];
    $mail->Body = "Name: $name <br> Phone Number: $number <br> Message: $message";
    $mail->send();
    if($mail->send())
    {
        echo "mail is sent";
    }else{
        echo "mail is not  sent";
    }
    
    $alert = "<div class='alert-success'><span>Message sent to $email</span></div>";

    } catch(Exception $e) {
        $alert = "<div class='alert-error'><span>'.$e->getMessage().'</span></div>";
    }

}



?>