
<?php
include 'db.php';

// Check whether the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Receive form information
    $id = filter_input(
        INPUT_POST,
        'Student_Id',
        FILTER_VALIDATE_INT
    );

    $name = trim($_POST['Student_Name'] ?? '');
    $email = trim($_POST['Email'] ?? '');

    // Validate information
    if (!$id || $id < 1 || $name === '' ||
        !filter_var($email, FILTER_VALIDATE_EMAIL)) {

        die("Please provide valid student information.");
    }

    // Update student information
    $stmt = mysqli_prepare(
        $conn,
        "UPDATE Students
         SET Student_Name = ?, Email = ?
         WHERE Student_Id = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ssi",
        $name,
        $email,
        $id
    );

    if (mysqli_stmt_execute($stmt)) {

        // Return to student list
        header("Location: students.php?message=updated");
        exit();

    } else {
        echo "Error updating student: " .
             mysqli_error($conn);
    }

} else {

    echo "Invalid request.";
}
?>
