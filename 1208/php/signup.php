<?php

$db_host='localhost';
$db_port='3306';
$db_user='user0';
$db_password='1234';

$pdo = new PDO("mysql:host=$db_host;port=$db_port;dbname=user", $db_user, $db_password);

// $email = json_decode(file_get_contents('php://input'))->{"email"};
// $username = json_decode(file_get_contents('php://input'))->{"username"};
// $password = json_decode(file_get_contents('php://input'))->{"password"};


$email = $_POST["email"];
$username = $_POST["username"];
$password = $_POST["password"];

$encryp = password_hash($password, PASSWORD_DEFAULT);

if ( $username == "" || $email == "" || $password == "" ) {

    $error = "Error";

    $output = array(
        'error' => $error
    );

} else {
    
    $email_sql = "SELECT * FROM members WHERE email='$email'";

    $statement = $pdo -> prepare($email_sql);

    $statement -> execute();
    
    $email_check = $statement -> fetch();
    
    if ( $email_check[0] == $email ) {

        $error = "exist email";

        $output = array(
            'error' => $error
        );
    
    } else {
        
        $signup_sql = "INSERT INTO members  VALUES ('$email', '$username', '$encryp')";

        $statement = $pdo -> prepare($signup_sql);

        $statement -> execute();
                
        $output = array(
            'success'  => true
        );
        
    }
}

echo json_encode($output);

// if ( $username == "" || $email == "" || $password == "" ) {

//     echo "Error";

// } else {
    
//     $email_sql = "SELECT * FROM members WHERE email='$email'";

//     $statement = $pdo -> prepare($email_sql);

//     $statement -> execute();
    
//     $email_check = $statement -> fetch();
//     json_encode($email_check);

//     if ( $email_check[0] == $email ) {

//         echo "exist email";

//     } else {

//         $username_sql = "SELECT * FROM members WHERE username ='$username'";

//         $statement = $pdo -> prepare($username_sql);
    
//         $statement -> execute();
    
//         $username_check = $statement -> fetch();
//         json_encode($username_check);
        
//         if ( $username_check[1] == $username ) {

//             echo "exist username";

//         } else {

//             $signup_sql = "INSERT INTO members  VALUES ('$email', '$username', '$encryp')";

//             $statement = $pdo -> prepare($signup_sql);

//             $statement -> execute();
            
//             echo "Sign up success";
            
//         } 
//     }
// }


?>