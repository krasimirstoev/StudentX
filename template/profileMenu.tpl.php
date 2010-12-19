<?php
if($_GET['Class'] == ucfirst("admin")){
	$path = SITE_URL."Admin/";
	
	$student = $username;

}
else{
	$path = SITE_URL."Members/";
}

?>
<a class="profileLink" href="<?=$path."editProfile/".$student; ?>" title="Редакция на профила">Редакция на профила</a>
<a class="profileLink" href="<?=$path."changePassword/".$student; ?>" title="Смяна на паролата">Смяна на паролата</a>
<a class="profileLink" href="<?=$path."changeAvatar/".$student; ?>" title="Аватар">Аватар</a>
<a class="profileLink" href="<?=SITE_URL."Members/".$student; ?>">Преглед на профила</a><br /><br />

<?php
if($message){
	echo "<h4>$message</h4>";
}
?>