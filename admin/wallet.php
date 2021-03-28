<?php

// Initialize the session
session_start();

if (isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === true) {
    $user = true;
}
if (isset($_COOKIE["active"]) || isset($_COOKIE["id"]) || isset($_COOKIE["email"])) {
    $user = true;
}
if (isset($_SESSION['access_token'])) {
    $user = true;
}
if ($user !== true) {
    header("location: index.php");
    exit();
}

// Include config file
// require_once "../config.php";

include 'database.php';

$email = $_SESSION['email'];
$errors = [];

$em = $_SESSION['email'];

$con = "SELECT * FROM contact";
$cont = $link->query($con) or die("Error: " . mysqli_error($link));

$wal = "SELECT * FROM wallet";
$out = $link->query($wal) or die("Error: " . mysqli_error($link));


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PerryPay Dashboard</title>
    <script src="assets/js/jquery-1.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="assets/css/theme.css">
    <style type="text/css">

    </style>
    <script>
        function ajx(v, b) {
            var ee;
            if (window.XMLHttpRequest) {
                ee = new XMLHttpRequest();
            } else {
                ee = new ActiveXObject("Microsoft.XMLHTTP");
            };
            ee.open("POST", 'dash.php', true);
            ee.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
            ee.onreadystatechange = function() {
                if (ee.status == 200 && ee.readyState == 4) {
                    if (typeof b == "function") {
                        if (ee.responseText == "unauth") {
                            //do something here
                        } else {
                            b(ee.responseText);
                        }
                    };
                }
            }
            ee.send(v);
            return true;
        };
    </script>
</head>

<body>
    <div class='sidebar'>
        <div href='' onclick='window.location = this.getAttribute("href")' class='logo'><a href="../index.php">PerryPays</a></div>
        <ul class="maxsid">
            <li><i class="fa fa-home"></i><a href="home.php" class="nav-link"> Transactions</a></li>
            <li><i class="fa fa-user"></i><a href="user.php" class="nav-link"> Users</a></li>
            <li class="chosen"><i class="fa fa-credit-card-alt"></i><a href="wallet.php" class="nav-link"> Wallet</a></li>
            <li><i class="fa fa-envelope"></i><a href="contact.php" class="nav-link"> Messages</a></li>
            <li><i class="fa fa-sign-out"></i><a href="logout.php" class="nav-link"> Logout</a></li>
        </ul>
    </div>
    <div class='content'>
        <div class="iContent">
            <div class="upHead">
                <div href='' onclick='window.location = this.getAttribute("href")' class='llogo logo'></div>
                <div class="right">
                    <div class="user"><i class="fa fa-user"></i></div>
                </div>
            </div>
            <div class="mainC">
                <div class="transaction-body">
                    <h5>Users Wallet</h5>
                    <hr>

                    <table class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Email</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Reference</th>
                            </tr>
                        </thead>
                        <?php
                        while ($tablerow = mysqli_fetch_array($out)) {
                        ?>
                            <tbody>
                                <tr>
                                    <td scope="row"><?php echo $tablerow['email'] ?></td>
                                    <td><?php echo $tablerow['amount'] ?></td>
                                    <td><?php echo $tablerow['ref'] ?></td>
                                </tr>
                            </tbody>
                        <?php } ?>

                    </table>
                </div>
            </div>
            <div class="bottom_bar bb_b">
                <ul class="maxsid">
                    <li><a href="home.php" class="nav-link"><i class="fa fa-home"></i></a></li>
                    <li><a href="user.php" class="nav-link"> <i class="fa fa-user"></i></a></li>
                    <li><a href="wallet.php" class="nav-link"> <i class="fa fa-credit-card-alt"></i></a></li>
                    <li><a href="contact.php" class="nav-link"> <i class="fa fa-envelope"></i></a></li>
                    <li><a href="logout.php" class="nav-link"> <i class="fa fa-sign-out"></i></a></li>
                </ul>
            </div>
        </div>
    </div>

</body>
<script type="text/javascript" src="assets/js/app.js"></script>
<script>
    var settings = {
        "url": "https://api.nomics.com/v1/exchange-rates?key=d0a9c5291efed251b6fd8c7b0b026255",
        "method": "GET",
        "timeout": 0,
    };

    $.ajax(settings).done(function(response) {
        console.log(response);
        var json = JSON.parse(response);
        console.log(json[0].currency);
    });
</script>


</html>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>