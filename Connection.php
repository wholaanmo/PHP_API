<?php
$host="localhost";
$user="root";
$pass= "";
$db="new_api";

$con=mysqli_connect($host,$user,$pass,$db);

if ($con) {
    echo"";
}
else {
    echo "DB NOT CONNECTED";
}
?>
