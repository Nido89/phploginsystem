<?php
require_once"config.php";
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
if ($_SERVER['REQUEST_METHOD'] == "POST"){

    // Check if username is empty
    if (empty(trim($_POST["username"]))){
        $username_err = "Username cannot be blank";
    }
    else {
        $sql = "SELECT id FROM users WHERE username =?";
        $stmt = mysqli_prepare($conn,$sql);
        if ($stmt)
        {
            mysqli_stmt_bind_param($stmt,"s", $param_username);
             // Set the value of param username
             $param_username = trim($_POST['username']);

             // A Try to execute this statement
             if (mysqli_stmt_execute($stmt)){
                 mysqli_stmt_store_result($stmt);
                 if (mysqli_stmt_num_rows($stmt) == 1)
                 {
                     $username_err = "This username is already taken";
                 }
                 else {
                     $username = trim($_POST['username']);
                 }
             }
             else {
                 echo "Something is not working";
             }
        }
    }
    mysqli_stmt_close($stmt);


    // Check for password
    if (empty(trim($_POST['password']))){
        $password_err = "Password can not be set Blank";
    }
    elseif(strlen(trim($_POST['password'])) < 5){
        $password_err = "Password can not be less than 5 chars";
    }
    else {
        $password = trim($_POST['password']);
    }

    // Checking for confirm password field
    if (trim($_POST['password']) != trim($_POST['confirm_password'])) {
        $password_err = "Password should match with confirm password";
    }

    // if there were no errors, move forward to insert in db
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err))
    {
        $sql = "INSERT INTO users(username,password) VALUES(?,?)";
        $stmt = mysqli_prepare($conn,$sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt,"ss",$param_username,$param_password);

            // set these parameters
            $param_username = $username;
            $param_password = password_hash($password,PASSWORD_DEFAULT);

            // Try to execute the query
            if (mysqli_stmt_execute($stmt))
            {
                header("location: login.php");

            }
            else {
                echo "Some things went wrong can not redirect";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}  
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://bootswatch.com/4/minty/bootstrap.min.css">

    <title>PHP-Based-Login-System</title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="#">PHPLoginSystem</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor01">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Contact Us</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>

<div class="container mt-4">
<h1>Register Today</h1>
<hr>
<form action="" method="post">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Username</label>
      <input type="text" class="form-control" name="username" id="inputEmail4">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Password</label>
      <input type="password" placeholder="Password" name="password" class="form-control" id="inputPassword4">
    </div>
  </div>
  <div class="form-group">
      <label for="inputPassword4">Confirm Password</label>
      <input type="password" placeholder="Confirm Password" name="confirm_password" class="form-control" id="inputPassword4">
    </div>
  <div class="form-group">
    <label for="inputAddress2">Address 2</label>
    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">City</label>
      <input type="text" class="form-control" id="inputCity">
    </div>
    <div class="form-group col-md-4">
      <label for="inputState">State</label>
      <select id="inputState" class="form-control">
        <option selected>Choose...</option>
        <option>...</option>
      </select>
    </div>
    <div class="form-group col-md-2">
      <label for="inputZip">Zip</label>
      <input type="text" class="form-control" id="inputZip">
    </div>
  </div>
  <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
        Check me out
      </label>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Sign in</button>
</form>

</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>