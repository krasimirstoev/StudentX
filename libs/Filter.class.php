<?php

class Filter{
	
	
	//Нулираме си променливите
	var $var;
	var $var0;
	var $filter;
	var $lenght;
	
	public function input($var0, $lenght = 0){
		/* Проверка за дължината на $var0 */
		if($lenght > 0){
			if(strlen($var0) > $lenght){
				return false;
			}
		}
		/* Край на проверката */
		$var0 = htmlspecialchars($var0);
		return $var0;
	}
	
	public function sql($var0, $lenght = 0){
		if($lenght > 0){
			if(strlen($var0) > $lenght){
				return false;
			}
		}
		return mysql_real_escape_string($var0);
	}

	public function decode($var0){
		$var = stripslashes(stripslashes($var0));

		return $var;
	}

	
}

$filter = new Filter();
?>
