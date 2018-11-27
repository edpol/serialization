<?php
    $body = ["product"=>"390653", "max_serial"=>5];
    $post_data = http_build_query($body, '', '&');
    $header[] = "Accept: application/json";
    $header[] = "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImIyZGFlNmFmZWE1MWJkMDk4Y2JlZGVkMDBlNWQyZGM3YTgzMjcyYWVkNDlmYTg4NDU5YmM3ZmJlNTlhZjkyZjFlM2IyMTQ0ODgxY2UxZDQzIn0.eyJhdWQiOiIxIiwianRpIjoiYjJkYWU2YWZlYTUxYmQwOThjYmVkZWQwMGU1ZDJkYzdhODMyNzJhZWQ0OWZhODg0NTliYzdmYmU1OWFmOTJmMWUzYjIxNDQ4ODFjZTFkNDMiLCJpYXQiOjE1MjcwMDYzMjQsIm5iZiI6MTUyNzAwNjMyNCwiZXhwIjoxNTU4NTQyMzI0LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.PtIRRFX-avOcme0ZqhAXEpvCockwRBs0zuFJL0hAHN1yc_1J6Bcg6tau2ypImUN6IhAG_uBEUktCzBsArg3UqhpYqLbNNkFe2RZO4qBh7hkN0sD9DZFtOO-C_75L70TQTi4nNQ3WVT3TOofx-rM4muW0KPacK2fKVjsBEe4i00jFVHGq4X-W2iVY-JRIU_gAjtkkQbsCeORfNo5ezMalwUCGuPjRWHFzsDxVp7_OAqZpjKteGrqgl7yM2aPMHFEJsxxPM4aaK8mElzlZUW94IObjfC7ZDnROXMrTU7Vu9l6UdhmLYoUMSfq1fCQHS5xvdiZO4NNjfUVt7Dk4oj_kE0HXqnvUZPYiZHgDZHmZ88iJPkN-qPEyEmWNKingJHhaQMf7HSeNdtCjtKiOOXax7l2kcltbP-0ZORL8JOZ3eXUDnJvM8URswbR2F_vJifnXWRbnG2BGoNz2HGMrb-m50p3n_F4gwi0tpwOHlsUR4d0RJ937YJNfy8nBetWgfN3w-5fM9e6XIQEhnJHIl3TaLaEjZ3Xq0A_nfB61tTzyYHcPofouWo4Up7YMWM9s3vUugPqZYsvC2i5kTuxU2y6KxLx2hawoLtgzmOUMnXL5YDlEGyK6YFokezge08mXHL6bvnSUy9_psiWZxcFeKQWZIPhBkHLOQ-5ffHCgA20sbVI";

    $ch = curl_init("http://pss.loc/api/v1/products/create");
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
 
?>