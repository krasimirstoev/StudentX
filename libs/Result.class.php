<?php
/**
 * @file: Result.Controller.php
 * @type: Controller
 * @description: Този клас извършва нужните за всеки тест операции.
 * @license: GNU General Public License v2
 */
class Result{
	
	/**
	 * @name: calcScore
	 * @type: Public
	 * @description: Функцията пресмята оценката на потребителя за даден тест по 6-балната система. 
	 **/
	public function calcScore($True, $False){
		//Извикваме си нужните ни класове
		global $filter;
		
		//Филтрираме подадените ни променливи
		$Total = 1;
		(int) $True = $filter->input($True);
		(int) $False = $filter->input($False);

		
		//Пресмятаме общия брой на въпросите
		if($True != 0){
			$Total = $True + $False;
		}
		
		//Пресмятаме оценката по 6-балната система и я закръгляме до две цифри след запетаята
		$SixResult0 = $True / $Total * 4 + 2;
		$SixResult = round($SixResult0, 2);
		
		return $SixResult;
	}
	
	/**
	 * @name: calcPercent
	 * @type: Public
	 * @description: Функцията пресмята оценката на потребителя за даден тест в проценти. 
	 **/
	public function calcPercent($True, $False){
		//Извикваме си нужните ни класове
		global $filter;
		
		//Филтрираме подадените ни променливи
		$Total = 1;
		(int) $True = $filter->input($True);
		(int) $False = $filter->input($False);
		
		//Пресмятаме общия брой на въпросите
		if($True != 0){
			$Total = $True + $False;
		}

		//Пресмятаме оценката в проценти и я закръгляме до две цифри след запетаята
		$percentResult0 = $True / $Total * 100;
		$percentResult = round($percentResult0, 2);

		return $percentResult;
	}
	
}
$result = new Result();
