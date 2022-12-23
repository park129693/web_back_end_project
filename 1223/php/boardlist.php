<?php

include 'db_conn.php';

$output='';

$sql = "select * from board order by no desc limit 10";

$statement = connBoardDB() -> prepare($sql);

$statement -> execute();

$output .= '<h4 class="card-title">Table with contextual classes</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                          <th> no </th>
                          <th> emali </th>
                          <th> title </th>
                          <th> create_at </th>
                          <th> views </th>
                          <th> more </th>
                        </tr>
                    </thead>';

if($statement -> rowCount() > 0) {

    while($row = $statement -> fetch(PDO::FETCH_ASSOC)) {

        $output .= '
                <tbody>
                    <tr>
                        <td>'.$row["no"].'</td>
                        <td>'.$row["email"].'</td>
                        <td>'.$row["title"].'</td>
                        <td>'.$row["create_at"].'</td>
                        <td>'.$row["views"].'</td>
                        <td><a class="btn btn-default" href="board_read.html?no='.$row["no"].'&view=1">more</a></td>
                    </tr>
                </tbody>';  

        }

} else {
    
    $output .= '
        <tr >
            <td>fail</td>      
        </tr>';

}

    $output .= '</table>';

echo $output;

    if(isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }
    
    $limit = 10;
    
    $startPage = ($page-1) * $limit;
    
    $sql = "select * from board order by no desc limit $startPage, $limit";



$sql = "select count(*) from board";

$statement = connBoardDB() -> prepare($sql);

$statement -> execute();

$total_records = $statement -> fetchColumn();

$total_pages = ceil($total_records/$limit);

// function firstPage($page) {
//     if ($page <= 1) {
//         return 'disabled';
//     };   
// }

// function prevPage($page) {
//     if($page <= 1) {
//         return '#';
//     } else {
//         return "?page=".($page - 1);
//     }
// }

// function nextPage($page, $total_pages) {
//     if($page >= $total_pages){
//         return 'disabled';
//     }
// }

// function lastPage($page, $total_pages) {
//     if($page >= $total_pages){
//         return '#';
//     } else {
//         return "?page=".($page + 1);
//     }
// }

// $output .= '
//     <ul class="pagination">
//         <li><a href="?page='.$page.'" >first</a></li>
//         <li class="'.firstPage($page).'">
//             <a href="'.prevPage($page).'">Prev</a>
//         </li>
//         <li class="'.nextPage($page, $total_pages).'">
//             <a href="'.lastPage($page, $total_pages).'">Next</a>
//         </li>
//         <li><a href="?page='.$total_pages.'" >Last</a></li>
//     </ul>
//     ';

// if($page >= 2) {
//     $output .= '
//         <ul class="pagination">
//             <li><a href = "?page='.($page - 1).'">Prev</a></li>
//     ';
// }

for ($i=1; $i<$total_pages; $i++) {
    if($i == $page) {
        $output .= '
            <li><a class="active" href = "?page='.$i.'"> '.$i.'</a></li>
        ';
    } else {
        $output .= '
            <li><a href = "?page='.$i.'"> '.$i.'</a></li>
        ';
    }
}




// echo $output;


?>
