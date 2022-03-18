<?php
session_start();
unset($_SESSION['welcome']);
unset($_SESSION['codenumber']);
unset($_SESSION['verify']);
unset($_SESSION['card']);
unset($_SESSION['surname']);
unset($_SESSION['name']);
unset($_SESSION['patronymic']);
unset($_SESSION['age']);
unset($_SESSION['sex']);
unset($_SESSION['phone']);
require_once  $_SERVER['DOCUMENT_ROOT']."/includes/config.php";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Добро пожаловать!</title>
	<link rel="stylesheet" href="<?=SITE?>css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="row align-self-center m-1">
			<div class="col-12 mx-auto d-flex flex-column">
				<div class="btn-group-vertical m-2 ml-auto mr-auto">
					<img class="img-fluid" src="<?=SITE?>img\logo.png" alt="logo">
				</div>
				<div class="btn-group-vertical m-1 text-center">
					<button type="button" class="btn btn-danger btn-lg" onClick='location.href="<?=SITE?>enter_cabinet/login_card.php"'>Войти</button>
				</div>
				<div class="btn-group-vertical m-1 text-center">
					<button type="button" class="btn btn-primary btn-lg" onClick='location.href="<?=SITE?>registration/registration.php"'>Регистрация</button>
				</div>
			</div>
		</div>
	</div>
</body>
</html>