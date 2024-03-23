<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register!</title>
</head>
<style>
*{
    font-family: 'DM Sans','Noto Sans', sans-serif;
    
}
button{
    font-family: 'DM Sans','Noto Sans', sans-serif;
}
body{
    background-color:white;
    margin:0;
    padding:0;
}
img{
    height:25vh;
    width:50vw;
}

#register-as-form, #studentRegister, #universityregister{
    width:90vw;
    padding:5vw;
    border:4px solid rgba(221, 218, 218, 0.363);
    border-radius:3vw;
}
#studentRegister,{
    margin-left:5%;
    margin-top:20%;
}
#register-as-form input, {
    margin-top:3vh;
}
#universityregister{
    margin-top:4vh;
}


@media (min-width:1000px){
    img{
        height:20vh;
        width:20vw;
    }
    #studentRegister{
        margin-top:10%;
    }

}
@media (min-width:1000px){
    #studentRegister,#universityregister{
        width:45vw;
        margin-left:30%;
        margin-top:2%;

    }
}
@media (min-width:1500px){
    #studentRegister,#register-as-form,#universityregister{
        width:50vw;
    }
    img{

        width:15vw;
    }
    #studentRegister{
        margin-left:30%;
        margin-top:5%;
    }
}
@media (min-width:1700px){
    #studentRegister,#universityregister,#register-as-form{
        width:30vw;
    }
    #studentRegister{
        margin-left:35%;
        margin-top:5%;
    }
}
@media (min-width:2000px){

}
</style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<body>
    <center>
        <div id="register-as">
    <img src="logo.png" alt="">
    <h1>We Are Happy To Serve You!</h1>
    <form id="register-as-form" action="register.php" method="post" id="ask">
    <h3>Register as: </h3>
    <input type="submit" value="Student" name="student" class="btn btn-secondary btn-lg"><br>
    <input type="submit" value="University" name="university" class="btn btn-secondary btn-lg"><br>
    </form>
    </div>
</center>

    <script>
    let registeras=document.getElementById("register-as");
    </script>
    <?php
   include 'dbconfig.php';

try {
    
    
    // Function to handle successful registration
    function successRegister() {
        echo "Thank you! Our team will contact you as soon as possible!";
    }
    
    // Function to handle university registration form
    function universityRegister() {
        echo "<script>document.getElementById('register-as').style.display='none';</script>";
        echo "<center>";
        echo '<form action="register.php" method="post" id="universityregister">';
        echo '<img src="logo.png">';
        echo "<h1>Hello!</h1>";
        echo "<p><b>Please provide your email for authentication. <br>Our team will connect with you promptly.</b></p>";
        echo '<div class="form-group">';
        echo '<label for="collegeemail">Email</label>';
        echo '<input name="collegeemail" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Email">';
        echo '</div>';
        echo '<input type="submit" name="university-submit" value="Submit" class="btn btn-success"><br>';
        echo '</form>';
        echo "</center>";
    }
    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["university-submit"])){
        $email=$_POST["collegeemail"];
        $checkemail=$pdo->prepare("SELECT * FROM `temp_names` WHERE  `UnivesityEmail`= :email");
        $checkemail->bindParam(':email',$email,PDO::PARAM_STR);
        $checkemail->execute();

        $no_rows=$checkemail->rowCount();

        if($no_rows > 0){
            echo "<script>alert('your email already exists!')</script>";
            universityRegister();
        }else{
            $query=$pdo->prepare("INSERT INTO `temp_names`(`UnivesityEmail`) VALUES (:email)");
            $query->bindParam(':email',$email,PDO::PARAM_STR);
            $query->execute();
        }

        
    }
    
    // Function to handle student registration form
    function studentRegister() {
        

        echo "<script>document.getElementById('register-as').style.display='none';</script>";
        
        echo '<form action="register.php" method="post" id="studentRegister">';
        echo '<center><img src="logo.png">';
        echo '<h2>Register</h2></center>';
        echo '<div class="form-group">';
        echo '<label for="firstName">First Name</label>';
        echo '<input name="firstName" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter first name">';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="lastName">Last Name</label>';
        echo '<input name="lastName" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter last name">';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="email">Email</label>';
        echo '<input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Email">';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="password">Password</label>';
        
        echo '<input name="password" type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Password">';
        echo '</div>';
        echo '<center><input type="submit" value="Register" name="register" class="btn btn-success" id="st-btn"></center><br>';
        echo '<a href="login.php">Already have an account? Login</a><br>';
        echo '</form>';
        
    }
    
    // Handle form submissions
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["student"])) {
            $_SESSION["user-type"] = "student";
            studentRegister();
        } elseif (isset($_POST["university"])) {
            $_SESSION["user-type"] = "university";
            universityRegister();
        } elseif (isset($_POST["register"])) {
            $email = $_POST["email"];
            $firstName = $_POST["firstName"];
            $lastName = $_POST["lastName"];
            $password = $_POST["password"];
            
            $check_email = $pdo->prepare("SELECT * FROM `user-auth` WHERE `email` = :email");
            $check_email->bindParam(':email', $email, PDO::PARAM_STR);
            $check_email->execute();

            $noEmails = $check_email->rowCount();


            if($noEmails>0){
                echo "<script>alert('Email Already Exists!');</script>";
                studentRegister();
            }else{
                studentRegister();
                $passCount=strlen($password);
                if($passCount < 8){
                    echo "<script>alert('Passwords Must Be Greater Than 8 Words!');</script>";
                }else{
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    $stmt = $pdo->prepare("INSERT INTO `user-auth`(`firstName`, `lastName`, `email`, `password`) VALUES (:firstName, :lastName, :email, :passw)");
                    $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
                    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
                    $stmt->bindParam(':passw', $hashedPassword, PDO::PARAM_STR);
                    $stmt->execute();
                    $_SESSION["completed"]=0;
                    $_SESSION["email"]=$email;
                    header("Location: work.php");
                }
            }
            
        }
    }
} catch (PDOException $e) {
    // Handle database connection errors
    echo "Error: " . $e->getMessage();
}
?>

</body>
</html>