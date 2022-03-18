<?php
session_start();
unset($_SESSION['welcome']);
unset($_SESSION['codenumber']);
unset($_SESSION['verify']);
unset($_SESSION['card']);
unset($_SESSION['phone']);
require_once  $_SERVER['DOCUMENT_ROOT']."/includes/config.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/functions.php";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Войти в личный кабинет</title>
	<link rel="stylesheet" href="<?=SITE?>css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="row align-self-center m-1 ml-auto mr-auto">
			<div class="btn-group-vertical m-2 ml-auto mr-auto w-100">
					<img class="img-fluid ml-auto mr-auto" src="<?=SITE?>img\logo.png" alt="logo">
				</div>
			<div class="col text-center w-100">
				<h3><span class="badge badge-primary">Личный кабинет</span></h3>
			</div>
		</div>
		<div class="row align-self-center m-1">
			<div class="col-12 mx-auto">
				<form method="POST" action="<?=SITE?>enter_cabinet/login_sms.php">
					<div class="form-group">
						<label for="card">Введите номер вашей карты</label>
						<input type="number" class="form-control" id="card" name="card" placeholder="№ карты" required>
					</div>
					<div class="text-center m-2">
						<button type="button" class="btn btn-secondary" onClick='location.href="<?=SITE?>enter_cabinet/enter.php"'>Назад</button>
						<button type="submit" class="btn btn-primary" name="enter">Войти</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>