<?php
include 'dbconfig.php';
function alert($message){
    echo "<script>alert('".$message."')</script>";
}

try {


    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $authenticate_email = $pdo->prepare("SELECT * FROM `user-auth` WHERE `email` = :email");
        $authenticate_email->bindParam(":email", $email, PDO::PARAM_STR);
        $authenticate_email->execute();
        $res = $authenticate_email->fetch(PDO::FETCH_ASSOC);
        $email_rows = $authenticate_email->rowCount();

        if ($email_rows == 0) {
            alert("email doesnt exist!!");
        } else {
            $stored_password=$res['password'];
            $verify = password_verify($password, $stored_password);
            if($verify){
                $_SESSION["name"]=$res["firstName"];
                $_SESSION["email"]=$email;
                header("Location: collageform.php");
            }else{
                alert("Incorrect Password");
            }
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<style>
*{
    font-family: 'DM Sans','Noto Sans', sans-serif;
    
}
button{
    font-family: 'DM Sans','Noto Sans', sans-serif;
}

img{
    height:20vh;
    margin-bottom:2vh;
}
h2{
    margin-bottom:5vh;
}
form{
    padding:2vw;
    width:30vw;
    margin-left:35vw;
    border:4px solid rgba(221, 218, 218, 0.363);
    margin-top:8vh;
    border-radius:2vw;
}

a{
    color:black;
}
.register{
    background-color:rgba(255, 255, 255, 0.7);
    font-weight:bold;
}
.register:hover{
    background-color:rgba(255, 255, 255, 0.9);
}
#st-btn{
    margin-top:5vh;
}
@media only screen and (max-width: 1150px){
    form{
        width:50vw;
        margin-left:25vw;
    }
}
@media only screen and (max-width:770px){
    form{
        width:70vw;
        margin-left:15vw;
    }
}
@media only screen and (max-width:480px){
    form{
        width:90vw;
        margin-left:5vw;
    }
}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login!</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<body>
    
    <form action="login.php" method="POST" >
        <center>
    <img src="logo.png" alt=""><br>
    <h2>Login</h2> </center>
    <div class="form-group">
    <label for="email">Email address</label>
    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>    
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" name="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
  </div>
  <center><input type="submit" value="Register" name="login" class="btn btn-success" id="st-btn"><br>
    <a href="register.php">Dont have an account? Register!</a><br></center>
    </form>
    
</body>
</html>
