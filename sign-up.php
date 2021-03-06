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
$firstname = $lastname = $username = $email = $password = $referral_id = '';

// Processing form data when form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // session_start();
    // var_dump($_POST);
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    #Test firstname
    if (empty($_POST['firstname'])) {
        $errors['firstname'] = 'First Name is required';
    } else {
        $firstname = test_input($_POST['firstname']);
        if (!preg_match("/^[a-zA-Z]*$/", $firstname)) {
            $errors['firstname'] = "Only letters and white spaces allowed";
        }
    }

    # Test lastname
    #Test lastname
    if (empty($_POST['lastname'])) {
        $errors['lastname'] = 'Last Name is required';
    } else {
        $lastname = test_input($_POST['lastname']);
        if (!preg_match("/^[a-zA-Z]*$/", $lastname)) {
            $errors['lastname'] = "Only letters and white spaces allowed";
        }
    }

    # Test username
    if (empty($_POST['username'])) {
        $errors['username'] = 'Username is required';
    } elseif (strlen($_POST['username']) < 5) {
        $errors['username'] = 'Username too short! Minimum of 5chars allowed.';
        $username = test_input($_POST['username']);
    } else {
        $username = test_input($_POST['username']);
        # Prepare a prepared statement
        $sql = "SELECT id FROM users WHERE username = :username";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            // Set parameters
            $param_username = $username;
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $errors['username'] = "This username is already taken.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    # Test Email
    if (empty($_POST['email'])) {
        $errors['email'] = 'Email is required';
    }
    if (!empty($_POST['email'])) {
        $email = test_input($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
            // $email = test_input($_POST['email']);
        } else {
            # Prepare a prepared statement
            $sql = "SELECT id FROM users WHERE email = :email";
            if ($stmt = $pdo->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                // Set parameters
                $param_email = $email;
                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    if ($stmt->rowCount() == 1) {
                        $errors['email'] = "This email is already taken.";
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                unset($stmt);
            }
        }
    }

    # Test Password
    if (empty($_POST['password'])) {
        $errors['password'] = 'Password is required';
    }
    if (!empty($_POST['password'])) {
        $password = test_input($_POST['password']);
        if (strlen($password) < 8) {
            $errors['password'] = 'Password must have at least 8 characters.';
        }
        // $pattern = "/^(?=.*[A-Z])(?=.*[0-9])(?=.*[a-z])(?=.*[\W]).{8,}$/"; # At least 8 character combination of alphanumeric lower and upper case, numbers and symbols
        // if (!preg_match($pattern, $password)){
        //     $errors['password'] = "Must contain at least 8 Alphanumeric characters with a combination of uppercase, lowercase, numbers and symbols";
        // }

    }

    # Check input errors before inserting in database
    if (empty($errors)) {
        // echo "All is well";
        // Prepare an insert statement
        $sql = "INSERT INTO users (firstname, lastname, username, email, password, active) VALUES (:firstname, :lastname, :username, :email, :password, 1)";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":firstname", $param_firstname, PDO::PARAM_STR);
            $stmt->bindParam(":lastname", $param_lastname, PDO::PARAM_STR);
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

            // Set parameters
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash and salt

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
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
            } else {
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div>
                <label for="firstname"><strong>First Name</strong></label><br>
                <input type="text" name="firstname" id="firstname" value="<?php echo $firstname; ?>" class="form-control">
                <span class="error"><?php echo $errors['firstname'] ?? '' ?></span>
            </div>
            <br>
            <div>
                <label for="lastname"><strong>Last Name</strong></label><br>
                <input type="text" name="lastname" id="lastname" value="<?php echo $lastname; ?>" class="form-control">
                <span class="error"><?php echo $errors['lastname'] ?? '' ?></span>
            </div>
            <br>
            <div>
                <label for="username"><strong>Username</strong></label><br>
                <input type="text" name="username" id="username" value="<?php echo $username; ?>" class="form-control">
                <span class="error"><?php echo $errors['username'] ?? '' ?></span>
            </div>
            <br>
            <div>
                <label for="email"><strong>Email</strong></label><br>
                <input type="text" name="email" id="email" value="<?php echo $email; ?>" class="form-control">
                <span class="error"><?php echo $errors['email'] ?? '' ?></span>
            </div>
            <br>
            <div>
                <label for="password"><strong>Password</strong></label><br>
                <input type="password" name="password" id="password" value="" class="form-control">
                <span class="error"><?php echo $errors['password'] ?? '' ?></span>
            </div>
            <br>
            <div>
                <label for="bank"><strong>Bank</strong></label><br>
                <input type="text" name="bank" id="bank" value="" class="form-control">
                <span class="error"><?php echo $errors['bank'] ?? '' ?></span>
            </div>
            <br>
            <div>
                <label for="account"><strong>Account Number</strong></label><br>
                <input type="text" name="account" id="account" value="" class="form-control">
                <span class="error"><?php echo $errors['password'] ?? '' ?></span>
            </div>
            <br>
            <div>
                <input type="checkbox" name="terms" id="terms" value="">
                I agree to the terms and conditions
            </div>
            <br>
            <div>
                <button type="submit" class="reg-btn">Register</button>
            </div>
        </form>
    </div>
</body>

</html>