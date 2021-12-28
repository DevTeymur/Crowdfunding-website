<?php
include('connectDB.php');

$invalid_password = False;
$invalid_email = False;
if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $query2 = "SELECT * FROM users WHERE email='$email';";
  $res2 = $link->queryExec($query2);
  $row = mysqli_fetch_assoc($res2);

  // Checking password and username
  if (mysqli_num_rows($res2) == 1) {
    if ($password == $row['password']) {
      session_destroy();
      session_start();
      $_SESSION['user_id'] = $row['idUser'];
      $_SESSION['first_name'] = $row['firstname'];
      $_SESSION['last_name'] = $row['lastname'];
      $_SESSION['email'] = $row['email'];
      header("Location:index.php");
      // header("Location:https://tim1.alwaysdata.net/crowdfunding/index.php");
    } else {
      $invalid_password = True;
    }
  } else {
    $invalid_email = True;
  }
}

?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="style.css" type="stylesheet">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <title>Login</title>
</head>

<body>
  <!-- Section -->
  <section class="vh-100" style="background-color: #508bfc;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card shadow-2-strong" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">
              <!-- <a style="font-weight: bold; color: white; background: black; border-radius: 8px;" class="navbar-brand" href="#">Crowd<span style="color: black; background: orange; border-radius: 10%; padding: 5px; margin-left: 5px;">Funding</span></a> -->
              <h3 class="mb-5">Welcome to CrowdFunding site</h3>
              <h3 class="mb-5">Sign in</h3>
              <?php
              if ($invalid_email == True) {
                echo "<div class=\"alert alert-danger\" role=\"alert\">";
                echo "User not found</div>";
              }
              if ($invalid_password == True) {
                echo "<div class=\"alert alert-danger\" role=\"alert\">";
                echo "False password</div>";
              }
              ?>

              <form action="" method="POST" name="loginform">
                <div class="form-outline mb-4">
                  <label class="form-label fw-bold" for="typeEmailX-2">Email</label>
                  <input type="email" name="email" id="typeEmailX-2" class="form-control form-control-lg" />
                </div>
                <div class="form-outline mb-4">
                  <label class="form-label fw-bold" for="typePasswordX-2">Password</label>

                  <input type="password" name="password" id="typePasswordX-2" class="form-control form-control-lg" />
                </div>

                <button class="btn btn-primary btn-lg btn-block" style="width: 100%;" type="submit" name="login">Login</button>
                <a href="home.php">Continue without login</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Section -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>