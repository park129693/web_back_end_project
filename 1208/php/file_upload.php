<?php

$db_host='localhost';
$db_port='3306';
$db_user='user0';
$db_password='1234';

$pdo = new PDO("mysql:host=$db_host;port=$db_port;dbname=file", $db_user, $db_password);

if ( !isset($_FILES['uploadfile']['name']) || $_FILES['uploadfile']['name'] == "" ) {
    
    $error = 'not file';

    $output = array(
        'error' => $error
    );
    
} else if ( isset($_FILES['uploadfile']['name']) || $_FILES['uploadfile']['name'] !== "" ) {

    $size = $_FILES['uploadfile']['size'];
    $name = $_FILES['uploadfile']['name'];
    $type = $_FILES['uploadfile']['type'];

    $file_exist_sql = "SELECT * from files WHERE `filename`='$name'";
    
    $statement = $pdo -> prepare($file_exist_sql);

    $statement -> execute();

    $result = $statement -> fetch();
    
    if ( $result['filename'] == $name ) {
        
        $error = 'file is exist';

        $output = array(
            'error' => $error
        );

    } else {

        $upfile = '/files';

        $file_sql = "INSERT INTO files VALUES ('$name', '$size', '$type' )";
    
        $statement = $pdo -> prepare($file_sql);
    
        $statement -> execute();
    
        move_uploaded_file($_FILES['uploadfile']['tmp_name'], "$upfile/$name");
        
        $size_mb = number_format(($size/1048576), 2);

        // echo $size_mb;

        $output = array(
            'success' => true,
            'filename' => $name,
            'size' => $size_mb
        );

    }
}

echo json_encode($output);

// print_r($_FILES['uploadfile']['error']);
// var_dump(isset($_FILES['uploadfile']['name']));
// var_dump($_FILES['uploadfile']['name'] !== "");
// var_dump($_FILES);
?>