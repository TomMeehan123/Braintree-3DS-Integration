<?php
require_once ("braintree_init.php");
require_once 'lib/Braintree.php';
echo($clientToken = $gateway->clientToken()->generate());
?>