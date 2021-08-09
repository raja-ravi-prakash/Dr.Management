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
        <h3 class='title'>Add Topic to Doctor</h3>
        <div class="options">
            <a href="/html/mini">Home</a>
            <a href="/html/mini/actions/register.php">Register Doctor</a>
            <a href="/html/mini/actions/addTopic.php">Add Topic</a>
            <a href="/html/mini/actions/removeTopic.php">Remove Topic</a>
            <a href="/html/mini/actions/searchTopic.php">Search Topic</a>
            <a href="/html/mini/actions/doctors.php">Doctors</a>
            <a href="/html/mini/actions/checkAppointments.php">Check Appointments</a>

        </div>
    </div>

    <?php
    if (empty($_POST)) {
        // echo "<img style='width:35em;' src='https://media.giphy.com/media/IgOEWPOgK6uVa/giphy.gif'/>";
        echo <<<ooo
                <form action="" class="container" method="post">
                    <input type="text" name="email" class="box" placeholder="Doctor Email" required>
                    <input type="password" name="password" class="box" placeholder="Doctor Password" required>
                    <input type="date" name="date" class="box" required/>
                    <input type="submit" value="Login" class="box-s">
                </form>
            ooo;
    } else {

        class MyDB extends SQLite3
        {
            function __construct()
            {
                $this->open('../data.db');
            }
        }

        try {
            $db = new MyDB();
        } catch (Exception $e) {
            echo $e;
        }
        $email = $_POST['email'];
        $password = $_POST['password'];
        $date = $_POST['date'];
        $password = md5($password . $email);

        $query = "SELECT * FROM DOCTOR WHERE email=='$email'";
        $res = $db->query($query);
        $res = $res->fetchArray(SQLITE3_ASSOC);

        if (empty($res)) {
            echo "<h1 style='color:red;'>There is no doctor who has email $email</h1>";
        } else {
            if ($password == $res['password']) {

                $query = "SELECT * FROM APPOINTMENTS WHERE email=='$email' AND date=='$date'";
                $ret = $db->query($query);
                echo "<table>";
                echo <<<ooo
                    <tr>
                        <th>Token</th>
                        <th>Patient Name</th>
                        <th>Time</th>
                        <th>Date</th>
                    </tr>
                ooo;
                while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row['token'] . "</td>";
                    echo "<td>" . $row['patientname'] . "</td>";
                    echo "<td>" . $row['time'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                unset($_POST);
                $_POST = array();
            } else {
                // echo "<img style='width:40em' src='https://media.giphy.com/media/QUY2pzDAKVpX3QacCg/giphy.gif'/><br>";
                echo "<h1 style='color:red;'>Wrong Password.</h1>";
            }
        }


        $db->close();
    }

    ?>
</body>

</html>