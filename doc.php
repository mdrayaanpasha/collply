<?php
include 'dbconfig.php';
$check_docs = $pdo->prepare("SELECT * FROM `documents` WHERE `email` = :email");
$check_docs->bindParam(":email", $email, PDO::PARAM_STR);
$check_docs->execute();
$rows = $check_docs->rowCount();

if ($rows > 0) {
    echo "<script>";
    echo "setTimeout(function() { alert('You have already provided all documents!'); }, 2000);";
    echo "setTimeout(function() { window.location.href = 'search.php'; }, 4000);";
    echo "</script>";
    exit();
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["UPLOAD"])) {
    // Check if all files were uploaded successfully
    $uploadErrors = [];
    foreach ($_FILES as $file) {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $uploadErrors[] = $file['name'] . ': File upload failed with error code ' . $file['error'];
        }
    }

    if (empty($uploadErrors)) {
        // Get file contents
        $adhar_content = file_get_contents($_FILES["Adhar"]["tmp_name"]);
        $marks10_content = file_get_contents($_FILES["Class-10th-MarksCard"]["tmp_name"]);
        $marks11_content = file_get_contents($_FILES["Class-11th-MarksCard"]["tmp_name"]);
        $candidate_content = file_get_contents($_FILES["Candidate-Image"]["tmp_name"]);

        // Insert into database
        $email = $_SESSION["email"];
        $insert = $pdo->prepare("INSERT INTO `documents`(`email`, `Adhar`, `class10`, `Class11`, `candidateimg`) VALUES (:email,:adhar,:c10,:c11,:img)");
        $insert->bindParam(":email", $email, PDO::PARAM_STR);
        $insert->bindParam(":adhar", $adhar_content, PDO::PARAM_LOB);
        $insert->bindParam(":c10", $marks10_content, PDO::PARAM_LOB);
        $insert->bindParam(":c11", $marks11_content, PDO::PARAM_LOB);
        $insert->bindParam(":img", $candidate_content, PDO::PARAM_LOB);

        if ($insert->execute()) {
            echo "Document uploaded successfully!";
        } else {
            echo "Error: " . $insert->errorInfo();
        }
    } else {
        // Display any upload errors
        echo implode('<br>', $uploadErrors);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>rayaan</title>
</head>
<script>
function homepage(){
    window.location.href="index.php"
}

</script>
<style>
label{
    font-weight:bold;
}
img{
    cursor:pointer;
}
.input-feild{
    margin-bottom:5vh;
}

.gradient-text {
    margin-top:3vh;
            margin-bottom:3vh;
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 36px;
            font-weight: bold;
            font-family: Arial, sans-serif;
        }
form{
    border-radius:2vw;
    border:5px solid rgba(221, 218, 218, 0.363);
    padding:2vw;
    margin-top:5vh;
    width:95vw;
}

*{
    font-family: 'DM Sans','Noto Sans', sans-serif;
}
button{
    font-family: 'DM Sans','Noto Sans', sans-serif;
}

</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<body>
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
    <center><h2 class="gradient-text">Documents Upload</h2></center>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <div>
        <label for="Adhar" class="form-label">Adhar Card</label>
        <input name="Adhar" class="form-control form-control-lg input-feild" id="formFileLg" type="file" required>
    </div>    
    <div>
        <label for="Class-11th-MarksCard" class="form-label">Class 11th Marks Card</label>
        <input name="Class-11th-MarksCard" class="form-control form-control-lg input-feild" id="formFileLg" type="file" required>
    </div>
    <div>
        <label for="Class-10th-MarksCard" class="form-label">Class 10th Marks Card</label>
        <input name="Class-10th-MarksCard" class="form-control form-control-lg input-feild" id="formFileLg" type="file" required>
    </div>
    <div>
        <label for="Candidate-Image" class="form-label">Candidate Image</label>
        <input name="Candidate-Image" class="form-control form-control-lg input-feild" id="formFileLg" type="file" required>
    </div>
        <input type="submit" name="UPLOAD" id="inp" onclick="go()"><br>
    </form>
    </center>
</body>
<script>
function go(){
    window.href.location("search.php")
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>
