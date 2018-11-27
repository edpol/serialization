<?php
    $body = array("username"=>"epol", "password"=>"momoney");
    $post_data = http_build_query($body, '', '&');
    $header[] = "Accept: application/json";

    $ch = curl_init("http://pss.loc/api/login");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    $serverOutput = curl_exec($ch);

    if($serverOutput === false) {
        echo 'Curl error: ' . curl_error($ch);
    } else {
        echo "Operation completed without any errors<br />\n";
        echo $serverOutput . "<br />\n";
    }

    curl_close($ch);

    $result = json_decode($serverOutput);
    echo "Status:        " . $result->status            . "<br />\n";
    echo "Token:         " . $result->data->token       . "<br />\n";

?>