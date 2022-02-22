<?php
    include "config/config.php";
    include "config/numberFormat.php";
    
    $typeSrc =  (isset($_GET['t'])) ? $_GET['t'] : "";
    $tagsSrc = (isset($_GET['ta'])) ? $_GET['ta'] : "";
    $fileTypeSrc = (isset($_GET['ft'])) ? $_GET['ft'] : "";
    $artistSrc = (isset($_GET['a'])) ? $_GET['a'] : "";
    $sortSrc = (isset($_GET['s'])) ? $_GET['s'] : "";
    $orderSrc = (isset($_GET['o'])) ? $_GET['o'] : "";
    $daySrc = (isset($_GET['d'])) ? $_GET['d'] : "";
    $monthSrc = (isset($_GET['m'])) ? $_GET['m'] : "";
    $yearSrc = (isset($_GET['y'])) ? $_GET['y'] : "";
    
    $tagsRep = str_replace('"',"%",$tagsSrc);
    $tagsRep1 = substr($tagsRep, 1, -1);
    $tagsRep2 = "'" . "$tagsRep1" . "'";
    $tagsRep3 = str_replace(',',"' AND links.tags_id LIKE '",$tagsRep2);

    // var_dump($tagsRep3);
    // this kind of query is really fucking retarded, they really shouldn't have let me get into coding 

    $typeQuery = ($typeSrc == "") ? "type.type_id!=''" : "type.type_id='$typeSrc'";
    $tagsQuery = ($tagsRep3 == "''") ? "links.tags_id!=''" : "links.tags_id LIKE $tagsRep3";
    $fileTypeQuery = ($fileTypeSrc == "") ? "file_type.file_type_id!=''" : "file_type.file_type_id='$fileTypeSrc'";
    $artistQuery = ($artistSrc == "") ? "links.artist!=''" : "links.artist LIKE'%$artistSrc%'";
    $sortQuery = ($sortSrc == "" && $orderSrc == "") ? "links.link_id DESC" : "links.$sortSrc $orderSrc";
    $dayQuery = ($daySrc == "") ? "" : "%$daySrc";
    $monthQuery = ($monthSrc == "") ? "" : "%$monthSrc%";
    $yearQuery = ($yearSrc == "") ? "" : "$yearSrc%";
    $dateQuery = ($daySrc != "" OR $monthSrc != "" OR $yearSrc) ? "links.input_date LIKE '$yearQuery$monthQuery$dayQuery'" : " links.input_date!= ''" ;
    
    // var_dump($typeQuery,$tagsQuery,$fileTypeQuery,$artistQuery);
    
    $linkPerPage = 50;
	$p = (isset($_GET['p']))? $_GET['p'] : "";
    $totalLink = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM links INNER JOIN type ON links.type_id=type.type_id INNER JOIN file_type ON links.file_type_id=file_type.file_type_id WHERE $typeQuery AND $tagsQuery AND $fileTypeQuery AND $dateQuery AND $artistQuery ORDER BY $sortQuery"));
    $totalPage = ceil($totalLink / $linkPerPage);
    $activePage = ($p == "")? 1 : $p;
    $firstItem = ($linkPerPage * $activePage) - $linkPerPage;
    $no = $firstItem + 1;
    $linksListTable = mysqli_query($connect, "SELECT * FROM links INNER JOIN type ON links.type_id=type.type_id INNER JOIN file_type ON links.file_type_id=file_type.file_type_id WHERE $typeQuery AND $tagsQuery AND $fileTypeQuery AND $dateQuery AND $artistQuery ORDER BY $sortQuery LIMIT $firstItem, $linkPerPage ");
    $totalLinksList = mysqli_num_rows($linksListTable);
    $totalAllLinks = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM links"));
    
    // var_dump("SELECT * FROM links INNER JOIN type ON links.type_id=type.type_id INNER JOIN file_type ON links.file_type_id=file_type.file_type_id WHERE $typeQuery AND $tagsQuery AND $fileTypeQuery AND $dateQuery AND $artistQuery ORDER BY $sortQuery");

    if(isset($_POST['search'])){
        $typeId = $_POST['type_id'];
        // $tagsId = $_POST['tags_id'];
        $tagsId = $_POST['tagsarea'];
        $fileTypeId = $_POST['file_type_id'];
        $artist = $_POST['artist'];
        $day = $_POST['day'];
        $month = $_POST['month'];
        $year = $_POST['year'];
        header("location:?t=$typeId&ta=$tagsId&ft=$fileTypeId&d=$day&m=$month&y=$year&a=$artist&s=&o=&p=1");
    }


?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="config/clipboard.min.js"></script>
    <script src="config/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="config/style.css">
    <link rel="icon" href="favicon.png">
    <link rel="stylesheet" href="config/selectize.custom.css">
    <script type="text/javascript" src="config/clipboard.min.js"></script>
    <script type="text/javascript" src="config/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="config/selectize.min.js"></script>

    <title>Links Lists</title>
</head>
<form action="" method="post">
<body>
<table align="center" border="0" class="index" width="100%">
            <tr>
                <td colspan="3" align="center">
                    <h3>Links List</h3>
                   <?= date("l d-F-Y")?>
                </td>
            </tr>
            <tr>
                <td colspan="3"><hr></td>
            </tr>
            

            <tr>
               <td align="center" colspan="3">
               Searching for [
               <?php if(isset($_GET['ta']) && $_GET['ta'] != ""){
                    $tagsno = 0;
                    $tags = json_decode($_GET['ta'], true);
                    $totalTags = count($tags);
                    while($tagsno < $totalTags){
                        $t = $tagsno++;
                        $rowTags = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM tags WHERE tags_id='$tags[$t]'"));    
                        echo $rowTags['tags_name'];
                        if($tagsno != $totalTags){
                            echo ", ";
                        }
                    } 
                }?>
                ]
               </td>
            </tr>
            <tr>
                <td colspan="3" align="center">
                    <table class="function" width="100%">
                        <tr>
                            <td style="padding: 1px 0px" align="left">
                                <div id="wrapper">
                                    <select placeholder="Tags" name="tags" id="tags"></select>
                                </div>
                            </td>
                            <td align="center">
                                <select name="type_id">
                                    <?php
                                        if($typeSrc == ""){
                                            ?>
                                    <option hidden value="">All Type</option>
                                    <?php }else{
                                        $linksRow1 = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM type WHERE type_id='$typeSrc'"));
                                    ?>
                                    <option hidden value="<?= $typeSrc?>"><?= $linksRow1['type_name']?></option>
                                    <?php }?>
                                    <option value="">All Type</option>
                                    <?php 
                                        $typeTable = mysqli_query($connect, "SELECT * FROM type ORDER BY type_name");
                                        while($typeRow = mysqli_fetch_array($typeTable)){
                                            ?> 
                                    <option value="<?= $typeRow['type_id']?>"><?= $typeRow['type_name']?></option>
                                    <?php }?>
                                </select>
                                <input type="text" name="artist" placeholder="Artist Name" value="<?=$artistSrc?>">
                                <select name="file_type_id">
                                    <?php
                                        if($fileTypeSrc == ""){
                                    ?>
                                    <option hidden value="">All File Type</option>
                                    <?php }else{
                                        $fileTypeRow3 = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM file_type WHERE file_type_id='$fileTypeSrc'"));    
                                    ?>
                                    <option hidden value="<?= $fileTypeSrc?>"><?= $fileTypeRow3['file_type']?></option>
                                    <?php }?>
                                    <option value="">All File Type</option>
                                    <?php 
                                        $fileTypeTable = mysqli_query($connect, "SELECT * FROM file_type ORDER BY file_type");
                                        while($fileTypeRow = mysqli_fetch_array($fileTypeTable)){
                                    ?> 
                                    <option value="<?= $fileTypeRow['file_type_id']?>"><?= $fileTypeRow['file_type']?></option>
                                    <?php }?>
                                </select>
                                <input style="width:50px;" value="<?=$daySrc?>" type="number" placeholder="All Day" name="day" onKeyPress="return check(event,value)" onInput="checkLength(2,this)">
                                <select name="month">
                                    <?php
                                        if($monthSrc == ""){
                                    ?>
                                    <option hidden value="">All Month</option>
                                    <?php }elseif($monthSrc == "1"){?>
                                        <option hidden value="1">January</option>
                                    <?php }elseif($monthSrc == "2"){?>
                                        <option hidden value="2">Febuary</option>
                                    <?php }elseif($monthSrc == "3"){?>
                                        <option hidden value="3">March</option>
                                    <?php }elseif($monthSrc == "4"){?>
                                        <option hidden value="4">April</option>
                                    <?php }elseif($monthSrc == "5"){?>
                                        <option hidden value="5">May</option>
                                    <?php }elseif($monthSrc == "6"){?>
                                        <option hidden value="6">June</option>
                                    <?php }elseif($monthSrc == "7"){?>
                                        <option hidden value="7">July</option>
                                    <?php }elseif($monthSrc == "8"){?>
                                        <option hidden value="8">August</option>
                                    <?php }elseif($monthSrc == "9"){?>
                                        <option hidden value="9">September</option>
                                    <?php }elseif($monthSrc == "10"){?>
                                        <option hidden value="10">October</option>
                                    <?php }elseif($monthSrc == "11"){?>
                                        <option hidden value="11">November</option>
                                    <?php }elseif($monthSrc == "12"){?>
                                        <option hidden value="12">Descember</option>
                                    <?php }?>
                                    
                                    <option value="">All Month</option>
                                    <option value="1">January</option>
                                    <option value="2">Febuary</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">Descember</option>
                                </select>
                                <input value="<?=$yearSrc?>" style="width:60px;" type="number" name="year" placeholder="All Year" onKeyPress="return check(event,value)" onInput="checkLength(4,this)">
                                <input type="submit" name="search" value="🔎" >
                            </td>


                            <td align="right">
                            <div class="dropdown">
                                <button class="dropbtn">Add Menu</button>
                                <div class="dropdown-content">
                                <?php
                                    $typeTable = mysqli_query($connect, "SELECT * FROM type");
                                    while($typeRow = mysqli_fetch_array($typeTable)){
                                ?>
                                <a href="add?t=<?= $typeRow['type_id']?>"><?= $typeRow['type_name']?></a>
                                <?php }?>
                            </div>
                            </div>
                            </td>
                        </tr>
                    </table>
                    </form>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="center">
                    <table class="list" width="100%" cellspacing="0">
                        <tr>
                            <th>No</th>
                            <th>Type</th>
                            <th colspan="2">
                            <?php if($sortSrc == "artist" && $orderSrc == "DESC"){?>
                                <a class="sort" href='?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&ft=<?=$fileTypeSrc?>&d=<?=$daySrc?>&m=<?=$monthSrc?>&y=<?=$yearSrc?>&a=<?=$artistSrc?>&s=artist&o=ASC&p=1'>Artist&#9660;</a>
                            <?php }elseif($sortSrc == "artist" && $orderSrc == "ASC"){?>
                                <a class="sort" href='?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&ft=<?=$fileTypeSrc?>&d=<?=$daySrc?>&m=<?=$monthSrc?>&y=<?=$yearSrc?>&a=<?=$artistSrc?>&s=&o=&p=1'>Artist&#9650;</a>
                            <?php }else{?>
                                <a class="sort" href='?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&ft=<?=$fileTypeSrc?>&d=<?=$daySrc?>&m=<?=$monthSrc?>&y=<?=$yearSrc?>&a=<?=$artistSrc?>&s=artist&o=DESC&p=1'>Artist</a>
                            <?php }?>
                            </th>
                            <th width="100px">Tags</th>
                            <th colspan="2">Link</th>
                            <th >
                            <?php if($sortSrc == "img_amount" && $orderSrc == "DESC"){?>
                                <a class="sort" href='?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&ft=<?=$fileTypeSrc?>&d=<?=$daySrc?>&m=<?=$monthSrc?>&y=<?=$yearSrc?>&a=<?=$artistSrc?>&s=img_amount&o=ASC&p=1'>Total&#9660;</a>
                            <?php }elseif($sortSrc == "img_amount" && $orderSrc == "ASC"){?>
                                <a class="sort" href='?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&ft=<?=$fileTypeSrc?>&d=<?=$daySrc?>&m=<?=$monthSrc?>&y=<?=$yearSrc?>&a=<?=$artistSrc?>&s=&o=&p=1'>Total&#9650;</a>
                            <?php }else{?>
                                <a class="sort" href='?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&ft=<?=$fileTypeSrc?>&d=<?=$daySrc?>&m=<?=$monthSrc?>&y=<?=$yearSrc?>&a=<?=$artistSrc?>&s=img_amount&o=DESC&p=1'>Total</a>
                            <?php }?>
                            </th>
                            <th>File Type</th>
                            <th >
                            <?php if($sortSrc == "input_date" && $orderSrc == "DESC"){?>
                                <a class="sort" href='?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&ft=<?=$fileTypeSrc?>&d=<?=$daySrc?>&m=<?=$monthSrc?>&y=<?=$yearSrc?>&a=<?=$artistSrc?>&s=input_date&o=ASC&p=1'>Date&#9660;</a>
                            <?php }elseif($sortSrc == "input_date" && $orderSrc == "ASC"){?>
                                <a class="sort" href='?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&ft=<?=$fileTypeSrc?>&d=<?=$daySrc?>&m=<?=$monthSrc?>&y=<?=$yearSrc?>&a=<?=$artistSrc?>&s=&o=&p=1'>Date&#9650;</a>
                            <?php }else{?>
                                <a class="sort" href='?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&ft=<?=$fileTypeSrc?>&d=<?=$daySrc?>&m=<?=$monthSrc?>&y=<?=$yearSrc?>&a=<?=$artistSrc?>&s=input_date&o=DESC&p=1'>Date</a>
                            <?php }?>
                            </th>
                            <th>Function</th>
                        </tr>
                        <?php
                            while($linksListRow = mysqli_fetch_array($linksListTable)){
                                $dateT = strtotime($linksListRow['input_date']);
                                $n = $no++;
                        ?>
                            <script>
                                var clipboard<?= $n?> = new ClipboardJS('#btn<?= $n?>');

                                clipboard<?= $n?>.on('success', function(e<?= $n?>) {
                                    console.info('Accion:', e<?= $n?>.action);
                                    console.info('Texto:', e<?= $n?>.text);
                                    console.info('Trigger:', e<?= $n?>.trigger);

                                    e<?= $n?>.clearSelection();
                                });

                                clipboard<?= $n?>.on('error', function(e<?= $n?>) {
                                    console.error('Accion:', e<?= $n?>.action);
                                    console.error('Trigger:', e<?= $n?>.trigger);
                                });

                                function check(e,value){
                                    //Check Charater
                                    var unicode=e.charCode? e.charCode : e.keyCode;
                                    if (value.indexOf(".") != -1)if( unicode == 46 )return false;
                                    if (unicode!=8)if((unicode<48||unicode>57)&&unicode!=46)return false;
                                }
                                function checkLength(len,ele){
                                var fieldLength = ele.value.length;
                                if(fieldLength <= len){
                                    return true;
                                }
                                else
                                {
                                    var str = ele.value;
                                    str = str.substring(0, str.length - 1);
                                    ele.value = str;
                                }
                                }
                            </script>
                            <input type="text" hidden id="<?= $n ?>" value="<?= $linksListRow['link']?>">
                        <tr>
                            <td align="center"><?= $n?></td>
                            <td class="caps" align="center">
                                <?php if($linksListRow['type_name'] != ""){?>
                                <a class="link" href="<?=$linksListRow['link_to_home']?>"><?= $linksListRow['type_name']?></a>
                                <?php }else{?>
                                    <?= $linksListRow['type_name']?>
                                <?php }?>
                            </td>
                            <td width="1px">
                                <?php if($linksListRow['type_name'] != ""){?>
                                    <a class="copy" id="btn<?= $n ?>" data-clipboard-text="<?=$linksListRow['link_to_user']?><?= $linksListRow['artist'] ?>" style="cursor:pointer">&#128203;</a>
                                <?php }else{?>
                                    <a class="copy" id="btn<?= $n ?>" data-clipboard-text="<?= $linksListRow['artist'] ?>" style="cursor:pointer">&#128203;</a>
                                <?php }?>
                            </td>
                            <td>
                                <?php if($linksListRow['type_name'] != ""){?>
                                    <a class="link" href="<?=$linksListRow['link_to_user']?><?= $linksListRow['artist']?>"><?= $linksListRow['artist']?></a>
                                <?php }else{?>
                                    <?= $linksListRow['artist']?>
                                <?php }?>
                            </td>
                            <td align="center">
                            <?php 
                                $tagsno = 0; //create a new variable (this is what part of the array is being processed i.e [0,1,2])
                                $tags = json_decode($linksListRow['tags_id'], true); //decoding the Array to something that is more manageable
                                $totalTags = count($tags);//count how many variable inside of the Array
                                while($tagsno < $totalTags){//as long as the variable tagsno is lower a.k.a if there's still tags variable that hasn't been processesed do the following
                                    $t = $tagsno++;//increase the tagsno variable until all of the array variable inside of the Array been converted
                                    $rowTags = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM tags WHERE tags_id='$tags[$t]'")); //convert the tags id into a tags name i.e 1 ==> Cute
                                    //and the repeat that again
                                    echo $rowTags['tags_name'];//putting a comma at the end of it
                                    if($tagsno != $totalTags){
                                        echo ", "; //only put a comma when it's between not the end
                                    }
                                }
                            ?>
                            </td>
                            <td width="1px"><a class="copy" id="btn<?= $n ?>" data-clipboard-text="<?= $linksListRow['link'] ?>" style="cursor:pointer">&#128203;</a></td>
                            <td><a class="link" href="<?= $linksListRow['link']?>"><?= $linksListRow['link']?></a></td>
                            <td align="center"><?= $linksListRow['img_amount']?></td>
                            <td class="caps" align="center"><?= $linksListRow['file_type']?></td>
                            <td align="center"><?= date("d-M-Y", $dateT)?></td>
                            <td align="center"><a class="link" onclick="saveURL()" href="update?type=update-home&id=<?= $linksListRow['link_id']?>&t=<?= $linksListRow['type_id']?>">Update</a><a class="link" onclick="return confirm('Are you sure you want to delete?')" href="function?type=delete-home&id=<?= $linksListRow['link_id']?>&t=<?= $linksListRow['type_id']?>">Delete</a></td>
                        </tr>
                            <?php } ?>
                    </table>
                </td>
            </tr>
            <?php if($totalLink == "0"){?>
            <tr>
                <td colspan="3" align="center"><h1>Oops, Looks like there's nothing here :(</h1></td>
            </tr>
			<?php }?>
            <tr>
                <td class="up" colspan="2" align="left">
                        Showing <?=$totalLink?> out of <?=$totalAllLinks?> Links, Pages <?=$activePage?>/<?=$totalPage?>
                </td>
                <td align="right">
                    © 2020-<?= date("Y")?> <a class="copy" href="https://twitter.com/KratzXD">@KratzXD</a> All rights reserved <br>
                    <a class="secret_button" href="tag">Add/Update Tags</a>
                    <a class="secret_button" href="artist_list">Artist List</a>
                </td>
            </tr>
            <tr>
                <td colspan="3" ><hr></td>
            </tr>
            <tr>
                <td align="right" width="50%">
					<?php
                    if($activePage == 1){?>
                    <a class="disabled" ><<</a>
					<?php }else{?>
                    <a class="page" href='?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&ft=<?=$fileTypeSrc?>&d=<?=$daySrc?>&m=<?=$monthSrc?>&y=<?=$yearSrc?>&a=<?=$artistSrc?>&s=<?=$sortSrc?>&o=<?=$orderSrc?>&p=1'><<</a>
					<?php }?>
				
                    <?php 
                    $pageNumber = 1;
                    if($activePage <= 1){
                    ?>
                        <a class="disabled " ><</a>
                    <?php }else{?>
                        <a class="page" href='?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&ft=<?=$fileTypeSrc?>&d=<?=$daySrc?>&m=<?=$monthSrc?>&y=<?=$yearSrc?>&a=<?=$artistSrc?>&s=<?=$sortSrc?>&o=<?=$orderSrc?>&p=<?= $activePage - 1?>'><</a>
                    <?php } ?>
                
                    <?php
                    $firstPageNumber = $activePage - 4;
                    for($number = $firstPageNumber; $number < $activePage; $number++){
                        if($number <= 0){
                        }else{
                    ?>
                        <a class="page" href='?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&ft=<?=$fileTypeSrc?>&d=<?=$daySrc?>&m=<?=$monthSrc?>&y=<?=$yearSrc?>&a=<?=$artistSrc?>&s=<?=$sortSrc?>&o=<?=$orderSrc?>&p=<?= $number?>'><?= $number?></a>
                    <?php }} ?>
                </td>
                <td width="1%" align="center">
                    
                    <input class="pageInput" type="number" size="1px" value="<?= $activePage?>" id="pageInputText">
                </td>
                <td align="left" width="50%">
                    <?php
                    $lastPageNumber = $activePage + 5;
                    for($number = $activePage + 1; $number < $lastPageNumber; $number++){
                        if($number > $totalPage){
                        }else{
                    ?>
                        <a class="page" href='?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&ft=<?=$fileTypeSrc?>&d=<?=$daySrc?>&m=<?=$monthSrc?>&y=<?=$yearSrc?>&a=<?=$artistSrc?>&s=<?=$sortSrc?>&o=<?=$orderSrc?>&p=<?= $number?>'><?= $number?></a>
                        <?php }} ?>
                        <script>
                            var input = document.getElementById("pageInputText");

                            input.addEventListener("keyup", function(event) {
                            if (event.keyCode === 13) {
                                var inputText = document.getElementById("pageInputText").value;
                                if (inputText < 1) {
                                    window.location.assign('?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&ft=<?=$fileTypeSrc?>&d=<?=$daySrc?>&m=<?=$monthSrc?>&y=<?=$yearSrc?>&a=<?=$artistSrc?>&s=<?=$sortSrc?>&o=<?=$orderSrc?>&p=1');
                                } else if(inputText > <?=$totalPage?>) {
                                    window.location.assign('?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&ft=<?=$fileTypeSrc?>&d=<?=$daySrc?>&m=<?=$monthSrc?>&y=<?=$yearSrc?>&a=<?=$artistSrc?>&s=<?=$sortSrc?>&o=<?=$orderSrc?>&p=<?=$totalPage?>');
                                } else {
                                    window.location.assign('?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&ft=<?=$fileTypeSrc?>&d=<?=$daySrc?>&m=<?=$monthSrc?>&y=<?=$yearSrc?>&a=<?=$artistSrc?>&s=<?=$sortSrc?>&o=<?=$orderSrc?>&p="+inputText+"');
                                }
                            }
                            });
                        </script>

                    <?php
                        if($activePage >= $totalPage){
                    ?>
                        <a class="disabled" >></a>
                    <?php }else{?>
                        <a class="page" href='?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&ft=<?=$fileTypeSrc?>&d=<?=$daySrc?>&m=<?=$monthSrc?>&y=<?=$yearSrc?>&a=<?=$artistSrc?>&s=<?=$sortSrc?>&o=<?=$orderSrc?>&p=<?= $activePage + 1?>'>></a>
                    <?php }?>
					
					<?php if($activePage == $totalPage or $totalPage == 0){?>
                    <a class="disabled" >>></a>
					<?php }else{?>
                    <a class="page" href='?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&ft=<?=$fileTypeSrc?>&d=<?=$daySrc?>&m=<?=$monthSrc?>&y=<?=$yearSrc?>&a=<?=$artistSrc?>&s=<?=$sortSrc?>&o=<?=$orderSrc?>&p=<?= $totalPage?>'>>></a>
					<?php }?>
                    
                </td>
            </tr>
        </table>

<script type="text/javascript">
    function saveURL() {
    <?php
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        
        $_SESSION["tempURL"] = $url;
    ?>
    }   
</script>

<script>
$(document).ready(function(){
    $(function() {
	var $wrapper = $('#wrapper');

	// display scripts on the page
	$('script', $wrapper).each(function() {
		var code = this.text;
		if (code && code.length) {
			var lines = code.split('\n');
			var indent = null;

			for (var i = 0; i < lines.length; i++) {
				if (/^[	 ]*$/.test(lines[i])) continue;
				if (!indent) {
					var lineindent = lines[i].match(/^([ 	]+)/);
					if (!lineindent) break;
					indent = lineindent[1];
				}
				lines[i] = lines[i].replace(new RegExp('^' + indent), '');
			}

			var code = $.trim(lines.join('\n')).replace(/	/g, '    ');
			var $pre = $('<pre>').addClass('js').text(code);
			$pre.insertAfter(this);
		}
	});

	// show current input values
	$('select.selectized,input.selectized', $wrapper).each(function() {
        var $container = $('<div>').addClass('value').html('');
		var $value = $('<textarea style="display:none;" name="tagsarea">').appendTo($container);
		var $input = $(this);
		var update = function(e) { $value.text(JSON.stringify($input.val())); }

		$(this).on('change', update);
		update();

		$container.insertAfter($input);
	});
});
$('#tags').selectize({
    plugins: ['remove_button'],
        theme: 'links',
        maxItems: null,
        valueField: 'id',
        searchField: 'title',
        options: [
            <?php 
                $tagsTable1 = mysqli_query($connect, "SELECT * FROM tags ORDER BY total_tags DESC");
                while($tagsRow1 = mysqli_fetch_array($tagsTable1)){
            ?>
            {id: <?= $tagsRow1['tags_id']?>, title: '<?=$tagsRow1['tags_name']?>(<?=number_format_short($tagsRow1['total_tags'])?>)'},
            <?php }?>
        ],
        render: {
            option: function(data, escape) {
                return '<div class="option">' +
                        '<span class="title">' + escape(data.title) + '</span>' +
                    '</div>';
            },
            item: function(data, escape) {
                return '<div class="item">' + escape(data.title) + '</div>';
            }
        },
        create: function(input) {
            return {
                id: 0,
                title: input,
                url: '#'
            };
        }
    });
});
</script>
</body>
</html>