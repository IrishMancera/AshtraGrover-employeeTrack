<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/adminmenu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Welcome Admin!</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            color: #000;
        }
        body{
            background-color: black;
        }
        #file-input {
            display: none;
        }

        .file-label {
            cursor: pointer;
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
        }

        .profile-pic{
        display: flex;
        justify-content: center;
        align-items: center;
        
        }
        .profile-pic img {
        background-color: #555;
        border-radius: 50%;
        
        }
        #selectedPic{
            height: 150px;
            width: 150px;
            border-radius: 50%;
            overflow: hidden;
            object-fit: cover;
        }
        input[type="file"] {
        display: block;
        margin-left: 70px;
        margin-top: 15px;
        }

        .profile-pic img {
            height: 150px;
            width: 150px;
            object-fit: cover;
        }
        .form-container {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            border-radius: 5px;
            z-index: 9999;
            width: 600px;
            height: 600px;
            border: 2px solid #000; 
            overflow-y: auto; 
            background-color: #A1A0A0;
        }
        .edit-form{
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            border-radius: 5px;
            z-index: 9999;
            width: 600px;
            height: 600px;
            border: 2px solid #000; 
            overflow-y: auto; 
        }
        .button-container {
            position: absolute;
            top: 185px;
            left: 920px;
            z-index: 999; /* Adjust the z-index as needed */

        }


        /* Button styles */
        .button-container button {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 20px; /* Adjust spacing between buttons */
            border-color: white;
        }
        .addButton {
            background-color: black; /* Change background color for Edit button */
        }
        .editButton {
            background-color: black; /* Change background color for Edit button */
        }

        .deleteButton {
            background-color: black; /* Change background color for Delete button */
        }

        .button-container button:hover {
            background-color: white;
            color: black;
            border-color: black;
        }
        /* CSS styles */
        form {
            width: 50%;
            margin: auto;

            
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: black;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="password"] {

            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: white;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }
        .close-button{
            padding: 5px 10px;
            background-color: #ccc;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            float: right;
            margin-top: -30px;
            
        }
        tr{
            height : 40px;
            color: black;
        }
        th{
            background-color: white;
        }
        td {
        text-align: center; /* Center align content within table cells */
        color: white;
        }
    </style>
</head>
<body>
    <div class="hero">
        <nav>
            <a href="adminmenu.html">
                <img src="img/ASHTRAGROVERtxt.png" class="logo" alt="Ashtra Rover Logo">
            </a>
            <ul>
                <li><a href="#"><i class="fa-solid fa-bell bell-icon"></i></a></li>
            </ul>
        </nav>
        <div class="button-container">
            <button onclick="toggleForm()" class="addButton">Add Employee</button>
            <button onclick="toggleForm()" class="editButton">Edit</button>
            <button onclick="deleteEmployee()" class="deleteButton">Delete</button>
        </div>
        <div class="form-container" id="employeeForm">

            <!-- Your form goes here -->
            <h2 id="formTitle" >Add Employee Form</h2>
            <button onclick="toggleForm()" class="close-button">X</button>
            <br>

            <div class="profile-pic" id="profilePic" >
                <img src="#" alt="Profile Picture" id="selectedPic" >
            </div>
            <?php
            // Check if 'id' is present in the URL query string (for edit)
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $emp_id = $_GET['id'];

                // Connect to the database
                $conn = new mysqli('localhost', 'root', '', 'ashtragroverdb');

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch employee details based on ID
                $sql = "SELECT * FROM employee WHERE emp_id = $emp_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Fetch and process employee details here
                    while ($row = $result->fetch_assoc()) {
                        // Assign fetched data to variables for pre-filling the form
                        $first_name = $row['emp_fname'];
                        $middle_name = $row['emp_mname'];
                        $last_name = $row['emp_lname'];
                        $address = $row['emp_address'];
                        $email = $row['emp_email'];
                        $phone = $row['emp_phone'];
                        $hiredate = $row['emp_hire_date'];
                        $image = $row['emp_pic'];
                        $password = $row['emp_password'];
                        echo "<script>document.getElementById('selectedPic').src = '{$image}';</script>";
                    }
                } else {
                    echo "No employee found with this ID";
                }

                $conn->close();
            } else {
                // Default values if it's an addition (or edit failed to fetch data)
                $first_name = '';
                $middle_name = '';
                $last_name = '';
                $password='';
                $address = '';
                $email = '';
                $phone = '';
                $hiredate = '';
                $image = '';
            }
            if (isset($_GET['id'])) {
                // If 'id' is present, retrieve the ID from the URL
                $emp_id = $_GET['id'];
                $form_action = "update_employee.php"; // Form action for updating an existing employee
            } else {
                // If 'id' is not present, it means we're adding a new employee
                $form_action = "emp_add.php"; // Form action for adding a new employee
            }
            ?>
            <form action="<?php echo $form_action; ?>" method="post" class="w-50" enctype="multipart/form-data">
                <input type="file" name="image" id="image" value="<?php echo $image; ?>" onchange="showPreview(event)"  >
                <br><br>
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo $first_name; ?>" required>
                <br><br>
                <label for="middle_name">Middle Name:</label>
                <input type="text" id="middle_name" name="middle_name" value="<?php echo $middle_name; ?>" required>
                <br>
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>" required>
                <br>
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo $address; ?>" required>
                <br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                <br>
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>" required>
                <br>
                <label for="hiredate">Hire Date:</label>
                <input type="text" id="hiredate" name="hiredate" value="<?php echo $hiredate; ?>" required>
                <br>
                <?php if (isset($emp_id)) : ?>
                    <input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>">
                <?php endif; ?>
                <input type="submit" value="<?php echo isset($emp_id) ? 'Update' : 'Submit'; ?>">
            </form>
        </div>

            <?php
                   $servername = "localhost";
                   $username = "root";
                   $password = "";
                   $dbname = "ashtragroverdb";

                   $conn = new mysqli($servername, $username, $password, $dbname);

                   if ($conn->connect_error) {
                       die("Connection failed: " . $conn->connect_error);
                   }
                   $sql = "SELECT emp_id, emp_fname, emp_mname, emp_lname, emp_address, emp_email, emp_phone, emp_hire_date, emp_pic
                   FROM employee";
                   $result = $conn->query($sql);   
                   if ($result->num_rows > 0) {
                        echo '<div class="table-container" style="max-height: 400px; width:90%; overflow: auto; margin-top: 240px;">';
                        echo '<table border="1" style="width: 100%;" class="header-table"> ';
                        echo '
                       <tr>
                           <th>ID</th>
                           <th>Picture</th>
                           <th>First Name</th>
                           <th>Middle Name</th>
                           <th>Last Name</th>
                           <th>Address</th>
                           <th>Email</th>
                           <th>Phone</th>
                           <th>Hire Date</th>
                           <th>Select</th>
                       </tr>';

                       while ($row = $result->fetch_assoc()) {
                           echo '<tr>';
                           echo '<td>' . $row['emp_id'] . '</td>';
                           echo '<td style="text-align: center; vertical-align: middle;"> <img src="' . $row['emp_pic'] . '" style="width: 50px; height: 50px;"/> </td>';                           
                           echo '<td>' . $row['emp_fname'] . '</td>';
                           echo '<td>' . $row['emp_mname'] . '</td>';
                           echo '<td>' . $row['emp_lname'] . '</td>';
                           echo '<td>' . $row['emp_address'] . '</td>';
                           echo '<td>' . $row['emp_email'] . '</td>';
                           echo '<td>' . $row['emp_phone'] . '</td>';
                           echo '<td>' . $row['emp_hire_date'] . '</td>';
                           echo '<td>';
                           echo '<input type="checkbox" class="editCheckbox" value="' . $row['emp_id'] . '" onchange="editEmployee(this)">';
                           echo '</td>';
                           echo '</tr>';
                       }
                       echo '</table>';
                   } else {
                        echo '<div style="color: white;">No employees found.</div>';
                   }
                   $conn->close();
                ?>
    </div>
</body>
<script>
function deleteEmployee() {
    const urlParams = new URLSearchParams(window.location.search);
    const empId = urlParams.get('id');

    if (confirm('Are you sure you want to delete this employee?')) {
        if (empId) {
            window.location.href = `phpfile/delete.php?id=${empId}`;
            alert("Employee details deleted successfully");
        } else {
            alert('Employee ID not found');
        }
    }
}
function toggleForm() {
    var form = document.getElementById("employeeForm");
    var title = document.getElementById("formTitle");

    if (form.style.display === "none" || form.style.display === "") {
        form.style.display = "block";
        title.innerText = 'Add Employee Form'; // Set default title when form is shown
    } else {
        form.style.display = "none";
    }
}
// Function to change the title to "Edit Form" when the "Edit" button is clicked
document.querySelector('.editButton').addEventListener('click', function() {
    document.getElementById('formTitle').innerText = 'Edit Form';
});
function editEmployee(checkbox) {
    if (checkbox.checked) {
        const employeeId = checkbox.value;
        window.location.href = 'empmanagement.php?id=' + employeeId;
    }
}
            function showPreview(event) {
                // Code for previewing image remains unchanged
            }
            function showPreview(event) {
            const fileInput = event.target;
            const file = fileInput.files[0];
            const reader = new FileReader();

            reader.onload = function(event) {
                const img = document.getElementById('selectedPic');
                const profilePic = document.getElementById('profilePic');
                
                img.src = event.target.result;
                img.style.display = 'block';
                profilePic.style.background = 'none';
            }

            reader.readAsDataURL(file);
        }
        const urlParams = new URLSearchParams(window.location.search);
            const updateSuccess = urlParams.get('updateSuccess');
            const addSuccess = urlParams.get('addSuccess');
            // If updateSuccess is 'true', display an alert
            if (updateSuccess === 'true') {
                alert("Employee details updated successfully");
            }
            if (addSuccess === 'true') {
                alert("Employee Recorded Successfully");
            }
        
        </script>
</html>