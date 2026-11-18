
<?php
include 'db.php';

// Maximum students per page
$limit = 3;

// Get current page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

// Count all students
$countResult = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM Students"
);

$totalStudents = mysqli_fetch_assoc($countResult)['total'];

// Calculate total pages
$totalPages = max(1, ceil($totalStudents / $limit));

// Prevent invalid page numbers
$page = min($page, $totalPages);

// Calculate starting record
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
    <title>Student Management</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h1>STUDENT MANAGEMENT SYSTEM</h1>

<h2>All Students</h2>

<p>Click on a student's name to edit their information.</p>

<table>

<tr>
    <th>Student ID</th>
    <th>Student Name</th>
    <th>Email</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($result)) { ?>

<tr>
    <td><?php echo htmlspecialchars($row['Student_Id']); ?></td>

    <td>
        <a href="edit.php?id=<?php echo $row['Student_Id']; ?>">
            <?php echo htmlspecialchars($row['Student_Name']); ?>
        </a>
    </td>

    <td><?php echo htmlspecialchars($row['Email']); ?></td>
</tr>

<?php } ?>

</table>

<p>Page <?php echo $page; ?> of <?php echo $totalPages; ?></p>

<div class="pagination">

<?php if ($page > 1) { ?>
    <a class="btn"
       href="students.php?page=<?php echo $page - 1; ?>">
       Prev
    </a>
<?php } else { ?>
    <span></span>
<?php } ?>

<?php if ($page < $totalPages) { ?>
    <a class="btn"
       href="students.php?page=<?php echo $page + 1; ?>">
       Next
    </a>
<?php } ?>

</div>

<p>
    <a href="enrollments.php">View Student Courses</a>
</p>

</div>

</body>
</html>
