<?php include('header.tpl.php');  
global $db, $members;

echo "<h1>Решените тестове</h1> \n
<table>
<tr><th>Дата и час</th><th>Тест</th><th>Оценка</th><th>Процент</th></tr>
";

while( $all = mysql_fetch_array($solved) ){
	$quizName = mysql_result($db->getQuiz($all['quiz_id']), 0, 'description');
	if($all['score'] >= 5.50){
		$style = "style='color: #00ff00;'";
	}
	else if($all['score'] <= 2.49){
		$style = "style='color: #ff0000;'";
	}
	else{
		$style = "";
	}
	echo "<tr class='list' {$style}>
	<td>{$all['datetime']}</td><td>{$quizName}</td><td>{$all['score']}</td><td>{$all['percent']}%</td>
	</tr>";
	
}
echo "</table>";
include('footer.tpl.php'); ?>