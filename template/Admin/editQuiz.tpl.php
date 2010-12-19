 <?php include('header.tpl.php');  
 global $filter;
while ( $d = mysql_fetch_array($result) ){
	?>

<h1>Редакция на тест:</h1>
<h4><?=$message; ?></h4>
<a href="<?php echo SITE_URL . "Admin/listQuestions/" . $filter->decode($d['id']); ?>" class="profileLink">Покажи въпросите в този тест</a>

<form name="add" action="" method="post" >
<ul>
<li>Име: <input type="text" name="name" size="30" value="<?=$filter->decode($d['name']); ?>" /></li>
<li>Предмет: <select name="discipline">
	<option value="--">--</option>
	<?php while( $all = mysql_fetch_array($allDisciplines) ){
		echo "<option value='{$filter->decode($all['id'])}'";
		if($filter->decode($all['id']) == $filter->decode($d['disc_id'])){
			echo "selected='selected'";
		}
		echo ">".$filter->decode($all['name'])."</option>\n";
	}
	?>
	</select></li>
<li>Клас: <select name="difficulty">
	<?php for($i=1; $i<13; $i++){
		echo "<option value='{$filter->decode($i)}'";
		if($filter->decode($i) == $filter->decode($d['difficulty'])){ 
			echo " selected='selected'";
		}
		echo ">{$filter->decode($i)}</option>\n";
	}
	?>
	</select></li>
<li>Описание: </li><li><textarea name="description" cols="60"><?=$filter->decode($d['description']); ?></textarea></li>
<?php
if($d['text_title'] != '0' && $d['text'] != '0'){
	?>
	<li style="border-top: 1px solid; padding-top: 15px; margin-top: 15px;">Заглавие на текста: <input type="text" name="text_title" size="30" value="<?=$filter->decode($d['text_title']); ?>" /></li>
	<li>Текст:</li> <li style="border-bottom: 1px solid; padding-bottom: 15px; margin-bottom: 15px;"> <textarea name="text" cols="60" rows="20"><?=$filter->decode($d['text']); ?></textarea></li>
	<li><input type="hidden" name="hastext" value="1" /></li>
	<?php } ?>
<li><input type="checkbox" name="published" value="1" id="published" <?php if($filter->decode($d['published']) == 1){ echo 'checked="checked"'; } ?>
	/><label for="published">Публикувай официално</label></li>
<li><input type="hidden" name="sent" value="1" />
<input type="submit" value="Редактирай" /></li>
</ul>
</form>

<?php
}
?>
<?php include('footer.tpl.php'); ?>
