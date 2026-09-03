<?php
include 'config/db.php';

if(isset($_POST['save'])){

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $subject = $_POST['subject'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    mysqli_query($conn,
    "INSERT INTO Tutors
    (FirstName, LastName, Subject, Email, PhoneNumber)
    VALUES
    ('$firstname','$lastname','$subject','$email','$phone')");
}

$result = mysqli_query($conn,
"SELECT * FROM Tutors");
?>

<!DOCTYPE html>
<html>
<head>

<title>Tutors</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body>

<?php include 'navbar.php'; ?>

<div class="container mt-4">

<h2>Tutor Management</h2>

<a href="dashboard.php" class="btn btn-secondary mb-3">
Back to Dashboard
</a>

<form method="POST">

<input type="text"
name="firstname"
class="form-control mb-2"
placeholder="First Name"
required>

<input type="text"
name="lastname"
class="form-control mb-2"
placeholder="Last Name"
required>

<input type="text"
name="subject"
class="form-control mb-2"
placeholder="Subject"
required>

<input type="email"
name="email"
class="form-control mb-2"
placeholder="Email"
required>

<input type="text"
name="phone"
class="form-control mb-2"
placeholder="Phone Number"
required>

<button
name="save"
class="btn btn-success">
Add Tutor
</button>

</form>

<hr>

<table class="table table-bordered table-striped">

<tr>
<th>ID</th>
<th>First Name</th>
<th>Last Name</th>
<th>Subject</th>
<th>Email</th>
<th>Phone</th>
</tr>

<?php
while($row=mysqli_fetch_assoc($result)){
?>

<tr>
<td><?php echo $row['TutorID']; ?></td>
<td><?php echo $row['FirstName']; ?></td>
<td><?php echo $row['LastName']; ?></td>
<td><?php echo $row['Subject']; ?></td>
<td><?php echo $row['Email']; ?></td>
<td><?php echo $row['PhoneNumber']; ?></td>
</tr>

<?php
}
?>

</table>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>