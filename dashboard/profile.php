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
            <li><i class="fa fa-home"></i><a href="index.php" class="nav-link"> Home</a></li>
            <li class="chosen"><i class="fa fa-user"></i><a href="profile.php" class="nav-link"> Profile</a></li>
            <li><i class="fa fa-bar-chart-o"></i><a href="sale.php" class="nav-link"> Sales</a></li>
            <li><i class="fa fa-gear"></i><a href="setting.php" class="nav-link"> Settings</a></li>
            <li><i class="fa fa-sign-out"></i><a href="logout.php" class="nav-link"> Logout</a></li>
        </ul>
    </div>
    <div class='content'>
        <div class="row profile-tab">
            <div class="col-md-3">
                <img src="../images/avatar.png" alt="" class="picture">
            </div>
            <div class="col-md-9">
                <button class="change-pix">
                    Change Profile Picture
                </button>
            </div>
        </div>
        <div class="row profile-details">
            <div class="col-md-6">
                <h6>First Name</h6>
                <p>This is first name</p>
            </div>
            <div class="col-md-6">
                <h6>Last Name</h6>
                <p>This is first name</p>
            </div>
            <div class="col-md-6">
                <h6>Email</h6>
                <p>This is first name</p>
            </div>
            <div class="col-md-6">
                <h6>Username</h6>
                <p>This is first name</p>
            </div>
            <div class="col-md-6">
                <h6>Mobile Number</h6>
                <p>This is first name</p>
            </div>
            <div class="col-md-6">
                <h6>Bank</h6>
                <p>This is first name</p>
            </div>
            <div class="col-md-6">
                <h6>Account Type</h6>
                <p>This is first name</p>
            </div>
            <div class="col-md-6">
                <h6>Account Number</h6>
                <p>This is first name</p>
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