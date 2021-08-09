<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Document</title>
</head>

<body>
    <div class="nav">
        <h3 class='title'>Doctors List</h3>
        <div class="options">
            <a href="/html/mini/">Home</a>
            <a href="/html/mini/actions/register.php">Register Doctor</a>
            <a href="/html/mini/actions/addTopic.php">Add Topic</a>
            <a href="/html/mini/actions/removeTopic.php">Remove Topic</a>
            <a href="/html/mini/actions/searchTopic.php">Search Topic</a>
            <a href="/html/mini/actions/doctors.php">Doctors</a>
            <a href="/html/mini/actions/checkAppointments.php">Check Appointments</a>
        </div>
    </div>

    <?php
    class MyDB extends SQLite3
    {
        function __construct()
        {
            $this->open('../data.db');
        }
    }

    try {
        $db = new MyDB();

        if (empty($_GET)) {
            echo "<h1 style='color:red;'>Bad Request : Go back to HOME</h1>";
        } else {

            if (!empty($_POST)) {

                $name = $_POST['name'];
                $date = $_POST['date'];
                $time = $_POST['time'];
                $email = $_POST['email'];
                $token = hash('crc32', $date . $time . "freddie" . $email);
                $query = "SELECT * FROM APPOINTMENTS WHERE token == '$token'";
                $ret = $db->query($query);

                if ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
                    echo "<h1 style='color:red;'>Sorry there is no availability go back.</h1>";
                } else {
                    $query = "INSERT INTO APPOINTMENTS (email,time,date,patientname,token) VALUES ('$email','$time','$date','$name','$token')";
                    if ($ret = $db->query($query)) {
                        echo "<h1 style='color:blue'>Appointment Created Successfully.</h1><br>";
                        echo "<h1>Token Number : $token</h1>";
                    } else
                        echo "<h1 style='color:red;'> Database Error : Please contact administrator.</h1>";
                }
            } else {

                $email = $_GET['email'];

                echo '<form action="" class="container" method="post">';
                $query = "SELECT name FROM TOPIC WHERE email='$email'";
                $ret = $db->query($query);

                echo "<input name='email' type='text' class='box' value='$email' readonly/>";

                echo '<select name="name" class="select" required>';
                while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
                    $s = "<option value=" . "'" . $row['name'] . "'>" . $row['name'] . "</option>";
                    echo $s;
                }

                echo '<input type="date" class="box" name="date" required/>';

                echo '</select>';

                $query = "SELECT time FROM DATES";
                $ret = $db->query($query);
                echo '<select name="time" class="select" type="text" required>';
                while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
                    $s = "<option value=" . "'" . $row['time'] . "'>" . $row['time'] . "</option>";
                    echo $s;
                }

                echo '</select>';

                echo '<input type="text" name="name" class="box" placeholder="Patient Name" required>';
                echo '<input type="submit" value="Check & Book if Available" class="box-s">';
                echo "</form>";
                echo "</form>";
            }
        }
    } catch (Exception $e) {
        echo $e;
    }

    ?>
</body>

</html>