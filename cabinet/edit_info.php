<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT']."/auth.php"; 
require_once $_SERVER['DOCUMENT_ROOT']."/includes/config.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/functions.php";

$holderId = $_SESSION['holder_id'];
$token = TOKEN;
$holderAction = "holder_info";
$searchHolder = "holder_id";

if(isset($_POST['editUser'])) {
	$surname = htmlspecialchars($_POST['surname']);
	$name = htmlspecialchars($_POST['name']);
	$patronymic = htmlspecialchars($_POST['patronymic']);
	$age = htmlspecialchars($_POST['birth']);
	$sex = htmlspecialchars($_POST['sex']);
	$marrital = htmlspecialchars($_POST['marrital']);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Редактировать данные</title>
	<link rel="stylesheet" href="<?=SITE?>css/bootstrap.min.css">
</head>
<body>
	<div class="container">
        <div class="row align-self-center m-1">
			<div class="btn-group-vertical m-2 ml-auto mr-auto w-100">
				<img class="img-fluid" src="<?=SITE?>img\logo.png" alt="logo">
			</div>
			<div class="col text-center p-0 d-flex flex-row justify-content-between w-100">
				<h3 class="mb-0"><span class="badge badge-primary pb-2 pt-2">Личный кабинет</span></h3>
				<a class="btn btn-secondary d-block" href="<?=SITE?>index.php?do=logout" role="button">Выйти</a>
			</div>
		</div>
        <div class="row align-self-center m-1">
            <div class="col-12 mx-auto">
                <div class="text-center m-2">
                <?php
                if(isset($_POST['editUser'])) {
                    //файл с записью данных в CRM
                    require_once("info_edit_curl.php");
                ?>
                    <p>Данные успешно изменены</p>
                 <?php } else { ?>
                    <p>Произошла ошибка</p>
                <?php } ?>
        <button type="button" class="btn btn-secondary" onClick='location.href="<?=SITE?>"'>Вернуться</button>
    </div>
</body>
</html>