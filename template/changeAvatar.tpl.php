<?php 
include('header.tpl.php');

echo "<h1>Редактирай аватара си</h1>";

include('profileMenu.tpl.php');
?>
<form action="" method="post" enctype="multipart/form-data">
<ul>

<li>
	<?php
	//echo $student;
	if($db->hasAvatar($student) == 1){
		$avatar_ext = $db->getAvatar($student);
		$ext = mysql_fetch_array($avatar_ext);
		echo "<img src='".SITE_URL."avatars/".$student. $ext[0]."' alt='Аватарът на {$student}' style='margin: 18px;'/>";
	}
	else{ ?>
	<img src="<?=SITE_URL; ?>images/noAvatar.jpg" alt="User has no avatar" style="margin: 18px; width: 200px; height: 200px;" />
	<?php } ?>
</li>
<li style="margin-bottom: 30px; margin-left: 35px;"><a class="profileLink" href="<?=$path."dropAvatar/".$student; ?>" title="Изтрий аватара!" >Изтрий аватара!</a></li>

<li>Изберете файл от вашия компютър: </li>
<li><input type="file" name="userfile" id="userfile" /></li>
<li><input type="hidden" name="sent" value="1" />
<input type="submit" value="Upload" /></li>
</ul>
</form>
<?php include('footer.tpl.php'); ?> 