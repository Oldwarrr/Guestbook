<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

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
		<link rel="stylesheet" href="includes/style.css">
	</head>
	<body>
		<div class="wrapper" id="wrapper">
			<h1>Комментарии</h1>
			
			<!-- PHP Script -->
	
			<?php
			 postMessage($add);
			 if(isset($_SESSION['msg'])){
				if($_SESSION['msg'] === 'Запись успешно сохранена!'){   //  Заготовка для смены фона в зависимости от результата длины сообщения
					echo "<div class='alert success'>" . $_SESSION['msg']  . "</div>"; //Обычный фон если меньше нормы
				}else{
					echo "<div class='alert cancel'>" . $_SESSION['msg']  . "</div>"; // Слишком длинное сообщение

				}
						
			 }
			 unset($_SESSION['msg']);  
			 ?> 


			<!-- HTML Form -->
			<div class="form" id="form">
				<form action="addComment.php" method="POST">
					<input class="name" name="name" type="text" autocomplete="off" placeholder="Ваше имя">
					<textarea class="text" name="message" autocomplete="off" placeholder="Ваш отзыв"></textarea>
					<button class="btn" type="submit" name="submit">Сохранить</button>	
				</form>	
			</div>
			
		</div>
		<script src="includes/javascript.js"></script>
	</body>
</html>