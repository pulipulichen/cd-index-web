<?php
$my_root = substr($_SERVER["SCRIPT_FILENAME"], 0, strrpos($_SERVER["SCRIPT_FILENAME"], "/"));
$s_dirs = array("/CD","/DIR"); // Which directories should be searched ("/dir1","/dir2","/dir1/subdir2","/Verzeichniss2/Unterverzeichniss2")? --> $s_dirs = array(""); searches the entire server
?>