<?php

    // Initialize the session
    session_start();

    // Include config file
    require_once "config.php";
    $loginUrl = $client->createAuthUrl();

    // Require redirect file
    // require_once "redirect.php";
 
    // Define variables and initialize with empty values
    $errors = [];
    $username = $email = $password = $referral_id = '';

    // Processing form data when form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        // session_start();
        // var_dump($_POST);
        function test_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }		
    
        # Test username
        if (empty($_POST['username'])){
            $errors['username'] = 'Username is required';
        } elseif (strlen($_POST['username']) < 5) {
            $errors['username'] = 'Username too short! Minimum of 5chars allowed.';
            $username = test_input($_POST['username']);
        } else {
            $username = test_input($_POST['username']);
            # Prepare a prepared statement
            $sql = "SELECT id FROM users WHERE username = :username";
            if($stmt = $pdo->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
                // Set parameters
                $param_username = $username;
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    if($stmt->rowCount() == 1){
                        $errors['username'] = "This username is already taken.";
                    } 
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
    
                // Close statement
                unset($stmt);
            }
        }

        # Test Email
        if (empty($_POST['email'])){
            $errors['email'] = 'Email is required';
        }
        if (!empty($_POST['email'])){
            $email = test_input($_POST['email']);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors['email'] = 'Invalid email format';
                // $email = test_input($_POST['email']);
            } else {    
                # Prepare a prepared statement
                $sql = "SELECT id FROM users WHERE email = :email";
                if($stmt = $pdo->prepare($sql)){
                    // Bind variables to the prepared statement as parameters
                    $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                    // Set parameters
                    $param_email = $email;
                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        if($stmt->rowCount() == 1){
                            $errors['email'] = "This email is already taken.";
                        } 
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
        
                    // Close statement
                    unset($stmt);
                }
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
			// $pattern = "/^(?=.*[A-Z])(?=.*[0-9])(?=.*[a-z])(?=.*[\W]).{8,}$/"; # At least 8 character combination of alphanumeric lower and upper case, numbers and symbols
            // if (!preg_match($pattern, $password)){
            //     $errors['password'] = "Must contain at least 8 Alphanumeric characters with a combination of uppercase, lowercase, numbers and symbols";
			// }
            
        }

        # Test Referral_id
        if (!empty($_POST['referral_id'])){
            $referral_id = test_input($_POST['referral_id']);
            $sql = "SELECT id FROM users WHERE my_referral_id = :referral_id"; 
                if($stmt = $pdo->prepare($sql)){
                    // Bind variables to the prepared statement as parameters
                    $stmt->bindParam(":referral_id", $param_referral_id, PDO::PARAM_STR);
                    // Set parameters
                    $param_referral_id = $referral_id;
                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        if(!$stmt->rowCount() >= 1){
                            $errors['referral_id'] = "This referral code doesn't exists.";
                        } 
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
        
                    // Close statement
                    unset($stmt);
                }
        }

        # Check input errors before inserting in database
        if (empty($errors)){
            // echo "All is well";
             // Prepare an insert statement
            $sql = "INSERT INTO users (username, email, password, referral_id, my_referral_id, active) VALUES (:username, :email, :password, :referral_id, :my_referral_id, 1)";
            
            if($stmt = $pdo->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
                $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
                $stmt->bindParam(":referral_id", $param_referral_id, PDO::PARAM_STR);
                $stmt->bindParam(":my_referral_id", $param_my_id, PDO::PARAM_STR);
                
                // Set parameters
                $param_username = $username;
                $param_email = $email;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash and salt
                $param_referral_id = $referral_id;
                $rand = rand(100,999);
                $param_my_id = $rand;
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    // session_start(); 
                    // // Store data in session variables
                    // $_SESSION["loggedin"] = true;
                    // $_SESSION["email"] = $email;
                    // // Set cookies
                    // $hour = time() + (3600 * 24 * 30); #Set time to 30 days. 3600 is for 1 hour
                    // setcookie('email', $email, $hour);
                    // setcookie('active', 1, $hour);
                    // // Redirect to login page
                    header("location: login.php");
                } else{
                    echo "Something went wrong. Please try again later.";
                }

                // Close statement
                unset($stmt);
            }

        }

            # Send mail below

    }

    # Close connection
    unset($pdo);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Perry Pays</title>
    <style>
		.error {color: #FF0000;}
	</style>
</head>
<body>
    <h1>Register</h1>
    <p>Already have an account? <a href="login.php">Log in</a></p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        
        <div>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?php echo $username; ?>">
            <span class="error"><?php echo $errors['username'] ?? '' ?></span>
        </div>        
        <br>
        <div>
            <label for="email">Email</label>
            <input type="text" name="email" id="email" value="<?php echo $email; ?>">
            <span class="error"><?php echo $errors['email'] ?? '' ?></span>
        </div>
        <br>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" value="">
            <span class="error"><?php echo $errors['password'] ?? '' ?></span>
        </div>
        <br>
        <div>
            <label for="referral_id">Referral</label>
            <input type="text" name="referral_id" id="referral_id" value="<?php echo $referral_id; ?>">
            <span class="error"><?php echo $errors['referral_id'] ?? '' ?></span>
        </div>
        <br>
        <div>
            <input type="checkbox" name="terms" id="terms" value="" >
            I agree to the terms and conditions
        </div>
        <br>
        <div>
            <button type="submit">Get Started!</button>
        </div>
        <br>
        <p>Or</p>
        <p><a href="<?php echo  $loginUrl ?>">Google</a></p>
        <p><a href="index.php">Website</a></p>
    </form>
    
</body>
</html>