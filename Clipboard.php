<?php
    $json = file_get_contents('php://input');
    $File = fopen("../dump/Clipboard.txt","a");
    fwrite($File,"$json\n");
    fclose($File);
?>
