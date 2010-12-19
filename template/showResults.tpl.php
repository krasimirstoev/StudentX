<?php include('header.tpl.php'); 
global $db, $members;
?>
<h1>Резултати от тест
<?php $quiz0 = mysql_fetch_array($quiz);
echo "{$quiz0['name']}";

echo "</h1><p>";
$i = 0;
while($row = mysql_fetch_array($correct)) {
	global $scf4u, $filter, $result;
	//Филтрираме и парсваме bbcode таговете
	$row['question'] = $scf4u->bbcode($row['question']);
	$row['question'] = $filter->decode($row['question']);
	
	$row['opt1'] = $scf4u->bbcode($row['opt1']);
	$row['opt1'] = $filter->decode($row['opt1']);
	
	$row['opt2'] = $scf4u->bbcode($row['opt2']);
	$row['opt2'] = $filter->decode($row['opt2']);
	
	$row['opt3'] = $scf4u->bbcode($row['opt3']);
	$row['opt3'] = $filter->decode($row['opt3']);
	
	$row['opt4'] = $scf4u->bbcode($row['opt4']);
	$row['opt4'] = $filter->decode($row['opt4']);
	
	
	$id = $row['id']; 
	$answer = $_POST[$id];
	$correct0 = "opt".$row['correct'];
	if($answer == $correct0){
		$True++;
		echo '<blockquote class="go">';
	}
	else if($answer == null){
		$False++;
		echo '<blockquote class="exclamation">';
		
	}
	else if($answer != $correct0){
		$False++;
		echo '<blockquote class="stop">';
	}
	$i++;
	echo "<h3>{$i}.{$row['question']}</h3>\n
	<ul style='list-style-type: disc;'>";
	for($p=1; $p<5; $p++){
		$opt = "opt".$p;
		//Ако е посочен верен отговор
		if($opt == $answer && $answer == $correct0){
			echo "<li><span style='color: #00FF00; font-weight: bold;'>{$row[$opt]}</span></li>";
		}
		//Ако е посочен грешен отговор
		else if($opt == $answer && $answer != $correct0){
			echo "<li><span style='color: #FF0000; font-weight: bold;'>{$row[$opt]}</span></li>";
		}
		//Ако не е посочен този отговор, но той е верен
		else if($opt != $answer && $opt == $correct0){
			echo "<li><span style='color: #00FF00;'>{$row[$opt]}</span></li>";
		}
		else{
				echo "<li>{$row[$opt]}</li>";
		}
	
	}
	echo "</ul></blockquote>";
}
	$sixResult =  $result->calcScore($True, $False);
	$percentResult = $result->calcPercent($True, $False);
	echo "
	<h4>Общо <span style='text-decoration: underline;'>Верни</span> отговори: {$True}.<br />
	Общо <span style='text-decoration: underline;'>Грешни</span> отговори: {$False}.</h4><br />
	<blockquote>
	<strong>Вашата оценка е <span style='text-decoration: underline;'>". $sixResult . "</span></strong><br />
	<strong>Решили сте <span style='text-decoration: underline;'>" . $percentResult ."%</span> от теста</strong><br /></p>";
	

if($members->isLogged() == True) {
	$db->solvedQuiz($quiz0['id'], $members->studentName(), $sixResult, $percentResult);
	$solved = $db->countSolved($quiz0['id'], $members->studentName());
	if($solved == 1){
		echo "<strong>Вие решихте този тест за първи път!</strong><br />";
	}
	else {
		echo "<strong>Този тест е решаван {$solved} пъти от Вас.</strong><br />";
	}
}
$totalSolved = $db->totalSolved($quiz0['id']);
echo "<strong>Този тест е решен общо {$totalSolved} пъти.</strong></blockquote>";
	

	
	
include('footer.tpl.php');
?>