<?php
include 'config/db.php';

session_start();

if(!isset($_SESSION['TutorID'])){
    header("Location: tutor_login.php");
    exit();
}

$tutorID = $_SESSION['TutorID'];

if(isset($_POST['save'])){

    $session = $_POST['session'];
    $status = $_POST['status'];
    $date = date("Y-m-d");

    mysqli_query($conn,"
    INSERT INTO Attendance(SessionID,AttendanceDate,Status)
    VALUES('$session','$date','$status')
    ");
}

$sessions = mysqli_query($conn,"
SELECT
Sessions.SessionID,
Students.FirstName,
Students.LastName,
Sessions.SessionDate,
Sessions.SessionTime
FROM Sessions
INNER JOIN Students
ON Sessions.StudentID=Students.StudentID
WHERE Sessions.TutorID=$tutorID
");

$attendance = mysqli_query($conn,"
SELECT
Attendance.*,
Students.FirstName,
Students.LastName
FROM Attendance
INNER JOIN Sessions
ON Attendance.SessionID=Sessions.SessionID
INNER JOIN Students
ON Sessions.StudentID=Students.StudentID
WHERE Sessions.TutorID=$tutorID
ORDER BY AttendanceDate DESC
");
?>

<!DOCTYPE html>
<html>

<head>

<title>Attendance</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<?php include 'tutor_navbar.php'; ?>

<div class="container mt-4">

<h2>Attendance Management</h2>

<div class="card shadow mb-4">

<div class="card-header bg-primary text-white">

Mark Attendance

</div>

<div class="card-body">

<form method="POST">

<label>Select Session</label>

<select name="session" class="form-control mb-3" required>

<option value="">Choose Session</option>

<?php while($row=mysqli_fetch_assoc($sessions)){ ?>

<option value="<?php echo $row['SessionID']; ?>">

<?php echo $row['FirstName']." ".$row['LastName']; ?>

(<?php echo $row['SessionDate']; ?>)

</option>

<?php } ?>

</select>

<label>Status</label>

<select name="status" class="form-control mb-3">

<option>Present</option>

<option>Absent</option>

</select>

<button class="btn btn-success" name="save">

Save Attendance

</button>

</form>

</div>

</div>

<div class="card shadow">

<div class="card-header bg-success text-white">

Attendance Records

</div>

<div class="card-body">

<table class="table table-bordered">

<tr>

<th>Student</th>
<th>Status</th>
<th>Date</th>

</tr>

<?php while($row=mysqli_fetch_assoc($attendance)){ ?>

<tr>

<td><?php echo $row['FirstName']." ".$row['LastName']; ?></td>

<td><?php echo $row['Status']; ?></td>

<td><?php echo $row['AttendanceDate']; ?></td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>

</body>

</html>