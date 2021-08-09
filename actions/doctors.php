<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Project</title>
    <link rel="stylesheet" href="../style/style.css">
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

        $query = "SELECT * from DOCTOR;";
        $ret = $db->exec($query);

        if (!$ret) {
            echo "<h1 style='color:red;'> Database Error : Please contact administrator.</h1>";
        } else {
            $ret = $db->query($query);
            echo "<div class='coni'>";
            while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
                $query = "SELECT COUNT(name) from TOPIC WHERE email==" . "'" . $row['email'] . "'";
                $cc = $db->query($query);
                $cc = $cc->fetchArray(SQLITE3_ASSOC);
                echo '<div class="doc-con" onclick="aler(' . "'" . $row['email'] . "'" . ')">';
                echo "<div class='doc-n'>";
                echo $row['name'];
                echo "</div>";
                echo "<div class='d-box'>";
                echo "ADDRESS = " . $row['address'] . "<br>";
                echo "EMAIL = " . $row['email'] . "<br>";
                echo "TOPIC = " . $cc['COUNT(name)'] . "<br>";
                echo "Phone Number = " . $row['phone'] . "<br>";
                echo "Location = " . $row['location'] . "<br>";
                echo "QUALIFICATION = " . $row['qualification'] . "<br>";
                echo "GENDER = " . $row['gender'] . "<br>";
                echo "</div>";
                echo "</div>";
            }

            echo "</div>";
            unset($_POST);
            $_POST = array();
        }
    } catch (Exception $e) {
        echo $e;
    }

    $db->close();


    ?>


    <script>
        function aler(pathData) {
            let res = confirm("Do you want to book an Appointment?");
            if (res) {
                location.href = "/html/mini/actions/appointment.php?email=" + pathData;
            }
        }
    </script>
</body>

</html>