<?php
session_start();

include 'database.php';

$wal = "SELECT * FROM wallet where email = '$_SESSION[email]'";
$out = $link->query($wal) or die("Error: " . mysqli_error($link));


while ($table = mysqli_fetch_array($out)) {
    $wallet = $table['amount'];
}

if (isset($_POST['proceed'])) {
    $amount = $_POST['amount'];
    $email = $_POST['email'];
    $coin = $_POST['coin'];
    $coin_amount = $_POST['coin_amount'];

    $initial_amount = $amount;
    $wall_money = $wallet - $initial_amount;
    echo "Redirecting, please wait ....";

    if ($amount < $wallet) {

        $check = "SELECT * FROM transactions where email = '$email' and coin = '$coin'";
        $output = $link->query($check) or die("Error: " . mysqli_error($link));
        $update = date('Y-m-d H:i:s');

        if (mysqli_num_rows($output) === 0) {

            $sql = "INSERT INTO transactions (email, amount, coin, coin_amount, updated_at) VALUES ('$email', '$amount', '$coin', '$coin_amount', '$update')";
        } elseif (mysqli_num_rows($output) === 1) {
            while ($tab = mysqli_fetch_array($output)) {
                $money = $tab['coin_amount'];
                $coin_amount += $money;
                $amt = $tab['amount'];
                $amount += $amt;
            }
            $sql = "UPDATE transactions SET coin_amount = '$coin_amount', amount = '$amount', updated_at = '$update'  WHERE email = '$email' and coin = '$coin'";
        }


        if (mysqli_query($link, $sql)) {
            $save = "UPDATE wallet SET amount = '$wall_money', updated_at = '$update' WHERE email = '$email'";
            if(mysqli_query($link, $save)){
            echo '<script>alert("Coin Bought Successfully");
            window.location.href="index.php"</script>';
            }
            //    header("location: index.php");
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
    } else {
        echo '<script>alert("Insufficient Balance");
        window.location.href="index.php"</script>';
    }
}
