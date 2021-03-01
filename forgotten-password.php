<?php

    // Include config file
    require_once "config.php";
    
    // Define variables and initialize with empty values
    $email = '';
    $errors = [];
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        // Clean input
        function test_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }	

        if (empty($_POST['email'])){
            $errors['email'] = "Enter your email";
        } else {
            $email = $_POST['email'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors['email'] = 'Invalid email format';
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
                        if(!$stmt->rowCount() >= 1){
                            $errors['email'] = "This email does not belong to a registered user.";
                        } else {
                            // Send mail here
                            echo "Yeaghhsj";
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
        
                    // Close statement
                    unset($stmt);
                }
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
    <title>Forgotten Password</title>
    <style>
		.error {color: #FF0000;}
	</style>
</head>
<body>
    <h1>Password Recovery</h1>
    <h3>Enter your email and instructions will sent to you!</h3>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label for="email">Email</label>
            <input type="text" name="email" id="email" value="<?php echo $email; ?>" placeholder="Email">
            <span class="error"><?php echo $errors['email'] ?? '' ?></span>
        </div>
        <br>
        <div>
            <button type="submit">Send</button>
        </div>
    </form>
    <br>
    <p><a href="login.php">Login</a> | <a href="index.php">Website</a></p>
</body>
</html>