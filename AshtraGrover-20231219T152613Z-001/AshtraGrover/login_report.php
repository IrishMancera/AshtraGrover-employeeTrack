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
            </a>
        </div>

    </nav>
    </div>
    </div>

    <!-- Main Content Section -->

        <div class="container">
    <h1 class="mt-5 mb-4 text-center"> LOGIN REPORT</h1>
</div>

<div class="container" style="position: relative; z-index: 2;">
    <div class="row d-flex align-items-center">
        <!-- Month Selection Button -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="month">Select Month:</label>
            <input style="margin-bottom: 10px;" type="month" id="month" name="month" required>
            <button type="submit">Generate Report</button>
        </form>
        <button type="button" style="width:100%;" class="btn btn-custom" onclick="printTable()">Print Table</button>

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

                        // Fetch attendance details
                        $sql = "SELECT emp_id, am_in, am_out, pm_in, pm_out
                                FROM atlog
                                WHERE DATE_FORMAT(atlog_date, '%Y-%m') = ?
                                ORDER BY emp_id, atlog_date";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $month);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Check if there are rows in the result set
                        if ($result->num_rows > 0) {
                            echo "<h3>Attendance for " . date('F Y', strtotime($month)) . "</h3>";
                            echo "<div class='table-container'>";
                            echo "<table class='table table-bordered table-striped'>";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>Employee ID</th>";
                            echo "<th>AM IN</th>";
                            echo "<th>AM OUT</th>";
                            echo "<th>AM Duration</th>";
                            echo "<th>PM IN</th>";
                            echo "<th>PM OUT</th>";
                            echo "<th>PM Duration</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";

                            // Loop through the fetched attendance data and output table rows
                            while ($attendance = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$attendance['emp_id']}</td>";
                                echo "<td>{$attendance['am_in']}</td>";
                                echo "<td>{$attendance['am_out']}</td>";
                                echo "<td>" . getDuration($attendance['am_in'], $attendance['am_out']) . "</td>";
                                echo "<td>{$attendance['pm_in']}</td>";
                                echo "<td>{$attendance['pm_out']}</td>";
                                echo "<td>" . getDuration($attendance['pm_in'], $attendance['pm_out']) . "</td>";
                                echo "</tr>";
                            }

                            echo "</tbody>";
                            echo "</table>";
                            echo "</div>"; // Close the table container
                        } else {
                            echo "No records found for the specified month.";
                        }

                        $stmt->close();
                    }

                    $conn->close();

                    function getDuration($start, $end) {
                        if ($start && $end) {
                            $start_time = strtotime($start);
                            $end_time = strtotime($end);
                            $duration_seconds = $end_time - $start_time;

                            $hours = floor($duration_seconds / 3600);
                            $minutes = floor(($duration_seconds % 3600) / 60);
                            $seconds = $duration_seconds % 60;

                            return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
                        }
                        return "N/A";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
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

        document.addEventListener('DOMContentLoaded', function() {
    const backgroundVideo = document.getElementById('backgroundVideo');

    if (localStorage.getItem('videoPlaybackTime')) {
        const playbackTime = parseFloat(localStorage.getItem('videoPlaybackTime'));
        backgroundVideo.currentTime = playbackTime;
        backgroundVideo.play().catch(error => {
            console.error('Video playback failed:', error);
        });
    }

    window.addEventListener('beforeunload', () => {
        localStorage.setItem('videoPlaybackTime', backgroundVideo.currentTime.toString());
    });
});
    </script>
</body>
</html>
