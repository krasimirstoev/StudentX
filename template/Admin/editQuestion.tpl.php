<?php include('header.tpl.php');  
global $filter;
?>

<h1>Редакция на въпрос:&nbsp;</h1>
<h4><?=$message; ?>&nbsp;</h4>

<?php
	while ( $d = mysql_fetch_array($result) ){
?>

<form name="add" action="" method="post">
<ul>
<li class="smallinput">В тест: <select name="quiz_id">
				<?php while( $all = mysql_fetch_array($allQuizes) ){
					echo "<option value='" . $all['id'] ."'";
					if($all['id'] == $d['quiz_id']){
						echo "selected='selected'";
					}
					
					echo ">".$filter->decode($all['description'])."</option>\n";
				}
				?>
				</select><br /><br /></li>
<li class="smallinput">Въпрос: <input type="text" name="question" size="30" value="<?=$filter->decode($d['question']); ?>" /> </li>
				
<li class="smallinput">Отговор A: <input type="text" name="opt1" size="30" value="<?=$filter->decode($d['opt1']); ?>" class="question"/>
				<label for="correct-1" >Верен <input type="radio" id="correct-1" name="correct" value="1" 
				<?php if($d['correct'] == 1){  echo '	checked="checked" '; } ?> /></label></li>
<li class="smallinput">Отговор B: <input type="text" name="opt2" size="30" value="<?=$filter->decode($d['opt2']); ?>" class="question"/>
				<label for="correct-2" >Верен <input type="radio" id="correct-2" name="correct" value="2" 
			<?php if($d['correct'] == 2){  echo '	checked="checked" '; } ?> /></label> </li>
<li class="smallinput">Отговор C: <input type="text" name="opt3" size="30" value="<?=$filter->decode($d['opt3']); ?>" class="question"/>
				<label for="correct-3" >Верен <input type="radio" id="correct-3" name="correct" value="3" 
				<?php if($d['correct'] == 3){  echo '	checked="checked" '; } ?> /></label> </li>
<li class="smallinput">Отговор D: <input type="text" name="opt4" size="30" value="<?=$filter->decode($d['opt4']); ?>" class="question"/> 
				<label for="correct-4" >Верен <input type="radio" id="correct-4" name="correct" value="4" 
				<?php if($d['correct'] == 4){  echo '	checked="checked" '; } ?> /></label> </li>

<li>&nbsp;<input type="hidden" name="sent" value="1" />
<input type="submit" value="Добави" /></li>
</ul>
</form>

<?php 
}
include('footer.tpl.php'); ?>
