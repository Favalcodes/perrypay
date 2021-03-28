<?php
session_start();

include 'database.php';


if (isset($_POST['proceed'])) {
    $amount = $_POST['amount'];
    $email = $_POST['email'];
    $coin = $_POST['coin'];
    $coin_amount = $_POST['coin_amount'];

    $wal = "SELECT * FROM transactions where email = '$_SESSION[email]' and coin = '$coin'";
    $out = $link->query($wal) or die("Error: " . mysqli_error($link));
    
    
    while ($table = mysqli_fetch_array($out)) {
        $wallet_coin = $table['coin_amount'];
    }

    echo "Redirecting, please wait ....";

    if ($coin_amount < $wallet_coin) {

        $check = "SELECT * FROM withdraw where email = '$email' and coin = '$coin'";
        $output = $link->query($check) or die("Error: " . mysqli_error($link));

        $update = date('Y-m-d H:i:s');
            $sql = "INSERT INTO withdraw (email, amount, coin, coin_amount, updated_at) VALUES ('$email', '$amount', '$coin', '$coin_amount', '$update')";

        $wallet_money = $wallet_coin - $coin_amount;
        if (mysqli_query($link, $sql)) {
        $save = "UPDATE transactions SET coin_amount = '$wallet_money', updated_at = '$update' WHERE email = '$email' and coin = '$coin'";
            if(mysqli_query($link, $save)){
            echo '<script>alert("Withdraw Successfully");
            window.location.href="index.php"</script>';
            //    header("location: index.php");
            }
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
    } else {
        echo '<script>alert("Insufficient Balance");
        window.location.href="index.php"</script>';
    }
}
