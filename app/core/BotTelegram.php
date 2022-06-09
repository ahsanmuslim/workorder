<?php

require_once ('../app/config/config.php');

class BotTelegram {

    //Fungsi untuk mengirim pesan ke user
    public static function sendMessage ($pesan, $chat_id) {
        
        $API = "https://api.telegram.org/bot".BOT_TOKEN."/sendmessage?parse_mode=markdown&chat_id=". $chat_id ."&text=". urlencode($pesan);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_URL, $API);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
        
    }

    //fungsi untuk mengirim foto Telegram 
    public static function sendPhoto ($chatid, $urlphoto, $caption) {

        $url = "https://api.telegram.org/bot" . BOT_TOKEN . "/sendPhoto";

        $content = [ 
            'chat_id' => $chatid, 
            'photo' => new CURLFile(realpath($urlphoto)), 
            'caption' => $caption
        ];

        // print_r($content);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($curl, CURLOPT_HTTPHEADER,array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $json_response = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // if ( $status != 201 ) {
        //     die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
        // }


        curl_close($curl);

        $response = json_decode($json_response, true);
        return $response;

    }


}
