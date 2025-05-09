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