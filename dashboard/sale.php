<?php

include 'database.php';

session_start();

$em = $_SESSION['email'];
$tran = "SELECT * FROM transactions where email = '$em' ORDER BY id DESC LIMIT 10";
$output = $link->query($tran) or die("Error: " . mysqli_error($link));


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
            <li><i class="fa fa-home"></i><a href="index.php" class="nav-link"> Dashboard</a></li>
            <li><i class="fa fa-user"></i><a href="profile.php" class="nav-link"> Profile</a></li>
            <li><i class="fa fa-credit-card-alt"></i><a href="wallet.php" class="nav-link"> Wallet</a></li>
            <li class="chosen"><i class="fa fa-bar-chart-o"></i><a href="sale.php" class="nav-link"> Transactions</a></li>
            <li><i class="fa fa-gear"></i><a href="setting.php" class="nav-link">Settings</a></li>
            <li><i class="fa fa-users"></i><a href="contact.php" class="nav-link"> Contact Support </a></li>
            <li><i class="fa fa-sign-out"></i><a href="logout.php" class="nav-link"> Logout</a></li>
        </ul>
    </div>
    <div class='content'>
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
                            <form>
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Withdraw from</label>
                                    <select class="form-control" id="selectCoin">
                                        <option hidden>--Select Coin --</option>
                                        <option value="BTC">Bitcoin</option>
                                        <option value="ETH">Ethereum</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>Coin amount</h6>
                                            <input type="text" class="form-control" id="coinAmt">
                                        </div>
                                        <div class="col-md-6">
                                            <h6>Naira Conversion</h6>
                                            <input type="text" class="form-control" id="naira" placeholder="0" readonly required>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn coin-btn">Withdraw</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row second-content">
            <div class="col-md-6 coin-market">
                <h5>Coin Market</h5>
                <div class="table-responsive-md">
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
            </div>
            <div class="col-md-6 trans-history">
                <h5>Transaction History</h5>
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
<script src="assets/js/app.js"></script>

</html>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>