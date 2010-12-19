<?php
/**
 * @file: {Name}.Controller.php
 * @type: Controller
 * @description: Описание...
 * @license: GNU General Public License v2
**/

class {Name} {

	//Променлви за нулиране

	/**
	 * @name: __call
	 * @description: Тази функция се изпълнява при извикване на несъществуваща
	 * 				функция в този клас. 
	 */
	function __call($getClass, $getFunction){
		global $pages;
		
		$pages->Error404();
	}

	function __construct() {
		
	}

	}

${name} = new {Name}();
