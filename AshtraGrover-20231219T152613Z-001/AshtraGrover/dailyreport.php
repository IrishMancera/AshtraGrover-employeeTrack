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
    <!-- Video Background -->

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
            </a>
        </div>

    </nav>
    </div>
    </div>
        <div class="container">
    <h1 class="mt-5 mb-4 text-center"> DAILY ATTENDANCE REPORT</h1>
</div>

    <div class="container" style="position: relative; z-index: 2;">
        <div class="row d-flex align-items-center">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="mb-3">
        <label for="date_selector">Select Date:</label>
        <input type="date" id="date_selector" name="selected_date">
        <button type="submit">Generate Report</button>
    </form>
<button type="button" style="width:100%;" class="btn btn-custom" onclick="printTable()">Print Table</button>
            <div class="table-container">
            <table class="table table-bordered table-striped">
                <tbody>
                <?php
                    $conn = new mysqli('localhost', 'root', '', 'ashtragroverdb');

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $selected_date = $_POST['selected_date'];

                            $formatted_date = date('l, F j, Y', strtotime($selected_date)); // Format the selected date

                            echo "<h2>Daily Attendance Report for $formatted_date</h2>";

                            // Fetch distinct days with entries in the atlog table for the selected date
                            $distinct_days_sql = "SELECT DISTINCT DATE(atlog_date) AS distinct_day FROM atlog WHERE DATE(atlog_date) = '$selected_date'";
                            $distinct_days_result = $conn->query($distinct_days_sql);

                            if ($distinct_days_result === false) {
                                die("Error in distinct days query: " . $conn->error);
                            }

                            while ($day_row = $distinct_days_result->fetch_assoc()) {
                                $specific_date = $day_row['distinct_day'];
                                $day_label = date('l, F j, Y', strtotime($specific_date));

                                echo "<h3>$day_label</h3>";

                                $emp_sql = "SELECT 
                                                employee.emp_id,
                                                emp_fname, 
                                                emp_mname, 
                                                emp_lname,
                                                MAX(CASE WHEN DATE(atlog_date) = '$specific_date' AND am_in IS NOT NULL AND am_out IS NOT NULL THEN 'Present' ELSE 'Absent' END) AS am_status,
                                                MAX(CASE WHEN DATE(atlog_date) = '$specific_date' AND pm_in IS NOT NULL AND pm_out IS NOT NULL THEN 'Present' ELSE 'Absent' END) AS pm_status
                                            FROM employee
                                            LEFT JOIN atlog ON employee.emp_id = atlog.emp_id
                                            WHERE DATE(atlog_date) = '$specific_date'
                                            GROUP BY employee.emp_id, emp_fname, emp_mname, emp_lname";

                                $emp_result = $conn->query($emp_sql);

                                if ($emp_result === false) {
                                    die("Error in attendance report query: " . $conn->error);
                                }

                                // Output the results for the specific day
                                echo "<div class='table-container'>";
                                echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>Employee ID</th>";
                                echo "<th>Name</th>";
                                echo "<th>AM Status</th>";
                                echo "<th>PM Status</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";

                                while ($row = $emp_result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['emp_id'] . "</td>";
                                    echo "<td>" . $row['emp_fname'] . " " . $row['emp_mname'] . " " . $row['emp_lname'] . "</td>";
                                    echo "<td>" . $row['am_status'] . "</td>";
                                    echo "<td>" . $row['pm_status'] . "</td>";
                                    echo "</tr>";
                                }

                                echo "</tbody>";
                                echo "</table>";
                                echo "</div>"; // Close the table container
                            }
                        }

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
