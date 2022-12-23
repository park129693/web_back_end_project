<?php 

include 'db_conn.php';

ob_start();

session_start();

$no = $_POST['no'];
$title = $_POST['title'];
$context = $_POST['context'];
$file = $_FILES['uploadfile'];

$email = $_SESSION['email'];

$uploaddir = '/var/www/html/files';

            $tmpfile = $file['tmp_name'];
            $namefile = $file['name'];
    
            $update_sql = "update board set title = '$title', context = '$context' where no = '$no'";
    
            $statement = connBoardDB() -> prepare($update_sql);
    
            $statement -> execute();

        if (!isset($board_no)) {
            $no_sql = "select no from board where email='$email' and no='$no' order by no desc limit 1";

            $statement = connBoardDB() -> prepare($no_sql);
            $statement -> execute();
            $result = $statement -> fetch(PDO::FETCH_ASSOC);
            $board_no = $result['no'];
        }

        $allowed_extension = array('csv');
        $file_array = explode(".", $namefile);
        $extension = end($file_array);

        if(in_array($extension, $allowed_extension)) {
            $new_file_name = rand() . '.' . $extension;
            
            $_SESSION['csv_file_name'] = $new_file_name;

            move_uploaded_file($tmpfile, "$uploaddir/$new_file_name");
            $file_content = file("$uploaddir/$new_file_name", FILE_SKIP_EMPTY_LINES);
        }

        $handle = fopen('/var/www/html/files/' . $_SESSION['csv_file_name'], "r");

        fgetcsv($handle);

        while (($data = fgetcsv($handle)) !== false) {
            
            $board_no;
            $enc_Year = $data[0];
            $enc_Wearing = $data[1];
            $enc_Release = $data[2];
            $enc_Stock = $data[3];
            $enc_Return = $data[4];
            $enc_gf_Wearing = $data[5];
            $enc_gf_Release = $data[6];
            $enc_gf_Stock = $data[7];
            $enc_gf_Return = $data[8];
            $email;

            $sql = "insert into board_wrsr (
                board_no,
                enc_Year,
                enc_Wearing,
                enc_Release,
                enc_Stock,
                enc_Return,
                enc_gf_Wearing,
                enc_gf_Release,
                enc_gf_Stock,
                enc_gf_Return,
                email 
            )";

            $sql = $sql. "values (
                '$board_no',
                '$enc_Year',
                '$enc_Wearing',
                '$enc_Release',
                '$enc_Stock',
                '$enc_Return',
                '$enc_gf_Wearing',
                '$enc_gf_Release',
                '$enc_gf_Stock',
                '$enc_gf_Return',
                '$email'
                )";
                
            $statement = connBoardDB() -> prepare($sql);

            $statement -> execute();

            if( opendir($uploaddir) ){
                @unlink("$uploaddir/" . $_SESSION['csv_file_name'] );
            }

            unset($_SESSION['csv_file_name']);
        }

    echo"<script>alert('Success');location.href='/table.html'</script>";



// if (!isset($_SESSION['email'])) {

    // echo"<script>alert('login Please!');location.href='/login.html'</script>";

// } else if (isset($_SESSION['email'])) {

    // if ($title == "" || $context == "" || $file == "") {

    //     echo"<script>alert('수정을 취소 하였습니다.');location.href='/board_read.html?no='$no''</script>";

    //    } else if (isset($title) || isset($context) ) {

    //     $uploaddir = '/var/www/html/files';
    //     $tmpfile = $file['tmp_name'];
    //     $namefile = $file['name'];

    //     $update_sql = "update board set title = $title, context = $context where no = $no";

    //     $statement = connBoardDB() -> prepare($update_sql);

    //     $statement -> execute();

    //    } else if (isset($file)) {

    //     if (!isset($board_no)) {
    //         $no_sql = "select no from board where email='$email' and no='$no' order by no desc limit 1";

    //         $statement = connBoardDB() -> prepare($no_sql);
    //         $statement -> execute();
    //         $result = $statement -> fetch(PDO::FETCH_ASSOC);
    //         $board_no = $result['no'];
    //     }
    
    //     $allowed_extension = array('csv');
    //     $file_array = explode(".", $namefile);
    //     $extension = end($file_array);

    //     if(in_array($extension, $allowed_extension)) {
    //         $new_file_name = rand() . '.' . $extension;
            
    //         $_SESSION['csv_file_name'] = $new_file_name;

    //         move_uploaded_file($tmpfile, "$uploaddir/$new_file_name");
    //         $file_content = file("$uploaddir/$new_file_name", FILE_SKIP_EMPTY_LINES);
    //     }

    //     set_time_limit(0);
    //     ob_implicit_flush(1);

    //     $handle = fopen('/var/www/html/files/' . $_SESSION['csv_file_name'], "r");

    //     fgetcsv($handle);

    //     while (($data = fgetcsv($handle)) !== false) {
            
    //         $board_no;
    //         $enc_Year = $data[0];
    //         $enc_Wearing = $data[1];
    //         $enc_Release = $data[2];
    //         $enc_Stock = $data[3];
    //         $enc_Return = $data[4];
    //         $enc_gf_Wearing = $data[5];
    //         $enc_gf_Release = $data[6];
    //         $enc_gf_Stock = $data[7];
    //         $enc_gf_Return = $data[8];
    //         $email;

    //         $sql = "update board_wrsr set
    //                 'enc_Year'=$enc_Year,
    //                 'enc_Wearing' = $enc_Wearing,
    //                 'enc_Release' = $enc_Release,
    //                 'enc_Stock' = $enc_Stock,
    //                 'enc_Return' = $enc_Return,
    //                 'enc_gf_Wearing' = $enc_gf_Wearing,
    //                 'enc_gf_Release' = $enc_gf_Release,
    //                 'enc_gf_Stock' = $enc_gf_Stock,
    //                 'enc_gf_Return' = $enc_gf_Return,
    //                 'email' = $email,
    //                 where 'board_no' = $board_no";
                
    //         $statement = connBoardDB() -> prepare($sql);

    //         $statement -> execute($data);

    //         if( opendir($uploaddir) ){
    //             @unlink("$uploaddir/" . $_SESSION['csv_file_name'] );
    //         }

    //         unset($_SESSION['csv_file_name']);
    //     }
        
    //     } else {
    //         $uploaddir = '/var/www/html/files';
    //         $tmpfile = $file['tmp_name'];
    //         $namefile = $file['name'];
    
    //         $update_sql = "update board set title = $title, context = $context where no = $no";
    
    //         $statement = connBoardDB() -> prepare($update_sql);
    
    //         $statement -> execute();

    //     if (!isset($board_no)) {
    //         $no_sql = "select no from board where email='$email' and no='$no' order by no desc limit 1";

    //         $statement = connBoardDB() -> prepare($no_sql);
    //         $statement -> execute();
    //         $result = $statement -> fetch(PDO::FETCH_ASSOC);
    //         $board_no = $result['no'];
    //     }
    
    //     $allowed_extension = array('csv');
    //     $file_array = explode(".", $namefile);
    //     $extension = end($file_array);

    //     if(in_array($extension, $allowed_extension)) {
    //         $new_file_name = rand() . '.' . $extension;
            
    //         $_SESSION['csv_file_name'] = $new_file_name;

    //         move_uploaded_file($tmpfile, "$uploaddir/$new_file_name");
    //         $file_content = file("$uploaddir/$new_file_name", FILE_SKIP_EMPTY_LINES);
    //     }

    //     set_time_limit(0);
    //     ob_implicit_flush(1);

    //     $handle = fopen('/var/www/html/files/' . $_SESSION['csv_file_name'], "r");

    //     fgetcsv($handle);

    //     while (($data = fgetcsv($handle)) !== false) {
            
    //         $board_no;
    //         $enc_Year = $data[0];
    //         $enc_Wearing = $data[1];
    //         $enc_Release = $data[2];
    //         $enc_Stock = $data[3];
    //         $enc_Return = $data[4];
    //         $enc_gf_Wearing = $data[5];
    //         $enc_gf_Release = $data[6];
    //         $enc_gf_Stock = $data[7];
    //         $enc_gf_Return = $data[8];
    //         $email;

    //         $sql = "update board_wrsr set 
    //                 'enc_Year'=$enc_Year,
    //                 'enc_Wearing' = $enc_Wearing,
    //                 'enc_Release' = $enc_Release,
    //                 'enc_Stock' = $enc_Stock,
    //                 'enc_Return' = $enc_Return,
    //                 'enc_gf_Wearing' = $enc_gf_Wearing,
    //                 'enc_gf_Release' = $enc_gf_Release,
    //                 'enc_gf_Stock' = $enc_gf_Stock,
    //                 'enc_gf_Return' = $enc_gf_Return,
    //                 'email' = $email
    //                 where 'board_no' = $$board_no";
                
    //         $statement = connBoardDB() -> prepare($sql);

    //         $statement -> execute($data);

    //         if( opendir($uploaddir) ){
    //             @unlink("$uploaddir/" . $_SESSION['csv_file_name'] );
    //         }

    //         unset($_SESSION['csv_file_name']);
    //     }
    // }
// }
?>