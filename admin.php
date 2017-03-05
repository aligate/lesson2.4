<?php
require_once 'components/functions.php';
if($_SESSION['user']!=='Админ'){
	 http_response_code(403);
	 include 'components/403.html';
	die();
}

if($_FILES){
$temp_name = $_FILES['test']['tmp_name'];
$name = 'json/'.$_FILES['test']['name'];
if(move_uploaded_file($temp_name, $name)) header('Location: list.php');
}
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Загрузка файлов</title>
    
  </head>
  <body>
	<h3>Добро пожаловать, <?= isLogged()['user']; ?>, в зону тестов!</h3>
    <h2>Загрузка тестовых файлов</h2>

   <form method = 'POST' enctype='multipart/form-data'>
		<input type ='file' name='test'>
		<button>Отправить</button>
	</form>
	<br/><a href="logout.php">Выход</a><br/>
	<p style ="color: blue; font-size:20px;"><a href="list.php">Перейти к списку загруженных файлов</a></p>
  </body>
</html>
