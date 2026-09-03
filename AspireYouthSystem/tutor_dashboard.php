<?php
include 'config/db.php';

session_start();

if(!isset($_SESSION['TutorID'])){
    header("Location: tutor_login.php");
    exit();
}

$tutorID = $_SESSION['TutorID'];

// Tutor details
$tutor = mysqli_query($conn,"SELECT * FROM Tutors WHERE TutorID=$tutorID");
$tutorData = mysqli_fetch_assoc($tutor);

// Total students assigned to this tutor
$totalStudents = mysqli_num_rows(mysqli_query($conn,"
SELECT DISTINCT StudentID
FROM Sessions
WHERE TutorID=$tutorID
"));

// Today's sessions
$today = date('Y-m-d');

$todaySessions = mysqli_num_rows(mysqli_query($conn,"
SELECT *
FROM Sessions
WHERE TutorID=$tutorID
AND SessionDate='$today'
"));

// Attendance rate
$present = mysqli_num_rows(mysqli_query($conn,"
SELECT AttendanceID
FROM Attendance
INNER JOIN Sessions
ON Attendance.SessionID=Sessions.SessionID
WHERE Sessions.TutorID=$tutorID
AND Attendance.Status='Present'
"));

$totalAttendance = mysqli_num_rows(mysqli_query($conn,"
SELECT AttendanceID
FROM Attendance
INNER JOIN Sessions
ON Attendance.SessionID=Sessions.SessionID
WHERE Sessions.TutorID=$tutorID
"));

if($totalAttendance>0){
    $attendanceRate = round(($present/$totalAttendance)*100);
}else{
    $attendanceRate = 0;
}

// Today's session list
$sessionList = mysqli_query($conn,"
SELECT
Students.FirstName,
Students.LastName,
Sessions.SessionTime,
Sessions.Venue
FROM Sessions
INNER JOIN Students
ON Sessions.StudentID=Students.StudentID
WHERE Sessions.TutorID=$tutorID
AND Sessions.SessionDate='$today'
");
?>
<!DOCTYPE html>

<html>

<head>
<title>Tutor Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include 'tutor_navbar.php'; ?>
<div class="container mt-4">
<h2>Tutor Dashboard</h2>
<div class="row">
<div class="col-md-4">
<div class="card bg-primary text-white mb-3">
<div class="card-body">

<h5>Total Students</h5>

<h2><?php echo $totalStudents; ?></h2>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card bg-success text-white mb-3">

<div class="card-body">

<h5>Today's Sessions</h5>

<h2><?php echo $todaySessions; ?></h2>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card bg-warning text-dark mb-3">

<div class="card-body">

<h5>Attendance Rate</h5>

<h2><?php echo $attendanceRate; ?>%</h2>

</div>

</div>

</div>

</div>

<div class="card">

<div class="card-header">

<h4>Today's Sessions</h4>

</div>

<div class="card-body">

<table class="table table-bordered">

<tr>

<th>Student</th>

<th>Time</th>

<th>Venue</th>

</tr>

<?php while($row=mysqli_fetch_assoc($sessionList)){ ?>

<tr>

<td><?php echo $row['FirstName']." ".$row['LastName']; ?></td>

<td><?php echo $row['SessionTime']; ?></td>

<td><?php echo $row['Venue']; ?></td>

</tr>

<?php } ?>

</table>

</div>

</div>

<br>

<div class="card">

<div class="card-header">

<h4>Quick Actions</h4>

</div>
<div class="card-body">
<a href="students.php" class="btn btn-primary">View Students</a>
<a href="attendance.php" class="btn btn-success">Mark Attendance</a>
<a href="sessions.php" class="btn btn-warning">View Sessions</a>
</div>
</div>
</div>
</body>
</html>