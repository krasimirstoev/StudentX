<?php 
include('header.tpl.php');
echo "<h1>Смяна на паролата</h1>";
include('profileMenu.tpl.php');
?>
<form action="" method="post">
<ul>
<li>Нова парола: </li>
<li><input type="password" name="newpassword0" size="35" maxlength="64" /></li>
<li>Въведете отново новата парола: </li>
<li><input type="password" name="newpassword1" size="35" maxlength="64" /></li>
<li>
<input type="hidden" name="sent" value="1" />
<input type="submit" name="submit" value="Готово!" /></li></ul>
</form>
<?php include('footer.tpl.php'); ?>
