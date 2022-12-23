<?php

include 'db_conn.php';

// $email = json_decode(file_get_contents('php://input'))->{"email"};
// $username = json_decode(file_get_contents('php://input'))->{"username"};
// $password = json_decode(file_get_contents('php://input'))->{"password"};

var_dump($_POST);
$email = $_POST["email"];
$username = $_POST["username"];
$password = $_POST["password"];

$encryp = password_hash($password, PASSWORD_DEFAULT);

if ( $username == "" || $email == "" || $password == "" ) {

    header("Location: /register.html");

} else {

    $email_sql = "SELECT * FROM members WHERE email='$email'";

    $statement = connUSERDB() -> prepare($email_sql);

    $statement -> execute();

    $email_check = $statement -> fetch();

    if ( $email_check[0] == $email ) {

        // echo "<script>alert('email is exist');location.href='/register.html'</script>";
        header("Location: /register.html");

    } else {

        $signup_sql = "INSERT INTO members  VALUES ('$email', '$username', '$encryp')";

        $statement = connUSERDB() -> prepare($signup_sql);

        $statement -> execute();

        header("Location: /login.html");
    }
}

?>

