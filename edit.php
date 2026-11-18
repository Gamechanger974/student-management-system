
<?php
include 'db.php';

// Get student ID from URL
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    die("Invalid student ID.");
}

// Retrieve the selected student
$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM Students WHERE Student_Id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$student = mysqli_fetch_assoc($result);

if (!$student) {
    die("Student not found.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h1>EDIT STUDENT INFORMATION</h1>

<form action="update.php" method="POST">

    <input type="hidden"
           name="Student_Id"
           value="<?php echo $student['Student_Id']; ?>">

    <label>Student Name:</label>

    <input type="text"
           name="Student_Name"
           value="<?php echo htmlspecialchars($student['Student_Name']); ?>"
           required>

    <label>Email Address:</label>

    <input type="email"
           name="Email"
           value="<?php echo htmlspecialchars($student['Email']); ?>"
           required>

    <button type="submit">Update Student</button>

</form>

<br>

<a href="students.php">Back to Students</a>

</div>

</body>
</html>
