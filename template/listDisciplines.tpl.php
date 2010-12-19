<?php include('header.tpl.php');  
global $db, $members;

echo "<h1>Онлайн решаване на тестове</h1> \n
<h2>Изберете предмет, по който искате да проверите знанията си!</h2> \n
<table>\n
";

while( $all = mysql_fetch_array($allDisciplines) ){
	$quiz_num = mysql_numrows($db->listQuizes(1, 1, $all['id']));
	
	if($quiz_num == 0){
		$quizes = "Няма тестове по този предмет";
	}
	else if($quiz_num == 1){
		$quizes = "Един тест";
	}
	else{
		$quizes = $quiz_num . " теста";
	}
	
	
	$url = SITE_URL."Quiz/listQuizes/{$all['slug']}";
	echo "<tr class='list' onclick='document.location.href=\"$url\"'>
		<td>
		<a href='$url' title='Решавай тестове по ".$all['name']."' style='text-decoration: none;'><span class='title'>".$all['name']." <span style='float: right; font-size: 12px; font-weight: bold;'>{$quizes}</span></span></a><br />
		<strong>".$all['description']."</strong> </td>
		
	</tr>";
}
echo "</table>";

include('footer.tpl.php'); ?>