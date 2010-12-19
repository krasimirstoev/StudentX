 <?php include('header.tpl.php');  ?>

<h1>Добави нов тест:</h1><br /><br />
<h4><?=$message; ?></h4>
<ul>
<li><form name="add" action="" method="post"></li>
<li>Име: <input type="text" name="name" size="30" /></li>
<li>Предмет: <select name="discipline">
	<?php while( $all = mysql_fetch_array($allDisciplines) ){
		echo "<option value='" . $all['id'] ."'>".$all['name']."</option>\n";
	}
	?>
	</select></li>
<li>Клас: <select name="difficulty">
	<?php for($i=1; $i<13; $i++){
		echo "<option value='" . $i ."'>$i</option>\n";
	}
	?>
	</select></li>
<li>Описание:</li> <li> <textarea name="description" cols="60"></textarea></li>
<?php
	if($_GET['id'] == 1){
		?>
		<li style="border-top: 1px solid; padding-top: 15px; margin-top: 15px;">Заглавие на текста: <input type="text" name="text_title" size="30" /></li>
		<li>Текст:</li> <li style="border-bottom: 1px solid; padding-bottom: 15px; margin-bottom: 15px;"> <textarea name="text" cols="60" rows="20">&nbsp;</textarea></li>
		<li><input type="hidden" name="hastext" value="1" /></li>
	<?php } ?>
<li><input type="checkbox" name="published" value="1" id="published" /><label for="published">Публикувай официално</label></li>
<li><input type="hidden" name="sent" value="1" />
<input type="submit" value="Добави" /></li>
<li></form></li>
</ul>
<?php include('footer.tpl.php'); ?>

