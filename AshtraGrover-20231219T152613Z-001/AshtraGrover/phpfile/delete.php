<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $emp_id = $_GET['id'];

    $conn = new mysqli('localhost', 'root', '', 'ashtragroverdb');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete associated records in the 'atlog' table first
    $deleteAtlogQuery = "DELETE FROM atlog WHERE emp_id = $emp_id";

    if ($conn->query($deleteAtlogQuery) === TRUE) {
        // Once associated records are deleted, proceed to delete the employee record
        $deleteEmployeeQuery = "DELETE FROM employee WHERE emp_id = $emp_id";

        if ($conn->query($deleteEmployeeQuery) === TRUE) {
            echo '<script>alert("Employee Record Deleted");</script>'; // Display an alert
            header("Location: ../empmanagement.php");
            exit; 
        } else {
            echo "Error deleting employee record: " . $conn->error;
        }
    } else {
        echo "Error deleting associated records: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid employee ID";
}
?>
