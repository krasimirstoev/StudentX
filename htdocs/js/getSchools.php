<?php
if(isset($_GET['location'])){
       include("../../config.php");
       include("../../libs/DB.class.php");
       include("../../libs/Filter.class.php");
	global $db, $filter;
	$result = $db->getSchools($_GET['location']);
	while($all = mysql_fetch_array($result)){
       echo $filter->decode($all['id']) . "!" . $filter->decode($all['name']) . "\n";
       }
}
?>