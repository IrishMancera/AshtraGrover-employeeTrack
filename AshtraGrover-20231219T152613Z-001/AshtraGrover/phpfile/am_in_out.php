<?php
$conn = new mysqli('localhost', 'root', '', 'ashtragroverdb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['morning_in'])) {
    if (isset($_POST['emp_id']) && isset($_POST['atlog_date'])) {
        $emp_id = $_POST['emp_id'];
        $atlog_date = $_POST['atlog_date'];
        $current_time = date('H:i:s');
        $current_hour = date('H');

        // Define the start time (e.g., 7 AM) and the late threshold time (e.g., 7:15 AM)
        $start_time = strtotime('07:00:00');
        $late_threshold = strtotime('07:15:00');

        // Check if the emp_id exists in the employee table
        $check_query = "SELECT emp_id FROM employee WHERE emp_id = '$emp_id'";
        $result = $conn->query($check_query);

        if ($result && $result->num_rows > 0) {
            // Check if there's already a morning check-in for this employee on the given date
            $sqlCheckMorningIn = "SELECT am_in FROM atlog WHERE emp_id = '$emp_id' AND atlog_date = '$atlog_date'";
            $morningInResult = $conn->query($sqlCheckMorningIn);

            if ($morningInResult && $morningInResult->num_rows > 0) {
                echo "Morning check-in already recorded for this employee on this date.";
            } else {
                // Insert the morning check-in time into the database
                $sqlQuery = "INSERT INTO atlog (emp_id, atlog_date, am_in) VALUES ('$emp_id', '$atlog_date', '$current_time')";
                if ($conn->query($sqlQuery) === TRUE) {
                    // Check if the employee is late
                    $current_time_seconds = strtotime($current_time);
                    if ($current_time_seconds > $late_threshold) {
                        // Calculate the delay in minutes
                        $delay_seconds = $current_time_seconds - $start_time;
                        $delay_minutes = floor($delay_seconds / 60);

                        // Update the am_late_minutes column in the database
                        $updateLateQuery = "UPDATE atlog SET am_late = $delay_minutes WHERE emp_id = '$emp_id' AND atlog_date = '$atlog_date'";
                        if ($conn->query($updateLateQuery) === TRUE) {
                            echo "<script>alert('You are late by $delay_minutes minute(s). Morning In recorded successfully.'); window.location.href = 'ashtra_rover.html';</script>";
                            // Additional action when employee is late
                        } else {
                            echo "Error updating late record: " . $conn->error;
                        }
                    } else {
                        echo "<script>alert('Morning In recorded successfully.'); window.location.href = 'ashtra_rover.html';</script>";
                    }
                } else {
                    echo "Error recording morning check-in: " . $conn->error;
                }
            }
        } else {
            echo "Employee with ID $emp_id does not exist.";
        }
    } else {
        echo "Invalid or missing emp_id/atlog_date.";
    }
} elseif (isset($_POST['morning_out'])) {
    if (isset($_POST['emp_id']) && isset($_POST['atlog_date'])) {
        $emp_id = $_POST['emp_id'];
        $atlog_date = $_POST['atlog_date'];
        $current_time = date('H:i:s');
        $current_hour = date('H');

        $check_query = "SELECT emp_id FROM employee WHERE emp_id = '$emp_id'";
        $result = $conn->query($check_query);

        if ($result && $result->num_rows > 0) {
            $sqlCheckMorningIn = "SELECT am_in FROM atlog WHERE emp_id = '$emp_id' AND atlog_date = '$atlog_date'";
            $morningInResult = $conn->query($sqlCheckMorningIn);

            if ($morningInResult && $morningInResult->num_rows > 0) {
                $sqlQuery = "UPDATE atlog SET am_out = '$current_time' WHERE emp_id = '$emp_id' AND atlog_date = '$atlog_date'";
                if ($conn->query($sqlQuery) === TRUE) {
                    $sqlCheckMorningOut = "SELECT am_in, am_out FROM atlog WHERE emp_id = '$emp_id' AND atlog_date = '$atlog_date'";
                    $morningOutResult = $conn->query($sqlCheckMorningOut);

                    if ($morningOutResult && $morningOutResult->num_rows > 0) {
                        $row = $morningOutResult->fetch_assoc();
                        $am_in = strtotime($row['am_in']);
                        $am_out = strtotime($row['am_out']);

                        $duration_seconds = $am_out - $am_in;
                        $undertime_seconds = 5 * 3600 - $duration_seconds;

                        if ($undertime_seconds > 0) {
                            $undertime_minutes = floor($undertime_seconds / 60);

                            $updateUndertimeQuery = "UPDATE atlog SET am_undertime = $undertime_minutes WHERE emp_id = '$emp_id' AND atlog_date = '$atlog_date'";
                            if ($conn->query($updateUndertimeQuery) === TRUE) {
                                echo "<script>alert('You left $undertime_minutes minute(s) early. Morning Out recorded successfully.'); window.location.href = 'ashtra_rover.html';</script>";
                            } else {
                                echo "Error updating undertime record: " . $conn->error;
                            }
                        }
                    }
                } else {
                    echo "Error updating record: " . $conn->error;
                }
            } else {
                echo "No morning check-in found for this employee.";
            }
        } else {
            echo "Employee with ID $emp_id does not exist.";
        }
    } else {
        echo "Invalid or missing emp_id/atlog_date.";
    }
} else {
}
$conn->close();
?>