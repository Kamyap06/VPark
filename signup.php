<?php
$showError = false;  
$showAlert = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){

include 'C:\xampp\htdocs\partials\_dbconnect.php';
$username = $_POST["username"];
$email = isset($_POST["email"]) ? $_POST["email"] : '';
$phone = $_POST["phone"];
$password = $_POST["password"];
$cpassword = $_POST["cpassword"];
// $exists=false;

$existSql = "SELECT * FROM `users` WHERE username='$username';";
$result = mysqli_query($conn, $existSql);
$numExitRows = mysqli_num_rows($result);
if($numExitRows > 0){
    $showError = "Username Already exists. ";
}
else{
    // $exists = false;


if($password == $cpassword ){
    // $hash = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO `users` (`username`, `email`, `password`, `dt`) VALUES ('$username', '$email', '$password', current_timestamp());";
    $result = mysqli_query($conn, $sql);
    if($result){
        $showAlert = true;
    }
}
else{
    $showError = "Password do not match ";
}
}
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>E_Secure</title>
  </head>
  <body>
    
    <?php
    if($showAlert){
    echo ' 
    <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Your account is now created and you can login.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
';
 }
 if($showError){
    echo ' 
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> '. $showError.'
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
';
 }
 ?>

    <div class="container my-4">
        <h1 class="text-center">SignUp</h1>
<form action="signup.php" method="post" style="display: flex; flex-direction:column; align-items:center ">
  <div class="form-group col-md-6">
    <label for="username">Username </label>
    <input type="text" maxlength="20" class="form-control" id="username" name="username" aria-describedby="emailHelp" required>
   
  </div>
  <div class="form-group col-md-6">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" name="email" required>
  </div>
  <div class="form-group col-md-6">
    <label for="phone">Phone no</label>
    <input type="phone" class="form-control" id="phone" name="phone" required>
  </div>
  <div class="form-group col-md-6">
    <label for="password">Password</label>
    <input type="password" maxlength="11" class="form-control" id="password" name="password" required>
  </div>
  <div class="form-group col-md-6">
    <label for="cpassword">Confirm Password</label>
    <input type="password" maxlength="11" class="form-control" id="cpassword" name="cpassword" required>
    <small id="emailHelp" class="form-text text-muted">Make sure type the same password.</small>
  </div>
 
  <button type="submit" class="btn btn-primary col-md-6">SignUp</button>
  <br><p col-md-6>Already have an account?<a href="login.php">Login</a></p>
</form>

    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>