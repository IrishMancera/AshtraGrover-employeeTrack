<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Welcome Employee</title>

    <style>
        html, body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom, #333333, #1a1a1a, #334d66, #001f3f);
 /* Set a background color for the body */
            overflow: hidden;
        }
        /* Adjust container and content alignment */
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            background-color: black;
            width: 375px;
            float: right;
            padding-top: 20px;
            color: white;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }
        .clock-container {
            display: flex;
            flex-direction: column;
            margin-bottom: 30px; /* Adjust the margin between the clock and h2 */
            margin-top: 10px;
            z-index: 100;
        }
        .digital.clock {
            border: 2px solid #333;
            padding: 10px;
            border-radius: 5px;
            font-size: 18px;
            margin-top: 10px;
            width: 200px;
            text-align: center;
        }
        .content {
            width: 600px;
            height: 200px;
            margin-left: 40px;
            position: relative; /* Required for pseudo-element positioning */
            color: white;
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
            background-color: #ecf0f1;
        }

        .content::after {
            content: '';
            position: absolute;
            left: -172px;
            bottom: 0;
            width: 2000px; /* Width of the line */
            height: 2px; /* Height (thickness) of the line */
            background-color: black; /* Color of the line */
        }
        nav{
            margin-left: 10px;
            
        }
        nav a{
            font-size: 25px;
            color: white;
            font-weight: bolder;
        }
        nav {
            background-color: #3498db; /* Background color for the navigation bar */
            padding: 10px 20px; /* Adjust padding */
            display: flex;
            justify-content: space-between; /* Align items at the ends */
            align-items: center;
            color: white; /* Text color for the link */
        }

        nav a {
            text-decoration: none; /* Remove underline */
            font-weight: bold;
            font-size: 16px;
        }

        nav a:hover {
            color: #ecf0f1; /* Change text color on hover */
        }
        .greet{
            margin-top: 40px;
            text-align: center;  
        }
        .am_pmin-out{
            text-align: center;
            margin-top: 100px;
        }
        .close-button{
            padding: 5px 10px;
            background-color: #ccc;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            float: right;
            margin-top: -40px;
        }
        .row{
           height: 100px;
        }

    </style>
</head>
<body>
    <div class="container">
        <h3>Clock (Manila Timezone)</h3>
        <div class="clock-container">
            <iframe src="https://free.timeanddate.com/clock/i95egn3n/n5514/szw210/szh210/hoc555/hbw6/cf100/hnce1ead6/hcw2/fan2/fas16/fdi64/mqc000/mqs4/mql20/mqw2/mqd94/mhc000/mhs3/mhl20/mhw2/mhd94/mmc000/mml10/mmw1/mmd94/hmr7/hsc000/hss1/hsl90" frameborder="0" width="210" height="210"></iframe>
        </div>
        <div class="digital clock">
            <?php
                date_default_timezone_set('Asia/Manila');
                echo date('h:i:s A');
                echo "<br>";
                echo date('d-m-Y');
                ?>
            </div>
    </div>
    <div class="content">
        <!-- Picture, Profile, and Change Password Button -->
        <div class="row">
            <div class="col-md-4 text-center">   
            <?php
                $conn = new mysqli('localhost', 'root', '', 'ashtragroverdb');

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                        }
                        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
                            $employee_id = $_GET['id'];

                            $query = "SELECT * FROM employee WHERE emp_id = ?";
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param("s", $employee_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result && $result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $emp_pic = $row['emp_pic'];
                                    if (!empty($emp_pic)) {
                                        echo '<div style="margin-top:13%">';
                                        echo '<img src="' . $emp_pic . '" alt="Employee Picture" style="width: 150px; height: 150px;border-radius: 75px;"> ';
                                        echo '</div>';
                                    } else {
                                        echo 'No employee picture available';
                                        }
                            }
                        }
                        $conn->close();
            ?>
            </div>
            <div class="col-md- 7 text-left">   
            <?php
                 $conn = new mysqli('localhost', 'root', '', 'ashtragroverdb');

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
                        $employee_id = $_GET['id'];

                            $query = "SELECT * FROM employee WHERE emp_id = ?";
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param("s", $employee_id);
                            $stmt->execute();
                            $result = $stmt->get_result();

                                if ($result && $result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $emp_id = $row['emp_id'];
                                    $first_name = $row['emp_fname'];
                                    $middle_name = $row['emp_mname'];
                                    $last_name = $row['emp_lname']; 
                                    $address = $row['emp_address'];
                                    $email = $row['emp_email'];
                                    $phone = $row['emp_phone'];

                                    // Display employee details
                                    echo "<br>";
                                    echo '<h4 style="font-weight: bold;">Profile</h4>';
                                    echo "<h5>Employee ID: $emp_id</h5>";
                                    echo "<h5>Name: $first_name $middle_name $last_name</h2>";
                                    echo "<h5>Address: $address</h5>";
                                    echo "<h5>Email: $email</h5>";
                                    echo "<h5>Phone: $phone</h5>";

                                } else {
                                    echo "No employee found for ID: $employee_id";
                                }
                                $conn->close();
                        }
            ?>
            </div>
            <div class="col-md-3 text-left">
                <button onclick="toggleForm('settingsFormPopup')" style="display: block; margin-left:700px; margin-top:-160px; background:black; color:white;" >Settings</button>
            </div>
        </div>
    </div>
    <div class="form-container" id="settingsFormPopup" style="display: none;">
        <!-- Your settings form goes here -->
        <h2 id="settingsFormTitle">Settings</h2>
        <button onclick="toggleForm('settingsFormPopup')" class="close-button">X</button>
        <!-- Add your settings form content here -->
        <form action="phpfile/change_password.php" method="post">
            <input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>">
            <label for="newPassword">New Password:</label>
            <input type="password" id="newPassword" name="newPassword" required><br><br>
            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required><br><br>
            <input type="submit" value="Change Password">
        </form>
        <h2>Send Message to Admin / Feedback</h2>
        <!-- Add your feedback form content here -->
        <form action="send_feedback.php" method="post">
            <label for="feedbackType">Type of Feedback:</label>
            <select id="feedbackType" name="feedbackType">
                <option value="message">Message to Admin</option>
                <option value="feedback">Feedback</option>
            </select><br><br>
            <label for="message">Your Message:</label><br>
            <textarea id="message" name="message" rows="4" cols="50" required></textarea><br><br>
            <input type="submit" value="Send">
        </form>
    </div>
    </div>    
        <div class="greet">
        <?php
                $conn = new mysqli('localhost', 'root', '', 'ashtragroverdb');

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
                    $employee_id = $_GET['id'];

                    $query = "SELECT * FROM employee WHERE emp_id = '$employee_id'";
                    
                    $result = $conn->query($query);

                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();

                        $first_name = $row['emp_fname'];

                        // Time-based greeting
                        date_default_timezone_set('Asia/Manila');
                        $time = date('H'); 

                        if ($time < 12) {
                            // Morning
                            echo "<h2 style='color:white;'>Good Morning, $first_name!</h2>";
                        } elseif ($time >= 12 && $time < 18) {
                            // Afternoon
                            echo "<h2 style='color:white;'>Good Afternoon, $first_name!</h2>";
                        } else {
                            // Evening
                            echo "<h2 style='color:white;'>Good Evening, $first_name! Thank you for your hard work!</h2>";
                        }
                    } 
                }
                $conn->close();
                ?>
    </div>
    <div class="am_pmin-out">
        <form method="post">
            <input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>">
            <input type="hidden" name="atlog_date" value="<?php echo date('Y-m-d'); ?>">
       
            <?php
                date_default_timezone_set('Asia/Manila');
                $time = date('H');

                if ($time >= 12 && $time < 18) {
                    // Afternoon: Show afternoon in and out buttons
                    echo '<input type="submit" name="morning_out" value="Morning Out" style="width: 200px; height: 50px; border-radius: 5px; margin:10px; color:black;">';
                    echo '<input type="submit" name="afternoon_in" value="Afternoon In" style="width: 200px; height: 50px; border-radius: 5px; margin:10px; color:black;">';
                    echo '<input type="submit" name="afternoon_out" value="Afternoon Out" style="width: 200px; height: 50px; border-radius: 5px; margin:10px; color:black;">';
                    include_once 'phpfile/pm_in_out.php';
                } elseif ($time >= 18) {
                    echo "<p style='color:white;'>Working Hours are finished! Good job for today!</p>";
                    echo '<input type="submit" name="afternoon_out" value="Afternoon Out" style="width: 200px; height: 50px; border-radius: 5px; margin:10px; color:black;">';
                    include_once 'phpfile/pm_in_out.php';
                } else {
                    // Morning: Show morning in and out buttons
                    echo '<input type="submit" name="morning_in" value="Morning In" style="width: 200px; height: 50px; border-radius: 5px; margin:10px; color:black;">';
                    echo '<input type="submit" name="morning_out" value="Morning Out" style="width: 200px; height: 50px; border-radius: 5px; margin:10px; color:black;">';
                    include_once 'phpfile/am_in_out.php';
                }
                ?>
        </form>
    </div>
</body>
<script>
    function toggleForm(formId) {
        var form = document.getElementById(formId);
        var title = document.getElementById(`${formId}Title`);

        if (form.style.display === "none" || form.style.display === "") {
            form.style.display = "block";
            title.innerText = 'Settings Form';
        } else {
            form.style.display = "none";
        }
    }
        </script>
</script>
</html>
