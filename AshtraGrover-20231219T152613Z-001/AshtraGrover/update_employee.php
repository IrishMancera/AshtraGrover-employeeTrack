<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all necessary POST parameters are present
    if (
        isset($_POST['emp_id'], $_POST['first_name'], $_POST['middle_name'], $_POST['last_name'], $_POST['address'], $_POST['email'], $_POST['phone'], $_POST['hiredate'])
    ) {
        // Retrieve POST data
        $emp_id = $_POST['emp_id'];
        $first_name = $_POST['first_name'];
        $middle_name = $_POST['middle_name'];
        $last_name = $_POST['last_name'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $hiredate = $_POST['hiredate'];

        // Initialize emp_pic variable
        $upload_image = '';

        // Check if an image file is uploaded
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = $_FILES['image'];

            $imagefilename = $image['name'];
            $imagetmpname = $image['tmp_name'];

            $filename_separate = explode('.', $imagefilename);
            $file_extension = strtolower(end($filename_separate));

            $allowed_extensions = array('jpeg', 'jpg', 'png');

            if (in_array($file_extension, $allowed_extensions)) {
                $upload_image = 'employee_picture/' . $imagefilename;
                move_uploaded_file($imagetmpname, $upload_image);
            } else {
                echo "Invalid file format. Please upload an image file.";
                exit();
            }
        }

        // Connect to the database
        $conn = new mysqli('localhost', 'root', '', 'ashtragroverdb');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Update query with emp_pic if an image is uploaded
        $sql = "UPDATE employee SET
            emp_fname=?,
            emp_mname=?,
            emp_lname=?,
            emp_address=?,
            emp_email=?,
            emp_phone=?,
            emp_hire_date=?" . (($upload_image !== '') ? ", emp_pic=?" : "") . "
            WHERE emp_id=?";

        $stmt = $conn->prepare($sql);

        // Determine the number of bind parameters based on the condition for emp_pic
        if ($upload_image !== '') {
            $stmt->bind_param("ssssssssi", $first_name, $middle_name, $last_name, $address, $email, $phone, $hiredate, $upload_image, $emp_id);
        } else {
            $stmt->bind_param("sssssssi", $first_name, $middle_name, $last_name, $address, $email, $phone, $hiredate, $emp_id);
        }   

        if ($stmt->execute()) {
            header("Location: empmanagement.php?updateSuccess=true");
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Missing required POST parameters";
    }
} else {
    echo "Invalid request method";
}
?>
