<?php
session_start();
include("db.php");

if(!isset($_SESSION['user'])){
    header("Location: login.php");
}

function maskPhone($phone){
    $phone = trim($phone);
    $length = strlen($phone);

    if($length <= 4){
        return str_repeat("*", $length);
    }

    $visibleDigits = ($length > 4) ? 4 : 3;
    return str_repeat("*", $length - $visibleDigits) . substr($phone, -$visibleDigits);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="header">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?></h2>
        <div class="nav">
            <a href="add_student.php" class="btn btn-primary">➕ Add Student</a>
            <a href="logout.php" class="btn btn-secondary">🚪 Logout</a>
        </div>
    </div>

    <h3>Student List</h3>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Student ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM students");

            while($row = mysqli_fetch_assoc($result)){
            ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['course']); ?></td>
                    <td><?php echo maskPhone($row['phone']); ?></td>
                    <td>
                        <a href="delete_student.php?id=<?php echo $row['id']; ?>" 
                           class="btn-delete" 
                           onclick="return confirm('Delete this student?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>