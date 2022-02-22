<br>
        <table width="100%" align="center" border="0" class="index" >
            <tr>
                <td colspan="2"  align="center">
                    <h3>Recently added Links</h3>
                </td>
            </tr>
            <tr>
                <td colspan="2" >
                    <hr>
                </td>
            </tr>
            <tr>
                <td align="right" colspan="2">
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
            <tr>
                <td colspan="2"  align="center">
                    <table width="100%" class="list" cellspacing="0">
                        <tr>
                            <th>No</th>
                            <th>Type</th>
                            <th colspan="2">Artist</th>
                            <th width="100px">Tags</th>
                            <th colspan="2">Link</th>
                            <th>Total</th>
                            <th>File Type</th>
                            <th>Date</th>
                            <th>Function</th>
                        </tr>
                        <?php
                            $no = 1;
                            $linksListTable = mysqli_query($connect, "SELECT * FROM links INNER JOIN type ON links.type_id=type.type_id INNER JOIN file_type ON links.file_type_id=file_type.file_type_id ORDER BY link_id DESC LIMIT 10 ");
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
                            </script>
                            <input type="text" hidden id="<?= $n ?>" value="<?= $linksListRow['link']?>">
                        <tr>
                            <td align="center"><?= $n?></td>
                            <td class="caps" align="center"><?= $linksListRow['type_name']?></td>
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
                                $tagsno = 0;
                                $tags = json_decode($linksListRow['tags_id'], true);
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
                            </td>
                            <td width="1px"><button class="copy" id="btn<?= $n ?>" data-clipboard-text="<?= $linksListRow['link'] ?>" style="cursor:pointer">&#128203;</button></td>
                            <td><a class="link" href="<?= $linksListRow['link']?>"><?= $linksListRow['link']?></a></td>
                            <td align="center"><?= $linksListRow['img_amount']?></td>
                            <td class="caps" align="center"><?= $linksListRow['file_type']?></td>
                            <td align="center"><?= date("d-M-Y", $dateT)?></td>
                            <td align="center"><a class="link" onclick="saveURL()" href="update?type=update-home&id=<?= $linksListRow['link_id']?>&t=<?= $linksListRow['type_id']?>">Update</a><a class="link" onclick="return confirm('Are you sure you want to delete?')" href="function?type=delete&id=<?= $linksListRow['link_id']?>&t=<?= $linksListRow['type_id']?>">Delete</a></td>
                        </tr>
                            <?php } ?>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="up" align="left">
                        Showing 10 out of <?=$totalLink = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM links"));?> Links
                </td>
                <td align="right">
                    © 2020-<?= date("Y")?> <a class="copy" href="https://twitter.com/KratzXD">@KratzXD</a> All rights reserved<br>
                    <a class="secret_button" href="tag">Add/Update Tags</a>
                    <a class="secret_button" href="artist_list">Artist List</a>
                </td>
            </tr>
            <tr>
                <td colspan="2" ><hr></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><button class="button" onclick="window.location.assign('index')">Home</button></td>
            </tr>
        </table>

