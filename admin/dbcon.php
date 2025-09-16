<?php

    $conn = mysqli_connect("localhost","root","","admin");

    if(!$conn){
        die('Connection Failed'. mysqli_connect_error());
    }

?>