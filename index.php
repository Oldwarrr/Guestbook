<?php
require_once 'db.php';
require_once 'functions.php';

// Взяли данные из базы
$addDate = $mysql->query("SELECT `date` FROM `guests`");
$addName = $mysql->query("SELECT `name` FROM `guests`");
$addMessage = $mysql->query("SELECT `message` FROM `guests`");
$add = $mysql->query("SELECT * FROM `guests` ORDER BY `guests` . `date` DESC");



?>

<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">  
		<title>Гостевая книга</title>
		<link rel="stylesheet" href="css/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="css/styles.css">
	</head>
	<body>
		<div id="wrapper">
			<h1>Комментарии</h1>

			<!-- PHP Script -->
			<?php
			 postMessage($add);
			 if(isset($_SESSION['msg'])){
				if($_SESSION['msg'] === 'Запись успешно сохранена!'){   //  Заготовка для смены фона в зависимости от результата длины сообщения
					echo "<div class='info alert alert-info'>" . $_SESSION['msg']  . "</div>"; //Обычный фон если меньше нормы
				}else{
					echo "<div class='info alert alert-info cancel'>" . $_SESSION['msg']  . "</div>"; // При превышении нормы(НЕ РАБОТАЕТ!)

				}
						
			 }
			 unset($_SESSION['msg']);  
			 ?> 


			<!-- HTML Form -->
			<div id="form">
				<form action="addComment.php" method="POST">
					<p><input name="name" class="form-control" placeholder="Ваше имя" autocomplete="off"></p>
					<p><textarea name="message" class="form-control" placeholder="Ваш отзыв"></textarea></p>
					<p><input type="submit" class="btn btn-info btn-block" value="Сохранить"></p>
				</form>	
			</div>
			
		</div>
	</body>
</html>