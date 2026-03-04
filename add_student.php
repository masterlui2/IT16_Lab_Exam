<?php
session_start();
include("db.php");

$error_message = "";

if(isset($_POST['add'])){

    $student_id = $_POST['student_id'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $course_description = $_POST['course_description'];
    $phone = $_POST['phone'];
    $phone = trim($_POST['phone']);

    // Phone validation: numbers only, 10-15 digits
    if(!preg_match('/^[0-9]+$/', $phone) || strlen($phone) < 10 || strlen($phone) > 15){
        $error_message = "Invalid phone number. Please use numbers only (10 to 15 digits).";
    }

    // Encryption settings
    $key = "my_secret_key_123"; 
    $cipher = "AES-128-CTR";
    $iv = "1234567891011121"; // 16 characters

    // Encrypt email
    $encrypted_email = openssl_encrypt($email, $cipher, $key, 0, $iv);

    $query = "INSERT INTO students 
              (student_id, fullname, email, course, course_description, phone)
              VALUES 
              ('$student_id', '$fullname', '$encrypted_email',
               '$course', '$course_description', '$phone')";
    if($error_message === ""){
        $query = "INSERT INTO students 
                  (student_id, fullname, email, course, course_description, phone)
                  VALUES 
                  ('$student_id', '$fullname', '$encrypted_email',
                   '$course', '$course_description', '$phone')";

    mysqli_query($conn, $query);
        mysqli_query($conn, $query);

    header("Location: dashboard.php");
        header("Location: dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Student</title>
</head>
<body>

<h2>Add Student</h2>

<?php if($error_message !== ""){ ?>
<p style="color: red;"><?php echo $error_message; ?></p>
<?php } ?>

<form method="POST">
    Student ID: <input type="text" name="student_id"><br>
    Full Name: <input type="text" name="fullname"><br>
    Email: <input type="text" name="email"><br>
    Phone: <input type="text" name="phone"><br>
    Course: <input type="text" name="course"><br>
    Course Description: <input type="text" name="course_description"><br>
    <button name="add">Add</button>
</form>

</body>
</html>