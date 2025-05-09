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
                            echo "<h2>Good Morning, $first_name!</h2>";
                        } elseif ($time >= 12 && $time < 18) {
                            // Afternoon
                            echo "<h2>Good Afternoon, $first_name!</h2>";
                        } else {
                            // Evening
                            echo "<h2>Good Evening, $first_name! Thank you for your hard work!</h2>";
                        }
                    } 
                }
                $conn->close();
                ?>