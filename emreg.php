<?php
// Establish a connection to the database
$servername = "localhost"; // or "127.0.0.1"
$username = "root"; // Default username for MySQL in XAMPP
$password = ""; // Default password for MySQL in XAMPP (empty by default)
$dbname = "job_hive"; // Database name you created earlier

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve and sanitize data from the form
$username = $conn->real_escape_string($_POST['username']);
$email = $conn->real_escape_string($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm-password'];

// Password confirmation check
if ($password !== $confirm_password) {
    echo "Passwords do not match!";
    exit();
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format!";
    exit();
}

// Hash the password before storing (recommended for security)
// $hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare the SQL statement to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO emlog (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $password);

// Execute the query
if ($stmt->execute()) {
    // Use JavaScript alert and redirect without header() function
    echo "<script>alert('Account created successfully.'); window.location.href = 'emlogin.html';</script>";
    exit();  // Always use exit after redirect to stop further execution
} else {
    echo "Error: " . $stmt->error;
}


// Close the prepared statement and connection
$stmt->close();
$conn->close();
?>
