<?php
$conn = new mysqli('localhost', 'root', '', 'ashtragroverdb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['afternoon_in'])) {
    if (isset($_POST['emp_id']) && isset($_POST['atlog_date'])) {
        $emp_id = $_POST['emp_id'];
        $atlog_date = $_POST['atlog_date'];
        $current_time = date('H:i:s');
        $start_time = strtotime('12:30:00');
        $late_threshold = strtotime('12:45:00');

        // Check if the emp_id exists in the employee table
        $check_query = "SELECT emp_id FROM employee WHERE emp_id = '$emp_id'";
        $result = $conn->query($check_query);

        if ($result && $result->num_rows > 0) {
            // Check if there's a morning record for this employee on the given date
            $morning_check_query = "SELECT am_in FROM atlog WHERE emp_id = '$emp_id' AND atlog_date = '$atlog_date'";
            $morning_check_result = $conn->query($morning_check_query);

            if ($morning_check_result && $morning_check_result->num_rows > 0) {
                // Update the afternoon check-in time in the same row
                $update_query = "UPDATE atlog SET pm_in = '$current_time' WHERE emp_id = '$emp_id' AND atlog_date = '$atlog_date'";
                if ($conn->query($update_query) === TRUE) {
                    // Check if the employee is late
                    $current_time_seconds = strtotime($current_time);
                    if ($current_time_seconds > $late_threshold) {
                        // Calculate the delay in minutes
                        $delay_seconds = $current_time_seconds - $start_time;
                        $delay_minutes = floor($delay_seconds / 60);

                        // Update the pm_late column in the database
                        $update_late_query = "UPDATE atlog SET pm_late = $delay_minutes WHERE emp_id = '$emp_id' AND atlog_date = '$atlog_date'";
                        if ($conn->query($update_late_query) === TRUE) {
                            echo "<script>alert('You are late by $delay_minutes minute(s). Afternoon In recorded successfully.'); window.location.href = 'ashtra_rover.html';</script>";
                        } else {
                            echo "Error updating late record: " . $conn->error;
                        }
                    } else {
                        echo "<script>alert('Afternoon In recorded successfully.'); window.location.href = 'ashtra_rover.html';</script>";
                    }
                } else {
                    echo "Error recording afternoon check-in: " . $conn->error;
                }
            } else {
                // If no morning record found, insert a new row for the afternoon check-in
                $insert_query = "INSERT INTO atlog (emp_id, atlog_date, pm_in) VALUES ('$emp_id', '$atlog_date', '$current_time')";
                if ($conn->query($insert_query) === TRUE) {
                    echo "<script>alert('Afternoon In recorded successfully.'); window.location.href = 'ashtra_rover.html';</script>";
                } else {
                    echo "Error recording afternoon check-in: " . $conn->error;
                }
            }
        } else {
            echo "Employee with ID $emp_id does not exist.";
        }
    } else {
        echo "Invalid or missing emp_id/atlog_date.";
    }
}elseif (isset($_POST['afternoon_out'])) {
    if (isset($_POST['emp_id']) && isset($_POST['atlog_date'])) {
        $emp_id = $_POST['emp_id'];
        $atlog_date = $_POST['atlog_date'];
        $current_time = date('H:i:s');
        $end_time = strtotime('18:00:00'); // 6 PM

        // Check if the emp_id exists in the employee table
        $check_query = "SELECT emp_id FROM employee WHERE emp_id = '$emp_id'";
        $result = $conn->query($check_query);

        if ($result && $result->num_rows > 0) {
            // Update the afternoon check-out time in the same row
            $update_query = "UPDATE atlog SET pm_out = '$current_time' WHERE emp_id = '$emp_id' AND atlog_date = '$atlog_date'";
            if ($conn->query($update_query) === TRUE) {
                // Check if the employee left early
                $current_time_seconds = strtotime($current_time);
                if ($current_time_seconds < $end_time) {
                    // Calculate the time left in minutes
                    $undertime_seconds = $end_time - $current_time_seconds;
                    $undertime_minutes = floor($undertime_seconds / 60);

                    // Update the pm_undertime column in the database
                    $update_undertime_query = "UPDATE atlog SET pm_undertime = $undertime_minutes WHERE emp_id = '$emp_id' AND atlog_date = '$atlog_date'";
                    if ($conn->query($update_undertime_query) === TRUE) {
                        echo "<script>alert('You left $undertime_minutes minute(s) early. Afternoon Out recorded successfully.'); window.location.href = 'ashtra_rover.html';</script>";
                    } else {
                        echo "Error updating undertime record: " . $conn->error;
                    }
                } else {
                    echo "<script>alert('Afternoon Out recorded successfully.'); window.location.href = 'ashtra_rover.html';</script>";
                }
            } else {
                echo "Error recording afternoon check-out: " . $conn->error;
            }
        } else {
            echo "Employee with ID $emp_id does not exist.";
        }
    } else {
        echo "Invalid or missing emp_id/atlog_date.";
    }
}elseif (isset($_POST['afternoon_out'])) {
    // Your existing code here...

} elseif (isset($_POST['morning_out'])) {
    if (isset($_POST['emp_id']) && isset($_POST['atlog_date'])) {
        $emp_id = $_POST['emp_id'];
        $atlog_date = $_POST['atlog_date'];
        $current_time = date('H:i:s');
        $current_hour = date('H');

        // Check if the emp_id exists in the employee table
        $check_query = "SELECT emp_id FROM employee WHERE emp_id = '$emp_id'";
        $result = $conn->query($check_query);

        if ($result && $result->num_rows > 0) {
            // Check if there's a morning check-in record for this employee on the given date
            $sqlCheckMorningIn = "SELECT am_in FROM atlog WHERE emp_id = '$emp_id' AND atlog_date = '$atlog_date'";
            $morningInResult = $conn->query($sqlCheckMorningIn);

            if ($morningInResult && $morningInResult->num_rows > 0) {
                // Update the morning check-out time in the same row
                $sqlQuery = "UPDATE atlog SET am_out = '$current_time' WHERE emp_id = '$emp_id' AND atlog_date = '$atlog_date'";
                if ($conn->query($sqlQuery) === TRUE) {
                    // Check for morning check-in and check-out times
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

                            // Update the am_undertime column in the database
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
                echo "<script>alert('No morning check-in found for this employee.');";
                echo "window.location.href = './searchlanding.php?id=$emp_id';</script>";
            }
        } else {
            echo "Employee with ID $emp_id does not exist.";
        }
    } else {
        echo "Invalid or missing emp_id/atlog_date.";
    }
} else {
    // Default else case
}
$conn->close();
?>
