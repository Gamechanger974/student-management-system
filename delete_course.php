
<?php
include 'db.php';

// Only accept POST requests
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    die("Invalid request.");
}

// Receive student and course IDs
$studentId = filter_input(
    INPUT_POST,
    'Student_Id',
    FILTER_VALIDATE_INT
);

$courseNo = filter_input(
    INPUT_POST,
    'Course_No',
    FILTER_VALIDATE_INT
);

if (!$studentId || !$courseNo ||
    $studentId < 1 || $courseNo < 1) {

    die("Invalid student or course ID.");
}

// Delete the student's enrollment
$sql = "DELETE FROM Selected
        WHERE Student_Id = ?
        AND Course_No = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "ii",
    $studentId,
    $courseNo
);

if (mysqli_stmt_execute($stmt)) {

    // Return to updated course list
    header("Location: student_courses.php?id=" . $studentId);
    exit();

} else {

    echo "Error deleting enrollment: " .
         mysqli_error($conn);
}
?>
