<?php

session_start();

$db_host='localhost';
$db_port='3306';
$db_user='user0';
$db_password='1234';

$pdo = new PDO("mysql:host=$db_host;port=$db_port;dbname=user", $db_user, $db_password);

// $email = json_decode(file_get_contents('php://input'))->{"email"};
// $passwd = json_decode(file_get_contents('php://input'))->{"password"};

$email = $_POST["email"];
$passwd = $_POST["password"];

if ($email == "" || $passwd == "") {

    $error = "need email or password";

    $output = array(
        'error' => $error
    );

} else {

    $email_sql = "SELECT * FROM members WHERE email='$email'";

    $result = queryevent( $pdo, $email_sql );
    
    if ($result[0] !== $email) {
        
        $error = "user is not exist";

       $output = array(
            'error' => $error
        ); 

    } else {

        $pw_sql = "SELECT `password` FROM members WHERE email='$email'";

        $result = queryevent( $pdo, $pw_sql );
    
        $encryp = $result[0];

        if ( password_verify($passwd, $encryp) ) {

            
            $_SESSION['email'] = $email;

            $message = "{$_SESSION['email']} Hello!";

            $output = array(
                'success' => true,
                'message' => $message,
                'session' => $_SESSION
            );

        } else {
            
            $error = "password wrong";

            $output = array(
                'error' => $error
            );
            
        }
    }

}

function queryevent( $pdo, $e ) {

    $statement = $pdo -> prepare($e);
    
    $statement -> execute();

    $result = $statement -> fetch();

    return $result;
}

echo json_encode($output);



?>