<?php

include 'db_conn.php';

$output='';

$per_page_record = 10;

if(isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}

$sql = "select count(*) from board";

$statement = connBoardDB() -> prepare($sql);

$statement -> execute();

$row = $statement -> fetchColumn();

$total_records = $row;     

$total_pages = ceil($total_records/$per_page_record);

function page1($page) {
    if ($page <= 1) {
        return 'disbled';
    };   
}

function page2($page) {
    if($page <= 1) {
        return '#';
    } else {
        return "?page=".($page - 1);
    }
}

function page3($page, $total_pages) {
    if($page >= $total_pages){
        return 'disabled';
    }
}

function page4($page, $total_pages) {
    if($page >= $total_pages){
        return '#';
    } else {
        return "?page=".($page + 1);
    }
}

$output .= '
    <li><a href="?page='.$page.'" >first</a></li>
    <li class="'.page1($page).'">
        <a href="'.page2($page).'">Prev</a>
    </li>
    <li class="'.page3($page, $total_pages).'">
        <a href="'.page4($page, $total_pages).'">Next</a>
    </li>
    <li><a href="?page='.$total_pages.'" >Last</a></li>
    ';

echo $output;

?>