<?php
    include "config/config.php";
    include "config/numberFormat.php";

    $type = $_GET['type'];
    $id = $_GET['id'];
    $t = $_GET['t'];
    $linksTable = mysqli_query($connect, "SELECT * FROM links INNER JOIN type ON links.type_id=type.type_id INNER JOiN file_type ON links.file_type_id=file_type.file_type_id WHERE link_id='$id'");
    $linksRow = mysqli_fetch_array($linksTable);


    if(isset($_POST['update'])){
        $artist  = $_POST['artist'];
        $tags_id  = $_POST['tagsarea'];
        $links  = $_POST['links'];
        $img_amount  = $_POST['img_amount'];
        $file_type_id  = $_POST['file_type_id'];
        $dateraw = strtotime($_POST['input_date']);
        $date = date("Y-m-d", $dateraw);
        // $date = $linksRow['input_date'];

        if (isset($_POST['editTags']) && $_POST['editTags'] == 'yes') {
            mysqli_query($connect, "UPDATE links SET tags_id='$tags_id' WHERE link_id='$id'");
            // var_dump("UPDATE links SET tags_id='$tags_id' WHERE link_id='$id'");
        }

        mysqli_query($connect, "UPDATE links SET artist='$artist',link='$links',img_amount='$img_amount',file_type_id='$file_type_id',input_date='$date' WHERE link_id='$id'");
        // var_dump("UPDATE links SET artist='$artist',link='$links',img_amount='$img_amount',file_type_id='$file_type_id',input_date='$date' WHERE link_id='$id'");
        
        include "total_tags.php";

        if (isset($_SESSION["tempURL"])) {
            $tempURL = $_SESSION["tempURL"];
            unset($_SESSION["tempURL"]);
            header("location:$tempURL");
        } else {
            header("location:index.php");
        }

        // header("location:index");
        // $jsonarray = json_decode($_POST['tagsarea'], true);

        //     echo $_POST['tagsarea'];
        //     echo "<br>";
        //     var_dump($jsonarray);
        //     echo "<br>";
        //     echo $jsonarray[1];

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
    <script>
        $(document).ready(function(){
            // $('#links').focus(function() {
            //     navigator.clipboard.readText()
            //     .then(text => {
            //         // console.log('Pasted content: ', text);
            //         document.getElementById("links").value = text;
            //     })
            //     .catch(err => {
            //         console.error('Failed to read clipboard contents: ', err);
            //     });
            // });

            $('#editTags').click(function() {
                if ($(this).is(':checked')){
                    $(".tagsitem").show();
                    $(".tagsitemX").hide();
                }else {
                    $(".tagsitem").hide();
                    $(".tagsitemX").show();
                }
            });


            // $('#artist').focus(function() {
            //     navigator.clipboard.readText()
            //     .then(text => {
            //         // console.log('Pasted content: ', text);
            //         document.getElementById("artist").value = text;
            //     })
            //     .catch(err => {
            //         console.error('Failed to read clipboard contents: ', err);
            //     });
            // });
        });
    </script>
    <title>Update <?= $linksRow['type_name'] ?> Links</title>
</head>
<body>
    <form action="" method="post">
        <table align="center" class="add-box" border="0">
            <tr>
                <td align="center" colspan="6"><h3>Update a <?= $linksRow['type_name'] ?> Links</h3><?= date("l d-F-Y")?></td>
            </tr>
            <tr>
                <td colspan="6">
                    <hr>
                </td>
            </tr>
            <tr>
                <td align="center">Artist</td>
                <td align="center" width="400px">Previous Tags : 
                <?php 
                    $tagsno = 0;
                    $tags = json_decode($linksRow['tags_id'], true);
                    $totalTags = count($tags);
                    while($tagsno < $totalTags){
                        $t = $tagsno++;
                        $rowTags = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM tags WHERE tags_id='$tags[$t]'"));    
                        echo $rowTags['tags_name'];
                        if($tagsno != $totalTags){
                            echo ", "; //only put a comma when it's between not the end
                        }
                    }
                ?>
                <input type="checkbox" name="editTags" id="editTags" value="yes">
                </td>
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
                    <input required autocomplete="off" name="artist" id="artist" type="text" size="15" value="<?= $linksRow['artist']?>">
                </td>
                <td>
                    <div style="display:none" class="tagsitem" id="wrapper">
                        <select name="tags" id="tags"></select>
                    </div>
                    <input class="tagsitemX" type="text"  disabled>
                </td>
                <td>
                    <input autocomplete="off" id="links" required name="links" type="text" size="50" value="<?= $linksRow['link'] ?>">
                </td>
                <td>
                    <input required name="img_amount" type="number" value="<?= $linksRow['img_amount'] ?>">
                </td>
                <td>
                    <select required name="file_type_id" >
                        <option hidden value="<?= $linksRow['file_type_id']?>"><?= $linksRow['file_type']?></option>
                        <?php 
                            $fileTypeTable = mysqli_query($connect, "SELECT * FROM file_type");
                            while($fileTypeRows = mysqli_fetch_array($fileTypeTable)){
                        ?>
                            <option value="<?= $fileTypeRows['file_type_id']?>"><?= $fileTypeRows['file_type']?></option>
                        <?php }?>
                    </select>
                </td>
                <td>
                <!-- date("d-M-Y", strtotime($linksRow['input_date'])) -->
                    <input required name="input_date" type="date" value="<?= $linksRow['input_date']?>" size="10">
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <hr>
                </td>
            </tr>
            <tr>
                <td colspan="6" align="center">
                    <input required type="submit" name="update" value="Update">
                </td>
            </tr>
        </table>
    </form>
    <?php include "lists.php"?>

<script>
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