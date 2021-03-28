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
  $email = $password = "";
  $email_err = $password_err = "";
  
  // Processing form data when form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    // Check if email is empty
  if (empty(trim($_POST["email"]))) {
    $email_err = "Please enter email.";
  } else {
    $email = trim($_POST["email"]);
  }

  // Check if password is empty
  if (empty(trim($_POST["password"]))) {
    $password_err = "Please enter your password.";
  } else {
    $password = trim($_POST["password"]);
  }

  // Validate credentials
  if (empty($email_err) && empty($password_err)) {
    // Prepare a select statement
    $sql = "SELECT id, email, password FROM admin WHERE email = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $param_email);

      // Set parameters
      $param_email = $email;
      $param_password = $password;

      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        // Store result
        mysqli_stmt_store_result($stmt);

        // Check if email exists, if yes then verify password
        if (mysqli_stmt_num_rows($stmt) == 1) {
          // Bind result variables
          mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
          if (mysqli_stmt_fetch($stmt)) {
            if (password_verify($password, $hashed_password)) {

              // Store data in session variables
              $_SESSION["loggedin"] = true;
              $_SESSION["id"] = $id;
              $_SESSION["email"] = $email;
            } else {
              // Display an error message if password is not valid
              $password_err = "The password you entered was not valid.";
            }
          }
          // Redirect to dashboard page
          header("location: home.php");
        } else {
          // Display an error message if username doesn't exist
          $email_err = "No account found with that Email.";
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
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
        <h4>Login</h4>
        <h4><a href="index.php">PerryPays</a></h4>
        </div>
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
            <br>
            <div>
                <button type="submit" class="reg-btn">Login</button>
            </div>
            </form>
    </div>
</body>

</html>