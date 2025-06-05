<?php
// Start session
session_start();

// Connect to your database
$servername = "localhost";
$username = "root";
$password = ""; // Your database password
$database = "job_hive"; // Change to your DB name

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$email = $_POST['email'];
$password = $_POST['password'];

// Protect against SQL injection
$email = mysqli_real_escape_string($conn, $email);

// Fetch user from database
$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    
    // Verify password
    if (password_verify($password, $row['password'])) {
        // Correct password
        $_SESSION['email'] = $email;
        $_SESSION['user_id'] = $row['id'];
        
        // Redirect to dashboard or homepage
        header("Location: dashboard.php");
        exit();
    } else {
        // Wrong password
        echo "<script>alert('Incorrect Password'); window.location.href='emlogin.html';</script>";
    }
} else {
    // No such user
    echo "<script>alert('No account found with this email'); window.location.href='emlogin.html';</script>";
}

// Close connection
$conn->close();
?>
