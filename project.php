<?php
    include("connectDB.php");
    $id = $_GET['id'];
    $query3 = "SELECT * FROM projects 
        JOIN users
        USING (idUser)
        WHERE idProject='$id';";
    $res = $link->queryExec($query3);
    $prDetails = mysqli_fetch_assoc($res);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
    </style>
    <style>
        .font-roboto {
            font-family: 'Roboto', sans-serif;
        }
    </style>
    <title><?php echo $prDetails['projectName']; ?></title>
</head>

<body class="mx-4 my-4">
    <h2 class="font-roboto">Project Name</h2>
    <hr>
    <h4 class="font-roboto"><?php echo $prDetails['projectName']; ?></h4>
    <hr>
    <?php
    echo "<p class=\"font-roboto\">Description<br>" . $prDetails['projectDescription'] . "</p>";
    echo "<p class=\"font-roboto\">End Date: " . $prDetails['projectEndDate'] . "</p>";
    echo "<p class=\"font-roboto\">Requested fund: " . $prDetails['requestedFund'] . "$</p>";
    ?>

</body>

</html>