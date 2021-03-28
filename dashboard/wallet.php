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
    header("location:../login.php");
    exit();
}

// Include config file
require_once "database.php";

// Define variables and initialize with empty values
$email = $_SESSION['email'];

$tran = "SELECT * FROM withdraw where email = '$email' ORDER BY id DESC LIMIT 10";
$output = $link->query($tran) or die("Error: " . mysqli_error($link));

$wal = "SELECT * FROM wallet where email = '$email'";
$out = $link->query($wal) or die("Error: " . mysqli_error($link));

$bc = "SELECT * FROM transactions where email = '$email' and coin = 'BTC'";
$bcout = $link->query($bc) or die("Error: " . mysqli_error($link));

$et = "SELECT * FROM transactions where email = '$email' and coin = 'ETH'";
$etout = $link->query($et) or die("Error: " . mysqli_error($link));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PerryPay Dashboard</title>
    <style>
        .error {
            color: #FF0000;
        }
    </style>
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
            <li><i class="fa fa-home"></i><a href="index.php" class="nav-link"> Dashboard</a></li>
            <li><i class="fa fa-user"></i><a href="profile.php" class="nav-link"> Profile</a></li>
            <li class="chosen"><i class="fa fa-credit-card-alt"></i><a href="wallet.php" class="nav-link"> Wallet</a></li>
            <li><i class="fa fa-bar-chart-o"></i><a href="sale.php" class="nav-link"> Transactions</a></li>
            <li><i class="fa fa-gear"></i><a href="setting.php" class="nav-link">Settings</a></li>
            <li><i class="fa fa-users"></i><a href="contact.php" class="nav-link"> Contact Support </a></li>
            <li><i class="fa fa-sign-out"></i><a href="logout.php" class="nav-link"> Logout</a></li>
        </ul>
    </div>
    <div class='content'>
        <div class="setting-content">
            <div class="wallet">
                <h3>Wallet</h3>
                <?php while ($tab = mysqli_fetch_array($out)) { ?>
                    <strong>NGN <?php echo $tab['amount'] ?></strong>
                <?php } ?>
            </div>
            <div class="coins">
                <div class="first">
                    <h5>BTC</h5>
                    <?php while ($btc = mysqli_fetch_array($bcout)) { ?>
                        <strong><?php echo $btc['coin_amount'] ?></strong>
                    <?php } ?>
                </div>
                <div class="second">
                    <h5>ETH</h5>
                    <?php while ($eth = mysqli_fetch_array($etout)) { ?>
                        <strong><?php echo $eth['coin_amount'] ?></strong>
                    <?php } ?>
                </div>

            </div>
            <button class="coin-btn" type="button" data-toggle="modal" data-target="#wallet">
                Top-Up Wallet
            </button>

            <div class="modal fade" id="wallet" tabindex="-1" aria-labelledby="walletLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="coinwithdrawalLabel">Top-up Wallet</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="walletForm" method="POST" action="initialize.php">
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" id="email" name="email" value="<?php echo $email ?>" required readonly />
                                </div>
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="tel" id="amt" name="amount" required />
                                </div>
                                <div class="form-group">
                                    <input type="tel" id="wal" name="wallet" value="1" hidden />
                                </div>
                                <div class="form-submit">
                                    <button type="submit" class="btn btn-primary" name="submit"> Pay </button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="transaction-body">
                <h5>Latest Withdraws</h5>
                <hr>
                <?php
                while ($tablerow = mysqli_fetch_array($output)) {
                ?>
                    <div class="row">
                        <div class="col-md-4">
                            <?php echo $tablerow['updated_at'] ?>
                        </div>
                        <div class="col-md-3">
                            <?php echo $tablerow['amount'] ?>
                        </div>
                        <div class="col-md-2">
                            <?php echo $tablerow['coin'] ?>
                        </div>
                        <div class="col-md-3">
                            <?php echo $tablerow['coin_amount'] ?>
                        </div>
                    </div>
                    <hr>
                <?php } ?>
            </div>
        </div>
        <div class="bottom_bar bb_b">
            <ul class="maxsid">
                <li><a href="index.php" class="nav-link"><i class="fa fa-home"></i></a></li>
                <li><a href="profile.php" class="nav-link"><i class="fa fa-user"></i></a></li>
                <li><a href="wallet.php" class="nav-link"><i class="fa fa-credit-card-alt"></i></a></li>
                <li><a href="sale.php" class="nav-link"><i class="fa fa-bar-chart-o"></i></a></li>
                <li><a href="setting.php" class="nav-link"><i class="fa fa-gear"></i></a></li>
                <li><a href="contact.php" class="nav-link"><i class="fa fa-users"></i></a></li>
                <li><a href="logout.php" class="nav-link"><i class="fa fa-sign-out"></i></a></li>
            </ul>
        </div>
    </div>
</body>

<!-- Modals -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div>
        </div>
    </div>
</div>

</html>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>