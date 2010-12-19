<?php global $filter;
$page = $filter->input($_GET['Function']);
?>
<div id="mainMenu">
	<ul class="floatRight">
		<li><a href="<?php echo SITE_URL . "Admin/Index"; ?>" 
		<?php if($page == null || $page == "Index"){ echo 'class="here"'; } ?>
		>Начало</a></li> 
		
		<li><a href="<?php echo SITE_URL . "Admin/listPages"; ?>"
		<?php if(preg_match("/page/i", $page)){ echo 'class="here"'; } ?>
		>Страници</a></li>
		
		<li><a href="<?php echo SITE_URL . "Admin/listDisciplines"; ?>"
		<?php if(preg_match("/discipline/i", $page)){ echo 'class="here"'; } ?>
		>Предмети</a></li>
		
		<li><a href="<?php echo SITE_URL . "Admin/listQuizes"; ?>"
		<?php if(preg_match("/quiz/i", $page)){ echo 'class="here"'; } ?>
		>Тестове</a></li>
		
		<li><a href="<?php echo SITE_URL . "Admin/listQuestions"; ?>"
		<?php if(preg_match("/question/i", $page)){ echo 'class="here"'; } ?>
		>Въпроси</a></li>
		
		<li><a href="<?php echo SITE_URL . "Admin/listUsers"; ?>"
		<?php if(preg_match("/user/i", $page) || preg_match("/profile/i", $page) || preg_match("/avatar/i", $page)){ echo 'class="here"'; } ?>
		>Потребители</a></li>
		<li><a href="<?php echo SITE_URL; ?>"><strong>Изход</strong></a></li>
	</ul>
</div> 
