<?php
    include "config/config.php";
    $type = $_GET['type'];
    $id = $_GET['id'];
    $t = $_GET['t'];

    if($type == "delete"){
        mysqli_query($connect, "DELETE FROM links WHERE link_id='$id'");
        include "total_tags.php";
        header("location:add?t=$t");
    }elseif($type == "delete-home"){
        mysqli_query($connect, "DELETE FROM links WHERE link_id='$id'");
        include "total_tags.php";
        header("location:index");
    }else{
        header("location:add?t=$t");
    }
?>