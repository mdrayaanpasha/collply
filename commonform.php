<?php
include 'dbconfig.php';

try {


    $check_edu = $pdo->prepare("SELECT * FROM `Educational Information` WHERE `email`=:email");
    $check_edu->bindParam(":email", $email, PDO::PARAM_STR);
    $check_edu->execute();
    $rows_edu = $check_edu->rowCount();

    $check = $pdo->prepare("SELECT * FROM `PersonalInfo` WHERE `email`=:email");
    $check->bindParam(":email", $email, PDO::PARAM_STR);
    $check->execute();
    $exist = $check->rowCount();

    $check_fam = $pdo->prepare("SELECT * FROM `familyInformation` WHERE `email`=:email");
    $check_fam->bindParam(":email", $email, PDO::PARAM_STR);
    $check_fam->execute();
    $row = $check_fam->rowCount();

    if ($rows_edu > 0 && $exist > 0 && $row > 0) {
        echo "<script>setTimeout(function() {alert('you have filled all information')}, 4000);";
        echo "setTimeout(function() { window.location.href = 'doc.php'; }, 4000);</script>";

        exit();
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Common Form!</title>
</head>
<style>


*{
    font-family: 'DM Sans','Noto Sans', sans-serif;
}
button{
    font-family: 'DM Sans','Noto Sans', sans-serif;
}
.opt{
    cursor:pointer;
}
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<?php
function input($type,$name){
    echo '<div class="form-group">';
    echo '<label for="'.$name.'">'.$name.'</label>';
    echo '<input name="'.$name.'" type="'.$type.'" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter '.$name.'" required>';
    echo '</div>';
    
}
function makeoption($name){
    echo '<div id="'.$name.'" class="opt">';
    echo "<p>".$name."</p>";
    echo '<img src="checkmark.png"alt="'.$name.'" id="'.$name.'-pic">';
    echo "</div>";
}
?>
<style>
    #options{
        display:flex;
        flex-wrap:wrap;
        padding:1vw;
        align-items:center;
        justify-content:space-evenly;
        border:2px solid rgba(221, 218, 218, 0.363);
    }
    .opt{
        border:2px solid rgba(221, 218, 218, 0.363);
        padding:2vw;
        border-radius:2vw;
        display:flex;
        align-items:center;
        justify-content:space-around;
    }
    .opt img{
        height:4vh;
        width:6vw;
        display:none;
    }
    nav img{
        height:12vh;
        width:40vw;
    }
    nav{

    }
    .container{
        padding:3vh;
        width:90vw;
        border:2px solid rgba(221, 218, 218, 0.363);
        border-radius:2vw;
        margin-top:5vh;
    }
    .gradient-text {
            margin-bottom:3vh;
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 36px;
            font-weight: bold;
            font-family: Arial, sans-serif;
        }
    .button-ine{
        margin-top:3vh;
    }
    @media (min-width:700px){
        nav img{
            width:20vw;
        }
    }
    @media (min-width:1000px){
        .container{
            width:50vw;
        }
        nav img{
            height:15vh;
            width:12vw;
        }
        .opt img{
            height:4vh;
            width:2vw;
        }
    }

    @media (min-width:1400px){
        .container{
            width:35vw;
        }
    }

    @media (min-width:2000px){
        nav img{
            height:17vh;
            width:15vw;
        }
    }
</style>
<body>
<script>
function homepage(){
    window.location.href="index.php"
}
</script>
<center>
<nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
<div class="container-fluid">
            <img src="logo.png" alt="Bootstrap" width="70" height="70">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="collegeform.php">Apply</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="search.php">Search</a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    <div id="options">
        <?php
        makeoption("Personal-Information");
        makeoption("Family-Information");
        makeoption("Educational-Background");
        ?>
    </div>

    
        <div id="personal-info" class="container">
            <form action="commonform.php" method="post">
            
            <h2 class="gradient-text">Personal Information</h2>
            <?php
            if($exist > 0){
                echo "<h3>Information Already Submitted!<h3>"; 
                echo "<script>document.getElementById('Personal-Information-pic').style.display='block';</script>";
            }else{
                input("text","Full-Name");
                input("date","Date-Of-Birth");
                input("text","Mobile-Number");    
                input("text","Nationality");
                echo '<label for="gender">Gender</label><br><select name="gender"><option value="-select-">--select--</option><option value="male">Male</option>';
                echo  '<option value="female">Female</option><option value="other">Other</option></select><br><input type="submit" value="save" class="btn btn-primary button-ine" name="save-personal" onclick="ref()" class="save"> </form>';
            }
            ?>
        </div>

        <div id="education" class="container">
        <form action="commonform.php" method="post">
        <h2 class="gradient-text">Educational Background</h2>
        <?php
        if($rows_edu > 0){
            echo "<h3>Information Already Submitted!<h3>"; 
            echo "<script>document.getElementById('Educational-Background-pic').style.display='block';</script>";
        }else{
            input("text","Enter-The-Name-Of-Your-School/PUCollage");
            input("text","City-Of-School");
            input("number","Your-Score-In-Recent-Tests");
            input("date","Date-Of-Graduating-Class12th/2ndPUC");

            echo '<label for="interest">Select Your Interest:</label><select id="interest" name="interest">';
            echo '<option value="select"><center>--SELECT--</center></option><option value="commerce">Commerce</option><option value="arts">Arts</option><option value="it">Information Technology</option><option value="engineering">Engineering</option><option value="science">Science</option><option value="medicine">Medicine</option><option value="law">Law</option><option value="design">Design</option>';
            echo '<option value="management">Management</option><option value="education">Education</option><option value="agriculture">Agriculture</option><option value="social_sciences">Social Sciences</option><option value="humanities">Humanities</option><option value="fine_arts">Fine Arts</option> <option value="architecture">Architecture</option><option value="veterinary_science">Veterinary Science</option><option value="other">Other</option></select><br>';
            echo '<input type="submit" value="save" class="btn btn-primary button-ine" name="save-education" onclick="ref()"></form>';
        }
        ?>
        
                    
                    
                
        </div>

        <div id="family" class="container">
    
        <h2 class="gradient-text">Family Information</h2>
        <form action="commonform.php" method="post">
        
            <?php

            $check_fam=$pdo->prepare("SELECT * FROM `familyInformation` WHERE `email`=:email");
            $check_fam->bindParam(":email",$email,PDO::PARAM_STR);
            $check_fam->execute();
            $row=$check_fam->rowCount();

            if($row > 0){
                echo "<h3 >Information Already Submitted!<h3>"; 
                echo "<script>document.getElementById('Family-Information-pic').style.display='block';</script>";
            }else{
                input("text","Mother-FullName");
                input("email","Mothers-Email");
                input("text","Mothers-PhoneNo");
                input("text","Mothers-Occupation");
                input("text","Fathers-FullName");
                input("email","Fathers-Email");
                input("text","Fathers-PhoneNo");
                input("text","Fathers-Occupation");
                echo '<input type="submit" value="save" name="saveFam" class="btn btn-primary button-ine" onclick="ref()"></form>';
            }
            
            
            ?>

        
        </div>        

    </form>    
    </div>
    </center>
    </body>
    <script>
    let edDiv = document.getElementById("education");
    let piDiv = document.getElementById("personal-info");
    let familyDiv = document.getElementById("family");

    let edButton = document.getElementById("Educational-Background");
    let piButton = document.getElementById("Personal-Information");
    let familyButton = document.getElementById("Family-Information");

    edDiv.style.display='block';
    piDiv.style.display = "none";
    familyDiv.style.display = "none";

    function ref(){
        location.relod();
        
    }
    edButton.addEventListener("click", () => {
        edDiv.style.display = "block";
        piDiv.style.display = "none";
        familyDiv.style.display = "none";
        documentDiv.style.display = "none";
    });

    piButton.addEventListener("click", () => {
        edDiv.style.display = "none";
        piDiv.style.display = "block";
        familyDiv.style.display = "none";
        documentDiv.style.display = "none";
    });

    familyButton.addEventListener("click", () => {
        edDiv.style.display = "none";
        piDiv.style.display = "none";
        familyDiv.style.display ="block";
        documentDiv.style.display = "none";
    });

    documentsButton.addEventListener("click", () => {
        edDiv.style.display = "none";
        piDiv.style.display = "none";
        familyDiv.style.display = "none";
        documentDiv.style.display = "block";
    });
    
</script>
<?php
function alert($mess){
    echo "<script>alert('".$mess."')</script>";
}
try{
    $pdo=new PDO($dsn,$username,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        if(isset($_POST["save-personal"])){
            if($_POST["gender"] === "-select-"){
                alert("Select Your Gender!!");
            } else {
                $name=$_POST["Full-Name"];
                $dob=$_POST["Date-Of-Birth"];
                $mobile_num=$_POST["Mobile-Number"];
                $nationality=$_POST["Nationality"];
                $gender=$_POST["gender"];

                $insertPi=$pdo->prepare("INSERT INTO `PersonalInfo`(`email`, `fullname`, `dob`, `mobile`, `nationality`, `gender`) VALUES (:email,:fullname,:dob,:mobile,:nationality,:gender)");
                $insertPi->bindParam(":email",$_SESSION["email"],PDO::PARAM_STR);
                $insertPi->bindParam(":fullname",$name,PDO::PARAM_STR);
                $insertPi->bindParam(":dob",$dob,PDO::PARAM_STR);
                $insertPi->bindParam(":mobile",$mobile_num,PDO::PARAM_STR);
                $insertPi->bindParam(":nationality",$nationality,PDO::PARAM_STR);
                $insertPi->bindParam(":gender",$gender,PDO::PARAM_STR);
                $insertPi->execute();
               
    
            }
        } else if(isset($_POST["save-education"])){
            if($_POST["interest"] == "select"){
                alert("Select Your Interest!!");
            } else {
                $school=$_POST["Enter-The-Name-Of-Your-School/PUCollage"];
                $city=$_POST["City-Of-School"];
                $score=$_POST["Your-Score-In-Recent-Tests"];
                $date=$_POST["Date-Of-Graduating-Class12th/2ndPUC"];
                $interest=$_POST["interest"];
        
                $insertEdu=$pdo->prepare("INSERT INTO `Educational Information`(`email`, `school`, `schoolCity`, `score`, `graduatingDate`, `interest`) VALUES (:email,:school,:schoolcity,:score,:graduatingDate,:interest)");
                $insertEdu->bindParam(':email',$email,PDO::PARAM_STR);
                $insertEdu->bindParam(':school',$school,PDO::PARAM_STR);
                $insertEdu->bindParam(':schoolcity',$city,PDO::PARAM_STR);
                $insertEdu->bindParam(':score',$score,PDO::PARAM_STR);
                $insertEdu->bindParam(':graduatingDate',$date,PDO::PARAM_STR);
                $insertEdu->bindParam(':interest',$interest,PDO::PARAM_STR);
                $insertEdu->execute();
                exit();
                header("cf.php");
            }
        } else if(isset($_POST["saveFam"])){

            $m=$_POST["Mother-FullName"];
            $mEmail=$_POST["Mothers-Email"];
            $mNo=$_POST["Mothers-PhoneNo"];
            $mOccupation=$_POST["Mothers-Occupation"];
            $f=$_POST["Fathers-FullName"];
            $fEmail=$_POST["Fathers-Email"];
            $fNo=$_POST["Fathers-PhoneNo"];
            $fOccupation=$_POST["Fathers-Occupation"];

            $insertFam=$pdo->prepare("INSERT INTO `familyinformation`(`email`, `mother`, `mEmail`, `mNo`, `mOccupation`, `father`, `fEmail`, `fNo`, `fOccupation`) VALUES (:email,:mother,:memail,:mno,:moccupation,:father,:femail,:fno,:foccupation)");
            $insertFam->bindParam(":email",$email,PDO::PARAM_STR);
            $insertFam->bindParam(":mother",$m,PDO::PARAM_STR);
            $insertFam->bindParam(":memail",$mEmail,PDO::PARAM_STR);
            $insertFam->bindParam(":mno",$mNo,PDO::PARAM_STR);
            $insertFam->bindParam(":moccupation",$mOccupation,PDO::PARAM_STR);
            $insertFam->bindParam(":father",$f,PDO::PARAM_STR);
            $insertFam->bindParam(":femail",$fEmail,PDO::PARAM_STR);
            $insertFam->bindParam(":fno",$fNo,PDO::PARAM_STR);
            $insertFam->bindParam(":foccupation",$fOccupation,PDO::PARAM_STR);
            $insertFam->execute();
        

        } 
}
}catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}



?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>