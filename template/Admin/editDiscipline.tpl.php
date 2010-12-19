<?php include('header.tpl.php'); 
global $filter;

while ( $d = mysql_fetch_array($result) ){

?>
<h1>Редактиране на предмет:</h1>
<h4><?=$message; ?></h4>
<a href="<?php echo SITE_URL . "Admin/listQuizes/" . $filter->decode($d['slug']); ?>" class="profileLink">Покажи тестовете по този предмет</a>
<form name="edit" action="" method="post">
<ul>
<li>Име: <input type="text" name="name" size="30" value="<?=$filter->decode($d['name']); ?>" /></li>
<li>Slug /на латиница/: <input type="text" name="slug" size="30" value="<?=$filter->decode($d['slug']); ?>" /></li>
<li>Описание: <textarea name="description" cols="35"><?=$filter->decode($d['description']); ?></textarea></li>
<li><input type="hidden" name="id" value="<?=$d['id']; ?>" />
<input type="hidden" name="sent" value="1" />
<input type="submit" value="Добави" /></li>
</ul>
</form>

<?php
}
?>



<?php include('footer.tpl.php'); ?>
