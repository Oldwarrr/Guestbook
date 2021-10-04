<?php
$mysql = new mysqli('guestbook','root','','guestbook');
$mysql->query("SET NAMES 'utf8'");

//Добавили если не пуст




if(!empty($_POST)){
    $name = $_POST['name'];
    $message = $_POST['message'];
	$date = date('d/m/Y H:i:s');
		//Если не пустые поля
		if(!empty($name) && !empty($message)){
			$submit = $mysql->query("INSERT INTO `guests`(name,message,date) VALUES('$name','$message','$date')");
			header('Location: index.php');
		}else{
			// echo "Пустая форма";
		}

	
}else{
    // echo "empty";
}





// Взяли данные из базы
$addDate = $mysql->query("SELECT `date` FROM `guests`");
$addName = $mysql->query("SELECT `name` FROM `guests`");
$addMessage = $mysql->query("SELECT `message` FROM `guests`");
$add = $mysql->query("SELECT * FROM `guests` ORDER BY `guests` . `date` DESC");



// Функция вывода данных
function postMessage($result){
	if($row = $result->num_rows > 0){
		while($row = $result->fetch_assoc()){	
		echo "
				<div class='note'>
					<p>
						<span class='date'>$row[date]</span>
						<span class='name'>$row[name]</span>
					</p>
					<p>
					$row[message]
					</p>
				</div>	
			 ";
		}
	}
}

// Функция вывода оповещения
function postAlert(){
	if(isset($_POST['submit'])){
		echo "
				<div class='info alert alert-info'>
				Запись успешно сохранена!
				</div>
			 ";

	}else{
		// echo "Failed ALERT";
	}
}

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
			<h1>Гостевая книга</h1>

			<!-- PHP Script -->
			<?php postMessage($add); postAlert();  ?> <!--Вывод данных и оповещения-->

			<!-- HTML Form -->
			<div id="form">
				<form action="" method="POST">
					<p><input name="name" class="form-control" placeholder="Ваше имя" autocomplete="off"></p>
					<p><textarea name="message" class="form-control" placeholder="Ваш отзыв"></textarea></p>
					<p><input type="submit" class="btn btn-info btn-block" value="Сохранить"></p>
				</form>
			</div>
		</div>
	</body>
</html>
