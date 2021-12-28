<?php
include("connectDB.php");
$query1 = "SELECT * FROM projects
    JOIN users
    USING (idUser);";
$res1 = $link->queryExec($query1);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Homepage</title>
</head>

<body class="mx-2 my-2">
    <a href="login.php" class="btn btn-primary position-absolute top-0 end-0 mx-3 my-3">Login</a>
    <!-- Section -->
    <section class="mx-4 my-4">
        <h3>Welcome</h3>
        <h5>Projects</h5>
        <div class="row">
            <?php
            // Displaying all projects
            while ($row = mysqli_fetch_assoc($res1)) {
                echo "<div class=\"col-md-4 col-sm-12 mb-4\">";
                echo "<div class=\"card\" >";
                echo "<div class=\"card-body\">";
                echo "<h5 class=\"card-title\">" . ($row['projectName']) . "</h5>";
                echo "<p class=\"card-text\">Start date: " . ($row['projectStartDate']) . "</p>";
                echo "<p class=\"card-text\">End date: " . ($row['projectEndDate']) . "</p>";
                echo "<p class=\"card-text\">Requested fund: " . ($row['requestedFund']) . "$</p>";
                echo "<p class=\"card-text\">Owner: " . ($row['firstname'] . " " . $row['lastname']) . "$</p>";
                echo "<a href=\"project.php?id=" . ($row['idProject']) . "\" class=\"btn btn-primary\">More info</a></div></div></div>";
            }
            ?>
        </div>
    </section>
    <!-- End Section -->

    <!-- Footer  -->
    <footer class="page-footer font-small blue">
        <div class="footer-copyright text-center py-3">
            © 2021: Created by Teymur Rzali CS-019, Elvin Rzayev CE-019
        </div>
    </footer>
    <!-- End Footer -->
</body>

</html>