<?php
// выбрать карту для проверки
function findCard($card)
{
	global $pdo;
	$query = "SELECT * FROM users WHERE card = :card LIMIT 1";
	$params = [
		':card' => $card
	];
	$stmt = $pdo->prepare($query);
	$stmt->execute($params);
	while ($row = $stmt->fetch())
	{
		$user_card[] = $row;
	}
	return $user_card;
}
// ****************************************************	

// выбрать карту для проверки
function findPhone($phone)
{
	global $pdo;
	$query = "SELECT * FROM users WHERE phone = :phone LIMIT 1";
	$params = [
		':phone' => $phone
	];
	$stmt = $pdo->prepare($query);
	$stmt->execute($params);
	while ($row = $stmt->fetch())
	{
		$user_phone[] = $row;
	}
	return $user_phone;
}
// ****************************************************	

// маска телефона
function maskPhone($phone) {
	$result = preg_replace('#\D#', '', $phone);
	$result = preg_replace('#^(38071|8071)#', '071', $result);
	$phoneLength = strlen($result);
	if ($phoneLength >= 10) {
		return $result;
	}
}

// объект в массив
function object_to_array($data)
{
    if (is_array($data) || is_object($data))
    {
        $result = array();
        foreach ($data as $key => $value)
        {
            $result[$key] = object_to_array($value);
        }
        return $result;
    }
    return $data;
}
// ****************************************************	

// curl
function curlCrm($token, $action, $searchAction, $search)
{
	$data = array("token" => $token,
		"request" => array("action" => "$action", "$searchAction" => "$search")
	); 
	$data_string = json_encode ($data, JSON_UNESCAPED_UNICODE);
	$curl = curl_init(CRM);                                        
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: ' . strlen($data_string))
);
	$result = curl_exec($curl);
	curl_close($curl);
	$result = json_decode($result);
	return $result;
}
// ****************************************************

// curl edit CRM
function EditCurlToCrm($token, $action, $result)
{
$dataEditHolder = array("token" => $token,
	"request" => array("action" => "$action", "data" => object_to_array($result))
); 
$data_stringEditHolder = json_encode ($dataEditHolder, JSON_UNESCAPED_UNICODE);
$curl = curl_init(CRM);                                        
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_stringEditHolder);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	'Content-Type: application/json',
	'Content-Length: ' . strlen($data_stringEditHolder))
);
$holderEditResult = curl_exec($curl);
return $holderEditResult;
curl_close($curl);
}
// ****************************************************

// send sms ПЕРЕМЕННЫЕ С БОЛЬШИХ БУКВ
function sendSms($Phone, $Text)
{
	$data = compact("Phone", "Text");
	$data_string = json_encode($data); 
	$ch = curl_init(SMS);                                        
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                      
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                     
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                        
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                     
		'Content-Type: application/json',                                                                                
		'Content-Length: ' . strlen($data_string))                                     
	);                                                                                                    
	$result = curl_exec($ch);
	$json = file_get_contents('php://input');
	$obj = json_decode($json);
}

?>