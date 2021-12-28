<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <!-- Project investment histoy for owner -->
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
    <!-- Top 5 investors visible only for owner -->
    <img src="top5.php" width="700" height="500" class="img-fluid rounded mx-auto d-block">

</body>

</html>