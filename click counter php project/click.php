<?php

error_reporting(0);
include("config.php");

$sql = "SELECT * FROM ".$SETTINGS["data_table"]." WHERE id='".intval($_REQUEST["id"])."'";
$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);

if (mysql_num_rows($sql_result)>0) {

	$banner = mysql_fetch_assoc($sql_result);
	
	$sql = "UPDATE ".$SETTINGS["data_table"]." SET clicks=clicks+1 WHERE id='".intval($_REQUEST["id"])."'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	
	header("Location: ".$banner["url"]);
		
} else {

	echo "Banner is missing.";
		
}

?>