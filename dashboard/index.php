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
// require_once "../config.php";

include 'database.php';

$email = $_SESSION['email'];
$errors = [];

$em = $_SESSION['email'];
$tran = "SELECT * FROM transactions where email = '$em' ORDER BY id DESC LIMIT 10";
$output = $link->query($tran) or die("Error: " . mysqli_error($link));

$bc = "SELECT * FROM transactions where email = '$em' and coin = 'BTC'";
$bcout = $link->query($bc) or die("Error: " . mysqli_error($link));

$et = "SELECT * FROM transactions where email = '$em' and coin = 'ETH'";
$etout = $link->query($et) or die("Error: " . mysqli_error($link));

$sql = "SELECT * FROM users where email = '$em'";
$result = $link->query($sql) or die("Error: " . mysqli_error($link));

$wal = "SELECT * FROM wallet where email = '$em'";
$out = $link->query($wal) or die("Error: " . mysqli_error($link));


if (isset($_POST['proceed'])) {
    while ($row = mysqli_fetch_array($out)) {
        $money = $row['amount'];
    }
}

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
            <li class="chosen"><i class="fa fa-home"></i><a href="index.php" class="nav-link"> Dashboard</a></li>
            <li><i class="fa fa-user"></i><a href="profile.php" class="nav-link"> Profile</a></li>
            <li><i class="fa fa-credit-card-alt"></i><a href="wallet.php" class="nav-link"> Wallet</a></li>
            <li><i class="fa fa-bar-chart-o"></i><a href="sale.php" class="nav-link"> Transactions</a></li>
            <li><i class="fa fa-gear"></i><a href="setting.php" class="nav-link">Settings</a></li>
            <li><i class="fa fa-users"></i><a href="contact.php" class="nav-link"> Contact Support </a></li>
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
            <div class="header">
                <div class="search left">
                    <div class="cs">
                        <i class="fa fa-search"></i>
                    </div>
                    <form action="#" onsubmit="return false" enctype="multipart/form-data" method="post">
                        <input type="search" name="search" class="search_g" placeholder="Search...">
                    </form>
                </div>
            </div>
            <div class="mainC">
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
                <div class="open-modal">
                    <button class="coin-btn" type="button" data-toggle="modal" data-target="#coinwithdrawal">
                        Coin Withdraw
                    </button>

                    <!-- Modals -->
                    <div class="modal fade" id="coinwithdrawal" tabindex="-1" aria-labelledby="coinwithdrawalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="coinwithdrawalLabel">Withdraw From Coin Wallet</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4">
                                            <h6>Minimuim Withdrawal</h6>
                                            <p>NGN100</p>
                                        </div>
                                        <div class="col-md-4">
                                            <h6>Maximum Withdrawal</h6>
                                            <p>NGN1,000,000</p>
                                        </div>
                                    </div>
                                    <form method="POST" action="withdraw.php">
                                        <input type="email" id="email-address" name="email" value="<?php echo $_SESSION['email'] ?>" class="form-control" required hidden />
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Withdraw from</label>
                                            <select class="form-control" id="selectCoin" name="coin">
                                                <option hidden>--Select Coin --</option>
                                                <option value="BTC">Bitcoin</option>
                                                <option value="ETH">Ethereum</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6>Coin amount</h6>
                                                    <input type="text" class="form-control" name="coin_amount" id="coinAmt">
                                                </div>
                                                <div class="col-md-6">
                                                    <h6>Naira Conversion</h6>
                                                    <input type="text" class="form-control" name="amount" id="naira" placeholder="0" readonly required>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" name="proceed" class="btn coin-btn">Withdraw</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="coin-btn" type="button" data-toggle="modal" data-target="#coinexchange">
                        Coin Exchange
                    </button>

                    <!-- Modals -->
                    <div class="modal fade" id="coinexchange" tabindex="-1" aria-labelledby="coinexchangeLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="coinwithdrawalLabel">Coin Exchange</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h6>$1</h6>
                                            <p>USD</p>
                                        </div>
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-4">
                                            <h6>NGN 450</h6>
                                            <p>Naira Buy Rate</p>
                                        </div>
                                    </div>
                                    <table class="table table-striped table-dark">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Coin</th>
                                                <th scope="col">USD</th>
                                                <th scope="col">NGN</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>BTC</td>
                                                <td id="usd_btc">0.00</td>
                                                <td id="ngn_btc">0.00</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>ETH</td>
                                                <td id="usd_eth">0.00</td>
                                                <td id="ngn_eth">0.00</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="coin-btn" type="button" data-toggle="modal" data-target="#buycoin">
                        Buy BTC
                    </button>
                    <!-- Modals -->
                    <div class="modal fade" id="buycoin" tabindex="-1" aria-labelledby="buycoinLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="coinwithdrawalLabel">Buy Coins</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="paymentForm" method="POST" action="pay.php">
                                        <div class="form-group">
                                            <label for="email">Email Address</label>
                                            <input type="email" id="email-address" name="email" value="<?php echo $_SESSION['email'] ?>" class="form-control" required readonly />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" value="NGN" hidden />
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Amount</label>
                                            <input type="tel" id="amt" name="amount" class="form-control" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="coin">Coin</label>
                                            <input type="text" name="coin" value="BTC" class="form-control" id="coin" readonly required>
                                        </div>
                                        <div class="form-group">
                                            <label for="coin_amount">Coin Amount</label>
                                            <input type="text" id="coinAmount" class="form-control" name="coin_amount" readonly required />
                                        </div>
                                        <div class="form-submit">
                                            <button type="submit" name="proceed"> Pay </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="coin-btn" type="button" data-toggle="modal" data-target="#buycoineth">
                        Buy ETH
                    </button>
                    <!-- Modals -->
                    <div class="modal fade" id="buycoineth" tabindex="-1" aria-labelledby="buycoinLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="coinwithdrawalLabel">Buy Coins</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="paymentForm" method="POST" action="pay.php">
                                        <div class="form-group">
                                            <label for="email">Email Address</label>
                                            <input type="email" id="email-address" name="email" value="<?php echo $_SESSION['email'] ?>" class="form-control" required readonly />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" value="NGN" hidden />
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Amount</label>
                                            <input type="tel" id="amount" class="form-control" name="amount" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="coin">Coin</label>
                                            <input type="text" name="coin" class="form-control" value="ETH" id="coin" readonly required>
                                        </div>
                                        <div class="form-group">
                                            <label for="coin_amount">Coin Amount</label>
                                            <input type="text" id="coin_amount" class="form-control" name="coin_amount" readonly required />
                                        </div>
                                        <div class="form-submit">
                                            <button type="submit" name="proceed"> Pay </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
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
                                            <input type="email" id="email" name="email" class="form-control" value="<?php echo $email ?>" required readonly />
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Amount</label>
                                            <input type="tel" id="amt" name="amount" class="form-control" required />
                                        </div>
                                        <div class="form-group">
                                            <input type="tel" id="wal" class="form-control" name="wallet" value="1" hidden />
                                        </div>
                                        <div class="form-submit">
                                            <button type="submit" class="btn btn-primary" name="submit"> Pay </button>
                                        </div>
                                    </form>
                                    <script src="https://js.paystack.co/v1/inline.js"></script>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="transaction-body">
                    <h5>Latest Transaction</h5>
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