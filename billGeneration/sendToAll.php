<?php
include 'connect.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';

?>

<html>
<head>
    <title>bill board</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<style>
    .tName {
        background-color: lightblue;
    }

    .table {
        text-align: center;
        font-size: 14px;
    }

    .details {
        font-size: 8px;
    }
</style>

<body>
    <h1 style="text-align:center">Bill board</h1>
    <form>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="display" style="text-align:center">Sending Bill To All</h3>
                            <div>
                                <div class="cardbody">
                                    <table class="table">
                                        <thead>
                                            <tr class="tName">
                                                <td>Name</td>
                                                <td>ID</td>
                                                <td>E-mail</td>
                                                <td>Address</td>
                                                <td>Usage</td>
                                                <td>Send Bill</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT * FROM customers WHERE c_reading != 0";
                                            $result = mysqli_query($con, $sql);
                                            if (!$result) {
                                                die("Invalid Query: " . mysqli_error($con));
                                            }

                                            while ($row = $result->fetch_assoc()) {
                                                $name = $row["c_name"];
                                                $email = $row["c_email"];
                                                $address = $row["c_address"];
                                                $reading =  $row["c_reading"];
                                                $history = $row["c_history"];
                                                $total = $row["c_total"];
                                                $id = $row["c_id"];
                                                $toDate = $row["c_date"];
                                                $fromDate = date('Y-m-d', strtotime($toDate . ' - 28 days')); 
                                                $currentDate = date('Y-m-d'); // Get the current date
                                                 $futureDate = date('Y-m-d', strtotime($currentDate . ' + 15 days')); 
                                                 $payment = "rahul7620347161@okaxis";

                                                // Calculate cost
                                                $cost = 0;
                                                if ($reading >= 15) {
                                                    if ($reading >= 26) {
                                                        $cost = $reading * 66;
                                                    } else {
                                                        $cost = $reading * 46;
                                                    }
                                                }

                                                try {
                                                    $mail = new PHPMailer(true);
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
                                                    $mail->Subject = "Water Bill";
                                                    $mail->Body = "Name:$name <br> Customer ID: $id <br> Address: $address <br><br> From: $fromDate <br> To: $toDate <br><br> Reading: $reading Litres <br> Bill Amount: $cost Rs <br><br> Due Date: $futureDate <br> Payment Gateway : $payment";

                                                    if ($mail->send()) {
                                                        echo "Mail is sent to $email<br>";

                                                        // Update customer's history and total
                                                        $sql_update_history = "UPDATE customers SET c_history = '$reading' WHERE c_id='$id'";
                                                        $result_update_history = mysqli_query($con, $sql_update_history);
                                                        if (!$result_update_history) {
                                                            echo "Error updating history: " . mysqli_error($con) . "<br>";
                                                        }

                                                        $sql_update_total = "UPDATE customers SET c_total = '$reading' + '$total' WHERE c_id='$id'";
                                                        $result_update_total = mysqli_query($con, $sql_update_total);
                                                        if (!$result_update_total) {
                                                            echo "Error updating total: " . mysqli_error($con) . "<br>";
                                                        }
                                                        $sql3 = "UPDATE customers ".
                                                        "SET c_reading = '0' ".
                                                        "WHERE c_id='$id'";
                                                        $result3 = $con->query($sql3);
                                                        $sql4 = "UPDATE customers ".
                                                        "SET c_date = 'NULL' ".
                                                        "WHERE c_id='$id'";
                                                        $result4 = $con->query($sql4);
                                                    } else {
                                                        echo "Mail could not be sent to $email. Error: " . $mail->ErrorInfo . "<br>";
                                                    }
                                                } catch (Exception $e) {
                                                    echo "An error occurred while sending the email: " . $e->getMessage() . "<br>";
                                                }
                                            }

                                            // Close the result set
                                            mysqli_free_result($result);

                                            // Close the database connection
                                            mysqli_close($con);
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
</html>
