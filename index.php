<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT']."/auth.php"; 
require_once $_SERVER['DOCUMENT_ROOT']. "/includes/config.php";
require_once $_SERVER['DOCUMENT_ROOT']. "/includes/functions.php";

?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Добро пожаловать!</title>
	<link rel="stylesheet" href="<?=SITE?>css/bootstrap.min.css">
	<link rel="stylesheet" href="<?=SITE?>css/style.css">
</head>
<body>
	<div class="container">
		<div class="row align-self-center m-1">
			<div class="btn-group-vertical m-2 ml-auto mr-auto w-100">
				<img class="img-fluid ml-auto mr-auto" src="<?=SITE?>img\logo.png" alt="logo">
			</div>
			<div class="col w-100 text-center p-0 d-flex flex-row justify-content-between">
				<h3 class="mb-0"><span class="badge badge-primary pb-2 pt-2">Личный кабинет</span></h3>
				<a class="btn btn-secondary d-block" href="<?=SITE?>index.php?do=logout" role="button">Выйти</a>
			</div>
		</div>
			<?php
			if(isset($_SESSION['card'])){
				$token = TOKEN;
				$card = $_SESSION['card'];
				$action = "card_info";
				$searchAction = "card_code";
				//card_info
				$result = curlCrm($token, $action, $searchAction, $card);

				//обработка card_info
				if(isset($result->Addresses)) {
					unset($result->Addresses);
				}

				if(isset($result->Cards)) {
					unset($result->Cards);
				}
				foreach ($result->Holders as $value) {
					$_SESSION['holder_id'] = $value->Holder_ID; // пользователя в сессию
					$surname = $value->L_Name;
					$name = $value->F_Name;
					$patronymic = $value->M_Name;
					$date = date_create($value->Birth);
					$calendDate = date_format($date, 'Y-m-d');
					$gender = $value->Gender;
					$marrital = $value->Marrital;
				}

				foreach ($result->Accounts as $value) {
					if ($value->Account_Type_ID == 3) { // счет потрат
						$costs = $value->Account_Number;
					}

					if($value->Account_Type_ID == 6) { //id лапши
						$noodles = floor($value->Balance);
					}
				}

				//transactions
				$actionTransaction = "account_transactions";
				$searchTransaction = "account_number";
				$resultTransaction = curlCrm($token, $actionTransaction, $searchTransaction, $costs);
			}

			//Лапша
			?>
			<div class="d-flex flex-row p-1">
			<?php
			for($i = 1; $i <= $noodles; $i++) { ?>
				<div class="noodle_width pb-1 pt-1">
					<img class="img-fluid" src="<?=SITE?>img\noodles-box.png" alt="noodles">
				</div>
			<?php }
				echo '</div>';
			?>
<div id="accordion">
  <div class="card mb-1">
    <div class="card-header p-0" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-danger collapsed btn-block font-weight-bold" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
        	Личная информация
        </button>
      </h5>
    </div>

    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
			<div class="col-12 mx-auto jumbotron">
				<form method="POST" action="<?=SITE?>cabinet/edit_info.php">
					<div class="form-group row">
						<label for="surname" class="col-3 col-form-label pr-0 pl-0">Фамилия</label>
						<div class="col-9">
							<input type="text" class="form-control" id="surname" name="surname" placeholder="Ваша фамилия" required value="<?=$surname?>">
						</div>
					</div>
					<div class="form-group row">
						<label for="name" class="col-3 col-form-label pr-0 pl-0">Имя</label>
						<div class="col-9">
							<input type="text" class="form-control" id="name" name="name" placeholder="Ваше имя" required value="<?=$name?>">
						</div>
					</div>
					<div class="form-group row">
						<label for="patronymic" class="col-3 col-form-label pr-0 pl-0">Отчество</label>
						<div class="col-9">
							<input type="text" class="form-control" id="patronymic" name="patronymic" placeholder="Ваше отчество" required value="<?=$patronymic?>">
						</div>
					</div>
					<hr class="my-1">
					<div class="form-group">
						<label for="phone">Телефон</label>
						<input type="tel" class="form-control" id="phone" placeholder="Ваш телефон" required value="<?=$_SESSION['phone']?>" readonly>
					</div>
					<div class="form-group">
						<label for="birth">Дата рождения</label>
						<input type="date" class="form-control" id="birth" name="birth" required value="<?=$calendDate?>" readonly>
					</div>
					<hr class="my-1">
					<div><label for="male">Выберите пол</label></div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="sex" id="male" value="Male" <?php
							if($gender == 'Male') {
								echo 'checked';
							}
						?>>
						<label class="form-check-label" for="male">Мужской</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="sex" id="female" value="Female" 
						<?php
							if($gender == 'Female') {
								echo 'checked';
							}
						?>>
						<label class="form-check-label" for="female">Женский</label>
					</div>
					<hr class="my-1">
					<div><label for="marrital">Женат/замужем</label></div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="marrital" id="marrital" value="Yes" <?php
							if($marrital == 'Yes') {
								echo 'checked';
							}
						?>>
						<label class="form-check-label" for="marrital">Да</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="marrital" id="no_marrital" value="No" <?php
							if($marrital == 'No') {
								echo 'checked';
							}
						?>>
						<label class="form-check-label" for="no_marrital">Нет</label>
					</div>
					<div class="text-center m-2">
					<button type="submit" class="btn btn-primary" name="editUser">Изменить данные</button>
				</div>
				</form>
			</div>
    </div>
  </div>

  <div class="card mb-1">
  	<div class="card-header p-0" id="headingTwo">
  		<h5 class="mb-0">
  			<button class="btn btn-danger collapsed btn-block font-weight-bold" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
  				Счета
  			</button>
  		</h5>
  	</div>

  	<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
  		<div class="card-body pr-0 pl-0">
  			<table class="table table-striped">
  				<thead>
  					<tr>
  						<th scope="col" class="p-0 text-center">Тип счета</th>
  						<th scope="col" class="p-0 text-center">Баланс</th>
  					</tr>
  				</thead>
  				<tbody>
  					<?php
  					foreach ($result->Accounts as $value) {
  						echo '<tr>';
	  						echo '<td>'.$value->Account_Type_Name.'</td>';
	  						echo '<td>'.$value->Balance.'</td>';
  						echo '</tr>';
  					}
  					?>
  				</tbody>
  			</table>
  		</div>
  	</div>
  </div>

  <div class="card mb-1">
    <div class="card-header p-0" id="headingThree">
      <h5 class="mb-0">
        <button class="btn btn-danger collapsed btn-block font-weight-bold" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Купоны
        </button>
      </h5>
    </div>

    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
      <div class="card-body pr-0 pl-0">
        <table class="table table-striped">
  				<thead>
  					<tr>
  						<th scope="col" class="p-0 text-center">Купон</th>
  						<th scope="col" class="p-0 text-center">Начало</th>
  						<th scope="col" class="p-0 text-center">Окончание</th>
  					</tr>
  				</thead>
  				<tbody>
  					<?php
  					foreach ($result->Coupons as $value) {
  						$prepareCouponOffered = date_create($value->Offered);
  						$couponOffered = date_format($prepareCouponOffered, 'd-m-Y');
  						$prepareCouponExpired = date_create($value->Expired);
  						$couponExpired = date_format($prepareCouponExpired, 'd-m-Y');
  						echo '<tr>';
	  						echo '<td class="w-25 pr-0 pl-0 text-center">'.$value->Coupon_Type_Name.'</td>';
	  						echo '<td class="text-center">'.$couponOffered.'</td>';
	  						echo '<td class="pr-0 pl-0 text-center">'.$couponExpired.'</td>';
  						echo '</tr>';
  					}
  					?>
  				</tbody>
  			</table>
      </div>
    </div>
  </div>

  <div class="card mb-1">
    <div class="card-header p-0" id="headingFour">
      <h5 class="mb-0">
        <button class="btn btn-danger collapsed btn-block font-weight-bold" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
          Транзакции
        </button>
      </h5>
    </div>

    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
    	<div class="card-body pr-0 pl-0">
    		<table class="table table-striped">
    			<thead>
    				<tr>
    					<th scope="col" class="p-0 text-center">№</th>
    					<th scope="col" class="p-0 text-center">Время</th>
    					<th scope="col" class="p-0 text-center">Сумма</th>
    					<th scope="col" class="p-0 text-center">Чек</th>
    				</tr>
    			</thead>
    			<tbody>
    				<?php
    				$count = 1;
    				foreach ($resultTransaction->Transactions as $value) {
    					$prepareTransactionTime = date_create($value->Transaction_Time);
    					$transactionTime = date_format($prepareTransactionTime, 'd-m-Y H:i:s');
    					$sum = $value->Summ;
    					$transactionId = $value->Transaction_ID;
   						$dopInfo = $value->Dop_Info; // есть ли чек
    					echo '<tr>';
	    					echo '<th scope="row" class="pr-0">'.$count.'</th>';
	    					echo '<td class="text-center pr-0 pl-0">'.$transactionTime.'</td>';
	    					echo '<td class="text-center pr-0 pl-0">'.$sum.'</td>';
	    					if ($dopInfo) {
	    						echo '<td class="text-center"><button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#check_'.$transactionId.'">Чек</button></td>';
	    					} else {
	    						echo '<td class="text-center pr-0 pl-0"></td>';
	    					}
    					echo '</tr>';
    					$count++; ?>
    				<?php } ?>
    			</tbody>
    		</table>
    	</div>

    	<!-- Чек -->
    	<?php foreach ($resultTransaction->Transactions as $value) {
    		$dopInfo = $value->Dop_Info; // есть ли чек
    		$transactionId = $value->Transaction_ID;
    		$prepareCheckTime = date_create($value->checkTime);
    		$checkTime = date_format($prepareCheckTime, 'd-m-Y H:i:s');
    		$checkNum = $value->check->checknum;
    		$checkOrder = $value->check->ordernum;
    		$checkAll = $value->check->lines;
    		$discountsAll = $value->check->discounts;
    		$total = $value->check->total;
    		$paymentsAll = $value->check->payments;
    		if ($dopInfo) { ?>
    			<div class="modal fade" id="check_<?=$transactionId?>" tabindex="-1" role="dialog" aria-labelledby="CheckModal<?=$transactionId?>" aria-hidden="true">
    				<div class="modal-dialog modal-dialog-centered" role="document">
    					<div class="modal-content">
    						<div class="modal-header">
    							<h5 class="modal-title" id="CheckModal<?=$transactionId?>">Чек <span class="font-weight-bold"><?=$checkNum?></span></h5>
    							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    								<span aria-hidden="true">&times;</span>
    							</button>
    						</div>
    						<div class="modal-body">
    							<div>Дата: <span class="font-weight-bold"><?=str_replace('T', ' ', $checkTime)?></span></div>
    							<div>Заказ: <span class="font-weight-bold"><?=$checkOrder?></span></div>
    							<table class="table table-striped table-sm">
    								<thead>
    									<tr>
    										<th scope="col" class="p-0 text-center">Название</th>
    										<th scope="col" class="p-0 text-center">Цена</th>
    										<th scope="col" class="p-0 text-center">Кол</th>
    										<th scope="col" class="p-0 text-center">Сумма</th>
    									</tr>
    								</thead>
    								<tbody>
    									<?php
    									foreach ($checkAll as $dish) {
    										$dishName = $dish->name;
    										$dishPrice = $dish->price;
    										$dishQuantity = $dish->quantity;
    										$dishSum = $dish->sum;
    										echo '<tr>';
	    										echo '<td class="pr-0 pl-0 text-center">'.$dishName.'</td>';
	    										echo '<td class="pr-0 pl-0 text-center">'.$dishPrice.'</td>';
	    										echo '<td class="pr-0 pl-0 text-center">'.$dishQuantity.'</td>';
	    										echo '<td class="pr-0 pl-0 text-center">'.$dishSum.'</td>';
    										echo '</tr>';
    									}
    									if ($discountsAll) {
    										foreach ($discountsAll as $discount) {
    											$discountName = $discount->name;
    											$discountSum = $discount->sum;
    											echo '<tr class="font-italic">';
	    											echo '<td colspan="3">'.$discountName.'</td>';
	    											echo '<td>'.$discountSum.'</td>';
    											echo '</tr>';
    										}
    									}
	    									echo '<tr>';
	    										echo '<td class="font-weight-bold" colspan="3">Всего</td>';
	    										echo '<td class="font-weight-bold">'.$total.'</td>';
	    									echo '</tr>';
	    								if ($paymentsAll) {
    										foreach ($paymentsAll as $payment) {
    											$paymentName = $payment->name;
    											$paymentSum = $payment->sum;
    											echo '<tr class="font-italic">';
	    											echo '<td colspan="3">'.$paymentName.'</td>';
	    											echo '<td>'.$paymentSum.'</td>';
    											echo '</tr>';
    										}
    									}
    									?>
    								</tbody>
    							</table>
    						</div>
    						<div class="modal-footer">
    							<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
    						</div>
    					</div>
    				</div>
    			</div>
    		<?php }
    	}?>
    </div>
</div>

</div>

	<script src="js/jquery-3.5.1.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>		
</body>
</html>