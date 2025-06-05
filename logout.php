<?php
session_start();

$username = $_SESSION['username'] ?? null;

if ($username) {
    // Connect to database
    $conn = new mysqli("localhost", "root", "", "job_hive");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete job posts by this user
    $stmt = $conn->prepare("DELETE FROM jobs WHERE posted_by = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

// Clear session and logout
$_SESSION = [];
session_destroy();

echo "<script>
    alert('Logged out and your job posts have been deleted.');
    window.location.href = 'emlogin.html';
</script>";
exit;
?>
