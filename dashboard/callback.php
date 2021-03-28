<?php

include 'database.php';

$curl = curl_init();
$reference = isset($_GET['reference']) ? $_GET['reference'] : '';
if(!$reference){
  die('No reference supplied');
}

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => [
    "accept: application/json",
    "authorization: Bearer sk_test_15936676a105e941a0fc1b94bba26f80f42e536c",
    "cache-control: no-cache"
  ],
));

$response = curl_exec($curl);
$err = curl_error($curl);

if($err){
    // there was an error contacting the Paystack API
  die('Curl returned error: ' . $err);
}

$tranx = json_decode($response);

if(!$tranx->status){
  // there was an error from the API
  die('API returned error: ' . $tranx->message);
}

if('success' == $tranx->data->status){
  // transaction was successful...
  // please check other things like whether you already gave value for this ref
  // if the email matches the customer who owns the product etc
  // Give value
 $refer = $tranx->data->reference;
 $status = $tranx->data->status;
 $amt = $tranx->data->amount;
 $channel = $tranx->data->channel;
 $email = $tranx->data->customer->email;
 $amount = $amt/100;
 $ref = 'PPs'.$refer;

 $check = "SELECT * FROM wallet where email = '$email'";
 $output = $link->query($check) or die("Error: " . mysqli_error($link));

 if(mysqli_num_rows($output) === 0){

 $sql = "INSERT INTO wallet (email, amount, status, ref, channel) VALUES ('$email', '$amount', '$status', '$ref', '$channel')";
 } elseif(mysqli_num_rows($output) === 1){
    while($tab = mysqli_fetch_array($output)){
        $money = $tab['amount'];
        $amount += $money;
    }
    $sql = "UPDATE wallet SET amount='$amount' WHERE email = '$email'";
 }
 if(mysqli_query($link, $sql)){
    header("location: index.php");
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

//   if ($stmt = mysqli_prepare($link, $sql)) {
//     // Bind variables to the prepared statement as parameters
//     mysqli_stmt_bind_param($stmt, "sssss", $param_amount, $param_email, $param_status, $param_ref, $param_channel);

//     // Set parameters
//     $param_amount = $amount;
//     $param_email = $email;
//     $param_status = $status;
//     $param_ref = $ref;
//     $param_channel = $channel;

//     // Attempt to execute the prepared statement
//     if (mysqli_stmt_execute($stmt)) {
//         // Redirect to dashboard page
//         header("location: index.php");
//     } else {
//         echo "Something went wrong. Please try again later.";
//     }

//     // Close statement
//     mysqli_stmt_close($stmt);
// }
}
