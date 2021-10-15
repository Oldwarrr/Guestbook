<?php
session_start();
require_once 'includes/db.php';

//Добавили данные если не пуст $_POST
if(isset($_POST)){
    $name = $_POST['name'];
    $message = $_POST['message'];
	$date = date('d.m.Y H:i:s');
		//Если не пустые поля
		if(!empty($name) && !empty($message)){
			if(mb_strlen($message) <= 255){
                $submit = $mysql->query("INSERT INTO `guests`(name,message,date) VALUES('$name','$message','$date')");
			    $_SESSION['msg'] = 'Запись успешно сохранена!';
			    header('Location: index.php?page=1');
            }else{
                $_SESSION['msg'] = 'Слишком длинное сообщение!';
			    header('Location: index.php?page=1');
            }
			
		}else{
			$_SESSION['msg'] = 'Заполните пустые поля!';
            header('Location: index.php?page=1');
		}
	}else{
    // echo "empty";
}