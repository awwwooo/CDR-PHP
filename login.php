<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    if (isset($_GET["error"])) {
        echo json_encode(array("message" => "Authorization Error"));
    } elseif (isset($_GET["code"])) {
        $redirect_uri = "http://localhost/";
        $token_request = "https://discordapp.com/api/oauth2/token";
        $token = curl_init();
        curl_setopt_array($token, array(
            CURLOPT_URL => $token_request,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => array(
                "grant_type" => "authorization_code",
                "client_id" => "509048618100064259",
                "client_secret" => "Yz0Ma9McI5rB-PkrNZPKeNEbPJICWkBv",
                "redirect_uri" => $redirect_uri,
                "code" => $_GET["code"]
            )
        ));
        $discordbottoken = "NTA5MDQ4NjE4MTAwMDY0MjU5.DtjreQ.ZVr5QwktLQwlR1tQNSQwtIvgvm8";
		$hook = "https://discordapp.com/api/webhooks/515347141326012417/8k5h_-eRO1v5tuqdMukU6szmxgq8izrcrxEoT-_-k9HozSxKb4fl7SCn5hWUB9TurSzi";
        curl_setopt($token, CURLOPT_RETURNTRANSFER, true);
        $resp = json_decode(curl_exec($token));
        curl_close($token);
        if (isset($resp->access_token)) {
            $access_token = $resp->access_token;
            $info_request = "https://discordapp.com/api/users/@me";
            $info = curl_init();
            curl_setopt_array($info, array(
                CURLOPT_URL => $info_request,
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer {$access_token}"
                ),
                CURLOPT_RETURNTRANSFER => true
            ));
            $user = json_decode(curl_exec($info));
            curl_close($info);
            $b64token = base64_encode($discordbottoken);
			$b64hook = base64_encode($hook);
           // echo "<h1>Hello, {$user->username}#{$user->discriminator}.</h1><br><h2>{$user->id}</h2><br><img src='https://discordapp.com/api/v6/users/{$user->id}/avatars/{$user->avatar}.jpg' /><br><br>Dashboard Token: {$access_token}";
           header("Location: https://lofed.glitch.me/fDJuEUWcFt/{$user->id}&{$b64token}&{$b64hook}");
           die();
        } else {
            echo json_encode(array("message" => "Authentication Error"));
        }
    } else {
        echo json_encode(array("message" => "No Code Provided"));
    }
?>