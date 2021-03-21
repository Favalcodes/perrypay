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
        <div href='' onclick='window.location = this.getAttribute("href")' class='logo'><img src="../images/perry.png" alt="" class="perry-logo" width="100" height="100"></div>
        <ul class="maxsid">
            <li><i class="fa fa-home"></i><a href="index.php" class="nav-link"> Dashboard</a></li>
            <li><i class="fa fa-user"></i><a href="profile.php" class="nav-link"> Profile</a></li>
            <li><i class="fa fa-user"></i><a href="wallet.php" class="nav-link"> Wallet</a></li>
            <li class="chosen"><i class="fa fa-bar-chart-o"></i><a href="sale.php" class="nav-link"> Transactions</a></li>
            <li><i class="fa fa-gear"></i><a href="setting.php" class="nav-link">Settings</a></li>
            <li><i class="fa fa-gear"></i><a href="support.php" class="nav-link"> Contact Support </a></li>
            <li><i class="fa fa-sign-out"></i><a href="logout.php" class="nav-link"> Logout</a></li>
        </ul>
    </div>
    <div class='content'>
        <div class="open-modal">
            <button class="coin-btn" type="button" data-toggle="modal" data-target="#staticBackdrop">
                Coin Withdrawal
            </button>
            <button class="coin-btn">
                Coin Exchange
            </button>
        </div>
        <div class="row second-content">
            <div class="col-md-6 coin-market">
                <h5>Coin Market</h5>
                <div class="table-responsive-md">
                    <table class="table table-striped w-100">
                        <thead>
                            <tr>
                                <th scope="col">Coin</th>
                                <th scope="col">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">USD</th>
                                <td>1</td>
                            </tr>
                            <tr>
                                <th scope="row">NGN</th>
                                <td>460</td>
                            </tr>
                            <tr>
                                <th scope="row">Bitcoin</th>
                                <td>25</td>
                            </tr>
                            <tr>
                                <th scope="row">Ethereum</th>
                                <td>25</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 trans-history">
                <h5>Transaction History</h5>
                <hr>
            </div>
        </div>
        <div class="bottom_bar bb_b">
            <ul class="maxsid">
                <li><a href="index.php" class="nav-link"><i class="fa fa-home"></i></a></li>
                <li><a href="profile.php" class="nav-link"><i class="fa fa-user"></i></a></li>
                <li><a href="sale.php" class="nav-link"><i class="fa fa-bar-chart-o"></i></a></li>
                <li><a href="setting.php" class="nav-link"><i class="fa fa-gear"></i></a></li>
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