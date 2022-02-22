<?php
    include "config/config.php";
    $id = (isset($_GET['t'])) ? $_GET['t'] : "";

    
    if($id == ""){
        if(isset($_POST['save'])){
            $tags = $_POST['tags'];
            
            mysqli_query($connect, "INSERT INTO tags VALUES (NULL,'$tags','')");
            header("location:tag");
        }
    }else{
        $tagsRowU = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM tags WHERE tags_id = $id"));
        if(isset($_POST['update'])){
            $tags = $_POST['tags'];

            mysqli_query($connect, "UPDATE tags SET tags_name='$tags' WHERE tags_id='$id'");
            header("location:tag");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="config/style.css">
    <link rel="stylesheet" href="config/selectize.custom.css">
    <script type="text/javascript" src="config/clipboard.min.js"></script>
    <script type="text/javascript" src="config/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="config/selectize.min.js"></script>
    <link rel="icon" href="favicon.png">
    <title>Add Tag</title>
</head>
<body>
    <form action="" method="post">
        <table align="center" class="add-box" border="0">
            <tr>
                <td align="center"><h3>Add a Tag</h3><?= date("l d-F-Y")?></td>
            </tr>
            <tr>
                <td>
                    <hr>
                </td>
            </tr>
            <tr>
                <td align="center">New Tag</td>
            </tr>
            <tr>
                <td width="100">
                    
                </td>
            </tr>
            <tr>
                <td >
                    <?php 
                    if($id == ""){
                    ?>
                    <input style="text-align: center" autocomplete="off" required name="tags" type="text" size="50" >
                    <?php
                    }else{
                        ?>
                    <input style="text-align: center" autocomplete="off" required name="tags" type="text" size="50" value="<?= $tagsRowU['tags_name']?>">
                    <?php
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <div id="note1"></div>
                    <div id="note"></div>
                    <hr>
                </td>
            </tr>
            <tr>
                <?php 
                if($id == ""){
                ?>
                <td align="center">
                    <input required type="submit" name="save" value="Save">
                </td>
                <?php
                }else{
                ?>
                <td align="center">
                    <input required type="submit" name="update" value="Update">
                </td>
                <?php
                }
                ?>
            </tr>
        </table>
        <br>
        <table class="index" width="100%" cellspacing="0">
            <tr>
                <td align="center">
                <h3>
                Avaliable Tags
                </h3>
                <hr>
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                <div class="wordwarp">
                <?php  
                    $tagsTable = mysqli_query($connect, "SELECT * FROM tags ORDER BY total_tags DESC");
                    while($tagsRow = mysqli_fetch_array($tagsTable)){
                        $tagsId = $tagsRow['tags_id'];
                        $numTable = mysqli_query($connect, "SELECT COUNT(*) FROM links WHERE tags_id LIKE '%$tagsId%'");
                        $numRow = mysqli_fetch_array($numTable);
                        ?>
                        <a class="secret_button" href="tag?t=<?= $tagsRow['tags_id']?>"><?= $tagsRow['tags_name']?>(<?= $numRow['COUNT(*)']?>)</a>
                <?php }?>
                </div>
                </td>
            </tr>
            
            <tr>
            <td><hr>note: you can click on the tags to edit them</td>
            </tr>
            <tr>
                <td colspan="2" align="center"><a style="cursor: pointer" class="button" onclick="window.location.assign('index')">Home</a></td>
            </tr>
        </table>
    </form>
</body>
</html>