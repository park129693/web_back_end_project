<?php

include 'db_conn.php';

$no = $_GET['no'];

$sql = "delete from board where no = $no";

$statement = connBoardDB() -> prepare($sql);

$statement -> execute();

$sql = "delete from board_wrsr where board_no = $no";

$statement = connBoardDB() -> prepare($sql);

$statement -> execute();

$sql = "alter table board AUTO_INCREMENT=1";

$statement = connBoardDB() -> prepare($sql);

$statement -> execute();


$sql="update board set `no`= 1"; 

$statement = connBoardDB() -> prepare($sql);

$statement -> execute();

echo"<script>alert('Success');location.href='/table.html'</script>";

?>