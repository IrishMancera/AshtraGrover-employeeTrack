<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Welcome Employee!</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background-color: antiquewhite;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50vh;
            flex-direction: column;
        }
        .digital.clock {
            border: 2px solid #333;
            padding: 10px;
            border-radius: 5px;
            font-size: 18px;
            margin-top: 10px;
        }
        .content {
            width: 500px;
            height: 200px;
            margin-top: 10px;
            border: 1px solid #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center">
            <?php
                include 'phpfile/greetings.php';
                ?>
                <div class="content">
                    <div class="row">
                    <div class="col-md-4 text-center">   
                        <?php
                            include 'phpfile/emppicture.php';
                        ?>
                    </div>
                    <div class="col-md-7 text-left">   
                        <?php
                            include 'phpfile/empprofile.php';
                        ?>
                    </div>
                </div>
            </div>
            </div>
                <div class="col-md-8 text-center">
                    <h2 style="margin-top: 115px;">Clock (Manila Timezone)</h2>
                    <iframe src="https://free.timeanddate.com/clock/i95egn3n/n5514/szw210/szh210/hoc555/hbw6/cf100/hnce1ead6/hcw2/fan2/fas16/fdi64/mqc000/mqs4/mql20/mqw2/mqd94/mhc000/mhs3/mhl20/mhw2/mhd94/mmc000/mml10/mmw1/mmd94/hmr7/hsc000/hss1/hsl90" frameborder="0" width="210" height="210"></iframe>
                    <div class="digital clock">
                        <?php
                            date_default_timezone_set('Asia/Manila');
                            echo date('h:i:s A');
                            echo "<br>";
                            echo date('d-m-Y');
                        ?>
                    </div>
                </div>
                <form method="post">
                    <input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>">
                    <input type="hidden" name="atlog_date" value="<?php echo date('Y-m-d'); ?>">
                    
                    <?php
                    date_default_timezone_set('Asia/Manila');
                    $time = date('H');

                    if ($time >= 12 && $time < 18) {
                        // Afternoon: Show afternoon in and out buttons
                        echo '<input type="submit" name="morning_out" value="Morning Out">';
                        echo '<input type="submit" name="afternoon_in" value="Afternoon In">';
                        echo '<input type="submit" name="afternoon_out" value="Afternoon Out">';
                        include_once 'phpfile/pm_in_out.php';
                    } elseif ($time >= 18) {
                        echo 'Working Hours is Finish! Goodjob for today(s) bideow';
                        echo '<input type="submit" name="afternoon_out" value="Afternoon Out">';
                        include_once 'phpfile/pm_in_out.php';
                    } else {
                        // Morning: Show morning in and out buttons
                        echo '<input type="submit" name="morning_in" value="Morning In">';
                        echo '<input type="submit" name="morning_out" value="Morning Out">';
                        include_once 'phpfile/am_in_out.php';
                    }
                    ?>
                </form>
    </div>
        
    </div>
            

</body>
</html>

