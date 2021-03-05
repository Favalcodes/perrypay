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
                            // $_SESSION["id"] = $id;
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
    <!-- <link rel="stylesheet" href="loginstyles.css"> -->
    <title>Document</title>
    <style>
		.error {color: #FF0000;}
	</style>
</head>
<body>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form" style="text-align: center;">  
        <h1>Sign In</h1>
        <p>Log in to your account to continue.</p>
        <br>
        <div>
            <label for="email">Email</label>
            <br>
            <input type="text" name="email" id="email" value="<?php echo $email; ?>" placeholder="example@mail.com">
            <span class="error"><?php echo $errors['email'] ?? '' ?></span>
        </div>
        <br>
        <div>
            <label for="password">Password| <a href="forgotten-password.php">Forgot password</a></label>
            <br>
            <input type="password" name="password" id="password" placeholder="Password">
            <span class="error"><?php echo $errors['password'] ?? '' ?></span>
        </div>
        <br>
        <input type="checkbox" name="rememberMe" id="rememberMe">
        <label for="remember">Remember me</label>
        <br><br>
        <div>
            <button type="submit">Log In</button>   
        </div>
    </form>

    <div style="text-align: center;">
        <br><br>
        <p>Or</p>
        <br><br>
        <h2><a href="<?php echo $loginUrl ?>">Google</a></h2>
        <br><br>
        <p>Not registered? <a href="sign-up.php">Create an account</a> | <a href="index.php">Website</a></p>
    </div>
   
   
</body>
</html>