
<?php
include 'db.php';

// Receive student ID
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    die("Invalid student ID.");
}

// Retrieve student information
$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM Students WHERE Student_Id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$studentResult = mysqli_stmt_get_result($stmt);
$student = mysqli_fetch_assoc($studentResult);

if (!$student) {
    die("Student not found.");
}

// Retrieve courses selected by the student
$sql = "SELECT Courses.Course_No, Courses.Course_Name
        FROM Selected
        INNER JOIN Courses
        ON Selected.Course_No = Courses.Course_No
        WHERE Selected.Student_Id = ?
        ORDER BY Courses.Course_No";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Courses</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h1>STUDENT ENROLLED COURSES</h1>

<h2>
    Student:
    <?php echo htmlspecialchars($student['Student_Name']); ?>
</h2>

<p>
    Student ID:
    <?php echo htmlspecialchars($student['Student_Id']); ?>
</p>

<table>

<tr>
    <th>Course Number</th>
    <th>Course Name</th>
    <th>Action</th>
</tr>

<?php if (mysqli_num_rows($result) > 0) { ?>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>

    <tr>

        <td>
            <?php echo htmlspecialchars($row['Course_No']); ?>
        </td>

        <td>
            <?php echo htmlspecialchars($row['Course_Name']); ?>
        </td>

        <td>

            <form action="delete_course.php" method="POST">

                <input type="hidden"
                       name="Student_Id"
                       value="<?php echo $id; ?>">

                <input type="hidden"
                       name="Course_No"
                       value="<?php echo $row['Course_No']; ?>">

                <button type="submit" class="delete">
                    Delete
                </button>

            </form>

        </td>

    </tr>

    <?php } ?>

<?php } else { ?>

    <tr>
        <td colspan="3">
            This student has not selected any courses.
        </td>
    </tr>

<?php } ?>

</table>

<br>

<a href="enrollments.php">Back to Student List</a>

</div>

</body>
</html>
