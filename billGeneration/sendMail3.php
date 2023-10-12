<?php
include 'connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

$name = "";
$id = "";
$email = "";
$address = "";
$reading = "";
$history = "";
$total = "";
$subject = "water Bill";
$fromData = "";
$toDate = "";
$cost = 0;

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if (!isset($_GET["id"])) {
        header("location: /billGeneration/index.php");
        exit;
    }
    $id = $_GET["id"];
    $sql = "SELECT * FROM customers WHERE c_id = '$id'";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    if (!$row) {
        header("location: /billGeneration/index.php");
        exit;
    }

    $name = $row["c_name"];
    $email = $row["c_email"];
    $address = $row["c_address"];
    $reading =  $row["c_reading"];
    $history = $row["c_history"];
    $total = $row["c_total"];
    $toDate = $row["c_date"];
    $fromDate = date('Y-m-d', strtotime($toDate . ' - 28 days')); 
    $currentDate = date('Y-m-d'); // Get the current date
    $futureDate = date('Y-m-d', strtotime($currentDate . ' + 15 days')); 
    $payment = "rahul7620347161@okaxis";
    if($reading >= 15)
    {
        if($reading >= 26)
        {
            $cost = $reading * 66;
        }else{
            $cost = $reading * 46;
        }
    }


    

    try{
        $mail->isSMTP();
    
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'project2sms2billing@gmail.com';
    $mail->Password = 'pabnainwzyzzttfo';
    $mail->SMTPSecure = 'tls';
    $mail->Port = '587';

    $mail->setFrom('project2sms2billing@gmail.com');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = "Name:$name <br> Customer ID: $id <br> Address: $address <br><br> From: $fromDate <br> To: $toDate <br><br> Reading: $reading Litres <br> Bill Amount: $cost Rs <br><br> Due Date: $futureDate <br> Payment Gateway : $payment";
    $mail->send();
    if($mail->send())
    {
        echo "mail is sent";
        $sql = "UPDATE customers ".
                "SET c_history = '$reading'".
                "WHERE c_id='$id'";
        $result = $con->query($sql);
        $sql2 = "UPDATE customers ".
                "SET c_total = '$reading' + '$total' ".
                "WHERE c_id='$id'";
        $result2 = $con->query($sql2);
        $sql3 = "UPDATE customers ".
                "SET c_reading = '0' ".
                "WHERE c_id='$id'";
        $result3 = $con->query($sql3);
        $sql4 = "UPDATE customers ".
                "SET c_date = 'NULL' ".
                "WHERE c_id='$id'";
        $result4 = $con->query($sql4);

        header("location: /billgeneration/index.php");
        exit;
    }else{
        echo "mail is not  sent";
        header("location: /billgeneration/index.php");
        exit;
    }
    
    $alert = "<div class='alert-success'><span>Message sent to $email</span></div>";

    } catch(Exception $e) {
        $alert = "<div class='alert-error'><span>" . $e->getMessage() . "</span></div>";
    }

}
else{

}



?>