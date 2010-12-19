<?php

//Константите за връзка с базата данни
define("DB_SERVER", "localhost");
define("DB_USER", "db_user_here");
define("DB_PASS", "db_pass_here");
define("DB_NAME", "db_name_here"); 

//Константи за пътища до основните директории
define("ROOT_PATH", "/home/studentx/");
define("CONTROLLERS", ROOT_PATH . "controllers/");
define("LIBS", ROOT_PATH . "libs/");
define("TEMPLATE", ROOT_PATH . "template/");
define("ADMIN_TEMPLATE", TEMPLATE . "Admin/");
define("ADMIN_MENU", ADMIN_TEMPLATE . "menu.tpl.php");
define("HTDOCS", ROOT_PATH."htdocs/");
define("INDEX", ROOT_PATH . "htdocs/index.php");


//Основни константи за име и URL на страницата
define("SITE_NAME", "StudentX");
define("SITE_URL", "http://studentX.net/");
define("DOMAIN", ".studentx.net");
define("ERROR404", SITE_URL . "Pages/404");


//Стрингове за хеширане на паролата
define("SALT0", "уиг&*хфоклагsH>hfж89БЙгфакеръгkjsdfHSDSA&(@хжа9&*lsdfkи");
define("SALT1", "йсафсдхОУХД)&77347вфхдфс8***&^Т*&Д*Сas8fjdKHKHsd97(^&F^");

//Информация за системните администратори
define("ADMIN_MAIL", "info@studentx.org");
