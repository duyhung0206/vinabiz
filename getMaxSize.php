<?php
$url = 'https://vinabiz.org/company';
//// create a new cURL resource
$curl = curl_init($url);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

curl_setopt($curl, CURLOPT_PUT, FALSE);
curl_setopt($curl, CURLOPT_POST, FALSE);
$homepage = curl_exec($curl);
curl_close($curl);
$stringToGetSize = 'Page 1 of';

$pos = strpos($homepage,$stringToGetSize);
$maxSize = '';
$i= $pos + 10;
while ($homepage[$i] != '.'){
    $maxSize .= $homepage[$i];
    $i++;
}
echo $maxSize;

?>