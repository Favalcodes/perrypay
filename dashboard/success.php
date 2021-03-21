<?php 
if($_GET['status'] !== "success") {
    header("location:javascript://history.go(-1)");
}

?>

<html>
    <h1>SUCCESS</h1>
</html>