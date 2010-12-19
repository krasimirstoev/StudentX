<?php include('header.tpl.php');  ?>

<strong>Добави нов въпрос:&nbsp;</strong><br /><br />
<h4><?=$message; ?></h4>


<form name="add" action="" method="post">
<ul>
<li class="smallinput">В тест: <select name="quiz_id">
				<?php while( $all = mysql_fetch_array($allQuizes) ){
					echo "<option value='" . $all['id'] ."'>".$all['name']."</option>\n";
				}
				?>
				</select></li>
<li class="smallinput">Въпрос: <input type="text" name="question" size="30" /> <br /><br /></li>
				
<li class="smallinput">Отговор A: <input type="text" name="opt1" size="30" class="question"/>
				<label for="correct-1" >Верен <input type="radio" id="correct-1" name="correct" value="1" /></label> </li>
<li class="smallinput">Отговор B: <input type="text" name="opt2" size="30" class="question"/>
				<label for="correct-2" >Верен <input type="radio" id="correct-2" name="correct" value="2" /></label> </li>
<li class="smallinput">Отговор C: <input type="text" name="opt3" size="30" class="question"/>
				<label for="correct-3" >Верен <input type="radio" id="correct-3" name="correct" value="3" /></label> </li>
<li class="smallinput">Отговор D: <input type="text" name="opt4" size="30" class="question"/>
				<label for="correct-4" >Верен <input type="radio" id="correct-4" name="correct" value="4" /></label> </li>
<li class="smallinput">&nbsp;<input type="hidden" name="sent" value="1" />
<input type="submit" value="Добави" /></li>
</ul>
</form>

<?php include('footer.tpl.php'); ?>
