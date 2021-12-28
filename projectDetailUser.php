<?php
include('commonFunctions.php');
$project_id = $_GET['idProject'];
session_start();
$user_id = $_SESSION['user_id'];
$_SESSION['project_id'] = $project_id;

$projectHistory = $link->queryExec("SELECT * FROM `projects_investors`
    JOIN users
    USING (idUser)
    WHERE idProject='$project_id';");

$pr_details = getProjectDetails($project_id, $link);

$remaining_money = $pr_details['requestedFund'] - projectsBudget($project_id, $link);

if (isset($_POST['donate'])) {
    $amount = $_POST['amount'];
    $date_ = $_POST['date_'];
    $date = date("Y-m-d", $timestamp);
    $insert_query = "INSERT INTO `projects_investors` (`idUser`, `idProject`, `investmentFund`, `investmentDate`) 
        VALUES ('$user_id', '$project_id', '$amount', '$date');";
    if ($link->queryExec($insert_query)) {
        header("Location: index.php");
        // header("Location: https://tim1.alwaysdata.net/crowdfunding/index.php");
    } else {
        echo '<script>Bad request to server</script>';
    }
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

        p,
        h2,
        h3 {
            font-family: 'Roboto', sans-serif;
        }
    </style>
    <title><?php echo $pr_details['projectName']; ?></title>
</head>

<body class="mx-3 my-3">
    <!-- Some information about project -->
    <?php
    echo "<div class=\"\"><a class=\"btn btn-outline-info\" href=\"index.php\">Home</a></div><hr>";
    echo "<div class=\"\"><h2>" . $pr_details['projectName'] . "</h2></div>";
    echo "<h3>Description</h3><hr>";
    echo "<p>" . $pr_details['projectDescription'] . "</p>";
    echo "<p>Start Date: " . $pr_details['projectStartDate'] . "</p>";
    echo "<p>End Date: " . $pr_details['projectEndDate'] . "</p>";
    echo "<p>Requested fund: " . $pr_details['requestedFund'] . "$</p>";

    // Checking preconditions if user can invest or not
    if (hasDonated($user_id, $project_id, $link) == 1) {
        echo "<p class=\"fw-bold\">You already contributed</p>";
    } else if (expiredProject($project_id, $link) == 1) {
        echo "<p class=\"fw-bold\">Project already expired</p>";
    } else {
        if (isOwner($user_id, $project_id, $link) == 0) {
            if ($remaining_money != 0) {
                // Form controls input fileds to invest to project
                echo "<hr>";
                echo "<form action=\"\" method=\"post\" name=\"form\">";
                echo "<label for=\"amount\" class=\"form-label\">Amount</label>";
                echo "<input type=\"number\" id=\"amount\" class=\"form-control\" name=\"amount\" required min=\"5\" max=\"" . $remaining_money . "\"><br>";
                echo "<label for=\"start\" class=\"form-label\">Date:</label>";
                echo "<input type=\"date\" id=\"start\" name=\"date_\" class=\"form-control\"
                    min=\"" . $pr_details['projectStartDate'] . "\" max=\"" . $pr_details['projectEndDate'] . "\">";
                echo "<input type=\"submit\" name=\"donate\" id=\"submit\" value=\"Invest\" class=\"btn btn-primary mt-3\"></form>";
            } else {
                echo "<p class=\"fw-bold\">Alredy enough invested to this project</p>";
            }
        } else {
            echo "<p class=\"fw-bold\">You are owner of this project</p>";
        }
    }
    ?>
    <img src="piechart.php" width="350" height="300" class="img-fluid rounded mx-auto d-block">
</body>

</html>

<?php
    if (isOwner($user_id, $project_id, $link) == 1) {
        include('projectDetailOwner.php');
    }
?>