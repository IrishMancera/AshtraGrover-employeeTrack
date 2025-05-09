<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ASHTRAGROVER</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="AG.simple.logo.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Aptos Narrow', sans-serif;
            color: white;
            text-transform: uppercase;
            text-shadow: 1px 1px 5px rgb(71, 49, 49);
            overflow-x: hidden; /* Hide horizontal scrollbar */
            background: linear-gradient(to bottom, #333333, #1a1a1a, #334d66, #001f3f);
            min-height: 100vh;
            height: auto;
        }

        #video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1; /* Ensure the video is behind other elements */
        }

        .container-fluid {
            position: relative;
            z-index: 2; /* Ensure the content is above the video */
        }

        .sticky-top {
            z-index: 3; /* Ensure the navigation bar is above the content */
        }

        .btn-custom {
            background-color: rgba(255, 255, 255, 0.5); /* Translucent white background for buttons */
            color: black;
        }

        .table-container {
            max-height: 400px; /* Adjust the maximum height of the table container */
            overflow-y: auto; /* Enable vertical scrollbar if needed */
            background-color: rgba(0, 0, 0, 0.8); /* Dark and translucent background for the table container */
            padding: 20px; /* Add padding to the table container */
            border-radius: 10px; /* Add border-radius for rounded corners */
            margin-top: 20px; /* Add margin to separate from buttons */
        }

        .table-container table {
            color: white; /* Set text color in the table */
        }

        .table-container th, .table-container td {
            border-color: white; /* Set border color for table cells */
        }
        td{
            color: white;
        }
        .table-striped>tbody>tr:nth-of-type(odd)>* {
            --bs-table-accent-bg: var(--bs-table-striped-bg);
             color: white; /* Change the text color for odd rows to red */
        }
        .back-video{
            position: absolute;
            right: 0;
            bottom: 0;
            z-index: -1;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <div class="container-fluid sticky-top bg-black bg-opacity-75" style="min-height: 70px;">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="nav mb-0 d-flex justify-content-around align-items-right h-120">
                    <a class="text-decoration-none h-100" href="aboutpage.html">
                        <li class="list-unstyled text-white d-flex align-items-right pe-8 ps-8 h-120 fw-bold">BACK</li>
                    </a>
            </ul>
        </div>
        <div class="row d-flex align-items-center">
        <!-- Logo Image -->
        <div class="col-sm-6 h-120">
            <a href="adminmenu.html">
                <img style="width:100px; margin-top: 10px;" class="h-70 img-fluid" src="img/AG.simple.logo.png" alt="logo" />
                <span class="visually-hidden">Go to Admin Menu</span>
            </a>
        </div>

    </nav>
    </div>
    </div>

    <!-- Main Content Section -->

        <div class="container">
    <h1 class="mt-5 mb-4 text-center"> MONTHLY ATTENDANCE REPORT</h1>
</div>

    <div class="container" style="position: relative; z-index: 2;">
        <div class="row d-flex align-items-center">
                <!-- Month Selection Button -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="mb-3">
                <label for="emp_id" class="form-label">Select Employee ID:</label>
                <select class="form-select" id="emp_id" name="emp_id" required>
                    <option value="">Select Employee ID</option>
                    <option value="all">All Employee</option>
                    <?php
                    $conn = new mysqli('localhost', 'root', '', 'ashtragroverdb');

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Fetch employee IDs
                    $emp_id_query = "SELECT DISTINCT emp_id FROM employee";
                    $emp_id_result = $conn->query($emp_id_query);

                    if ($emp_id_result->num_rows > 0) {
                        while ($row = $emp_id_result->fetch_assoc()) {
                            echo "<option value='" . $row['emp_id'] . "'>" . $row['emp_id'] . "</option>";
                        }
                    }
                    $conn->close();
                    ?>
                </select>
            </div>  
        <label for="month">Select Month:</label>
        <input style="margin-bottom: 10px;" type="month" id="month" name="month" required>
        <button type="submit">Generate Report</button>
    </form>
<button type="button" style="width:100%;" class="btn btn-custom" onclick="printTable()">Print Table</button>

            <!-- Your existing content -->

            <!-- Updated Table Container -->
            <div class="table-container">
            <table class="table table-bordered table-striped">
                <tbody>
                <?php
                    $conn = new mysqli('localhost', 'root', '', 'ashtragroverdb');

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $emp_id = $_POST['emp_id'];
                        $month = $_POST['month'];

                        // Fetch employee details
                        if ($emp_id === "all") {
                            echo "<h3>Employee Details</h3>";
                            echo "Selected Employee ID: All Employees<br>";
                            // No need to fetch individual employee details when all employees are selected
                        } else {
                            $emp_sql = "SELECT emp_fname, emp_mname, emp_lname FROM employee WHERE emp_id = ?";
                            $stmt = $conn->prepare($emp_sql);
                            $stmt->bind_param("s", $emp_id);
                            $stmt->execute();
                            $emp_result = $stmt->get_result();

                            if ($emp_result->num_rows > 0) {
                                $emp_row = $emp_result->fetch_assoc();
                                echo "<h3>Employee Details</h3>";
                                echo "Name: " . $emp_row['emp_fname'] . " " . $emp_row['emp_mname'] . " " . $emp_row['emp_lname'] . "<br>";
                            } else {
                                echo "Employee details not found.<br>";
                            }
                            $stmt->close();
                        }

                        // Fetch attendance details
                        if ($emp_id === "all") {
                            $sql = "SELECT emp_id, atlog_date, am_in, am_out, am_late, am_undertime, pm_in, pm_out, pm_late, pm_undertime
                                    FROM atlog
                                    WHERE DATE_FORMAT(atlog_date, '%Y-%m') = ?
                                    ORDER BY emp_id, atlog_date";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("s", $month);
                        } else {
                            $sql = "SELECT atlog_date, am_in, am_out, am_late, am_undertime, pm_in, pm_out, pm_late, pm_undertime
                                    FROM atlog
                                    WHERE emp_id = ? AND DATE_FORMAT(atlog_date, '%Y-%m') = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("ss", $emp_id, $month);
                        }

                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Check if there are rows in the result set
                        if ($result->num_rows > 0) {
                            echo "<h3>Attendance for " . date('F Y', strtotime($month)) . "</h3>";
                            echo "<div class='table-container'>";
                            echo "<table class='table table-bordered table-striped'>";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>Date</th>";
                            echo "<th>AM IN</th>";
                            echo "<th>AM OUT</th>";
                            echo "<th>AM LATE</th>";
                            echo "<th>AM UNDERTIME</th>";
                            echo "<th>PM IN</th>";
                            echo "<th>PM OUT</th>";
                            echo "<th>PM LATE</th>";
                            echo "<th>PM UNDERTIME</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";

                            // Loop through the fetched attendance data and output table rows
                            while ($attendance = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$attendance['atlog_date']}</td>";
                                echo "<td>{$attendance['am_in']}</td>";
                                echo "<td>{$attendance['am_out']}</td>";
                                echo "<td>{$attendance['am_late']}</td>";
                                echo "<td>{$attendance['am_undertime']}</td>";
                                echo "<td>{$attendance['pm_in']}</td>";
                                echo "<td>{$attendance['pm_out']}</td>";
                                echo "<td>{$attendance['pm_late']}</td>";
                                echo "<td>{$attendance['pm_undertime']}</td>";
                                echo "</tr>";
                            }

                            echo "</tbody>";
                            echo "</table>";
                            echo "</div>"; // Close the table container
                        } else {
                            echo "No records found for the specified month and employee.";
                        }

                        $stmt->close();
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Your existing scripts -->
    <script>
            function printTable() {
        window.print();
    }
        // Enable Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Show the hovering black box on hover
    </script>
</body>
</html>
