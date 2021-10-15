<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';


// Взяли данные из базы
$addDate = $mysql->query("SELECT `date` FROM `guests`");
$addName = $mysql->query("SELECT `name` FROM `guests`");
$addMessage = $mysql->query("SELECT `message` FROM `guests`");
// Определение номера страницы
if(isset($_GET['page'])){
	$page = $_GET['page'];
}else {
	$page = 1; // Номер страницы
}

$limit = 3; // Макс. количество комментариев на странице (Для SQL запроса)
$start = ($page - 1)*$limit; // Порядковый номер комментария, с которого идет отсчет в БД (Для SQL запроса)
$add = $mysql->query("SELECT * FROM `guests` ORDER BY `guests` . `date` DESC LIMIT $start, $limit"); // Данные из БД
$countOfId = $mysql->query("SELECT COUNT(`id`) FROM `guests`"); // Количество комментариев в БД
$count = $countOfId->fetch_assoc()['COUNT(`id`)']; // Присвоение переменной значения,  равного количеству комментариев в БД
$pageCount = ceil($count / $limit); // Количество страниц пагинации
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
			
			<nav>
				<ul class="pagination">
								
				<?php 
				if($pageCount > 1){ // Пагинация появится при условии, что страниц будет более одной
					
					//Кнопка перехода на первую страницу
					if($pageCount > 2){
						if($page != 1){
							$disabled = "";
						}else{
							$disabled = " disabled";
						}
					echo "
						<li>
							<a class = 'pagination__page $disabled ' href = '?page=1'>В начало</a>
						</li>
						 ";
					}

					//Стрелка назад с блокировкой на стартовой странице
					$prev = $page - 1;
					if($page != 1){
						$disabled = "";	
					}else{
						$disabled = " disabled";
					}
					echo "
							<li>
								<a class = 'pagination__page $disabled' href = '?page=$prev'>«</a>
							</li>
						 ";
				
					
					
					// Цикл вывода пагинации
					for($i = 1; $i <= $pageCount; $i++){
						if($page == $i){		
							$classActive = " active";
						}else {
							$classActive = "";
						}
						echo "
						<li>
						<a class = 'pagination__page $classActive' href = '?page=$i'>$i</a>
						</li>
						";
   					}
					
					//Стрелка вперед с блокировкой на последней странице
					$next = $page + 1;
					if($page != $pageCount){
						$disabled = "";	
					}else{
						$disabled = " disabled";
					}
					echo "
					<li>
						<a class = 'pagination__page $disabled' href = '?page=$next'>»</a>
					</li>
				 		 ";
					
					//Кнопка перехода на последнюю страницу
					if($pageCount > 2){
						// $disabled = "";	
						if($page != $pageCount){
							$disabled = "";
						}else{
							$disabled = " disabled";
						}
					echo "
						<li>
							<a class = 'pagination__page $disabled ' href = '?page=$pageCount'>В конец</a>
						</li>
						 ";
					}
				}	
				?>	

				</ul>
			</nav>

			<!-- PHP Script -->
	
			<?php

			// Вывод данных с БД
			 postMessage($add);
				
			// Вывод оповещения о сообщении
			 if(isset($_SESSION['msg'])){
				if($_SESSION['msg'] === 'Запись успешно сохранена!'){   //  Заготовка для смены фона в зависимости от результата длины сообщения
					echo "<div class='alert success'>" . $_SESSION['msg']  . "</div>"; // Запись успешно сохранена
				}else{
					echo "<div class='alert cancel'>" . $_SESSION['msg']  . "</div>"; // Слишком длинное сообщение
				}
						
			 }
			 unset($_SESSION['msg']);  
			 ?> 


			<!-- HTML Form -->
			<div class="form" id="form">
				<form id="form" action="addComment.php" method="POST">
					<input class="name" name="name" type="text" autocomplete="off" placeholder="Ваше имя">
					<textarea class="text" name="message" autocomplete="off" placeholder="Ваш отзыв"></textarea>
					<button class="btn" type="submit" name="submit">Сохранить</button>	
				</form>	
			</div>	
		</div>
		<script src="includes/javascript.js"></script>
	</body>
</html>


<!-- 
Добавить:
1. Отправку формы на Enter
2. Сделать отображение максимум 4-5ти страниц комментариев
 -->