<?php

error_reporting(0);
include("config.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Page counter data</title>
<style>
BODY, TD {
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
}
</style>
</head>


<body>

<table width="700" border="1" cellspacing="0" cellpadding="4">
  <tr>
    <td width="600" bgcolor="#CCCCCC"><strong>URL</strong></td>
    <td width="100" bgcolor="#CCCCCC"><strong>Clicks</strong></td>
  </tr>
<?php
$sql = "SELECT * FROM ".$SETTINGS["data_table"]." ORDER BY clicks DESC";
$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
if (mysql_num_rows($sql_result)>0) {
	while ($row = mysql_fetch_assoc($sql_result)) {
?>
  <tr>
    <td><a href="<?php echo $row["url"]; ?>" target="_blank"><?php echo $row["url"]; ?></a></td>
    <td><?php echo $row["clicks"]; ?></td>
  </tr>
<?php
	}
} else {
?>
<tr><td colspan="5">No results found.</td>
<?php	
}
?>
</table>


</body>
</html>