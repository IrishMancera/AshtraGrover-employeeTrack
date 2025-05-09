<?php
// Establish a database connection
$conn = new mysqli('localhost', 'root', '', 'ashtragroverdb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['emp_id']) && isset($_POST['password'])) {
    $employee_id = $_POST['emp_id'];
    $password = $_POST['password'];

    // Retrieve employee details by ID
    $query = "SELECT * FROM employee WHERE emp_id = ?";
    
    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $employee_id);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        // Employee ID found, verify the password
        $employee = $result->fetch_assoc();
        $stored_password = $employee['emp_password'];

        // Compare the passwords directly
        if ($password === $stored_password) {
            // Password matches, redirect to a landing page or perform further actions
            header("Location: ../searchlanding.php?id=$employee_id");
            exit(); // Ensure that no more output is sent
        } else {
            // Password does not match, redirect back with an error
            header("Location: ../ashtra_rover.html?error=1");
            exit();
        }
    } else {
        // Employee ID not found, redirect back with an error
        header("Location: ../ashtra_rover.html?error=1");
        exit();
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>
