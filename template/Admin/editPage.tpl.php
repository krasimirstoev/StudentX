<?php 
global $filter;
include('header.tpl.php');  
 $page = mysql_fetch_array($result);
 ?>
<p>
<strong>Редактиране на страница:</strong><br /><br />
<em><?=$message; ?></em>
</p>
<ul>
	<li><form name="edit" action="" method="post"></li>
	<li>Име: <input type="text" name="name" size="30" value="<?=$filter->decode($page['name']); ?>"/></li>
	<li>Slug/на латиница/: <input type="text" name="slug" size="30" value="<?=$filter->decode($page['slug']); ?>"/></li>
	<li>Съдържание:</li> <li><textarea name="content" cols="60" rows="20"><?=$filter->decode($page['content']); ?></textarea></li>
	<li><input type="checkbox" name="published" value="1" id="published" <?php if($filter->decode($page['published']) == 1){ echo 'checked="checked"'; } ?>
	/><label for="published">Публикувай официално</label></li>
	<li><input type="checkbox" name="showinmenu" value="1" id="showinmenu" <?php if($filter->decode($page['showinmenu']) == 1){ echo 'checked="checked"'; } ?>
	/><label for="showinmenu">Показвай в менюто</label></li>
	<li><input type="hidden" name="sent" value="1" />
	<input type="submit" value="Редактирай" /></li>
	<li></form></li>
</ul>
<?php include('footer.tpl.php'); ?>