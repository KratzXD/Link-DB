<?php
    include "config/config.php";
    include "config/numberFormat.php";
    
    $typeSrc =  (isset($_GET['t'])) ? $_GET['t'] : "";
    $artistSrc = (isset($_GET['a'])) ? $_GET['a'] : "";
    $sortSrc = (isset($_GET['s'])) ? $_GET['s'] : "";
    $tagsSrc = (isset($_GET['ta'])) ? $_GET['ta'] : "";
    $orderSrc = (isset($_GET['o'])) ? $_GET['o'] : "";
    // this kind of query is really fucking retarded, they really shouldn't have let me get into coding 

    $typeQuery = ($typeSrc == "") ? "type.type_name!=''" : "type.type_name='$typeSrc'";
    $artistQuery = ($artistSrc == "") ? "links.artist!=''" : "links.artist LIKE'%$artistSrc%'";
    $tagsQuery = ($tagsSrc == "") ? "links.tags_id!=''" : "links.tags_id LIKE '%$tagsSrc%'";
    $sortQuery = ($sortSrc == "" && $orderSrc == "") ? "COUNT(*) DESC" : "COUNT(*) $orderSrc";
    
    // var_dump($typeQuery,$tagsQuery,$fileTypeQuery,$artistQuery);
    
    $linkPerPage = 50;
	$p = (isset($_GET['p']))? $_GET['p'] : "";
    $totalLink = mysqli_num_rows(mysqli_query($connect, "SELECT artist,type_name,COUNT(*),link_to_user,link_to_home FROM links INNER JOIN type ON links.type_id=type.type_id WHERE $tagsQuery AND $typeQuery AND $artistQuery GROUP BY artist ORDER BY $sortQuery"));
    $totalPage = ceil($totalLink / $linkPerPage);
    $activePage = ($p == "")? 1 : $p;
    $firstItem = ($linkPerPage * $activePage) - $linkPerPage;
    $no = $firstItem + 1;
    $linksListTable = mysqli_query($connect, "SELECT artist,type_name,COUNT(*),link_to_user,link_to_home FROM links INNER JOIN type ON links.type_id=type.type_id WHERE $tagsQuery AND $typeQuery AND $artistQuery GROUP BY artist ORDER BY $sortQuery LIMIT $firstItem, $linkPerPage ");
    $totalLinksList = mysqli_num_rows($linksListTable);
    $totalAllLinks = mysqli_num_rows(mysqli_query($connect, "SELECT COUNT(*) FROM links GROUP BY artist"));
    
    // var_dump("SELECT artist,type_name,COUNT(*),link_to_user,link_to_home FROM links INNER JOIN type ON links.type_id=type.type_id WHERE $tagsQuery AND $typeQuery AND $artistQuery GROUP BY artist ORDER BY $sortQuery");

    if(isset($_POST['search'])){
        $typeId = $_POST['type_id'];
        // $tagsId = $_POST['tags_id'];
        $tagsId = $_POST['tags'];
        $fileTypeId = $_POST['file_type_id'];
        $artist = $_POST['artist'];
        header("location:?t=$typeId&ta=$tagsId&a=$artist&s=&o=&p=1");
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

    <title>Artist List</title>
</head>
<form action="" method="post">
<body>
<table align="center" border="0" class="index" width="100%">
            <tr>
                <td colspan="3" align="center">

                <?php
                    if($tagsSrc != ""){
                        $rowTagsName = mysqli_fetch_array(mysqli_query($connect, "SELECT tags_name FROM tags WHERE tags_id = $tagsSrc"));
                        $tagsName = $rowTagsName['tags_name'];                
                    }
                ?>

                    <h3><?php if($tagsSrc != ""){echo $tagsName;}?> Artist List</h3>
                   <?= date("l d-F-Y")?>
                </td>
            </tr>
            <tr>
                <td colspan="3"><hr></td>
            </tr>       
            <tr>
                <td colspan="3" align="center">
                    <table class="function" width="100%">
                        <tr>
                             <td align="left">
                                <select name="type_id">
                                    <?php
                                        if($typeSrc == ""){
                                            ?>
                                    <option hidden value="">All Type</option>
                                    <?php }else{
                                        $linksRow1 = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM type WHERE type_name='$typeSrc'"));
                                    ?>
                                    <option hidden value="<?= $typeSrc?>"><?= $linksRow1['type_name']?></option>
                                    <?php }?>
                                    <option value="">All Type</option>
                                    <?php 
                                        $typeTable = mysqli_query($connect, "SELECT * FROM type ORDER BY type_name");
                                        while($typeRow = mysqli_fetch_array($typeTable)){
                                            ?> 
                                    <option value="<?= $typeRow['type_name']?>"><?= $typeRow['type_name']?></option>
                                    <?php }?>
                                </select>
                                <input type="text" name="artist" placeholder="Artist Name" value="<?=$artistSrc?>">
                                <select name="tags">
                                    <?php
                                        if($tagsSrc == ""){
                                            ?>
                                    <option hidden value="">All Tags</option>
                                    <?php }else{
                                        $linksRow2 = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM tags WHERE tags_id='$tagsSrc'"));
                                    ?>
                                    <option hidden value="<?= $tagsSrc?>"><?= $linksRow2['tags_name']?>(<?=number_format_short($linksRow2['total_tags'])?>)</option>
                                    <?php }?>
                                    <option value="">All Tags</option>
                                    <?php 
                                        $tagsTable = mysqli_query($connect, "SELECT * FROM tags ORDER BY total_tags DESC");
                                        while($tagsRow = mysqli_fetch_array($tagsTable)){
                                            ?> 
                                    <option value="<?= $tagsRow['tags_id']?>"><?= $tagsRow['tags_name']?>(<?=number_format_short($tagsRow['total_tags'])?>)</option>
                                    <?php }?>
                                </select>
                                <input type="submit" name="search" value="🔎" >

                                <script>
                                    var clipboard1 = new ClipboardJS('#all');

                                    clipboard1.on('success', function(e1) {
                                        console.info('Accion:', e1.action);
                                        console.info('Texto:', e1.text);
                                        console.info('Trigger:', e1.trigger);

                                        e1.clearSelection();
                                    });

                                    clipboard1.on('error', function(e1) {
                                        console.error('Accion:', e1.action);
                                        console.error('Trigger:', e1.trigger);
                                    });

                                    function check(e1,value){
                                        //Check Charater
                                        var unicode=e1.charCode? e1.charCode : e1.keyCode;
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
                                
                                <?php
                                    $linksListTable1 = mysqli_query($connect, "SELECT artist,type_name,COUNT(*),link_to_user,link_to_home,tags_id FROM links INNER JOIN type ON links.type_id=type.type_id WHERE $tagsQuery AND $typeQuery AND $artistQuery GROUP BY artist ORDER BY COUNT(*) DESC");
                                    $artistTxt = "";
                                        while($allArtist = mysqli_fetch_array($linksListTable1)){
                                            $artistTxt = $artistTxt.$allArtist['link_to_user']. $allArtist['artist']."\n";
                                        }
                                ?>

                                <a class="button" id="all" data-clipboard-text="<?=$artistTxt?>" style="cursor:pointer">&#128203;</a>

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
                            <th width="5px">No</th>
                            <th width="50px">Type</th>
                            <th colspan="2">
                            <?php if($sortSrc == "artist" && $orderSrc == "DESC"){?>
                                <a class="sort" href="?t=<?=$typeSrc?>&a=<?=$artistSrc?>&ta=<?=$tagsSrc?>&s=artist&o=ASC&p=1">Artist&#9660;</a>
                            <?php }elseif($sortSrc == "artist" && $orderSrc == "ASC"){?>
                                <a class="sort" href="?t=<?=$typeSrc?>&a=<?=$artistSrc?>&ta=<?=$tagsSrc?>&s=&o=&p=1">Artist&#9650;</a>
                            <?php }else{?>
                                <a class="sort" href="?t=<?=$typeSrc?>&a=<?=$artistSrc?>&ta=<?=$tagsSrc?>&s=artist&o=DESC&p=1">Artist</a>
                            <?php }?>
                            </th>
                            <th width="100px">
                            <?php if($sortSrc == "img_amount" && $orderSrc == "DESC"){?>
                                <a class="sort" href="?t=<?=$typeSrc?>&a=<?=$artistSrc?>&ta=<?=$tagsSrc?>&s=img_amount&o=ASC&p=1">Total Links&#9660;</a>
                            <?php }elseif($sortSrc == "img_amount" && $orderSrc == "ASC"){?>
                                <a class="sort" href="?t=<?=$typeSrc?>&a=<?=$artistSrc?>&ta=<?=$tagsSrc?>&s=&o=&p=1">Total Links&#9650;</a>
                            <?php }else{?>
                                <a class="sort" href="?t=<?=$typeSrc?>&a=<?=$artistSrc?>&ta=<?=$tagsSrc?>&s=img_amount&o=DESC&p=1">Total Links</a>
                            <?php }?>
                            </th>
                        </tr>
                        <?php
                            while($linksListRow = mysqli_fetch_array($linksListTable)){
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
                            <td align="center"><?= $linksListRow['COUNT(*)']?></td>
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
                        Showing <?=$totalLink?> out of <?=$totalAllLinks?> Artists, Pages <?=$activePage?>/<?=$totalPage?>
                </td>
                <td align="right">
                    © 2020-<?= date("Y")?> <a class="copy" href="https://twitter.com/KratzXD">@KratzXD</a> All rights reserved <br>
                    <a class="secret_button" href="tag">Add/Update Tags</a>
                    <a class="secret_button" href="index">Home</a>
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
                    <a class="page" href='?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&a=<?=$artistSrc?>&s=<?=$sortSrc?>&o=<?=$orderSrc?>&p=1'><<</a>
					<?php }?>
				
                    <?php 
                    $pageNumber = 1;
                    if($activePage <= 1){
                    ?>
                        <a class="disabled " ><</a>
                    <?php }else{?>
                        <a class="page" href='?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&a=<?=$artistSrc?>&s=<?=$sortSrc?>&o=<?=$orderSrc?>&p=<?= $activePage - 1?>'><</a>
                    <?php } ?>
                
                    <?php
                    $firstPageNumber = $activePage - 4;
                    for($number = $firstPageNumber; $number < $activePage; $number++){
                        if($number <= 0){
                        }else{
                    ?>
                        <a class="page" href='?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&a=<?=$artistSrc?>&s=<?=$sortSrc?>&o=<?=$orderSrc?>&p=<?= $number?>'><?= $number?></a>
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
                        <a class="page" href='?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&a=<?=$artistSrc?>&s=<?=$sortSrc?>&o=<?=$orderSrc?>&p=<?= $number?>'><?= $number?></a>
                        <?php }} ?>
                        <script>
                            var input = document.getElementById("pageInputText");

                            input.addEventListener("keyup", function(event) {
                            if (event.keyCode === 13) {
                                var inputText = document.getElementById("pageInputText").value;
                                if (inputText < 1) {
                                    window.location.assign('?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&a=<?=$artistSrc?>&s=<?=$sortSrc?>&o=<?=$orderSrc?>&p=1');
                                } else if(inputText > <?=$totalPage?>) {
                                    window.location.assign('?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&a=<?=$artistSrc?>&s=<?=$sortSrc?>&o=<?=$orderSrc?>&p=<?=$totalPage?>');
                                } else {
                                    window.location.assign('?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&a=<?=$artistSrc?>&s=<?=$sortSrc?>&o=<?=$orderSrc?>&p="+inputText+"');
                                }
                            }
                            });
                        </script>

                    <?php
                        if($activePage >= $totalPage){
                    ?>
                        <a class="disabled" >></a>
                    <?php }else{?>
                        <a class="page" href='?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&a=<?=$artistSrc?>&s=<?=$sortSrc?>&o=<?=$orderSrc?>&p=<?= $activePage + 1?>'>></a>
                    <?php }?>
					
					<?php if($activePage == $totalPage or $totalPage == 0){?>
                    <a class="disabled" >>></a>
					<?php }else{?>
                    <a class="page" href='?t=<?=$typeSrc?>&ta=<?=$tagsSrc?>&a=<?=$artistSrc?>&s=<?=$sortSrc?>&o=<?=$orderSrc?>&p=<?= $totalPage?>'>>></a>
					<?php }?>
                    
                </td>
            </tr>
        </table>
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