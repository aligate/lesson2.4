<?php 
session_start();

define('CAPTCHA_FILE', __DIR__ . '/captcha.json');

function saveCaptcha($code)
{
    $ip = $_SERVER['REMOTE_ADDR'];
    $data = getCaptchaCodes();
    $data[$ip] = $code;
    file_put_contents(CAPTCHA_FILE, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}

function logAdmin($login, $password){
	$admin_data = getAdminData();
	if($admin_data['login']===$login AND $admin_data['password']===md5($password)){
		$_SESSION['user'] = $admin_data['name'];
		
		return true;
	}
	
}
/*
	Функция блокировки авторизации 
*/
function isBlocked(){
	$ip = $_SERVER['REMOTE_ADDR'];
	$data[$ip] = time()+60;
	if(!is_file("components/blocked($ip).json")){
	file_put_contents("components/blocked($ip).json", json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	}
	$check = json_decode(file_get_contents("components/blocked($ip).json"), true);

	if($check[$ip] > time()){
		include_once 'blocked.html';
		exit();
	} else{
		unlink("components/blocked($ip).json");
		session_destroy();
		
	}
}

function isGuest($login){
	if(!empty($login)){
	$_SESSION['user']= $login;
	return true;
	}
}

function getCaptchaCodes()
{
    if (!file_exists(CAPTCHA_FILE)) {
        return [];
    }
    $data = file_get_contents(CAPTCHA_FILE);
    $data = json_decode($data, true);
    if (!$data) {
        $data = [];
    }
    return $data;
}


function isLogged()
{
    return !empty($_SESSION) ? $_SESSION : [];
}

function counter(){
	
	 if (!isset($_SESSION['counter']))
	{
		$_SESSION['counter'] = 1;
	}
	else
	{
		$_SESSION['counter']++;
	}
	return $_SESSION['counter'];
}

function getAdminData(){
	
	$file = __DIR__.'/config.json';
	if(file_exists($file)){
		$data = json_decode(file_get_contents($file), true);
		return $data;
	}
	return false;
}


function generateCaptchaText($length = 10)
{
    $symbols = '12345678890ASDF';
    $result = [];
    for($i = 0; $i < $length; $i++) {
        $result[$i] = $symbols[mt_rand(0, strlen($symbols) - 1)];
    }
    return implode('', $result);
}


 function renderPicture($m){
	$file = "<?php\n";
	$file .= "require_once 'functions.php';\n";
	$file .= "header('Content-Type: image/png');\n";
	$file .= "getPrize('$m');\n";
	$file .="?>";
	file_put_contents(__DIR__.'/prize.php', $file);
}

function getCaptcha($text){
	$im = imagecreatetruecolor(100, 50);
	$backColor = imagecolorallocate($im, 255, 114, 221);
    $textColor = imagecolorallocate($im, 255, 255, 255);
    $fontFile = __DIR__ . '/arial.ttf';
    imagefill($im, 0, 0, $backColor);
	imagettftext($im, 20, 0, 30, 30, $textColor, $fontFile, $text);
    imagepng($im);
    imagedestroy($im);
	
}


function getPrize($message)
{
	
    $im = imagecreatetruecolor(360, 350);
	$backColor = imagecolorallocate($im, 255, 224, 221);
    $textColor = imagecolorallocate($im, 129, 15, 90);
    $fontFile = __DIR__ . '/arial.ttf';
    $imBox = imagecreatefrompng(__DIR__ . '/prize.png');
    imagefill($im, 0, 0, $backColor);
    imagecopy($im, $imBox, 10, 80, 20, 0, 256, 256);
    imagettftext($im, 20, 0, 30, 30, $textColor, $fontFile, $message);
    imagepng($im);
    imagedestroy($im);
}



?>