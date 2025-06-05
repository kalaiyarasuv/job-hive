<?php
session_start(); // ✅ Start session at the top

// Retrieve the email and password from the POST request
$email = $_POST['email'];
$password = $_POST['password'];

// Database connection
$dbname = "job_hive";
$conn = new mysqli("localhost", "root", "", $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to validate user and redirect accordingly
function validateUser($conn, $table, $email, $password, $RedirectPage, $ErrorRedirect) {
    $sql = "SELECT * FROM $table WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $Name = $user['username']; 

        // Check password (plain comparison here — not secure, but okay for now)
        if ($password === $user['password']) {
            $_SESSION['username'] = $Name; // ✅ Set session for later use
            header("Location: $RedirectPage");
            exit();
        } else {
            echo "<script>";
            echo "alert('Password is Incorrect');";
            echo "window.location.href='$ErrorRedirect';";
            echo "</script>";
            exit();
        }
    }

    $stmt->close();
    return false;
}

// Call the validation function
if (!validateUser($conn, 'emlog', $email, $password, 'pp.php', 'emlogin.html')) {
    echo "<script>";
    echo "alert('Email is Incorrect');";
    echo "window.location.href='emlogin.html';";
    echo "</script>";
    exit();
}

// Close DB connection
$conn->close();
?>
