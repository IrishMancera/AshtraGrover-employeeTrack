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
            overflow: hidden;
        }
        #video-background {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -1000;
            object-fit: cover; /* Ensure the video covers the entire container */
        }
        #content {
            position: relative;
            z-index: 1;
            padding: 10px;
            color: #fff;
        }
        * {
            font-family: "Lato";
            color: white;
            text-shadow: 1px 1px 5px rgb(71, 49, 49);
        }
        .nav a li {
            transition: 0.5s;
        }
        .nav a li:hover {
            background-color: rgba(206, 198, 198, 0.5);
        }
        .floating-container {
            background-color: rgba(0, 0, 0, 0.7); /* Semi-dark background with 70% opacity */
            padding: 20px;
            border: 2px solid rgba(255, 255, 255, 0.2); /* Semi-transparent white border */
            border-radius: 10px;
        }
        .floating-container p {
            color: #fff; /* Text color in the container */
        }
        .hover-box {
            background-color: black;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }
        .image-box {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .image-box img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- Video Background -->
    <video id="video-background" autoplay muted loop>
        <source src="..video/Bkg.mp4" type="video/mp4">
    </video>


    <!-- Navigation Bar -->
    <div class="container-fluid" style="min-height: 100vh; overflow-y: auto; overflow-x: hidden;">
        <div class="row bg-black bg-opacity-75 d-flex align-items-center sticky-top" style="height: 70px">
            <!-- Logo Section -->
            <div class="col-sm-3 p-3 h-20">
                <a href="#" class="h-30">
                    <img class="img-fluid h-10" src="textfx.png" alt="logo" />
                </a>
            </div>

            <!-- Navigation Links Section -->
            <div class="col-sm-8 h-70">
                <ul class="nav mb-0 d-flex justify-content-around align-items-center h-120">
                    <a class="text-decoration-none h-100" href="aboutpage.html">
                        <li class="list-unstyled text-white d-flex align-items-right pe-8 ps-8 h-120 fw-bold">BACK</li>
                    </a>

                </ul>
            </div>
        </div>




        <!-- Main Content Section -->
        <div class="row d-flex align-items-center">
            <!-- Logo Image -->
            <div class="col-sm-6 h-120">
                <img class="h-90 img-fluid" src="AG.simple.logo.png" alt="logo" />
            </div>

            <div class="table-container">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Hired Date </th>
                    <th>Attendance</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch and display data from your database
                foreach ($yourData as $row) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['position']}</td>";
                    echo "<td>{$row['department']}</td>";
                    echo "<td>{$row['attendance']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>



    

    <!-- Your existing scripts -->
    <script>
        // Enable Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Show the hovering black box on hover
        document.getElementById('blackBox').classList.remove('d-none');
    </script>
</body>
</html>