<?php

// Initialize the session
session_start();

// Include config file
require_once "database.php";

// Check if the user is already logged in, if yes then redirect him to home page
if (isset($_SESSION["id"])) {
    header("location: home.php");
    exit;
  }
  
  // Define variables and initialize with empty values
  $email = $password = $confirm_password = "";
  $email_err = $password_err = $confirm_password_err = "";
  
  // Processing form data when form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    // Validate email
    if (empty(trim($_POST["email"]))) {
      $email_err = "Please enter a valid email.";
    } else {
      // Prepare a select statement
      $sql = "SELECT id FROM admin WHERE email = ?";
  
      if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_email);
  
        // Set parameters
        $param_email = trim($_POST["email"]);
  
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
          /* store result */
          mysqli_stmt_store_result($stmt);
  
          if (mysqli_stmt_num_rows($stmt) == 1) {
            $email_err = "This email is already taken.";
          } else {
            $email = trim($_POST["email"]);
          }
        } else {
          echo "Oops! Something went wrong. Please try again later.";
        }
  
        // Close statement
        mysqli_stmt_close($stmt);
      }
    }
  
    // Validate password
    if (empty(trim($_POST["password"]))) {
      $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
      $password_err = "Password must have atleast 6 characters.";
    } else {
      $password = trim($_POST["password"]);
    }
  
    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
      $confirm_password_err = "Please confirm password.";
    } else {
      $confirm_password = trim($_POST["confirm_password"]);
      if (empty($password_err) && ($password != $confirm_password)) {
        $confirm_password_err = "Password did not match.";
      }
    }
  
    // Check input errors before inserting in database
    if (empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
  
      // Prepare an insert statement
      $sql = "INSERT INTO admin (email, password) VALUES (?, ?)";
  
      if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_password);
  
        // Set parameters
        $param_email = $email;
        $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
  
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
  
  
          // Redirect to dashboard page
          header("location: index.php");
        } else {
          echo "Something went wrong. Please try again later.";
        }
  
        // Close statement
        mysqli_stmt_close($stmt);
      }
    }
  
  
  
    // Close connection
    mysqli_close($link);
  }
  

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PerryPay</title>
    <!-- <script src="assets/js/jquery-1.js" defer></script> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="css/theme.css">
</head>

<body class="reg-body">
    <div class="card">
        <div class="d-flex justify-content-between">
        <h4>Register</h4>
        <h4><a href="index.php">PerryPays</a></h4>
        </div>
        <p>Already have an account? <a href="login.php">Log in</a></p>
        <form action="" method="POST">
        <div>
                <label for="email"><strong>Email</strong></label><br>
                <input type="text" name="email" id="email" class="form-control" required>
                <span class="error"><?php echo $email_err; ?></span>
            </div>
            <br>
            <div>
                <label for="password"><strong>Password</strong></label><br>
                <input type="password" name="password" id="password" class="form-control" required>
                <span class="error"><?php echo $password_err; ?></span>
            </div>
            <div>
                <label for="password"><strong>Confirm Password</strong></label><br>
                <input type="password" name="confirm_password" id="password" class="form-control" required>
                <span class="error"><?php echo $confirm_password_err; ?></span>
            </div>
            <br>
            <div>
                <button type="submit" class="reg-btn">Register</button>
            </div>
            </form>
    </div>
</body>

</html>