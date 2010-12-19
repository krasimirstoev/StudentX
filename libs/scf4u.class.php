<?php
/**
 * @name: scf4u (SimpleClassFunctions4you)
 * @author: Kiril Vladimirov(NetCutter)
 * @description: Very simple, but extremely usefull class,
 * maded by me, for one article in www4u.org
 * @license: GNU GPL v2
 * @created: 17 May 2008
**/
class SimpleClassFunctions4u{
	
	/**
	 * @desctiption: Simple php function that calculates image's 
	 * width and height. The first parameter is contains 
	 * Image File URL, the second is for image border, and the last 
	 * defines image's alt. 
	 * @created: 17 May 2008
	 **/
	public function img0($file, $border, $alt){
		
		$clean = array();
		$clean['alt'] = htmlentities($alt, ENT_QUOTES, 'UTF-8');
		if(ctype_digit($border)){
			$clean['border'] = $border;
		}
		else{
			$clean['border'] = 0;
		}
		
		list($width, $height) = getimagesize($file);
		echo( "<img src=\"{$file}\" 
				style=\" width: {$width}; height :{$height};\" 
				border=\"{$clean['border']}\" 
				alt=\"{$clean['alt']}\" 
		/>");
	}
	
	
	/**
	 * @desctiption: Simple php function. The first parameter is contains 
	 * Image File URL, the second is for image border, and the last 
	 * defines image's alt. 
	 * @created: 17 May 2008
	 **/
	public function img1($file, $border, $alt, $width, $height){
		
		$clean = array();
		$clean['alt'] = htmlentities($alt, ENT_QUOTES, 'UTF-8');
		
		$nums = array();
		if(!ctype_digit($border) ? $num['border'] = $border : $num['border'] = 0);
		if(!ctype_digit($width) ? $num['width'] = $height : $num['width'] = 0);
		if(!ctype_digit($height) ? $num['height'] = $height : $num['height'] = 0);

		
		list($width, $height) = getimagesize($file);
		echo( "<img src=\"{$file}\" 
				style=\" width: {$num['width']}; height :{$num['height']};\" 
				border=\"{$num['border']}\" 
				alt=\"{$clean['alt']}\" 
		/>");
	}
	
	/**
	 * @function: validEmail
	 * @description: Функцията подлага под множество проверки валидността на подаден e-mail адресс
	 **/ 
	public function validEmail($email) {
	$isValid = true;
	$atIndex = strrpos($email, "@");
	if (is_bool($atIndex) && !$atIndex)
	{
		$isValid = false;
	}
	else
	{
		$domain = substr($email, $atIndex+1);
		$local = substr($email, 0, $atIndex);
		$localLen = strlen($local);
		$domainLen = strlen($domain);
		if ($localLen < 1 || $localLen > 64)
		{

			$isValid = false;
		}
		else if ($domainLen < 2 || $domainLen > 255)
		{

			$isValid = false;
		}
		else if ($local[0] == '.' || $local[$localLen-1] == '.')
		{

			$isValid = false;
		}
		else if (preg_match('/\\.\\./', $local))
		{

			$isValid = false;
		}
		else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
		{

			$isValid = false;
		}
		else if (preg_match('/\\.\\./', $domain))
		{

			$isValid = false;
		}
		else if
(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
					  str_replace("\\\\","",$local)))
		{

			if (!preg_match('/^"(\\\\"|[^"])+"$/',
				 str_replace("\\\\","",$local)))
			{
				$isValid = false;
			}
		}
		if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
		{

			$isValid = false;
		}
	}
	return $isValid;
	}
	
	/**
	 * @function: cyrillicName
	 * @description: Функцията проверя дали истниското име на потребителя е написано на кирилица 
	**/
	public function cyrillicName($string){
		if (preg_match("/[А-Яа-я]/i", $string)){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * @function: hashString
	 * @description: Функцията хешира подадения стринг
	**/
	public function hashString($string){
		//Нулираме си променливата
		$string0 = null;
		
		//Хешираме стринга
		$string0 = md5(SALT0 . md5($string) . SALT1);
		
		return $string0;
	}
	
	/**
	* @function: generatePassword
	* @type: Public
	* @description: Функцията генерира парола от 8 символа
	**/
	public function generatePassword(){
		//Генерираме случаен стринг
		$code = md5(uniqid(rand(), true));
		
		//Връщаме само първите 8 символа от генерирания стринг
		return substr($code, 0, 8);
	}
	
	/**
	* @function: mailPassword
	* @type: Public
	* @description: Функцията праща нова парола на потребителския email
	**/
	public function mailPassword($username, $password, $email){
		//Дефинираме хедърите
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= 'From: ' . ADMIN_MAIL . "\r\n";
		$headers .= 'Reply-to: ' . ADMIN_MAIL . "\r\n";
		$headers .= 'Content-Transfer-Encoding: 16bit' . "\r\n";
		
		//Дефинираме стойността на "Относно"
		$subject = "=?UTF-8?B?" . base64_encode("[".SITE_NAME."] Забравена парола") . "?=";
		
		$content = "Поискали сте нова парола за вашия акаунт в " . SITE_NAME . "<br /> \n 
				Вашите потребителско име и парола са: <br /><br />\n \n
				Потребителско име: <strong>". $username . "</strong><br />\n
				Парола: <strong>" . $password ."</strong><br /><br />\n \n
				Можете да влезете с новите ви потребителско име и парола от този адрес: <br />\n ".
				SITE_URL . "Members/Login ";
		
		//Изпращаме писмото
		mail($email, $subject, $content, $headers);
	}
	
	/**
	* @funcion: getCurrentPage
	* @type: Public
	* @description: Функцията връща текущия URL
	**/
	public function getCurrentPage() {
		//Извикваме си нужните ни класове
		global $filter;
		
		//Филтрираме си _GET променливите
		$Class = $filter->input($_GET['Class']);
		$Function = $filter->input($_GET['Function']);
		$Id = $filter->input($_GET['id']);
		
		$currentPage = SITE_URL;
		if($Class != ""){
			$currentPage .= $Class . "/";
		}
		if($Function != ""){
			$currentPage .= $Function . "/";
		}
		if($Id != "") {
			$currentPage .= $Id . "/";
		}
		return $currentPage;
	}

	/**
	* @function: bbcode
	* @type: Public
	* @description: Функцията добавя възможността за bbcode форматиран текст
	**/
	public function bbcode($str) {
		//Извикваме си нужните ни класове
		global $filter;

		$search = array(
		'/\[b\](.*?)\[\/b\]/is',
		'/\[i\](.*?)\[\/i\]/is',
		'/\[u\](.*?)\[\/u\]/is',
		'/\[img\](.*?)\[\/img\]/is',
		'/\[center\](.*?)\[\/center\]/is',
		'/\[right\](.*?)\[\/right\]/is',
		'/\[left\](.*?)\[\/left\]/is',
		'/\[br\]/is',
		'/\[url\](.*?)\[\/url\]/is',
		'/\[del\](.*?)\[\/del\]/is',
		'/\[url\](.*?)\[\/url\]/is',
		'/\[url=(.*?)\](.*?)\[\/url\]/is',
		'/\[h2\](.*?)\[\/h2\]/is',
		'/\[h3\](.*?)\[\/h3\]/is',
		'/\[h4\](.*?)\[\/h4\]/is',
		'/\[h5\](.*?)\[\/h5\]/is'
		 );
		 
		$replace = array(
		'<strong>$1</strong>',
		'<em>$1</em>',
		'<u>$1</u>',
		'<img src="$1" alt="$1" />',
		'<div style="text-align: center;">$1</div>',
		'<div style="text-align: right;">$1</div>',
		'<div style="text-align: left;">$1</div>',
		'<br />',
		'<a href="$1">$1</a>',
		'<del>$1</del>',
		'<a href="$1" title="$1">$1</a>',
		'<a href="$1" title="$2">$2</a>',
		'<h2>$1</h2>',
		'<h3>$1</h3>',
		'<h4>$1</h4>',
		'<h5>$1</h5>'
		);
		
		$str = preg_replace ($search, $replace, $str);
		return $str;
	}

	/**
	* @function: makeAvatar
	* @type: Public
	* @description: Преоразмерява каченото изображение с размери 200x200
	*/
	public function makeAvatar($student, $filename, $file_ext) {
	
		require_once(ROOT_PATH . 'libs/asido/class.asido.php');
		asido::driver('gd');
		mt_srand();
	
		$orig = HTDOCS."uploads/".$filename; //път до качената картинка
		$tmpthumb = HTDOCS."avatars/".$student . $file_ext; //път до тъмбнейла

		if(!copy($orig, $tmpthumb)){
			return false;
		}
		if(!($th = asido::image($tmpthumb, $tmpthumb))){
			return false;
		}
		asido::stretch($th, 200, 200, ASIDO_RESIZE_STRETCH);

		$th->save(ASIDO_OVERWRITE_ENABLED);


		return true;
	}
	
	/**
	* @function: sendMail
	* @type: Public
	* @description: Функцията праща мейл към администратора
	**/
	public function sendMail($name, $email, $content){
		//Дефинираме хедърите
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= 'From: ' . $email . "\r\n";
		$headers .= 'Reply-to: ' . $email . "\r\n";
		$headers .= 'Content-Transfer-Encoding: 16bit' . "\r\n";
		
		//Дефинираме стойността на "Относно"
		$subject = "=?UTF-8?B?" . base64_encode("Запитване от {$name} в [".SITE_NAME."]") . "?=";
		
		$content = "Име: {$name}<br /> \n 
				E-mail: {$email} <br /><br />\n\n
				{$content}"
				;
		
		//Изпращаме писмото
		mail(ADMIN_MAIL, $subject, $content, $headers);
	}
	
	/**
	* @function: breadcrumbs
	* @type: Public
	* @description: Функцията обработва т.нар. 'пътечки' за всяка страница
	**/
	public function breadcrumbs($id){
		global $breadcrumbs;

		$bcl = array();
		$pageid = $id;
		while( strlen( $pageid ) > 0 ){
			$bcl[] = $pageid;
			$pageid = $breadcrumbs[ $pageid ]['parent'];
		}
		for( $i = count( $bcl ) - 1; $i >= 0; $i-- ){
			$page = $breadcrumbs[$bcl[$i]];
			if ( $i > 0 ){
				echo( "<a href=\"" );
				echo( SITE_URL . $page['url'] );
				echo( "\">" );
			}
			echo( $page['title'] );
			if ( $i > 0 ){
				echo( "</a> > " );
				
			}
			if(count($bcl) > 1 && $i <= 0){
			return true;
			}
		}
	}
	
	/**
	* @name: str2ascii
	* @type: Public
	* @description: Функцията връща подадения стринг с неговители ASCII кодове 
	**/
	public function str2ascii($input){ 
		foreach (str_split($input) as $obj) { 
			$output .= '&#' . ord($obj) . ';'; 
		}
	return $output;
	}
	

}

$scf4u = new SimpleClassFunctions4u();
?>
