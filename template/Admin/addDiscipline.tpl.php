<?php include('header.tpl.php');  ?>

<strong>Добави нов предмет:</strong><br /><br />
<h4><?=$message; ?></h4>


<form name="add" action="" method="post">
<ul>
<li>Име: <input type="text" name="name" size="30" /></li>
<li>Slug /на латиница/: <input type="text" name="slug" size="30" /></li>
<li>Описание: <textarea name="description" cols="20"></textarea></li>
<li><input type="hidden" name="sent" value="1" />
<input type="submit" value="Добави" /></li>
</ul>
</form>
<?php include('footer.tpl.php'); ?>
