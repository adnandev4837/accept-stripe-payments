<?php
require_once('vendor/autoload.php'); // Include the Stripe PHP library

$secret_key = $_POST['secret_key'];

\Stripe\Stripe::setApiKey($secret_key); // Set your Stripe secret API key

header('Content-Type: application/json');

$currency = $_POST['currency'];
$token_id = $_POST['token_id'];
$description=$_POST['description'];
$amount = $_POST['amount'];

try {
  // Create a charge or payment intent using the Stripe API
  $charge = \Stripe\Charge::create([
    'amount' => $amount,
    'currency' => $currency,
    'source' => $token_id,
    'description' => $description,
  ]);

  // Payment was successful
  // You can handle any additional logic here, such as updating a database or sending confirmation emails

  http_response_code(200);
  echo json_encode(['message' => 'Payment successful']);
} catch (Exception $e) {
  // Payment failed
  // You can handle the error here and return an appropriate response

  http_response_code(500);
  echo json_encode(['error' => 'Payment failed']);
}
