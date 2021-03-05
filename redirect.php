<?php

    // Start session
    // session_start();

    // Include config file
    require_once "config.php";
    
    // authenticate code from Google OAuth Flow
    if (isset($_GET['code'])) {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $_SESSION['access_token'] = $token;
        if (isset($_SESSION['access_token'])){
            $client->setAccessToken($_SESSION['access_token']);
        }
        
        
        // get profile info
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        $email =  $google_account_info->email;
        $name =  $google_account_info->name;
        // echo "<pre>";
        // var_dump($email);

        //Check if the user exists in the db
        $sql = "SELECT email FROM users WHERE email = :email";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);            
            // Set parameters
            $param_email = $email;
            if($stmt->execute()){
                // Check if email exists
                if($stmt->rowCount() == 1){
                    session_start();
                    $hour = time() + (3600 * 24 * 30); #Set time to 30 days. 3600 is for 1 hour
                    // setcookie('id', $id, $hour);
                    setcookie('email', $email, $hour);
                    setcookie('active', 1, $hour);
                    
                    // Store data in session variables
                    $_SESSION["loggedin"] = true;
                    // $_SESSION["id"] = $id;
                    $_SESSION["email"] = $email;

                    // Redirect user to dashboard page
                    header("location: dashboard/index.php");
                } else {
                    $sql = "INSERT INTO users (username, email, my_referral_id, active) VALUES (:username, :email, :my_referral_id, 1)";

                    if($stmt = $pdo->prepare($sql)){
                        // Bind variables to the prepared statement as parameters
                        $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
                        $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                        $stmt->bindParam(":my_referral_id", $param_my_id, PDO::PARAM_STR);

                        // Set parameters
                        $param_username = $name;
                        $param_email = $email;
                        $rand = rand(100,999);
                        $param_my_id = $rand;

                        // Attempt to execute the prepared statement
                        if($stmt->execute()){
                            session_start(); 
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["email"] = $email;

                            // Set cookies
                            $hour = time() + (3600 * 24 * 30); #Set time to 30 days. 3600 is for 1 hour
                            // setcookie('id', $id, $hour);
                            setcookie('email', $email, $hour);
                            setcookie('active', 1, $hour);
                            // Redirect to dashboard page
                            header("location: dashboard/index.php.php");
                        }
                    }
                }
            }
        }
        
        // now you can use this profile info to create account in your website and make user logged in.
    } 
    // else {
    //     echo "<a href='".$client->createAuthUrl()."'>Google Login</a>";
    // }
?>