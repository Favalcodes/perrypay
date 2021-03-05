<?php

    // Initialize the session
    session_start();
 
    if(isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === true){
        $user = true;
    }
    if (isset($_COOKIE["active"]) || isset($_COOKIE["id"]) || isset($_COOKIE["email"])){
        $user = true;
    }
    if(isset($_SESSION['access_token'])){
        $user = true;
    }
    if ($user !== true){
        header("location:../login.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Dashboard | Classbeam</title>
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
        <div href='' onclick='window.location = this.getAttribute("href")' class='logo'><img src="../images/perry.png" alt="" class="perry-logo" width="100" height="100"></div>
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
                    <button class="coin-btn" type="button" data-toggle="modal" data-target="#staticBackdrop">
                        Coin Withdrawal
                    </button>
                    <button class="coin-btn">
                        Coin Exchange
                    </button>
                    <button class="coin-btn">
                        Calculator
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