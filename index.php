<?php
include('checkAuth.php');
include('commonFunctions.php');

$user_id = $_SESSION['user_id'];
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];
$email = $_SESSION['email'];

$query = "SELECT * FROM projects
    JOIN users
    USING (idUser);";

$allpr = $link->queryExec($query);

// For log out button
if (isset($_POST['button1'])) {
    header("Location: login.php");
    // header("Location: https://tim1.alwaysdata.net/crowdfunding/login.php");
    session_destroy();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Home</title>
</head>

<body class="mx-3 my-1">

    <header class="d-flex flex-row" style="float: right">
        <?php echo "<a href=\"profile.php?id=" . ($user_id) . "\" class=\"btn btn-outline-info p-2 mx-2\" id=\"navbarNavAltMarkup\">Profile</a>"; ?>
        <form method="post">
            <input type="submit" name="button1" value="Log out" class="btn btn-primary p-2">
        </form>
    </header>
    <h3 class="font-roboto ">Crowdfunding</h3>
    </div>
    </nav>

    <!-- Section -->
    <section class="mx-4 my-4">
        <div class="row">
            <?php
            // Displaying all projects with checking preconditions
            while ($row = mysqli_fetch_assoc($allpr)) {
                echo "<div class=\"col-md-4 col-sm-12 mb-4\">";
                echo "<div class=\"card\" >";
                echo "<div class=\"card-body\">";
                if (expiredProject($row['idProject'], $link) == 1) {
                    echo "<h5 class=\"card-title\">" . ($row['projectName']) . " - <span class=\"fw-bold\">Expired</span></h5>";
                } else {
                    echo "<h5 class=\"card-title\">" . ($row['projectName']) . "</h5>";
                }
                echo "<p class=\"card-text\">Start date: " . ($row['projectStartDate']) . "</p>";
                echo "<p class=\"card-text\">End date: " . ($row['projectEndDate']) . "</p>";
                echo "<p class=\"card-text\">Requested fund: " . ($row['requestedFund']) . "$</p>";
                echo "<p class=\"card-text\">Owner: " . ($row['firstname'] . " " . $row['lastname']) . "</p>";

                if (isOwner($user_id, $row['idProject'], $link) == 1) {
                    echo "<a href=\"projectDetailUser.php?idProject=" . ($row['idProject']) . "\" class=\"btn btn-info\">See Details</a></div></div></div>";
                } else if (hasDonated($user_id, $row['idProject'], $link) == 1) {
                    echo "<a href=\"projectDetailUser.php?idProject=" . ($row['idProject']) . "\" class=\"btn btn-outline-warning\">Get info</a></div></div></div>";
                } else if (expiredProject($row['idProject'], $link) == 1) {
                    echo "<a href=\"projectDetailUser.php?idProject=" . ($row['idProject']) . "\" class=\"btn btn-outline-danger\">Get info</a></div></div></div>";
                } else {
                    echo "<a href=\"projectDetailUser.php?idProject=" . ($row['idProject']) . "\" class=\"btn btn-success\">Invest</a></div></div></div>";
                }
            }
            ?>
        </div>
    </section>
    <!-- End Section  -->

    <!-- Graph -->
    <img src="maingraph.php" width="1000" height="500" class="img-fluid rounded mx-auto d-block">

    <!-- Footer -->
    <footer class="page-footer font-small blue">
        <div class="footer-copyright text-center py-3">
            © 2021: Created by Teymur Rzali CS-019, Elvin Rzayev CE-019
        </div>
    </footer>
    <!-- End Footer -->

</body>

</html>