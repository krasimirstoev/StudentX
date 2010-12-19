<?php include('header.tpl.php');
$clean = array();
$all = mysql_fetch_array($studentInfo);
$realname = $all['real_name'];
$email = $all['email'];
$city = $all['city'];

echo "<h1> Редакция на профила </h1>";
include('profileMenu.tpl.php');

?>
<form action="" method="post">
<?php include('memberInfo.tpl.php'); ?>
<input type="hidden" name="sent" value="1" />
<input type="submit" name="submit" value="Готово!" />
</form>

<?php include('footer.tpl.php'); ?> 