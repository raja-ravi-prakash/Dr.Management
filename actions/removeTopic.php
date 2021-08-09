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
        <h3 class='title'>Remove Topic to Doctor</h3>
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
    if (empty($_POST)) {
        // echo "<img style='width:25em;' src='https://media.giphy.com/media/10UHehEC098kAE/giphy.gif'/>";
        echo <<<ooo
                <form action="" class="container" method="post">
                    <input type="text" name="name" class="box" placeholder="Topic Name" required>
                    <input type="text" name="email" class="box" placeholder="Doctor Email" required>
                    <input type="password" name="password" class="box" placeholder="Doctor Password" required>
                    <input type="submit" value="Remove Topic" class="box-s">
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
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password = md5($password . $email);

        $query = "SELECT * FROM DOCTOR WHERE email=='$email'";
        $res = $db->query($query);
        $res = $res->fetchArray(SQLITE3_ASSOC);


        if (empty($res)) {
            // echo "<img src='https://media.giphy.com/media/MB6mmz21wDPZc2827I/giphy.gif'/>";
            echo "<h1 style='color:red;'>There is no doctor who has email $email</h1>";
        } else {

            if ($password == $res['password']) {
                $query = "DELETE FROM TOPIC WHERE name=='$name' AND email=='$email';";
                $ret = $db->exec($query);

                if (!$ret) {
                    // echo "<img src='https://media.giphy.com/media/3o6MbfScJnCnh8cexa/giphy.gif'/><br>";
                    echo "<h1 style='color:red;'> Database Error : Please contact administrator.</h1>";
                } else {
                    // echo "<img src='https://media.giphy.com/media/xUKrrEnN9I5lnrcSMv/giphy.gif'/><br>";
                    echo "<h2 style='color:blue;'>Operation executed Successfully.</h2>";
                    unset($_POST);
                    $_POST = array();
                }
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