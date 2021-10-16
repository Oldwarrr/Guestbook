<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';


// Взяли данные из базы
$addDate = $mysql->query("SELECT `date` FROM `guests`");
$addName = $mysql->query("SELECT `name` FROM `guests`");
$addMessage = $mysql->query("SELECT `message` FROM `guests`");
// Определение номера страницы
if(isset($_GET['page'])){
	$page = preg_replace('#[^0-9]#i','', $_GET['page']);
}else {
	$page = 1; // Номер страницы
}


$limit = 3; // Макс. количество комментариев на странице (Для SQL запроса)
$start = ($page - 1)*$limit; // Порядковый номер комментария, с которого идет отсчет в БД (Для SQL запроса)
$add = $mysql->query("SELECT * FROM `guests` ORDER BY `guests` . `date` DESC LIMIT $start, $limit"); // Данные из БД
$countOfId = $mysql->query("SELECT COUNT(`id`) FROM `guests`"); // Количество комментариев в БД
$count = $countOfId->fetch_assoc()['COUNT(`id`)']; // Присвоение переменной значения,  равного количеству комментариев в БД
$pageCount = ceil($count / $limit); // Количество страниц пагинации
if($page < 1){
	$page = 1;
}elseif($page > $pageCount){
	$page = $pageCount;
}

$centerPages = "";

$sub1 = $page - 1;
$sub2 = $page - 2;
$sub3 = $page - 3;
$sub4 = $page - 4;
$add1 = $page + 1;
$add2 = $page + 2;
$add3 = $page + 3;
$add4 = $page + 4;
$disabled = 'disabled';
if($pageCount >= 5){
	if($page == 1){
		$centerPages .= "<li><span class='pagination__page active'>$page</span></li>";
		$centerPages .= "<li><a class='pagination__page' href='$_SERVER[PHP_SELF]?page=$add1'>$add1</a></li>";
		$centerPages .= "<li><a class='pagination__page' href='$_SERVER[PHP_SELF]?page=$add2'>$add2</a></li>";
		$centerPages .= "<li><a class='pagination__page' href='$_SERVER[PHP_SELF]?page=$add3'>$add3</a></li>";
		$centerPages .= "<li><a class='pagination__page' href='$_SERVER[PHP_SELF]?page=$add4'>$add4</a></li>";
	}elseif($page == ($pageCount -1)){
		$centerPages .= "<li><a class='pagination__page' href='$_SERVER[PHP_SELF]?page=$sub3'>$sub3</a></li>";
		$centerPages .= "<li><a class='pagination__page' href='$_SERVER[PHP_SELF]?page=$sub2'>$sub2</a></li>";
		$centerPages .= "<li><a class='pagination__page' href='$_SERVER[PHP_SELF]?page=$sub1'>$sub1</a></li>";
		$centerPages .= "<li><span class='pagination__page active'>$page</span></li>";
		$centerPages .= "<li><a class='pagination__page' href='$_SERVER[PHP_SELF]?page=$add1'>$add1</a></li>";
	}elseif($page ==$pageCount){
		$centerPages .= "<li><a class='pagination__page' href='$_SERVER[PHP_SELF]?page=$sub4'>$sub4</a></li>";
		$centerPages .= "<li><a class='pagination__page' href='$_SERVER[PHP_SELF]?page=$sub3'>$sub3</a></li>";
		$centerPages .= "<li><a class='pagination__page' href='$_SERVER[PHP_SELF]?page=$sub2'>$sub2</a></li>";
		$centerPages .= "<li><a class='pagination__page' href='$_SERVER[PHP_SELF]?page=$sub1'>$sub1</a></li>";
		$centerPages .= "<li><span class='pagination__page active'>$page</span></li>";
	}elseif($page > 2 && $page <($pageCount - 1)){
		$centerPages .= "<li><a class='pagination__page' href='$_SERVER[PHP_SELF]?page=$sub2'>$sub2</a></li>";
		$centerPages .= "<li><a class='pagination__page' href='$_SERVER[PHP_SELF]?page=$sub1'>$sub1</a></li>";
		$centerPages .= "<li><span class='pagination__page active'>$page</span></li>";
		$centerPages .= "<li><a class='pagination__page' href='$_SERVER[PHP_SELF]?page=$add1'>$add1</a></li>";
		$centerPages .= "<li><a class='pagination__page' href='$_SERVER[PHP_SELF]?page=$add2'>$add2</a></li>";
	}elseif($page = 2){
		$centerPages .= "<li><a class='pagination__page' href='$_SERVER[PHP_SELF]?page=$sub1'>$sub1</a></li>";
		$centerPages .= "<li><span class='pagination__page active'>$page</span></li>";
		$centerPages .= "<li><a class='pagination__page' href='$_SERVER[PHP_SELF]?page=$add1'>$add1</a></li>";
		$centerPages .= "<li><a class='pagination__page' href='$_SERVER[PHP_SELF]?page=$add2'>$add2</a></li>";
		$centerPages .= "<li><a class='pagination__page' href='$_SERVER[PHP_SELF]?page=$add3'>$add3</a></li>";
	}
}

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
			<?
				if($pageCount > 0){
					echo "<p>Страница $page из $pageCount</p>";
				}
			?>
			
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
							<a class = 'pagination__page fw $disabled ' href = '?page=1'>В начало</a>
						</li>
						 ";
					}

					//Стрелка назад с блокировкой на стартовой странице
					if($page != 1){
						$disabled = "";	
					}else{
						$disabled = " disabled";
					}
					echo "
							<li>
								<a class = 'pagination__page $disabled' href = '?page=$sub1'>«</a>
							</li>
						 ";

					// Цикл вывода пагинации - СТАРЫЙ
					if($pageCount < 5){ // Вывод циклом, если страниц меньше 5
						for($i = 1; $i <= $pageCount; $i++){
							if($i > 0){
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
						}
					}else{
						echo "<br>" . $centerPages;//Вывод пагинации - НОВЫЙ
					}
		
					//Стрелка вперед с блокировкой на последней странице
					if($page != $pageCount){
						$disabled = "";	
					}else{
						$disabled = " disabled";
					}
					echo "
						<li>
							<a class = 'pagination__page $disabled' href = '?page=$add1'>»</a>
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
							<a class = 'pagination__page fw $disabled ' href = '?page=$pageCount'>В конец</a>
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
2. Поработать над защитой от неправильного ввода в адресную строку
 -->