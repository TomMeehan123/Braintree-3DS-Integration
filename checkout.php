<?php
require_once ("braintree_init.php");
//require_once ("index.php");
require_once 'lib/Braintree.php';
echo json_encode($_POST);

$nonceFromTheClient = $_POST["payment_method_nonce"];
$amount = $_POST['amount'];
$dataFromDevice = $_POST['device_data'];
$result = $gateway->transaction()->sale([
    'amount' => '10.00',
    'paymentMethodNonce' => $nonceFromTheClient,
    'options' => [
    'submitForSettlement' => True,
    ],
    'deviceData' => $dataFromDevice
  ]);
  
  if ($result->success) {
    print_r("Successfull!!!!". json_encode($result));
   // console.log($result);
    // See $result->transaction for details
  } else {
    // Handle errors
    print_r("Failed");
  }

echo($result);
?>