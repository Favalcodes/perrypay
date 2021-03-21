<?php

$ref = $_GET['reference'];
if($ref == ""){
    header("Location:javascript://history.go(-1)");
}
?>
<?php
  $curl = curl_init();
  
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($ref),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Authorization: Bearer sk_test_15936676a105e941a0fc1b94bba26f80f42e536c",
      "Cache-Control: no-cache",
    ),
  ));
  
  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  
  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    // echo $response;
    $result = json_decode($response);
  }
  if($result->data->status == "success"){
    $status = $result->data->status;
    $reference = $result->data->reference;
    $lname = $result->data->customer->last_name;
    $fname = $result->data->customer->first_name;
    $fullname = $fname . " " . $lname;
    $customer_email = $result->data->customer->email;
    date_default_timezone_set("Africa/Lagos");
    $Date_time = date('m/d/Y h:i:s a', time());

    include("../config.php");

    $stmt = $pdo->prepare("INSERT into customer_details(status, reference, fullname, date_processed, email) VALUES(?, ?, ?, ?, ?)");

    $stmt->bindParam("s", $status, PDO::PARAM_STR);
    $stmt->bindParam("s", $reference, PDO::PARAM_STR);
    $stmt->bindParam("s", $fullname, PDO::PARAM_STR);
    $stmt->bindParam("s", $Date_time, PDO::PARAM_STR);
    $stmt->bindParam("s", $customer_email, PDO::PARAM_STR);
    $stmt->execute();

    if(!$stmt) {
        echo "There was a problem in your code" . mysqli_error($pdo);
    } else {
        header("location: success.php?status=success");
        exit;
    }
    $stmt->close();

  }else{
    header("location: error.html");
    exit;
  }
?>