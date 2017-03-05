<?php
require_once 'components/functions.php';
$number = '';
$data = $_POST;
$error=[];
if(isset($data['submit'])){
$number = counter();
if(empty($data['guest'])){
	
	if(array_key_exists('captcha', $data)===false){
		
		if(logAdmin($data['login'], $data['password'])){
		
		header('Location: admin.php');
		}
		else 
		{	
			$error[]= "Логин или пароль не подходят";
		} 
	}	
		else{
			$ip = $_SERVER['REMOTE_ADDR'];
			$dataCaptcha = getCaptchaCodes();
			if(array_key_exists($ip, $dataCaptcha) AND strcmp($dataCaptcha[$ip], $data['captcha']) === 0){
				if(logAdmin($data['login'], $data['password'])){
					header('Location: admin.php');
				} 
				else{
					$error[]= "Логин или пароль не подходят";
				}
			}
			else {
				$error[]= "Введенная капча неверна";
				
			}
		}
}	
		elseif(isGuest($data['guest']))
		{	
			header('Location: list.php');
		}
	}
	if($number > 10){ 
			isBlocked();
			$error=[];
			$data['captcha']=null;
			header('Location: index.php');
			}


			
?>

<html>
  <head>
    <meta charset="utf-8">
	 <link rel="stylesheet" href="css/main.css">
	 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	
    <title>Вход на сайт</title>
    
  </head>
  <body> 
   
    <section>
    <div class="container">
        <div class="row">

            <div class="col-sm-4 col-sm-offset-4 padding-right">

               <div class="signup-form">
                    <h2>Авторизуйтесь</h2>
                    <form action="#" method="post">
                        <input type="text" name="login" placeholder="логин" value=""/>
                        <input type="password" name="password" placeholder="Пароль" value=""/>
						<h3>Или зайдите как гость</h3>
						<input type="text" name="guest" placeholder="введите ваше имя" value=""/>
						<input type="submit" name="submit" class="btn btn-default" value="Вход" />
						<?php if($number > 5): ?>
						<img src="components/captcha.php"/><br/>
						<label for="captcha">Введите код с картинки</label><br />
						<input id="captcha" size="15" type="text" name="captcha" />
						<?php endif; ?>
						</form>
                </div>
				<?php if(!empty($error)) echo array_shift($error);?>
				 <br/>
            </div>
        </div>
    </div>
</section>
 </body>
</html>
