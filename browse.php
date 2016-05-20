<?php
	include("config.php");
	//$my_root = "D:/CD Index/Database";
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CD Index Web Browse</title>
</head>

<body>
<div style="float:right;">
	<a href="index.php">Search</a> | Browse
</div>
<h1><a href="browse.php">CD Index Web Browse</a></h1>
<hr />
<?php
	
	function showDir($my_root, $base, $dir)
	{
		$handle = @opendir($base.$dir);
		$name = iconv("big5", "utf-8", $dir);
		echo "<li>".$name."\n";
		echo "<ul>\n";
		while ($file = @readdir($handle))
		{
			if ($file == "." || $file == "..")
				continue;
			$path = $base.$dir;
			if (substr($path, -1) != "/")
				$path = $path."/";
			if (is_dir($path.$file))
				showDir($my_root, $path, $file);
			else if (is_file($path.$file))
				showFile($my_root, $path, $file);
		}
		echo "</ul>\n";
		echo "</li>";
	}
	
	function showFile($my_root, $base, $file)
	{
		if (substr($file, -4) != ".IDX")
			return;
		
		$name = iconv("big5", "utf-8", $file);
		$path = $base.$name;
		//$path = str_replace($my_root,"","$path");
		$path = substr($path, strlen($my_root));
		
		echo "<li><a href=\"reader.php?file=".urlencode($path)."\" target=\"_blank\">".$name."</a></li>";
	}
	
	echo "<ul>";
	for ($i = 0; $i < count($s_dirs); $i++)
	{
		showDir($my_root, $my_root, $s_dirs[$i]);
	}
	echo "</ul>";
?>

</body>
</html>
