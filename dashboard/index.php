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

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://rest.coinapi.io/v1/exchangerate/BTC?invert=true&asset_id_base=BTC',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'X-CoinAPI-Key: 03B83426-7EAD-4BDD-B796-AF9C2D08AE09'
  ),
));

$response = curl_exec($curl);
$data = json_decode($response);
$ngn = $data->rates[2748]->rate;
$usd = $data->rates[2532]->rate;
// var_dump($data);
// echo $ngn;
// echo $usd;
curl_close($curl);
// echo $response;

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
    <link rel="stylesheet" href="assets/css/index.css">
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
    <div class="overlay">
        <form class="save_x">

        </form>
    </div>
    <div class='sidebar'>
        <div href='' onclick='window.location = this.getAttribute("href")' class='logo'><a href="../index.php"><img src="../images/perry.png" alt="" class="perry-logo" width="100" height="100"></a></div>
        <ul class="maxsid">
            <li class="chosen"><i class="fa fa-home"></i><a href="index.php" class="nav-link"> Home</a></li>
            <li><i class="fa fa-user"></i><a href="profile.php" class="nav-link"> Profile</a></li>
            <li><i class="fa fa-bar-chart-o"></i><a href="sale.php" class="nav-link"> Sales</a></li>
            <li><i class="fa fa-gear"></i><a href="setting.php" class="nav-link">Settings</a></li>
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
                <div class="right">
                    <div class="user">FullName</div>
                </div>
            </div>
            <div class="mainC">
                <div class="wallet">
                    <h3>Wallet</h3>
                    <strong>NGN 0.00</strong>
                </div>
                <div class="open-modal">
                    <button class="coin-btn" type="button" data-toggle="modal" data-target="#coinwithdrawal">
                        Coin Withdrawal
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
                                            <p>$1</p>
                                        </div>
                                        <div class="col-md-4">
                                            <h6>Maximum Withdrawal</h6>
                                            <p>$10,000</p>
                                        </div>
                                    </div>
                                    <form>
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Withdraw from</label>
                                            <select class="form-control" id="exampleFormControlSelect1">
                                                <option hidden>--Select Coin --</option>
                                                <option value="bitcoin">Bitcoin</option>
                                                <option value="ethereum">Ethereum</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6>Withdraw amount $</h6>
                                                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="$">
                                                </div>
                                                <div class="col-md-6">
                                                    <h6>Naira Conversion</h6>
                                                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="NGN">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Security Key</label>
                                            <input type="password" class="form-control" id="exampleFormControlInput1" placeholder="****">
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
                                                <td>$50,823.960</td>
                                                <td>₦22,970,782</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>ETH</td>
                                                <td>$1,805.230</td>
                                                <td>₦753,353.500</td>
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
                        Buy Coins
                    </button>
                    <!-- Modals -->
                    <div class="modal fade" id="buycoin" tabindex="-1" aria-labelledby="buycoinLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
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
                                                <td>$50,823.960</td>
                                                <td>₦22,970,782</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>ETH</td>
                                                <td>$1,805.230</td>
                                                <td>₦753,353.500</td>
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


                    <button class="coin-btn" type="button" data-toggle="modal" data-target="#coinexchange">
                        Top-Up Wallet
                    </button>
                </div>
                <div class="transaction-body">
                    <h5>Latest Transaction</h5>
                    <hr>
                </div>
            </div>
            <div class="bottom_bar bb_b">
                <ul class="maxsid">
                    <li class="chosen"><i class="fa fa-home"></i><span>Home</span></li>
                    <li><i class="fa fa-bar-chart-o"></i> <span>Report</span></li>
                    <li><i class="fa fa-envelope-o"></i> <span>Messages</span></li>
                    <li><i class="fa fa-gear"></i> <span>Settings</span></li>
                </ul>
            </div>
        </div>
    </div>

</body>


</html>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>