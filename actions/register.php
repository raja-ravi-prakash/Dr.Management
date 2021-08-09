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
        <h3 class="title">Doctor Registration</h3>
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
        // echo "<img style='width:35em;' src='https://media.giphy.com/media/R6xi8dXsRhIjK/giphy.gif'/>";
        echo <<<ooo
                <form action="" class="container" method="post">
                    <input type="text" name="name" class="box" placeholder="Doctor Name" required>
                    <select type="text" name="gender" class="select" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <input type="text" name="email" class="box" placeholder="Doctor Email" required>
                    <input type="password" name="password" class="box" placeholder="Doctor Password" required>
                    <input type="text" name="qualification" class="box" placeholder="Doctor Qualification" required>
                    <input type="text" name="phone" class="box" placeholder="Doctor Phone Number" required>
                    <input type="text" name="location" class="box" placeholder="Doctor Location" required>
                    <input type="text" name="address" class="box" placeholder="Doctor Address" required>
                    <input type="submit" value="Create" class="box-s">
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
        $phone = $_POST['phone'];
        $qualification = $_POST['qualification'];
        $location = $_POST['location'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];
        $password = $_POST['password'];

        $password = md5($password . $email);

        $query = "INSERT INTO DOCTOR (name,email,password,phone,qualification,location,gender,address) VALUES ('$name','$email','$password','$phone','$qualification','$location','$gender','$address');";
        $ret = $db->exec($query);
        if (!$ret) {
            // echo "<img src='https://media.giphy.com/media/3o6MbfScJnCnh8cexa/giphy.gif'/>";
            echo "<h1 style='color:red;'> Database Error : Please contact administrator.</h1>";
        } else {
            // echo "<img src='https://media.giphy.com/media/KGeqA1GqHBP2La5eSn/giphy.gif'/><br>";
            echo "<h1 style='color:blue'>Record created Successfully.</h1>";
            unset($_POST);
            $_POST = array();
        }
        $db->close();
    }

    ?>
</body>

</html>