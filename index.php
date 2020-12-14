<?php
$domains = ['http://test.damprodam.ru/', 'https://yaneedex.ru', 'http://www.google.com'];
// $url = 'http://test.damprodam.ru/';
function isSiteAvailable($url) {
  
  if (!filter_var($url, FILTER_VALIDATE_URL)) {
    return false;
  }

  $curlInit = curl_init($url);

    // Установка параметров запроса

  curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10); // кол-во секунд ожидания
  curl_setopt($curlInit, CURLOPT_HEADER, true); // включения заголовков в вывод
  curl_setopt($curlInit, CURLOPT_NOBODY, true); //исключение тела ответа из вывода
  curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, true); // возврат результата передачи в качестве строки из curl_exec() вместо прямого вывода в браузер.

  curl_exec($curlInit);
  // Получение ответа
  // $response = curl_exec($curlInit); // Выполняет запрос cURL
  // print_r($response);
  // echo $response;

  // /// закрываем CURL
  // curl_close($curlInit);

  // return $response ? true : false;

  $httpCode = curl_getinfo($curlInit, CURLINFO_HTTP_CODE);
  curl_close($curlInit);

  return $httpCode;
}
// $check = isSiteAvailable($url);

$mass = [];
foreach ($domains as $index => $url) {
  $check = isSiteAvailable($url);

  if ($check != 200) {

  $off = "Сайт " . $url . " не доступен " . date('d.m.Y H:i:s');
  array_push($mass, $off);
}
}
  // print_r($mass);
$sites = implode(", ", $mass);
  file_put_contents('unev.php', $sites);

  sendMessage('@test_analyzer_irormlg', $sites, '1452762121:AAF66kR5JyrzcRoLtrSnTDSwhSlUs-zGxEc',);


// if(isSiteAvailable(($url))) {
//   $on = 'Сайт доступен';
// } else {
//   $off = 'Сайт не доступен ' . date('d.m.Y H:i:s');
//   // sendMessage('@test_analyzer_irormlg', $off, '1452762121:AAF66kR5JyrzcRoLtrSnTDSwhSlUs-zGxEc',);
// }

// скрипт для вывода сообщения в телеграмм
function sendMessage($chatID, $messaggio, $token) {


    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID;
    $url = $url . "&text=" . urlencode($messaggio);
    $ch = curl_init();
    $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $optArray);
    $result = curl_exec($ch);
    curl_close($ch);
		return $result;
};

// sendMessage('@test_analyzer_irormlg', $off, '1452762121:AAF66kR5JyrzcRoLtrSnTDSwhSlUs-zGxEc',);