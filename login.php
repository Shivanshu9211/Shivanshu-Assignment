<?php

session_start();


if (isset($_SESSION['username'])) {
    header("location: welcome.php");
    exit;
}
require_once "config.php";

$username = $password = "";
$err = "";


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty(trim($_POST['username'])) || empty(trim($_POST['password']))) {
        $err = "Please enter username + password";
    } else {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }


    if (empty($err)) {
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = $username;


        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) == 1) {
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                if (mysqli_stmt_fetch($stmt)) {
                    if (password_verify($password, $hashed_password)) {

                        session_start();
                        $_SESSION["username"] = $username;
                        $_SESSION["id"] = $id;
                        $_SESSION["loggedin"] = true;


                        header("location: welcome.php");

                    }
                }

            }

        }
    }


}


?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AutoFiller</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="styles2.css">
    <link rel="stylesheet" href="style.css">
</head>
<style>
    section{
    position: relative;
    width: 100%;
    height: 100vh;
    display: flex;
}

section .imgbx{

    z-index: -1;
    position: relative;
    width: 50%;
    height: 100%;
}

section .imgbx::before{
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(225deg,#e91e63, #03a9f4);
    z-index: 1;
    mix-blend-mode: screen;
}

section .imgbx img{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

section .contentbx{
    display: flex;
    justify-content: center;
    align-items: center;
    width: 50%;
    height: 100%;
}

section .contentbx .formbx h2{
    color: #607d8d;
    font-weight: 600;
    font-size: 1.5em;
    text-transform: uppercase;
    margin-bottom: 20px;
    border-bottom: 4px solid #03a9f4;
    display: inline-block;
    letter-spacing: 1px;
} 

section .contentbx .formbx .inputbx span{
    font-size: 16px;
    margin-bottom: 5px;
    display: inline-block;
    color: #607db8;
    font-weight: 16px;
    letter-spacing: 1px;
}

section .contentbx .formbx .inputbx input{
    width: 100%;
    padding: 10px 20px;
    outline: none;
    font-weight: 400;
    border: 1px solid #607db8;
    font-size: 16px;
    letter-spacing: 1px;
    color: #607db8;
    background: transparent;
    border-radius: 30px;
}

section .contentbx .formbx .inputbx input[type="submit"]{
    background: #03a9f4;
    color: black;
    outline: none;
    border: none;
    font-weight: 500;
    cursor: pointer;
}

section .contentbx .formbx .inputbx input[type="submit"]:hover{
    background: #CBF7F3;
    
}

section .contentbx .formbx .check{
    /* margin-top: 10px; */
    margin-bottom: 10px;
    color: #607d8d;
    font-weight: 400;
    font-size: 14px;
}

section .contentbx .formbx .inputbx p{
    color: #607d8d;
}
section .contentbx .formbx .inputbx p a{
    color: #03a9f4;
}

section{
    background-position-y: top;
}

    svg{
    position: absolute;
}

section .contentbx .formbx{
    margin-top: 100px;
}
</style>

<body>
    <div id="main-contentbox">

    <nav class="navbar">
      <a href="index.html" class="logo-name"><span style="color: #64ccc5">Hire</span><span>.com</span></a>
      <div class="navbar-links">
        <ul>
          <li><a href="">Home</a></li>
          <li><a href="">About Us</a></li>
          <li><a href="">Search</a></li>
          <li><a href="login.php">Sign In</a></li>
        </ul>
      </div>
    </nav>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 319">
            <path fill="#03a9f4" fill-opacity="1"
                d="M0,192L80,170.7C160,149,320,107,480,112C640,117,800,171,960,176C1120,181,1280,139,1360,117.3L1440,96L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z">
            </path>
        </svg>
    </div>

    <section>
        <div class="imgbx">
            <img src="1.jpg" alt="">
        </div>
        <div class="contentbx">
            <div class="formbx">
                <h2>Login</h2>
                <form action="" method="post">
                    <div class="inputbx">
                        <span>Username</span>
                        <input type="text" name="username">
                    </div>
                    <div class="inputbx">
                        <span>Password</span>
                        <input type="password" name="password">
                    </div>
                    <div class="check">
                        <label><input type="checkbox" name="" > Remember Me</label>
                    </div>
                    <div class="inputbx">
                        <input type="submit" value="Sign in" name="">
                    </div>
                    <div class="inputbx">
                        <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- <div class="container mt-4">
        <h3>Please Login Here:</h3>
        <hr> -->

        <!-- <form action="" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Username</label>
                <input type="text" name="username" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Enter Username">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                    placeholder="Enter Password">
            </div>
            <div class="form-group form-check" >
                <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form> -->



</body>

</html>