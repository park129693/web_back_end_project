<?php

include 'db_conn.php';

$no=$_GET['no'];

if(isset($_GET['view'])) {

    $view_sql = "update board set views = views + 1 where no = $no";

    $statement = connBoardDB() -> prepare($view_sql);

    $statement -> execute();
}

if (!isset($_GET['no'])) {

    header("Location: /table.html");
    
} else if (isset($_GET['no'])) {
    
    $sql = "select * from board where no=$no";

    $statement = connBoardDB() -> prepare($sql);

    $statement -> execute();
   
    if ($statement -> rowCount() > 0) {

        $result = $statement -> fetch(PDO::FETCH_ASSOC);
    
        $sql_query = "select * from board_wrsr where board_no = $no order by no desc limit 11";
    
        $statement = connBoardDB() -> prepare($sql_query);
    
        $statement -> execute();
    
        $board_chart_data = $statement -> fetchAll(PDO::FETCH_CLASS);

    } else {

        header("Location: /table.html");

    }
    
    session_start();

    $session = $_SESSION['email'];

    echo json_encode(array($result, $board_chart_data, $session));

} else {

    header("Location: /table.html");

}



?>

