<?php
include 'config/db.php';

$tutorID = 1; // Change this later after tutor login

$sessions = mysqli_query($conn,"
SELECT
    Sessions.*,
    Students.FirstName,
    Students.LastName
FROM Sessions
INNER JOIN Students
ON Sessions.StudentID = Students.StudentID
WHERE Sessions.TutorID = $tutorID
ORDER BY SessionDate ASC, SessionTime ASC
");
?>

<!DOCTYPE html>
<html>

<head>

<title>My Sessions</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<?php include 'tutor_navbar.php'; ?>

<div class="container mt-4">

<h2>My Sessions</h2>

<div class="card shadow">

<div class="card-header bg-primary text-white">

Scheduled Tutoring Sessions

</div>

<div class="card-body">

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>Session ID</th>
<th>Student</th>
<th>Date</th>
<th>Time</th>
<th>Venue</th>

</tr>

</thead>

<tbody>

<?php

if(mysqli_num_rows($sessions)>0){

while($row=mysqli_fetch_assoc($sessions)){

?>

<tr>

<td><?php echo $row['SessionID']; ?></td>

<td><?php echo $row['FirstName']." ".$row['LastName']; ?></td>

<td><?php echo $row['SessionDate']; ?></td>

<td><?php echo $row['SessionTime']; ?></td>

<td><?php echo $row['Venue']; ?></td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="5" class="text-center">

No sessions assigned.

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

<br>

<a href="tutor_dashboard.php" class="btn btn-secondary">
Back to Dashboard
</a>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>