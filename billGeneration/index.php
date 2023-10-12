<?php
include 'connect.php';
?>

<html>
    <head>
        <title>bill board</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <style>
        .tName{
            background-color: lightblue;
            
        }
        .table{
            
            text-align: center;
            font-size: 14px;
        }
        .details{
            font-size: 8px;
        }


    </style>
    <body>
        <h1 style="text-align:center">Bill board</h1>
        <form>
            <div class="container">
            <a class="btn btn-primary" href="/billGeneration/sendToAll.php">Send To All</a>
                <div class="row">
                <a class="btn btn-primary" href="/billGeneration/allCustomers.php">All Customers</a>
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="display" style="text-align:center">Pending Customers</h3>
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
                                            $sql="SELECT * FROM customers WHERE c_reading != 0";
                                            $result= mysqli_query($con, $sql); 
                                            if(!$result)
                                            {
                                                die("Invalid Query: ");
                                            }

                                            while($row = $result->fetch_assoc())
                                            {
                                                echo "
                                                     <tr>
                                                     <td>$row[c_name]</td>
                                                     <td>$row[c_id]</td>                                               
                                                     <td>$row[c_email]</td>
                                                     <td>$row[c_address]</td>
                                                     <td>$row[c_reading]</td>
                                                   
                                                    <td><a  href='/billGeneration/sendMail3.php?id=$row[c_id]'>Send</a></td>
                                                    </tr>
                                                ";
                                                
                                            }

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