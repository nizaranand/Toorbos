<?php

$path = $_REQUEST['path'];
$path2 = $_REQUEST['path2'];

move_uploaded_file($_FILES['Filedata']['tmp_name'], $path.$_FILES['Filedata']['name']); 
copy($path.$_FILES['Filedata']['name'],$path2.$_FILES['Filedata']['name']);
chmod($path.$_FILES['Filedata']['name'], 0777); 
chmod($path2.$_FILES['Filedata']['name'], 0777); 

?>
