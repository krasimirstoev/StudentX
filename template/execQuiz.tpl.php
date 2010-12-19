<?php
global $db, $scf4u, $filter;
include('header.tpl.php'); 

$quiz = $db->getQuiz($quizID);
$quiz0 = mysql_fetch_array($quiz);
echo "<h1>{$filter->decode($quiz0['name'])}</h1>
<h2>{$filter->decode($quiz0['description'])}</h2>";
if($quiz0['text_title'] != '0' && $quiz0['text'] != '0'){
       $quiz0['text_title'] = $scf4u->bbcode($quiz0['text_title']);
       $text_title = $filter->decode($quiz0['text_title']);
       $quiz0['text'] = $scf4u->bbcode($quiz0['text']);
       $text = $filter->decode($quiz0['text']);
echo "<h3>{$text_title}&nbsp;</h3>
<h4 style='text-align: justify;' >{$text}&nbsp;</h4>";

} ?>

<form action="<?=SITE_URL . 'Quiz/showResults/'. $_GET['id']; ?>" method="post" name="quiz" id="quiz">
<?php
$i = 1;
while($all = mysql_fetch_array($allQuestions)){
	global $scf4u, $filter;
	$all['question'] = $scf4u->bbcode($all['question']);
	$question = $filter->decode($all['question']);

	$all['opt1'] = $scf4u->bbcode($all['opt1']);
	$opt1 = $filter->decode($all['opt1']);

	$all['opt2'] = $scf4u->bbcode($all['opt2']);
	$opt2 = $filter->decode($all['opt2']);
	
	$all['opt3'] = $scf4u->bbcode($all['opt3']);
	$opt3 = $filter->decode($all['opt3']);
	
	$all['opt4'] = $scf4u->bbcode($all['opt4']);
	$opt4 = $filter->decode($all['opt4']);

	$n = array('1', '2', '3', '4');
	shuffle($n);
	

	echo "<blockquote><h3>{$i}.{$question}</h3>\n
		 <ul>";
		foreach($n as $q){
			$opt = ${"opt" . $q};
			echo"
			<li class='list' onclick='document.forms.quiz.opt{$q}{$all['id']}.checked = true;'><input type='radio' name='{$all['id']}'  value='opt{$q}' id='opt{$q}{$all['id']}' />
			<label for='opt{$q}{$all['id']}'>$opt </label></li>";
		}
		echo "</ul>
		</blockquote>\n";
	++$i;
	}
	?>


<input type="hidden" name="test_id" value="<?=$_GET['id']; ?>" />
<input type="hidden" name="sent" value="1" />
<input type="submit" value="Изпрати" />
</form>


<?php include('footer.tpl.php'); ?>
