<?php

    // Initialize the session
    session_start();

     
    // Check if the user is already logged in, if yes then redirect him to welcome page
    if((isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) || (isset($_SESSION['access_token'])) || isset($_COOKIE["email"])){
        // header("location: dashboard.php");
        header("location: dashboard/index.php");
        exit;
    }
 
    // Include config file
    require_once "config.php";
    $loginUrl = $client->createAuthUrl();

    // Require redirect file
    // require_once "redirect.php";

    // Define variables and initialize with empty values
    $errors = [];
    $email = $password = $rememberMe = "";
    
    // Processing form data when form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        // var_dump($_POST);

        function test_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }	

        # Test Email
        if (empty($_POST['email'])){
            $errors['email'] = 'Email is required';
        }
        if (!empty($_POST['email'])){
            $email = test_input($_POST['email']);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors['email'] = 'Invalid email format';
            }
            
        }

        # Test Password
        if (empty($_POST['password'])){
            $errors['password'] = 'Password is required';
        }
        if (!empty($_POST['password'])){
            $password = test_input($_POST['password']);
            if(strlen($password) < 8){
                $errors['password'] = 'Password must have at least 8 characters.';
            } 
        }

        // Validate credentials
        if (empty($errors)){
            // Prepare a select statement
        $sql = "SELECT id, email, password FROM users WHERE email = :email";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if email exists, if yes then verify password
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        // $id = $row["id"];
                        $email = $row["email"];
                        // $username = $row["username"];
                        $hashed_password = $row["password"];
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start(); # comment this later to test sth
                            # New(START)
                            if ($_POST['rememberMe'] == 'on'){
                                $hour = time() + (3600 * 24 * 30); #Set time to 30 days. 3600 is for 1 hour
                                // setcookie('id', $id, $hour);
                                setcookie('email', $email, $hour);
                                setcookie('active', 1, $hour);
                            }
                            # New(END)
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
                            // $_SESSION["username"] = $username;                            
                            
                            // Redirect user to dashboard page
                            header("location: dashboard/index.php");
                        } else{
                            // Display an error message if password is not valid
                            $errors["password"] = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $errors['email'] = "No account found with this email.";
                }
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
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form">  
    <div class="d-flex justify-content-between">
        <h4>Login</h4>
        <h4><a href="index.php">PerryPays</a></h4>
        </div>
        <div>
            <label for="email"><strong>Email</strong></label>
            <br>
            <input type="text" name="email" id="email" value="<?php echo $email; ?>" placeholder="example@mail.com" class="form-control">
            <span class="error"><?php echo $errors['email'] ?? '' ?></span>
        </div>
        <br>
        <div>
            <label for="password"><strong>Password</strong></label>
            <br>
            <input type="password" name="password" id="password" placeholder="Password" class="form-control">
            <span class="error"><?php echo $errors['password'] ?? '' ?></span>
            <a href="forgotten-password.php" class="create">Forgot password</a>
        </div>
        <br>
        <input type="checkbox" name="rememberMe" id="rememberMe">
        <label for="remember">Remember me</label>
        <br><br>
        <div>
            <button type="submit" class="reg-btn">Log In</button>   
        </div>
    </form>

    <div style="text-align: center;">
        <br><br>
        <!-- <p>Or</p> -->
        <!-- <br><br> -->
        <!-- <h2><a href="<?php echo $loginUrl ?>">Google</a></h2> -->
        <br><br>
        <p>Not registered? <a href="sign-up.php" class="create">Create an account</a>
    </div>
   
</div>
</body>
</html>