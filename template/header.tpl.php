<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="bg" lang="bg-BG">
<head profile="http://gmpg.org/xfn/11">
<title><?=$title; ?></title>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<meta name="author" content="Кирил Владимиров, Красимир Стоев"/>
<meta name="keywords" content="studentx, тестове, училище, литература, БЕЛ, кандидат-студенти, биология, история, география, английски език" />
<meta name="description" content="StudentX - Решаване на онлайн тестове по Литература, Биология, История, Английски език, География. Безплатно!" />
<meta name="robots" content="index, follow, archive" />
<meta name="verify-v1" content="8ItjR3VUik8410xjBpLvA84Xv8IOted5C1yJG7uQdFY=" />
<base href="<?=SITE_URL; ?>" />
<link rel="stylesheet" type="text/css" href="<?=SITE_URL; ?>css/html.css" media="screen, projection, tv " />
<link rel="stylesheet" type="text/css" href="<?=SITE_URL; ?>css/print.css" media="print" />
<script type="text/javascript" src="<?=SITE_URL; ?>js/prototype-1.6.0.3.js">&nbsp;</script>
<script type="text/javascript">domain = '<?=SITE_URL; ?>'</script>
<script type="text/javascript" src="<?=SITE_URL; ?>js/ajax.js"></script>

</head>
<body>
<div id="content">
  <div id="header">
    <div id="title">
      <h1><a href="<?=SITE_URL; ?>" title="<?=SITE_NAME; ?>"><?=SITE_NAME;?> &nbsp; &nbsp; &nbsp; &nbsp;</a></h1>
      <h2>онлайн тестове</h2>
    </div>
    <img src="<?=SITE_URL; ?>images/bg/header_left.jpg" alt="left slice" class="left" />
    <img src="<?=SITE_URL; ?>images/bg/header_right.jpg" alt="right slice" class="right" />
  </div>
<?php require_once('menu.tpl.php'); ?>
  <div id="page">
    <div class="width75 floatLeft">
      <div class="box">
        <?php 
	global $scf4u, $breadcrumbs, $filter;
	$pageid0 = $filter->input($_GET['id']);
	$pageid1 = $filter->input($_GET['Function']);
	$pageid2 = $filter->input($_GET['Class']);
	if(!$scf4u->breadcrumbs($pageid0)){
		if(!$scf4u->breadcrumbs($pageid1)){
			$scf4u->breadcrumbs($pageid2);
		}
	}
	?>
      </div>
      <div class="gradient">