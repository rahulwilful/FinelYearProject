<?php
include 'connect.php';

$name = "";
$id = "";
$email = "";
$address = "";
$reading = "";


$errorMessage = "";
$successMessage = "";

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $name = $_POST["name"];
    $id = $_POST["id"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $reading = $_POST["reading"];

    do{
        if(empty($name)||empty($id)||empty($email)||empty($address)||empty($reading))
        {
            $errorMessage = "All The Feilds Required";
            break;
        }
        //adding new customer
        $sql = "INSERT INTO customers (c_id,c_name,c_email,c_address,c_reading)".
               "VALUES ('$id', '$name', '$email', '$address', '$reading')";
        $result=mysqli_query($con, $sql); 

        if(!$result)
        {
            $errorMessage = "Invalid Query" . $con->error;
            break;
        }

        $name = "";
        $id = "";
        $email = "";
        $address = "";
        $reading = "";

        $successMessage = "Customer Added Successfully";

        header("location: /billGeneration/allCustomers.php");
        exit;

    }while(false);

}
?>

<html>
    <head>
        <title>bill board</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">  
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>

    <body>
        <div class="container my-5">
            <h2>New Customer</h2>
            <?php
            if(!empty($errorMessage))
            {
                echo $errorMessage;
            }
            ?>
            <form method="post">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-lable">Name</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-lable">Customer ID</label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control" name="id" value="<?php echo $id; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-lable">Email</label>
                    <div class="col-sm-6">
                        <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-lable">Address</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="address" value="<?php echo $address; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-lable">Reading</label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control" name="reading" value="<?php echo $reading; ?>">
                    </div>
                </div>

                <?php
                if(!empty($successMessage))
                {
                    echo $successMessage;
                }
                ?>
                <div class="row mb-3">                   
                    <div class="col-sm-6">
                        <button type="submit" class="btn-primary">Submit</button>
                    </div>
                    <div class="col-sm-6">
                        <a class="outlnine-primary" href="/billGeneration/allCustomers.php" role="button">Cancel</a>
                    </div>
                </div>
                
            </form>

        </div>

    </body>

</html>