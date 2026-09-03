<?php
session_start();
include 'config/db.php';

$message = "";

if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$result = mysqli_query($conn,"
SELECT *
FROM Tutors
WHERE Email='$email'
AND Password='$password'
");

    if(mysqli_num_rows($result) > 0){

        $tutor = mysqli_fetch_assoc($result);

        $_SESSION['TutorID'] = $tutor['TutorID'];
        $_SESSION['TutorName'] = $tutor['FirstName']." ".$tutor['LastName'];

        header("Location: tutor_dashboard.php");
        exit();

    }else{

        $message = "Invalid email address.";

    }
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Tutor Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

<div class="row justify-content-center mt-5">

<div class="col-md-5">

<div class="card shadow">

<div class="card-header bg-primary text-white text-center">

<h3>Tutor Login</h3>

</div>

<div class="card-body">

<?php
if($message != ""){
    echo "<div class='alert alert-danger'>$message</div>";
}
?>

<form method="POST">

<label>Email</label>
<input type="email" name="email" class="form-control mb-3" required>

<label>Password</label>
<input type="password" name="password" class="form-control mb-3" required>

<button type="submit" name="login" class="btn btn-primary w-100">
    Login
</button>

</form>

<br>

<a href="index.php" class="btn btn-secondary w-100">
    Back to Home
</a>

</div>

</div>

</div>

</div>

</div>

</body>
</html>