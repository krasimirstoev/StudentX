 <?php include('header.tpl.php');  ?>
<p>
<strong>Добави нова страница:</strong><br /><br />
<em><?=$message; ?></em>
</p>
<ul>
	<li><form name="add" action="" method="post"></li>
	<li>Име: <input type="text" name="name" size="30"/></li>
	<li>Slug/на латиница/: <input type="text" name="slug" size="30"/></li>
	<li>Съдържание:</li> <li><textarea name="content" cols="60" rows="20"></textarea></li>
	<li><input type="checkbox" name="published" value="1" id="published" /><label for="published">Публикувай официално</label></li>
	<li><input type="checkbox" name="showinmenu" value="1" id="showinmenu" /><label for="showinmenu">Показвай в менюто</label></li>
	<li><input type="hidden" name="sent" value="1" />
	<input type="submit" value="Добави" /></li>
	<li></form></li>
</ul>
<?php include('footer.tpl.php'); ?>