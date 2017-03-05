<?php
require_once 'components/functions.php';
if(isset($_POST['delete'])){
	unlink($_POST['file']);
	header($_SERVER['PHP_SELF']);
}

$dir = __DIR__.'/json/';
$files = scandir($dir);

?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Загрузка файлов</title>
    
  </head>
  <body> 
<h2>Список тестов</h2>
<?php if(isLogged()['user']=='Админ') : ?>
	<form method="post">
	<ul  style="list-style: none;">
	<?php foreach($files as $file) :?>
	<?php if(strpos($file, '.json')) :?>
	<?php $array = json_decode(file_get_contents('json/'.$file), true);?>
	<?php if(isset($array)):?>
	<?php foreach($array as $key=>$value): ?>
	 
<li><input type="checkbox" name="file" value="json/<?=$file; ?>"><a href ="test.php?id=<?= substr($file, 0, -5); ?>"><?= $key." ($file)"; ?></a></li>
	<?php endforeach; ?>
	<?php endif; ?>
	<?php endif; ?>
	<?php endforeach; ?>
</ul>
	<br/><input type="submit" name="delete" value="Удалить файл">
	</form>
	<br/><a href="admin.php">Вернуться в панель админа</a>
	
	<?php else: ?>
	<h3>Добро пожаловать, <?= isLogged()['user']; ?>, в зону тестов!</h3>
<ul  style="list-style: circle;">
	<?php foreach($files as $file) :?>
	<?php if(strpos($file, '.json')) :?>
	<?php $array = json_decode(file_get_contents('json/'.$file), true);?>
	<?php foreach($array as $key=>$value): ?>
<li><a href = "test.php?id=<?= substr($file, 0, -5); ?>"><?= $key." ($file)"; ?></a></li>
	<?php endforeach; ?>
	<?php endif; ?>
	<?php endforeach; ?>
</ul>
	<br/><a href="logout.php">Выход</a>

	
	<?php endif; ?>
 </body>
</html>
