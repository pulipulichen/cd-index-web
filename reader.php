<?php
	include("config.php");
	
	if (isset($_GET["search"]))
		$search = $_GET["search"];
	//$search = "data";
	
	$filePath = $my_root.$_GET["file"];
	$filePath = iconv("utf-8", "big5", $filePath);
	if (is_file($filePath) == false)
	{
		echo "File not found.";
		exit();
	}
	
	$lastSlash = strrpos($filePath, "/");
	$filename = substr($filePath, $lastSlash+1);
	$text = file_get_contents($filePath);
	$text = iconv("utf-16le", "utf-8", $text);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_GET["file"]; ?></title>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="cd-index.js"></script>
<link href="cd-index.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1><?php echo $_GET["file"]; ?></h1>

<input type="text" style="width: 50%" class="keyword" value="<?php echo $search; ?>" /> 
<button type="button" onclick="search()">搜尋</button>
<span class="counter-label">現在進度<span class="counter-now">1</span>/<span class="counter-all"></span>筆</span>
<span class="search-complete">完成，共找到<span class="search-match">0</span>筆資料</span>

<hr />
<?php 
	$lines = explode("\n", $text);
	
	function dirDetect($lines, $i)
	{
		if ($i >= count($lines) - 1)
			return -1;
		
		//先看看這一層的tab數
		$thisLine = $lines[$i];
		$thisTabs = count(explode("\t", $thisLine));
		
		//再看看下一層的tab數
		$nextLine = $lines[($i+1)];
		$nextTabs = count(explode("\t", $nextLine));
		
		if ($thisTabs == $nextTabs)
			return 0;
		else if ($thisTabs > $nextTabs)
			return -1;
		else
			return 1;
	}
	
	echo "<ul class=\"root-dir\">\n";
	for ($i = 1; $i < count($lines); $i++)
	{
		if (trim($lines[$i]) == "")
			continue;
		
		$l = trim($lines[$i]);
		$isMatch = false;
		if (isset($search) && $search != ""
			&& (strlen($search) < strlen($l) || strlen($search) == strlen($l))
			)
		{
			if (strpos(strtolower($l), strtolower($search)) === false)
				$isMatch = false;
			else
				$isMatch = true;
		}
		
		$action = dirDetect($lines, $i);
		
		echo "<li>";
		
		if ($action == 1)
		{
			echo "<span class=\"flag hidden\">[+]</span>";
			if ($isMatch == false)
				echo "<span class=\"dir-name name\">";
			else
				echo "<span class=\"dir-name name found\">";
		}
		else
		{
			if ($isMatch == false)
				echo "<span class=\"name\">";
			else
				echo "<span class=\"name found\">";
		}
		echo $l."</span>";
		
		if ($action == 0)
			echo "</li>\n";
		else if ($action == 1)
		{
			echo "\n";
			echo "<ul style=\"display:none;\">\n";
		}
		else
		{
			echo "</li>\n";
			echo "</ul>\n";
			echo "</li>\n";
		}
		
	}
	echo "</ul>\n";
?>
</body>
</html>
