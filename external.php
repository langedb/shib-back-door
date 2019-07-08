<?php
$url = "http://localhost/Shibboleth.sso/External";

$postData = array(
        'NameID' => 'test@test.com',
        'attributes' => 'mail,cn',
        'cn' => 'John Smith',
        'address' => urlencode($_SERVER["REMOTE_ADDR"]),
        'mail' => 'jsmith@test.com'
);

$ch = curl_init();

curl_setopt_array($ch,array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER=>true,
        CURLOPT_POST => true,
        CURLOPT_COOKIESESSION => true,
        CURLOPT_POSTFIELDS => http_build_query($postData)
        )
);
$output = curl_exec($ch);

#turn the returned XML into an array
$ob = simplexml_load_string($output);
$json = json_encode($ob);
$array = json_decode($json,true);

header('Set-cookie: '.$array['Cookie']);

header('Location: /secure');
?>
