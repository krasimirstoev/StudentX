<?php include('header.tpl.php');
$pageInfo = mysql_fetch_array($result);

echo "<h1>{$name}</h1> \n
<p class='page'>{$content}</p>\n
";

include('footer.tpl.php'); ?>