<?php
    include "config/config.php";

    $tableTags = mysqli_query($connect,"SELECT * FROM tags ORDER BY total_tags DESC");
    while ($rowTags = mysqli_fetch_array($tableTags)) {
        $tags = $rowTags['tags_name'];
        $tagsId = $rowTags['tags_id'];
        $rowTotalTags = mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(tags_id) FROM links WHERE tags_id LIKE '%$tagsId%'"));
        $totalTags = $rowTotalTags['COUNT(tags_id)'];
        mysqli_query($connect, "UPDATE tags SET total_tags = '$totalTags' WHERE tags_id = '$tagsId'");
        // echo $totalTags;
        // echo "  ";
        // echo $tags;
        // echo "<br>";
    }

?>