<?php

include 'db_conn.php';

// $email = json_decode(file_get_contents('php://input'))->{"email"};
// $passwd = json_decode(file_get_contents('php://input'))->{"password"};

$email = $_POST["email"];
$passwd = $_POST["password"];

if ($email == "" || $passwd == "") {

    header("Location: /login.html");

} else {

    $email_sql = "SELECT * FROM members WHERE email='$email'";

    $statement = connPlatonDB() -> prepare($email_sql);

    $statement -> execute();

    $result = $statement -> fetch();

    json_encode($result);

    if ($result[0] !== $email) {

       header("Location: /login.html");

    } else {

        $pw_sql = "SELECT `password` FROM members WHERE email='$email'";

        $statement = connPlatonDB() -> prepare($pw_sql);

        $statement -> execute();

        $result = $statement -> fetch();

        $encryp = $result[0];

        if ( password_verify($passwd, $encryp) ) {

            session_start();

            $_SESSION['email'] = $email;
           header("Location: /index.html");

        } else {

            header("Location: /register.html");

        }
    }

}


?>