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

    // Include config file
    require_once "../config.php";

    // Define variables and initialize with empty values
    $errors = [];
    $new_password = $confirm_password = "";    
    
    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        function test_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }	

         // Validate new password
        if (empty($_POST['new_password'])){
            $errors['new_password_err'] = "Please enter the new password.";   
        }
        if (!empty($_POST['new_password'])){
            $new_password = test_input($_POST['new_password']);
            if(strlen($new_password) < 8){
                $errors['new_password_err'] = 'Password must have at least 8 characters.';
            }
        }
        
        // Validate confirm password
        if(empty($_POST["confirm_password"])){
            $errors['confirm_password_err'] = "Please confirm the password.";
        } else{
            $confirm_password = test_input($_POST["confirm_password"]); 
            if(empty($errors['confirm_password_err']) && ($new_password != $confirm_password)){
                $errors['confirm_password_err']  = "Password did not match.";
            }
        }

        // Check input errors before updating the database
        if (empty($errors)){
            // Prepare an update statement
            $sql = "UPDATE users SET password = :password WHERE email = :email";
            
            if($stmt = $pdo->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
                $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                
                // Set parameters
                $param_password = password_hash($new_password, PASSWORD_DEFAULT);
                $param_email = $_SESSION["email"];
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    // Password updated successfully.

                    # The echo statement should be in a modal
                    echo "<script>alert('Password reset successfully')</script>";
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                unset($stmt);
            }
        }
    }
    
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PerryPay Dashboard</title>
    <style>
		.error {color: #FF0000;}
	</style>
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
            <li><i class="fa fa-user"></i><a href="profile.php" class="nav-link"> Profile</a></li>
            <li><i class="fa fa-bar-chart-o"></i><a href="sale.php" class="nav-link"> Sales</a></li>
            <li class="chosen"><i class="fa fa-gear"></i><a href="setting.php" class="nav-link"> Settings</a></li>
            <li><i class="fa fa-sign-out"></i><a href="logout.php" class="nav-link"> Logout</a></li>
        </ul>
    </div>
    <div class='content'>
        <div class="setting-content">
            <div class="row">
                <div class="col-md-12">
                    <h6 class="mb-3">Change Password</h6>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label for="exampleInputEmail1">New Password</label>
                            <input type="password" name="new_password"  class="form-control pwd" value="<?php echo $new_password; ?>"
                             id="exampleInputPassword" >
                             <span class="error"><?php echo $errors['new_password_err'] ?? '' ?></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control pwd" value="<?php echo $confirm_password; ?>" 
                            id="exampleInputPassword">
                            <span class="error"><?php echo $errors['confirm_password_err'] ?? '' ?></span>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Sign me out</label>
                        </div>
                        <button type="submit" class="coin-btn">Submit</button>
                    </form>
                </div>
               
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h6 class="mb-3 mt-2">Change Bank Details</h6>
                    <form>
                        <div class="form-group">
                            <label for="exampleInputEmail1">New Bank</label>
                            <input type="text" class="form-control" id="exampleInputPassword">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">New Account Number</label>
                            <input type="text" class="form-control" id="exampleInputPassword">
                        </div>
                        <button type="submit" class="coin-btn">Submit</button>
                    </form>
                </div>
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