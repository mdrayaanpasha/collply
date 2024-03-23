<?php
include 'dbconfig.php';

function remove($url){
    $domain = preg_replace("~(?:f|ht)tps?://(?:www\.)?([^/]+).*~i", "$1", $url);

    
    $domainName = explode(".", $domain)[0];

    return $domainName;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
nav h2{
    color:white;
    cursor:pointer;
}
nav{
    height:15vh;
    width:98vw;
    display:flex;
    align-items:center;
    justify-content:space-around;
    background-color:rgba(156, 215, 147, 0.6);
}
nav img{
    height:18vh;
}
nav button{
    height:7vh;
    width:10vw;
    border:none;
    border-radius:1vw;
    background-color:rgba(156, 215, 147, 0.9);
    color:white;
    box-shadow: 2px 2px 2px 2px rgba(49, 48, 48, 0.281);
    font-weight:bold;
    font-size:2.5vh;
}
nav button:hover{
    background-color:rgba(156, 215, 147);
    box-shadow: none;
    cursor:pointer;
}
*{
    font-family: 'DM Sans','Noto Sans', sans-serif;
}
button{
    font-family: 'DM Sans','Noto Sans', sans-serif;
}
.collage-name{
    border:2px solid rgba(156, 215, 147, 0.6);
    background-color:white;
    height:5vh;
    width:10vw;
    font-weight:bold;
}
#collage-name-card{
    margin-top:6vh;
    display:flex;
    align-items:center;
    justify-content:space-evenly;
    flex-wrap:wrap;
}
#collage-form{
    border:2px solid rgba(156, 215, 147, 0.6);
    width:70vw;
    padding:5vh;
    margin-top:4vh;
}
.questions{
    margin-bottom:3vh;
}
#upload{
    background-color:rgba(156, 215, 147, 0.9);
    color:white;
    font-weight:bold; 
    height:6vh;
    width:10vw;
    border:none;  
}
.collages-filled{
    display:flex;
    border:2px solid rgba(156, 215, 147, 0.6);
    background-color:white;
    height:5vh;
    width:10vw;
    font-weight:bold;
    justify-content:space-evenly;
    align-items:Center;

}
.collages-filled img{
    height:4vh;
    width:2vw;

}
#main{
    display:none;
    width:20vw;
    padding:5vw;
    margin-top:5vh;
    border:4px solid rgba(156, 215, 147, 0.6);
}
#main p{
    font-size:4vh;
    font-weight:bold;
    color:green;
}
</style>
<script>
function submitted() {

    let main = document.getElementById("main");
    main.style.display='block';
    main.innerHTML = "<p>Already Submitted!<p>";
    setTimeout(function() {
        main.innerHTML = "";
        main.style.display="none" // Clear the message after 3 seconds
    }, 3000); // Adjusted to 3000 milliseconds (3 seconds)
}
</script>
<body>
<nav>
    <img src="logo.png" alt="" onclick="homepage()">
    <h2 onclick="homepage()">Selected Collages!</h2>
    <button onclick="gethelp">Get Help</button>
    </nav>
    <div id="collage-name-card">
    <?php
    //here am gonna get collages name 

    $get_collages=$pdo->prepare("SELECT `collageSelected` FROM `user-auth` WHERE `email`=:email");
    $get_collages->bindParam(":email",$email,PDO::PARAM_STR);
    $get_collages->execute();
    $collages=$get_collages->fetch(PDO::FETCH_ASSOC);
    $collage_Arr=explode(",",$collages["collageSelected"]);

    $s=count($collage_Arr);
    if($collage_Arr[1]==''){
        echo "no collages Selected!";
    }else{
        for($i=1;$i<$s;$i++){
            if($collage_Arr[$i]==NULL){
                continue;
            }else{
                //now check if stuff was inserted already?
                $inserted=$pdo->prepare("SELECT * FROM `$collage_Arr[$i]` WHERE `email`=:email ");
                $inserted->bindParam(":email",$email,PDO::PARAM_STR);
                $inserted->execute();
                $questions = $inserted->fetch(PDO::FETCH_ASSOC);
                $no_rows=$inserted->rowCount();
                $no_columns=$inserted->columnCount();
    
                $empty=true;
                if($no_rows == 0){
                    echo '<form action="college.php" method="POST">';
                    echo '<input type="hidden" name="collageName" value="'.$collage_Arr[$i].'">';
                    echo '<input type="submit" name="tofill" class="collage-name"  value="'.remove($collage_Arr[$i]).'">';
                    echo '</form>';
                }else{
                    echo '<div class="collages-filled" onclick="submitted()">';
                    echo '<img src="checkmark.png">';
                    echo '<p>'.remove($collage_Arr[$i]).'</p>';
                    echo '</div>';
                }
            }            
        }
    
        
    
   echo "</div>";


    //from here one i am gonna focus on how am gonna handle the requests to fill the forms of indiviual universities that
    //selected:

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["tofill"])) {
        $fillthis = $_POST["collageName"];
        // Now let's get the questions from the university where 'candidate' = $fillthis
        $get_questions = $pdo->prepare("SELECT * FROM `$fillthis` WHERE `email` = :fillthis");
        $get_questions->bindParam(":fillthis", $fillthis, PDO::PARAM_STR);
        $get_questions->execute();
        $questions = $get_questions->fetch(PDO::FETCH_ASSOC);
        $noQuestions = $get_questions->columnCount();


        echo '<center><form method="POST" id="collage-form" action="college.php"><h1>'.remove($fillthis).' Questions: </h1>';
        for ($i = 2; $i < $noQuestions; $i++) {
            $columnMeta = $get_questions->getColumnMeta($i);
            $columnName = $columnMeta['name'];
            if ($columnName !== "candidate" && $columnName !== "name") {
                echo '<label for="' . $questions[$columnName] . '">' . $questions[$columnName] . '</label><br>';
                echo '<textarea type="text" name="'.$columnName.'" rows="10" cols="60" class="questions" required></textarea><br>';
            }
        }
        echo '<input type="hidden"  name="collagename" value="'.$fillthis.'">';
        echo '<input type="submit" name="upload" value="upload" id="upload">';
        echo "</form></center>";
    }
    function alert($mess){
        echo "<script>alert(".$mess.")</script>";
    }
    
    if(isset($_POST["upload"])){
        $fillthis=$_POST["collagename"];
        //now that i have the name of the collage that the user was gonna upload to now am gonna get their rows and then the data that the user has submitted
        $get_questions = $pdo->prepare("SELECT * FROM `$fillthis` WHERE `email` = :fillthis");
        $get_questions->bindParam(":fillthis", $fillthis, PDO::PARAM_STR);
        $get_questions->execute();
        $questions = $get_questions->fetch(PDO::FETCH_ASSOC);
        $noQuestions = $get_questions->columnCount();

        //now lets insert some shit so that i can update later;
        // $check_there=$pdo->prepare("SELECT * FROM `$fillthis` WHERE `email`=:email");
        // $check_there->bindParam(':email',$email,PDO::PARAM_STR);
        // $check_there->execute();
        $insert=$pdo->prepare("INSERT INTO `$fillthis` (`candidate`,`email`) VALUES ('Non Candidate',:email)");
        $insert->bindParam(':email',$email,PDO::PARAM_STR);
        $insert->execute();
        
        for($i=0;$i<$noQuestions;$i++){
            $columnMeta = $get_questions->getColumnMeta($i);
            $columnName = $columnMeta['name'];
            if($columnName=='candidate' || $columnName == 'email'){
                continue;
            }else{
                $update=$pdo->prepare("UPDATE `$fillthis` SET `$columnName`=:answer WHERE `email`=:email");
                $update->bindParam(':answer',$_POST[$columnName],PDO::PARAM_STR);
                $update->bindParam(':email',$email,PDO::PARAM_STR);
                $update->execute();
            }
           
           
        }

        header("Location: college.php");
        exit();
    }
}
    ?>
    <center>
    <div id="main">
    
    </div>
    </center>
</body>
</html>