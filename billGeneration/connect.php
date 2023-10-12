<?php

$con =new mysqli('localhost','root','','billing');

if(!$con)
{
    die(mysqli_error($con));
}

?>