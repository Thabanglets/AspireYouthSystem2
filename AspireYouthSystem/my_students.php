<?php
include 'config/db.php';

$tutorID = 1; // Replace with logged-in tutor later

$students = mysqli_query($conn,"
SELECT DISTINCT
Students.StudentID,
Students.FirstName,
Students.LastName,
Students.Email,
Students.PhoneNumber,
Students.Status
FROM Students
INNER JOIN Sessions
ON Students.StudentID = Sessions.StudentID
WHERE Sessions.TutorID = $tutorID
");
?>

<!DOCTYPE html>
<html>

<head>

<title>My Students</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<?php include 'tutor_navbar.php'; ?>

<div class="container mt-4">

<h2>My Students</h2>

<div class="card shadow">

<div class="card-header bg-primary text-white">

Assigned Students

</div>

<div class="card-body">

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>ID</th>
<th>First Name</th>
<th>Last Name</th>
<th>Email</th>
<th>Phone</th>
<th>Status</th>

</tr>

</thead>

<tbody>

<?php

if(mysqli_num_rows($students)>0){

while($row=mysqli_fetch_assoc($students)){

?>

<tr>

<td><?php echo $row['StudentID']; ?></td>

<td><?php echo $row['FirstName']; ?></td>

<td><?php echo $row['LastName']; ?></td>

<td><?php echo $row['Email']; ?></td>

<td><?php echo $row['PhoneNumber']; ?></td>

<td>

<?php

if($row['Status']=="Approved"){

echo "<span class='badge bg-success'>Approved</span>";

}else{

echo "<span class='badge bg-warning text-dark'>Pending</span>";

}

?>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="6" class="text-center">

No students assigned.

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>