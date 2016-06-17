<?php

//Check location is present or not
if (empty($_GET['location'])) {
    return json_encode(array("error" => true, "errorMessage" => "Location is mandatory"));
}

require_once('weatherApi.php');

//create object to weatherApi class
$weatherApiObj = new weatherApi($_GET['location']);

//echo result
echo $weatherApiObj->getResult();
