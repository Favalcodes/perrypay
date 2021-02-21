<?php

    // Initialize the session
    session_start();
 
    // Check if the user is logged in, if not then redirect user to login page
    // if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    //     header("location: login.php");
    //     exit;
    // }
    if(isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === true){
        $user = true;
    }
    if (isset($_COOKIE["active"]) || isset($_COOKIE["id"]) || isset($_COOKIE["email"])){
        $user = true;
    }
    if ($user !== true){
        header("location:login.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <title>Dashboard | Perry Pays</title>
</head>
<body>
    Welcome Name
    <div class="row">
        <div class="col-lg-4">
            <h2><a href="logout.php">Logout</a></h2>
        </div>
        <div class="col-lg-8">
        <form action="" method="post">
            <p>Setup your account</p>
            <br>
            <div>
                <label for="fullname">Full Name</label>
                <input type="text" name="fullname" id="fullname" placeholder="Full Name">
            </div>
            <br>
            <div>
                <label for="phonenumber">Phone Number</label>
                <input type="tel" name="phonenumber" id="phonenumber" placeholder="Phone Number"> 
            </div>
            <br>
            <div>
                <label for="Bank">Bank</label>
                <select name="bank" id="bank">
                    <option value="">Abbey Mortgage Bank</option>
                    <option value="">Access Bank</option>
                    <option value="">Access Bank(Diamond)</option>
                </select>
                <label for="account_number">Account Number</label>
                <select name="account_number" id="account_number">
                    <option value=""></option>
                </select>
            </div>
            <br>
            <div>
                <label for="account_title">Account Title</label>
                <input type="text" name="account_title" id="account_title" disabled>
            </div>
            <div>
                <button type="submit">Save</button>
            </div>
        </form>
    </div>
    </div>
    
    
    
</body>
</html>