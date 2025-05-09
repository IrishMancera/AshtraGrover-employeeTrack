<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['newPassword'], $_POST['confirmPassword'], $_POST['emp_id'])) {
    $employee_id = $_POST['emp_id'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate if both passwords match
    if ($newPassword === $confirmPassword) {
        // Your database connection code
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "ashtragroverdb";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind the update query using a prepared statement
        $update_query = "UPDATE employee SET emp_password = ? WHERE emp_id = ?";
        $stmt = $conn->prepare($update_query);

        if ($stmt) {
            // Bind parameters to the statement
            $stmt->bind_param("si", $newPassword, $employee_id);

            // Execute the statement
            if ($stmt->execute()) {
                echo "<script>alert('Password updated successfully!');";
                echo "window.location.href = '../searchlanding.php?id=$employee_id';</script>";
            } else {
                echo "Error updating password: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error in the prepared statement";
        }

        // Close the connection
        $conn->close();
    } else {
        // Redirect back to searchlanding.php with the emp_id parameter if passwords don't match
        echo "<script>alert('Passwords do not match. Please re-enter.');";
        echo "window.location.href = '../searchlanding.php?id=$employee_id';</script>";
    }
} else {
    echo "Please provide newPassword, confirmPassword, and emp_id";
}
?>
