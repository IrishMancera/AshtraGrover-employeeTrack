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