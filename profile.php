<?php
include("commonFunctions.php");
include('checkAuth.php');

// Declaring some variables
$user_id = $_GET['id'];
$user_id = $_SESSION['user_id'];
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];
$email = $_SESSION['email'];
$owner = False;


$query = "SELECT * FROM projects
    WHERE idUser='$user_id';";
$query = $link->queryExec($query);
if (mysqli_num_rows($query) == 1) {
    $owner = True;
}
if ($owner == 1) {
    $users_project = mysqli_fetch_assoc($query);
    $prId = $users_project['idProject'];
    $prName = $users_project['projectName'];
    $prDesc = $users_project['projectDescription'];
    $prStart = $users_project['projectStartDate'];
    $prEnd = $users_project['projectEndDate'];
    $requestedFund = $users_project['requestedFund'];
    $projectHistory = $link->queryExec("SELECT * FROM `projects_investors`
        JOIN users
        USING (idUser)
        WHERE idProject='$prId';");
}

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

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');

        p {
            font-family: 'Roboto', sans-serif;
        }
    </style>
    <title><?php echo $first_name ?></title>
</head>

<body class="mx-4 my-4">
    <header class="d-flex flex-row" style="float: right">
        <a class="btn btn-outline-info p-2 mx-2" href="index.php">Home</a>
        <form method="post">
            <input type="submit" name="button1" value="Log out" class="btn btn-primary p-2">
        </form>
    </header>

    <h2 class="font-roboto">Personal information</h2>
    <hr>
    <?php
    echo "<p>First Name: " . $first_name . "</p>";
    echo "<p>Last Name: " . $last_name . "</p>";
    echo "<p>Email: " . $email . "</p>";
    ?>
    <h2 class="font-roboto">Your project</h2>
    <hr>
    <?php
    if ($owner == False) {
        echo "<p class=\"font-roboto\">You are not project owner.</p>";
    } else {
        echo "<p>Project: " . $prName . "</p>";
        echo "<p>Description: " . $prDesc . "</p>";
        echo "<p>Start Date: " . $prStart . "</p>";
        echo "<p>End Date: " . $prEnd . "</p>";
        echo "<p>Requested fund: " . $requestedFund . "</p>";
        echo "<p>Budget: " . projectsBudget($prId, $link) . "$</p>";

    ?>
        <!-- Displaying history of investments -->
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Donater</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Investment Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($detail = mysqli_fetch_assoc($projectHistory)) {
                    echo "<tr>";
                    echo "<td>" . ($detail['firstname'] . " " . $detail['lastname']) . "</td>";
                    echo "<td>" . ($detail['investmentFund']) . "</td>";
                    echo "<td>" . ($detail['investmentDate']) . "</td>";
                    echo "</tr>";
                }
                ?>

            </tbody>
        </table>
    <?php } ?>

    <!-- Footer -->
    <footer class="page-footer font-small blue">
        <div class="footer-copyright text-center py-3">
            © 2021: Created by Teymur Rzali CS-019, Elvin Rzayev CE-019
        </div>
    </footer>
    <!-- End Footer -->
</body>

</html>