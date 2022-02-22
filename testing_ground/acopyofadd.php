<?php
    include "../config/config.php";
    include "../config/numberFormat.php";

    $t = $_GET['t'];
    $typeTable = mysqli_query($connect, "SELECT * FROM type WHERE type_id='$t'");
    $type = mysqli_fetch_array($typeTable);

    if(isset($_POST['save'])){
        $tags_id  = $_POST['tagsarea'];
        $links  = $_POST['links'];
        $img_amount  = $_POST['img_amount'];
        $file_type_id  = $_POST['file_type_id'];
        $input_date  = date("Y-m-d");

        $similarLinkTable = mysqli_query($connect,"SELECT * FROM links WHERE link = '$links'");
        $similarLink = mysqli_fetch_array($similarLinkTable);
        // var_dump($similarLink);

        if($similarLink == true){
            echo "<script>window.alert('This link is already in the system!')</script>";
            echo "<script>window.location.assign('?t=$t')</script>";
            // header("location:add?t=$t");
            // echo "<script>if(window.alert('This link is already in the system!')){window.location.reload();}</script>";

        }else{

            if($t == "1"){ //twitter
                $artist_tags = str_replace("/st", "", substr($_POST['links'], 20, -32));
                $artist = "@".$artist_tags."";
            
            }elseif($t == "2"){ //pixiv
                $artist  = substr($_POST['artist'], 31);
            
            }elseif($t == "3"){ //nhentai
                $artist  = substr($_POST['artist'], 27, -1);
            
            }else{ 
                $artist  = $_POST['artist'];
            
            }
            
        if($file_type_id == "4"){
            $digit3 = rand(0,999);
            $folderName = "$artist-p$img_amount-$digit3";
            mkdir("D:/data/raw manuscript/$y/$m/$d/$folderName", 0777, true);
        }

        mysqli_query($connect, "INSERT INTO links VALUES (NULL,'$t','$artist','$tags_id','$links','$img_amount','$file_type_id','$input_date')");
        include "total_tags.php";
        header("location:add?t=$t");
        }
        }       
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../config/style.css">
    <link rel="stylesheet" href="../config/selectize.custom.css">
    <script type="text/javascript" src="../config/clipboard.min.js"></script>
    <script type="text/javascript" src="../config/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../config/selectize.min.js"></script>
    <link rel="icon" href="favicon.png">
    <script>
        $(document).ready(function(){
            $('#links').focus(function() {
                navigator.clipboard.readText()
                .then(text => {
                    // console.log('Pasted content: ', text);
                    document.getElementById("links").value = text;
                })
                .catch(err => {
                    console.error('Failed to read clipboard contents: ', err);
                });
            });
            $('#artist').focus(function() {
                navigator.clipboard.readText()
                .then(text => {
                    // console.log('Pasted content: ', text);
                    document.getElementById("artist").value = text;
                })
                .catch(err => {
                    console.error('Failed to read clipboard contents: ', err);
                });
            });
        });
    </script>
    <title>Add <?= $type['type_name'] ?> Links</title>
</head>
<body>
    <form action="" method="post">
        <table align="center" class="add-box" border="0">
            <tr>
                <td align="center" colspan="6"><h3>Add a <?= $type['type_name'] ?> Link</h3><?= date("l d-F-Y")?></td>
            </tr>
            <tr>
                <td colspan="6">
                    <hr>
                </td>
            </tr>
            <tr>
                <td align="center">Artist</td>
                <td align="center">Tags</td>
                <td align="center">Links</td>
                <td align="center">Total</td>
                <td align="center">File Type</td>
                <td align="center">Date</td>
            </tr>
            <tr>
                <td colspan="6" width="100">
                    
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                        if($t == "1"){
                    ?>
                        <input readonly name="artist" type="text" size="33"  value="Autofill" >
                    <?php }else{ ?>
                        <input required autocomplete="off" name="artist" id="artist" type="text" size="33" >
                    <?php }?>
                </td>
                <td>
                    <div id="wrapper">
                        <select name="tags" id="tags">
                        </select>
                    </div>
                </td>
                <td>
                    <input autocomplete="off" id="links" required name="links" type="text" size="50">
                </td>
                <td>
                    <input required id="total" onchange="changeType()" name="img_amount" type="number" value="1">
                </td>
                <td>
                    <select class="caps" id="fileType" onchange="changeType()" required name="file_type_id" >
                        <?php 
                            $fileTypeRowsDef = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM file_type WHERE file_type_id='1'"));
                        ?>
                            <option class="caps" hidden value="<?= $fileTypeRowsDef['file_type_id']?>"><?= $fileTypeRowsDef['file_type']?></option>
                        <!-- <option value="" hidden >--/--</option> -->
                        <?php 
                            $fileTypeTable = mysqli_query($connect, "SELECT * FROM file_type");
                            while($fileTypeRows = mysqli_fetch_array($fileTypeTable)){
                        ?>
                            <option class="caps" value="<?= $fileTypeRows['file_type_id']?>"><?= $fileTypeRows['file_type']?></option>
                        <?php }?>
                    </select>
                </td>
                <td>
                    <input required name="input_date" type="text" readonly value="<?= date("d-M-Y")?>" size="10">
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <div id="note1"></div>
                    <div id="note"></div>
                    <?php if($t == "2"){?>
                    <div id="note3">The system will automatically remove the "https://www.pixiv.net/en/users/"</div>
                    <?php } ?>
                    <hr>
                </td>
            </tr>
            <tr>
                <td colspan="6" align="center">
                    <input required type="submit" name="save" value="Save">
                </td>
            </tr>
        </table>
    </form>

<script>

function changeType() {
    var idType = document.getElementById("fileType");
    var selectId = idType.value;

    var idTotal = document.getElementById("total");
    var total = idTotal.value;
    
    if (total >= 10 && selectId != "4"){
        document.getElementById("note1") .innerHTML = "<div id='note1'>note: if the nominal is more than 10 use a fileType 'Folder' for better organization</div>"; 
    }else{
        document.getElementById("note1") .innerHTML = "<div id='note1'></div>"; 
    }

    //summon the message if the right fileType is selected
    if (selectId == "4"){
	  	//  document.getElementById("P").style.visibility = "hidden";
        document.getElementById("note") .innerHTML = "<div id='note'>note: the file type 'Folder' creates a new folder inside of the day directory with the format 'Artist-TotalPage-3Digit' i.e .../5/412523-21-123</div>"; 
    }else{
        // document.getElementById("P").style.visibility = "visible";
        document.getElementById("note") .innerHTML = "<div id='note'></div>"; 
	}
}

$(document).ready(function(){
    
    $(function() {
	var $wrapper = $('#wrapper');

    
    // theme switcher
	var theme_match = String(window.location).match(/[?&]theme=([a-z0-9]+)/);
	var theme = (theme_match && theme_match[1]) || 'default';
	var themes = ['default','legacy','bootstrap2','bootstrap3'];
	$('head').append('<link rel="stylesheet" href="../dist/css/selectize.' + theme + '.css">');

	var $themes = $('<div>').addClass('theme-selector').insertAfter('h1');
	for (var i = 0; i < themes.length; i++) {
		$themes.append('<a href="?theme=' + themes[i] + '"' + (themes[i] === theme ? ' class="active"' : '') + '>' + themes[i] + '</a>');
	}

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

        setValue(value, silent);

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