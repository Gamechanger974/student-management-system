
<?php
include 'db.php';

// Maximum records per page
$limit = 3;

// Current page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

// Count students
$countResult = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM Students"
);

$totalStudents = mysqli_fetch_assoc($countResult)['total'];

// Calculate pages
$totalPages = max(1, ceil($totalStudents / $limit));

$page = min($page, $totalPages);

// Calculate offset
$offset = ($page - 1) * $limit;

// Retrieve students
$sql = "SELECT * FROM Students
        ORDER BY Student_Id
        LIMIT $limit OFFSET $offset";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Enrollments</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h1>STUDENT COURSE ENROLLMENT</h1>

<p>Click on a student's name to view their courses.</p>

<table>

<tr>
    <th>Student ID</th>
    <th>Student Name</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($result)) { ?>

<tr>

    <td>
        <?php echo htmlspecialchars($row['Student_Id']); ?>
    </td>

    <td>
        <a href="student_courses.php?id=<?php
            echo $row['Student_Id'];
        ?>">
            <?php echo htmlspecialchars($row['Student_Name']); ?>
        </a>
    </td>

</tr>

<?php } ?>

</table>

<p>Page <?php echo $page; ?> of <?php echo $totalPages; ?></p>

<div class="pagination">

    <?php if ($page > 1) { ?>

        <a class="btn"
           href="enrollments.php?page=<?php echo $page - 1; ?>">
           Prev
        </a>

    <?php } else { ?>

        <span></span>

    <?php } ?>

    <?php if ($page < $totalPages) { ?>

        <a class="btn"
           href="enrollments.php?page=<?php echo $page + 1; ?>">
           Next
        </a>

    <?php } ?>

</div>

<p>
    <a href="students.php">Back to Student Management</a>
</p>

</div>

</body>
</html>
