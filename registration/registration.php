<?php
session_start();
unset($_SESSION['codenumber']);
unset($_SESSION['verify']);
unset($_SESSION['card']);
unset($_SESSION['surname']);
unset($_SESSION['name']);
unset($_SESSION['patronymic']);
unset($_SESSION['age']);
unset($_SESSION['sex']);
unset($_SESSION['phone']);
require_once $_SERVER['DOCUMENT_ROOT']. "/includes/config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Регистрация</title>
	<link rel="stylesheet" href="<?=SITE?>css/bootstrap.min.css">
	<link rel="stylesheet" href="<?=SITE?>css/style.css">
</head>
<body>
	<div class="container">
		<div class="row align-self-center m-1 ml-auto mr-auto">
			<div class="btn-group-vertical m-2 ml-auto mr-auto w-100">
					<img class="img-fluid ml-auto mr-auto" src="<?=SITE?>img\logo.png" alt="logo">
				</div>
			<div class="col text-center w-100">
				<h3><span class="badge badge-primary">Регистрация</span></h3>
			</div>
		</div>
		<div class="row align-self-center m-1">
			<div class="col-12 mx-auto">
				<form method="POST" action="<?=SITE?>registration/registration_sms.php">
					<label class="mb-0" for="cardPhone">Введите карту и свой телефон</label>
					<div class="row mb-1" id="cardPhone">
						<div class="col pr-1">
							<input type="number" class="form-control" name="card" placeholder="№ карты" required>
						</div>
						<div class="col pl-1">
							<input type="tel" class="form-control" name="phone" placeholder="071xxxxxxx" required>
						</div>
					</div>
					<div class="form-group">
						<label class="mb-0" for="surname">Фамилия</label>
						<input type="text" class="form-control" id="surname" name="surname" placeholder="Ваша фамилия" required>
					</div>
					<div class="form-group">
						<label class="mb-0" for="name">Имя</label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Ваше имя" required>
					</div>
					<div class="form-group">
						<label class="mb-0" for="patronymic">Отчество</label>
						<input type="text" class="form-control" id="patronymic" name="patronymic" placeholder="Ваше отчество" required>
					</div>
					<div class="form-group">
						<label class="mb-0" for="birth">Дата рождения</label>
						<input type="date" class="form-control" id="birth" name="birth" required>
					</div>
					<hr class="my-1">
					<div><label class="mb-0" for="male">Выберите пол</label></div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="sex" id="male" value="Male" checked>
						<label class="form-check-label" for="male">Мужской</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="sex" id="female" value="Female">
						<label class="form-check-label" for="female">Женский</label>
					</div>
					<div><label class="mb-0"s for="marrital">Женат/замужем</label></div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="marrital" id="marrital" value="Yes">
						<label class="form-check-label" for="marrital">Да</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="marrital" id="no_marrital" value="No" checked>
						<label class="form-check-label" for="no_marrital">Нет</label>
					</div>
					<hr class="my-1">
					<div class="form-check">
					    <input type="checkbox" class="form-check-input" id="agree" required>
						<label class="form-check-label" for="agree">Я согласен с </label><u data-toggle="modal" data-target="#terms"> условиями регистрации</u>
					</div>
					<div class="text-center m-2">
					<button type="button" class="btn btn-secondary" onClick='location.href="<?=SITE?>enter_cabinet/enter.php"'>Назад</button>
					<button type="submit" class="btn btn-primary" name="registration">Отправить</button>
				</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="terms" tabindex="-1" role="dialog" aria-labelledby="termsLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="termsLabel">Условия регистрации</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <p>Даю свое согласие на хранение и обработку своих персональных данных (имени, номера телефона) и на получение материалов рекламного и/или информационного характера посредством SMS-сервисов от ООО «Русь» (GoodCity), ИКЮЛ 20366950.</p>
			<p>Согласие на SMS-оповещения может быть отозвано в любой момент путем обращения по тел: 606.</p>
			<p>Предъявляйте, пожалуйста, карту при каждой покупке.</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
	      </div>
	    </div>
	  </div>
	</div>

	<script src="<?=SITE?>js/jquery-3.5.1.min.js"></script>
	<script src="<?=SITE?>js/bootstrap.bundle.min.js"></script>	
</body>
</html>