<?php
session_start();
$mysql = new mysqli('guestbook','root','','guestbook');
$mysql->query("SET NAMES 'utf8'");

if(!isset($mysql)){
	die('Error connection to DataBase');
}
