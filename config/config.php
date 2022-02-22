<?php
    session_start();
    
    $connect = mysqli_connect('localhost','root','','link-db');

    date_default_timezone_set('Singapore');

    $rowDate = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM folder_date"));

    $a = $rowDate['folder_date'];
    $b = date("Y-m-d");
    $d = date("j");
	$m1 = date("m");
    $m2 = date("F");
	$m = "$m1-$m2";
    $y = date("Y");

    if($a < $b){
        mkdir("C:/.raw manuscript/$y/$m/$d", 0777, true);
        mysqli_query($connect, "UPDATE folder_date SET folder_date='$b' WHERE folder_date='$a'");
    }

?>


