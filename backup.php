<?php

$filename='database_backup.sql';

$result=exec('SELECT * INTO OUTFILE database_backup.sql FROM links;');

?>