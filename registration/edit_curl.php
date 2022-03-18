<?php
// Записываю в CRM
// Получаю ID владельца
$token = TOKEN;
$cardAction = "card_info";
$searchAction = "card_code";
$searchHolder = "holder_id";
$holderAction = "holder_info";
$editAction = "edit_holder";

$result = curlCrm($token, $cardAction, $searchAction, $card);
foreach ($result->Holders as $value) {
	$holderId = $value->Holder_ID;
}

//Получаю данные по ID
$holderResult = curlCrm($token, $holderAction, $searchHolder, $holderId);

//изменяю данные
if(isset($holderResult->Accounts)) {
	unset($holderResult->Accounts);
}
if(isset($holderResult->Addresses)) {
	unset($holderResult->Addresses);
}
if(isset($holderResult->Cards)) {
	unset($holderResult->Cards);
}
if(isset($holderResult->Contacts)) {
	unset($holderResult->Contacts);
}
if(isset($holderResult->Coupons)) {
	unset($holderResult->Coupons);
}
if(isset($holderResult->Holder)) {
	$date = date_create($age);
	$holderResult->Holder->Birth = date_format($date, 'Y-m-d');
	$holderResult->Holder->F_Name = $name;
	$holderResult->Holder->Full_Name = $surname . ' ' . $name;
	$holderResult->Holder->Gender = $sex;
	$holderResult->Holder->L_Name = $surname;
	$holderResult->Holder->M_Name = $patronymic;
	$holderResult->Holder->Marrital = $marrital;
}

//измененные данные отправляю в CRM

$holderEditResult = EditCurlToCrm($token, $editAction, $holderResult);

?>