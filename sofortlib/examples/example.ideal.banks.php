<?php
require_once(dirname(__FILE__).'/../ideal/sofortLibIdealBanks.inc.php');

// enter your configuration key – you only can create a new configuration key by creating
// a new Gateway project in your account at sofort.com
$SofortLibIdealBanks = new SofortLibIdealBanks('12345:123456:edc788a4316ce7e2ac0ede037aa623d7');

$SofortLibIdealBanks->sendRequest();

print_r($SofortLibIdealBanks->getBanks());
