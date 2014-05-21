<?php

error_reporting(0);
include("config.php");

if ($_REQUEST["do"]=='add') {
	
	$sql = "INSERT INTO ".$SETTINGS["data_table"]." SET date_time=now(), name='".mysql_real_escape_string($_REQUEST["name"])."', email='".mysql_real_escape_string($_REQUEST["email"])."', comment='".mysql_real_escape_string($_REQUEST["comment"])."'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);

}

?>
<div id="Comments">
<?php
$sql = "SELECT * FROM ".$SETTINGS["data_table"]." ORDER BY id DESC";
$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
while ($row = mysql_fetch_assoc($sql_result)) {
	echo "<div><h2>".stripslashes($row["name"])."</h2>";
	echo "<span>posted on ".$row["date_time"]."</span>";
	echo "<p>".stripslashes(nl2br($row["comment"]))."</p></div>";
}
?>
</div>
<form id="GuestBookFrm" name="GuestBookFrm" onsubmit="return false;">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td colspan="2"><strong>Add your comment</strong></td>
    </tr>
  <tr>
    <td>Name</td>
    <td><label>
      <input type="text" name="your_name" id="your_name" />
    </label></td>
  </tr>
  <tr>
    <td>Email</td>
    <td><input type="text" name="email" id="email" /></td>
  </tr>
  <tr>
    <td>Comment</td>
    <td><label>
      <textarea name="comment" id="comment" rows="5"></textarea>
    </label></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><label>
      <input type="button" name="button" id="button" value="Submit" onclick="SubmitComment()" />
    </label></td>
  </tr>
</table>
</form>