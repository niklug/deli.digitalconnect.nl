<?php

$url = $_GET['data_url'];



$strResponse = httpGetRequest($url);
    $aResponse = explode('|', $strResponse);
# Bad response
    if (!isset($aResponse[1]))
        die('Error' . $aResponse[0]);
    $responsetype = explode(' ', $aResponse[0]);
    $trxid = $responsetype[1];
// Hier kunt u het transactie id aan uw order toevoegen.
    if ($responsetype[0] == "000000")
        die($aResponse[1]);
    else
        die($aResponse[0]);


function httpGetRequest($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $strResponse = curl_exec($ch);
    curl_close($ch);
    if ($strResponse === false)
        die("Could not fetch response " . $url);
    return $strResponse;
}

?>