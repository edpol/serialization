# Samples

    Assume your URL is http://your-url.com

### Login
```
    $body = array("username"=>"username", "password"=>"password");
    $post_data = http_build_query($body, '', '&');
    $header[] = "Accept: application/json";

    $ch = curl_init("http://your-url.com/api/login");
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
```

### Create
```
    $body = ["product"=>"(product number)", "max_serial"=>(max serial number)];
    $post_data = http_build_query($body, '', '&');
    $header[] = "Accept: application/json";
    $header[] = "Authorization: Bearer (token)";

    $ch = curl_init("http://your-url.com/api/v1/products/create");
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
    echo "Status:        " . $result->status                   . "<br />\n";
    echo "SKU:           " . $result->data->product->sku       . "<br />\n";
    echo "Max Serial:    " . $result->data->product->max_serial. "<br />\n";
```

### Reserve
```
    $body = ["serial_number"=>(serial number)];
    $post_data = http_build_query($body, '', '&');
    $header[] = "Accept: application/json";
    $header[] = "Authorization: Bearer (token)";

    $ch = curl_init("http://your-url.com/api/v1/serial_numbers/{product number}/reserve");
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
    echo "Status:        " . $result->status                   . "<br />\n";
    echo "Serial Number: " . $result->data->serial_number      . "<br />\n";
```

### Release
```
    $body = nothing
    $post_data = http_build_query($body, '', '&');
    $header[] = "Accept: application/json";
    $header[] = "Authorization: Bearer (token)";

    $ch = curl_init("http://your-url.com/api/v1/serial_numbers/{product number}/{serial number}/release");
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
    echo "Status:        " . $result->status                   . "<br />\n";
    echo "Serial Number: " . $result->data->serial_number      . "<br />\n";
```

### Status
```
    $header[] = "Accept: application/json";
    $header[] = "Authorization: Bearer (token)";

    $ch = curl_init("http://your-url.com/api/v1/serial_numbers/(product number)/(serial number)/status");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
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
    echo "Status:        " . $result->status              . "<br />\n";
    echo "SKU:           " . $result->data->sku           . "<br />\n";
    echo "Serial Number: " . $result->data->serial_number . "<br />\n";
    echo "Available:     " . $result->data->available     . "<br />\n";
```
