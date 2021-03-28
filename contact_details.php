<?php

// Define variables and initialize with empty values
$errors = [];
$fullname = $email = $subject = $message = '';

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

    #Test fullname
    if (empty($_POST['fullname'])) {
        $errors['fullname'] = 'Full Name is required';
    } else {
        $fullname = test_input($_POST['fullname']);
        if (!preg_match("/^[a-zA-Z]*$/", $fullname)) {
            $errors['fullname'] = "Only letters and white spaces allowed";
        }
    }

    #Test subject
    if (empty($_POST['subject'])) {
        $errors['subject'] = 'Subject is required';
    } else {
        $subject = test_input($_POST['subject']);
        if (!preg_match("/^[a-zA-Z]*$/", $subject)) {
            $errors['subject'] = "Only letters and white spaces allowed";
        }
    }

    // email
    if (empty($_POST['email'])) {
        $errors['email'] = 'Email is required';
    } else {
        $email = test_input($_POST['email']);
        if (!preg_match("/^[a-zA-Z]*$/", $email)) {
            $errors['email'] = "Only letters and white spaces allowed";
        }
    }

    // message
    if (empty($_POST['message'])) {
        $errors['message'] = 'Message is required';
    } else {
        $message = test_input($_POST['message']);
        if (!preg_match("/^[a-zA-Z]*$/", $message)) {
            $errors['message'] = "Only letters and white spaces allowed";
        }
    }

    # Check input errors before inserting in database
    if (empty($errors)) {
        echo "All is well";
        // Prepare an insert statement
        $sql = "INSERT INTO contact (fullname, email, subject, message) VALUES (:fullname, :email, :subject, :message)";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":fullname", $param_fullname, PDO::PARAM_STR);
            $stmt->bindParam(":subject", $param_subject, PDO::PARAM_STR);
            $stmt->bindParam(":message", $param_message, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

            // Set parameters
            $param_fullname = $fullname;
            $param_subject = $subject;
            $param_message = $message;
            $param_email = $email;

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
                header("location: index.php");
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