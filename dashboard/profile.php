<?php

    // Start session
    session_start();

    // Include config file
    require_once "../config.php";

    $email = $_SESSION['email'];
    $errors = [];
    
    // Prepare a select statement
    $sql = "SELECT * FROM users WHERE email = :email";
    if ($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
        $param_email = $email;

        // Attempt to execute the prepared statement
        if ($stmt->execute()){
            // Check if email exists
            if($stmt->rowCount() == 1){
                $row = $stmt->fetch();

                $firstName = $row['firstname'];
                $lastName = $row['lastname'];
                $email = $row['email'];
                $username = $row['username'];
                $mobileNumber = $row['mobile_number'] ?? '';
                $bank = $row['bank'] ?? '';
                $accountType = $row['account_type'] ?? '';
                $accountNumber = $row['account_number'] ?? '';
                $fileNameNew = $row['image'];

            }
        }
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(isset($_FILES["photo"])){
            $fileName = $_FILES["photo"]["name"];
            $fileType = $_FILES["photo"]["type"];
            $fileSize = $_FILES["photo"]["size"];
            $fileTmpName = $_FILES['photo']['tmp_name'];
            $fileError = $_FILES['photo']['error'];
        }

        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileActualExt= strtolower($ext); # Change the all extensions cases to lower cases

        // Allowed file types
        $allowed = array("jpg", "jpeg", "png");

        // Verify file size - 10MB maximum
        $maxSize = 10 * 1024 * 1024;

        if (in_array($fileActualExt, $allowed)){
            if ($fileError === 0) {
                if ($fileSize < $maxSize){
                    $fileNameNew = uniqid('', true).".".$fileActualExt;
                    $targetDirectory = "uploads/";

                    // make sure the 'uploads' folder exists
                    // if not, create it
                    if(!is_dir($targetDirectory)){
                        mkdir($targetDirectory, 0777, true);
                    }
                    $fileDestination = $targetDirectory.$fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);                          
                } else {
                    $errors['photo'] = "Your photo is too big";
                }
            } else {
                # This is for the file info error
                $errors['photo'] = "There was an error uploading your photo!";
            }
        } else {
            # This is if the file is not of the filetype in $allowed array
            $errors['photo'] =  "You cannot upload photos of this type!";
        }
    
        if (empty($errors)){
            $sql = "UPDATE users SET image = :image WHERE email = :email";
            if ($stmt = $pdo->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                $stmt->bindParam(':image', $param_image);           
                // Set parameters
                $param_email = $_SESSION["email"];
                $param_image = $fileNameNew;

                if($stmt->execute()){
                    echo "<script>alert('Photo Uploaded')</script>";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Dashboard | Classbeam</title>
    <script src="assets/js/jquery-1.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/theme.css">
    <style type="text/css">

    </style>
    <script>
        function ajx(v, b) {
            var ee;
            if (window.XMLHttpRequest) {
                ee = new XMLHttpRequest();
            } else {
                ee = new ActiveXObject("Microsoft.XMLHTTP");
            };
            ee.open("POST", 'dash.php', true);
            ee.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
            ee.onreadystatechange = function() {
                if (ee.status == 200 && ee.readyState == 4) {
                    if (typeof b == "function") {
                        if (ee.responseText == "unauth") {
                            //do something here
                        } else {
                            b(ee.responseText);
                        }
                    };
                }
            }
            ee.send(v);
            return true;
        };
    </script>
</head>

<body>
    <div class="overlay">
        <form class="save_x">

        </form>
    </div>
    <div class='sidebar'>
        <div href='' onclick='window.location = this.getAttribute("href")' class='logo'><img src="../images/perry.png" alt="" class="perry-logo" width="100" height="100"></div>
        <ul class="maxsid">
            <li><i class="fa fa-home"></i><a href="index.php" class="nav-link"> Home</a></li>
            <li class="chosen"><i class="fa fa-user"></i><a href="profile.php" class="nav-link"> Profile</a></li>
            <li><i class="fa fa-bar-chart-o"></i><a href="sale.php" class="nav-link"> Sales</a></li>
            <li><i class="fa fa-gear"></i><a href="setting.php" class="nav-link"> Settings</a></li>
            <li><i class="fa fa-sign-out"></i><a href="logout.php" class="nav-link"> Logout</a></li>
        </ul>
    </div>
    <div class='content'>
        <div class="row profile-tab">
            <div class="col-md-3">
                <!-- <img src="../images/avatar.png" alt="" class="picture"> -->
                <?php echo isset($fileNameNew ) ? "<img src='uploads/{$fileNameNew}'  class='picture'>" : "<img src='../images/avatar.png' alt='' class='picture'>";  ?><br>
                <?php echo $errors['photo'] ?? '' ?>
            </div>
            <div class="col-md-9">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" >
                    <input type="file" name="photo" id="file" class="change-pix">
                    <button type="submit" class="change-pix">
                        Change Profile Picture
                    </button>
                </form>
            </div>
        </div>
        <div class="row profile-details">
            <div class="col-md-6">
                <h6>First Name</h6>
                <?php echo $firstName ?><br>
            </div>
            <div class="col-md-6">
                <h6>Last Name</h6>
                <?php echo $lastName ?><br>
            </div>
            <div class="col-md-6">
                <h6>Email</h6>
                <?php echo $email ?><br>
            </div>
            <div class="col-md-6">
                <h6>Username</h6>
                <?php echo $username ?><br>
            </div>
            <div class="col-md-6">
                <h6>Mobile Number</h6>
                <?php echo $mobileNumber ?><br>
            </div>
            <div class="col-md-6">
                <h6>Bank</h6>
                <?php echo $bank ?><br>
            </div>
            <div class="col-md-6">
                <h6>Account Type</h6>
                <?php echo $accountType ?><br>
            </div>
            <div class="col-md-6">
                <h6>Account Number</h6>
                <?php echo $accountNumber ?>
            </div>
        </div>
    </div>
</body>

<!-- Modals -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div>
        </div>
    </div>
</div>

</html>