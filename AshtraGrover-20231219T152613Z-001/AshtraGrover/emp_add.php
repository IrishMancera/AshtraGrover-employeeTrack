<?php
// Establishing a database connection
$conn = new mysqli('localhost', 'root', '', 'ashtragroverdb');

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieving form data
$first_name = $_POST['first_name'];
$middle_name = $_POST['middle_name'];
$last_name = $_POST['last_name'];
$address = $_POST['address'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$hire = $_POST['hiredate'];
$image = $_FILES['image'];
$password = !empty($_POST['password']) ? $_POST['password'] : 'ashtragrover1234'; // Set default password if empty

// Handling image upload
$imagefilename = $image['name'];
$imagefileerror = $image['error'];
$imagetmpname = $image['tmp_name'];

$filename_separate = explode('.', $imagefilename);
$file_extension = strtolower(end($filename_separate));

$extension = array('jpeg', 'jpg', 'png');
if (in_array($file_extension, $extension)) {
    $upload_image = 'employee_picture/' . $imagefilename;
    move_uploaded_file($imagetmpname, $upload_image);

    // Using prepared statement to prevent SQL injection
    $sql = "INSERT INTO employee (emp_fname, emp_mname, emp_lname, emp_address, emp_email, emp_phone, emp_hire_date, emp_pic, emp_password) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $first_name, $middle_name, $last_name, $address, $email, $phone, $hire, $upload_image, $password);

    // Execute the statement
    if ($stmt->execute()) {
        header("Location: empmanagement.php?addSuccess=true");
    } else {
        echo "Error in Employee";
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Invalid file extension";
}

// Close the database connection
$conn->close();
?>
