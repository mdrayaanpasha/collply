<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<?php
include 'dbconfig.php';

function res($r){

    echo '<div class="collage" name="select">';
    echo '<form action="search.php" method="POST">';
    echo '<input type="hidden" name="collage-selected" value="' . $r["website_link"] . '">';
    echo '<input type="hidden" name="collage-name" value="' . $r["college_name"] . '">';
    if ($r["college_pic"] == NULL) {
        echo '<center><img src="images.png" id="collage-image" alt="pic-' . $r["college_name"] . '"><hr></center>';
    } else {
        // Output the image from the database
        echo '<img src="data:image/jpeg;base64,' . base64_encode($r["college_pic"]) . '" alt="' . $r["college_name"] . '" id="collage-image"><hr> ';
    }
    echo '<h3><b>' . $r["college_name"] . '</b></h3>';
    echo '<p>' . $r["about_college"] . '</p>';
    echo '<center><input type="submit" name="addcollage"  value="Add Collage" class="btn btn-primary"></center>'; 
    echo "</form></div>";
}

function isunique($arr){
    $s=count($arr);
    for($i=0;$i<$s;$i++){
        for($j=$i+1;$j<$s;$j++){
            if($arr[$i]===$arr[$j]){
                return false;
            }
        }
    }
    return true;
}
function UniqueOrNot($arr,$variable){
    $s=count($arr);
    if($s == 0){
        return true;
    }
    for($i=0;$i<$s;$i++){
        if($arr[$i]===$variable){
            return false;
        }
    }

    return true;
    
}
function alert($mess){
    echo "<script>alert('".$mess."')</script>";
}
if (isset($_POST["addcollage"])) {
    $collage_selected = $_POST["collage-selected"];
    $collage=$_POST["collage-name"];
    $query = $pdo->prepare("SELECT `collageSelected` FROM `user-auth` WHERE `email`=:email");
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC); // Fetch a single row
    
    // Check if a result was found
    if ($result) {
        // Concatenate the new collage selection with the existing ones
        $existing_selections = $result["collageSelected"];
        $collage_arr=explode(",",$existing_selections);
        $authenticate=UniqueOrNot($collage_arr,$collage_selected);
        if(!$authenticate){
            //if collage in the database
            alert("The Collage Has Already Been Added!");
            $new_str=$existing_selections;
            
        }else{
            //if collage not in databse
            $new_str = $existing_selections . "," . $collage_selected;
        }
    } else {
        // Set the new collage selection directly
        $new_str = $collage_selected;
    }

    //lets breakdown the array of collage links;
    
    
    // Prepare and execute the update query
    $update_query = $pdo->prepare("UPDATE `user-auth` SET `collageSelected`=:new WHERE `email`=:email");
    $update_query->bindParam(":email", $email, PDO::PARAM_STR);
    $update_query->bindParam(":new", $new_str, PDO::PARAM_STR);
    $status = $update_query->execute();
    
    // Check if the update was successful
    if ($status) {
        alert($collage." added!");
    }else{
        echo "there was a problem adding: ".$collage;
    }
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
img{
    width:35vw;
    height:14vh;
}
button{
    cursor:pointer;
}
*{
    font-family: 'DM Sans','Noto Sans', sans-serif;
}
button{
    font-family: 'DM Sans','Noto Sans', sans-serif;
}


body {
  background-image: url('Firefly students thinking about university applications 20315.jpg');
  -webkit-backdrop-filter: brightness(90%); 
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;
}
nav{
    margin-bottom:1vh;
}
nav img{
    height:9vh;
    width:30vw;
}
#search{
    display:flex;
}
.collage{
padding:3vw;
border: 3px solid rgba(221, 218, 218, 0.363);
}
.collage img{
    width:90vw;
    height:20vh;
}
@media (min-width:700px){
    .collage img{
    width:90vw;
    height:30vh;
}
}

@media (min-width:1400px){
    #showcollage{
        display:flex;
        flex-wrap:wrap;
    }
    .collage{
        width:30vw;
        margin-left:15vw;
        margin-bottom:3vh;
    }
    .collage img{
        width:25vw;
        
    }

}
</style>
<body>
    
    <script>
    function gocollage(){
        window.location.href='college.php';
    }
    </script>
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

    <form action="search.php" method="POST">
    <div class="mb-3" id="search">
        <input type="text" name="query" class="form-control" id="exampleFormControlInput1" placeholder="Search Collages.....">
        <input type="submit" value="Search" name="search" id="search-button" class="btn btn-primary">
    </div>
            <center><button onclick="gocollage()" class="btn btn-primary" type="button">Fill For Your Selected Collages</button></center>
        </form>
        <script>
            function showError() {
                var error = document.getElementById("error");
                error.style.display = "block";
                setTimeout(function() {
                    error.style.display = "none";
                }, 4000); // 4000 milliseconds = 4 seconds
            }
        </script>

        <style>
        
        </style>
        <div id="error" style="display: none;">
            <p><center>No Results Found!</center></p>
        </div>

   

    <div id="showcollage">
        
        <?php 
        
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["search"])) {
            $query = $pdo->prepare("SELECT * FROM `collegeinfo` WHERE `college_name` LIKE :something");
            $query->bindValue(":something", '%' . $_POST["query"] . '%', PDO::PARAM_STR);
            $query->execute();
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            $no_rows=$query->rowCount();
        
            if($no_rows > 0){
              foreach($res as $r){
                  res($r);
              }   
            }else{
                echo "<script>showError()</script>";
            }
           
        }
        $get = $pdo->prepare("SELECT * FROM `CollegeInfo` ORDER BY RAND() LIMIT 6;");
        $get->execute();
        $results = $get->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $r) {
            res($r);
        }
        
        ?>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>
